<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manufacturer_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * 제조사별 제품 수를 집계하고 순위를 매기는 메서드
     * @param int|null $limit  가져올 레코드 수
     * @param int|null $offset  시작 오프셋
     * @param string|null $keyword 검색 키워드 (제조사명 검색)
     * @return array 제조사별 제품 수 데이터 배열
     */
    public function get_manufacturer_product_ranks($limit = NULL, $offset = NULL, $keyword = NULL)
    {
        $this->db->select('tm.id, tm.biz_name AS manufacturer_name, COUNT(tp.id) AS product_count');
        $this->db->from('tb_manufacturer tm');
        $this->db->join('tb_product tp', 'tm.id = tp.manufacturer_id', 'left');

        if ($keyword) {
            $this->db->like('tm.biz_name', $keyword);
        }

        $this->db->group_by('tm.id, tm.biz_name');
        $this->db->order_by('product_count', 'DESC');
        $this->db->order_by('manufacturer_name', 'ASC');

        if ($limit !== NULL) {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * 제조사별 제품 수 순위의 전체 레코드 개수를 반환하는 메서드 (페이징용)
     * @param string|null $keyword 검색 키워드
     * @return int 전체 레코드 수
     */
    public function count_manufacturer_product_ranks($keyword = NULL)
    {
        $this->db->select('COUNT(DISTINCT tm.id) as total_count');
        $this->db->from('tb_manufacturer tm');
        $this->db->join('tb_product tp', 'tm.id = tp.manufacturer_id', 'left');

        if ($keyword) {
            $this->db->like('tm.biz_name', $keyword);
        }

        $result = $this->db->get()->row();
        return $result->total_count;
    }


	/**
     * 특정 제조사의 총 제품 수를 가져오는 메서드
     * @param int $manufacturer_id 제조사 ID
     * @return int 총 제품 수
     */
    public function get_total_products_by_manufacturer($manufacturer_id)
    {
        $this->db->where('manufacturer_id', $manufacturer_id);
        return $this->db->count_all_results('tb_product');
    }

    /**
     * 특정 제조사의 제품 수 순위를 계산하는 메서드
     * @param int $manufacturer_id 제조사 ID
     * @return int|null 해당 제조사의 순위 (없으면 null)
     */
    public function get_manufacturer_rank($manufacturer_id)
    {
        // 1. 모든 제조사별 제품 수 집계
        $this->db->select('tm.id, COUNT(tp.id) AS product_count');
        $this->db->from('tb_manufacturer tm');
        $this->db->join('tb_product tp', 'tm.id = tp.manufacturer_id', 'left');
        $this->db->group_by('tm.id');
        $this->db->order_by('product_count', 'DESC'); // 제품 수 내림차순 정렬
        $this->db->order_by('tm.biz_name', 'ASC'); // 제품 수가 같으면 제조사명 오름차순 정렬

        $query = $this->db->get();
        $ranks = $query->result_array();

        $rank = 1;
        $prev_product_count = -1; // 이전 제품 수를 저장하여 공동 순위 처리
        $index_count = 0; // 실제 배열 인덱스를 카운트

        foreach ($ranks as $row) {
            if ($prev_product_count != $row['product_count']) {
                $rank = $index_count + 1; // 제품 수가 다르면 새로운 순위 부여
            }

            if ($row['id'] == $manufacturer_id) {
                return $rank; // 해당 제조사를 찾으면 순위 반환
            }
            $prev_product_count = $row['product_count'];
            $index_count++;
        }

        return null; // 해당 제조사를 찾지 못했을 경우
    }

    /**
     * 특정 제조사의 이름을 가져오는 메서드
     * @param int $manufacturer_id 제조사 ID
     * @return string|null 제조사 이름 또는 null
     */
    public function get_manufacturer_name($manufacturer_id)
    {
        $result = $this->db->select('biz_name')
                          ->where('id', $manufacturer_id)
                          ->get('tb_manufacturer')
                          ->row();
        return $result ? $result->biz_name : null;
    }

    public function get_total_count() {
        return $this->db->count_all_results('pb_manufacturer');
    }
    
    public function get_active_count() {
        return $this->db->where('state', 1)
                       ->where('is_closed', 0)
                       ->count_all_results('pb_manufacturer');
    }
    
    public function get_inactive_count() {
        return $this->db->where('state', 0)
                       ->or_where('is_closed', 1)
                       ->count_all_results('pb_manufacturer');
    }
    
    public function get_recent_manufacturers($limit = 5) {
        return $this->db->select('id, biz_name, representative_name, updated_at')
                       ->from('tb_manufacturer')
                       ->order_by('updated_at', 'DESC')
                       ->limit($limit)
                       ->get()
                       ->result();
    }
}