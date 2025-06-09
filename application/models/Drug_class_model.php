<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drug_class_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_total_count() {
        $subquery = $this->db->select('p.drug_class_cd')
                            ->from('tb_product p')
                            ->where('p.drug_class_cd IS NOT NULL')
                            ->where('p.state', 1)
                            ->group_by('p.drug_class_cd')
                            ->get_compiled_select();
                            
        $result = $this->db->query("SELECT COUNT(*) as total FROM ({$subquery}) t")->row();
        return $result->total;
    }
    
    public function get_top_classes($limit = 10) {
        // 기본 쿼리
        $result = $this->db->select('p.drug_class_cd, 
                                   ac.name as drug_class_name,
                                   COUNT(*) as product_count,
                                   CAST(AVG(p.sales_commission_rate) AS DECIMAL(10,2)) as avg_commission_rate,
                                   CAST(AVG(p.commission) AS DECIMAL(10,2)) as avg_commission')
                          ->from('tb_product p')
                          ->join('administrative_code ac', 'ac.code = p.drug_class_cd AND ac.group_code = "DRG_CLS_NO" AND ac.state = 1', 'left')
                          ->where('p.drug_class_cd IS NOT NULL')
                          ->where('p.state', 1)
                          ->group_by('p.drug_class_cd, ac.name')
                          ->order_by('product_count', 'DESC')
                          ->limit($limit)
                          ->get()
                          ->result();

        // 순위 계산을 위한 전체 데이터 가져오기
        $all_data = $this->db->select('p.drug_class_cd, 
                                     COUNT(*) as product_count,
                                     CAST(AVG(p.sales_commission_rate) AS DECIMAL(10,2)) as avg_commission_rate,
                                     CAST(AVG(p.commission) AS DECIMAL(10,2)) as avg_commission')
                            ->from('tb_product p')
                            ->where('p.drug_class_cd IS NOT NULL')
                            ->where('p.state', 1)
                            ->group_by('p.drug_class_cd')
                            ->get()
                            ->result();

        // 전체 분류 수
        $total_count = count($all_data);

        // 순위 맵 생성
        $commission_ranks = [];
        $commission_rate_ranks = [];
        $prev_commission = null;
        $prev_rate = null;
        $commission_rank = 0;
        $rate_rank = 0;
        $count = 0;

        // 수수료율 기준 정렬
        usort($all_data, function($a, $b) {
            return (float)$b->avg_commission_rate <=> (float)$a->avg_commission_rate;
        });

        foreach ($all_data as $item) {
            $count++;
            
            // 수수료율 순위 계산
            if ($prev_rate !== $item->avg_commission_rate) {
                $rate_rank = $count;
                $prev_rate = $item->avg_commission_rate;
            }
            $commission_rate_ranks[$item->drug_class_cd] = $rate_rank;
        }

        // 수수료 금액 기준 정렬
        usort($all_data, function($a, $b) {
            return (float)$b->avg_commission <=> (float)$a->avg_commission;
        });

        $count = 0;
        foreach ($all_data as $item) {
            $count++;
            
            // 수수료 순위 계산
            if ($prev_commission !== $item->avg_commission) {
                $commission_rank = $count;
                $prev_commission = $item->avg_commission;
            }
            $commission_ranks[$item->drug_class_cd] = $commission_rank;
        }

        // 결과에 순위 적용
        foreach ($result as $item) {
            // 수수료 값들을 float로 형변환
            $item->avg_commission_rate = (float)$item->avg_commission_rate;
            $item->avg_commission = (float)$item->avg_commission;
            // 순위와 전체 개수를 별도 필드로 분리
            $item->commission_rank_num = (int)$commission_ranks[$item->drug_class_cd];
            $item->commission_rate_rank_num = (int)$commission_rate_ranks[$item->drug_class_cd];
            $item->total_count = $total_count;
        }
                       
        return $result;
    }
    
    public function get_class_statistics($limit, $offset, $sort_by = 'product_count', $sort_dir = 'DESC') {
        // 유효한 정렬 컬럼 확인
        $valid_sort_columns = [
            'product_count' => 'product_count',
            'avg_commission_rate' => 'avg_commission_rate',
            'avg_commission' => 'avg_commission'
        ];

        // 기본 정렬 설정
        $sort_column = isset($valid_sort_columns[$sort_by]) ? $valid_sort_columns[$sort_by] : 'product_count';
        $sort_direction = strtoupper($sort_dir) === 'ASC' ? 'ASC' : 'DESC';

        // 디버그 로그 추가
        log_message('debug', '[Model] Sort Parameters - Column: ' . $sort_column . ', Direction: ' . $sort_direction);

        // 기본 통계 데이터를 위한 서브쿼리
        $base_query = $this->db->select('p.drug_class_cd, 
                                       COUNT(*) as product_count,
                                       CAST(AVG(p.sales_commission_rate) AS DECIMAL(10,2)) as avg_commission_rate,
                                       CAST(AVG(p.commission) AS DECIMAL(10,2)) as avg_commission')
                              ->from('tb_product p')
                              ->where('p.drug_class_cd IS NOT NULL')
                              ->where('p.state', 1)
                              ->group_by('p.drug_class_cd')
                              ->get_compiled_select();

        // 전체 분류 수 계산
        $total_count = $this->db->query("SELECT COUNT(*) as total FROM ({$base_query}) t")->row()->total;

        // ORDER BY 절 구성
        $order_by = "";
        if ($sort_column === 'product_count') {
            $order_by = "bs.product_count {$sort_direction}";
        } elseif ($sort_column === 'avg_commission_rate') {
            $order_by = "bs.avg_commission_rate {$sort_direction}";
        } elseif ($sort_column === 'avg_commission') {
            $order_by = "bs.avg_commission {$sort_direction}";
        }

        // 메인 쿼리
        $main_query = "WITH base_stats AS (
            {$base_query}
        )
        SELECT 
            bs.*,
            ac.name as drug_class_name,
            {$total_count} as total_count,
            DENSE_RANK() OVER (ORDER BY bs.avg_commission DESC) as commission_rank_num,
            DENSE_RANK() OVER (ORDER BY bs.avg_commission_rate DESC) as commission_rate_rank_num
        FROM base_stats bs
        LEFT JOIN administrative_code ac ON ac.code = bs.drug_class_cd 
            AND ac.group_code = 'DRG_CLS_NO' 
            AND ac.state = 1
        ORDER BY {$order_by}, bs.drug_class_cd ASC
        LIMIT ?, ?";

        // offset과 limit를 정수로 변환
        $offset = (int)$offset;
        $limit = (int)$limit;

        // 디버그 로그 추가
        log_message('debug', '[Model] Generated SQL: ' . str_replace('?, ?', $offset . ', ' . $limit, $main_query));

        $result = $this->db->query($main_query, array($offset, $limit))->result();

        // 결과의 수수료 값들을 float로 형변환
        foreach ($result as $item) {
            $item->avg_commission_rate = (float)$item->avg_commission_rate;
            $item->avg_commission = (float)$item->avg_commission;
            $item->commission_rank_num = (int)$item->commission_rank_num;
            $item->commission_rate_rank_num = (int)$item->commission_rate_rank_num;
            $item->product_count = (int)$item->product_count;
        }

        return $result;
    }
    
    public function get_class_detail($drug_class_cd) {
        // 분류 기본 통계 정보
        $query = $this->db->select('p.drug_class_cd,
                                  ac.name as drug_class_name,
                                  COUNT(*) as product_count,
                                  AVG(p.sales_commission_rate) as avg_commission_rate,
                                  AVG(p.commission) as avg_commission')
                         ->from('tb_product p')
                         ->join('administrative_code ac', 'ac.code = p.drug_class_cd AND ac.group_code = "DRG_CLS_NO" AND ac.state = 1', 'left')
                         ->where('p.drug_class_cd', $drug_class_cd)
                         ->where('p.state', 1)
                         ->group_by('p.drug_class_cd, ac.name')
                         ->get();
                         
        return $query->row();
    }
    
    public function get_class_products($drug_class_cd) {
        // 해당 분류의 제품 목록
        return $this->db->select('p.*, m.name as manufacturer_name, ac.name as drug_class_name')
                       ->from('tb_product p')
                       ->join('pb_manufacturer m', 'm.id = p.manufacturer_id')
                       ->join('administrative_code ac', 'ac.code = p.drug_class_cd AND ac.group_code = "DRG_CLS_NO" AND ac.state = 1', 'left')
                       ->where('p.drug_class_cd', $drug_class_cd)
                       ->order_by('p.commission', 'DESC')
                       ->get()
                       ->result();
    }
} 