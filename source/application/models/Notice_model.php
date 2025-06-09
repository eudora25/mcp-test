<?php
class Notice_model extends CI_Model {

	/**
     * 공지사항 리스트에 제품명, 제약사명, 성분명, 자사제품 여부를 포함하여 가져오는 메서드
     * (제조사 ID가 1인 제품의 공지만 포함)
     * @param array $admin 관리자 정보 배열
     * @param int|null $limit 가져올 레코드 수
     * @param int|null $start 시작 오프셋
     * @param string|null $keyword 검색 키워드
     * @return array 공지사항 데이터 배열
     */
    public function get_notices_full_info($admin, $limit = NULL, $start = NULL, $keyword = NULL)
    {
        // 서브쿼리 - 다른 제조사의 제품만 필터링
        $subquery = $this->db->select('p.id')
                            ->from('tb_product p')
                            ->where('p.manufacturer_id !=', $admin['user_id'])
                            ->get_compiled_select();

        $select = "n.*, 
                  p.name as product_name, 
                  p.drug_class_cd,
                  ac.name as drug_class_name,
                  m.biz_name as manufacturer_name,
                  n.notice_class_cd,
                  c.name as notice_class_name,
                  CASE 
                    WHEN n.noti_crisis_level = 'A' THEN '긴급'
                    WHEN n.noti_crisis_level = 'B' THEN '중요'
                    ELSE '일반'
                  END as crisis_level_name,
                  CASE 
                    WHEN n.noti_category = 'L' THEN '법령'
                    WHEN n.noti_category = 'M' THEN '제조'
                    WHEN n.noti_category = 'S' THEN '안전'
                    ELSE '기타'
                  END as category_name";
                  
        $this->db->select($select, FALSE);
        $this->db->from('tb_product_notice n');
        $this->db->join('tb_product p', 'n.product_id = p.id', 'left');
        $this->db->join('tb_manufacturer m', 'p.manufacturer_id = m.id', 'left');
        $this->db->join('administrative_code ac', 'ac.code = p.drug_class_cd', 'left');
        $this->db->join('pb_code c', 'c.code = n.notice_class_cd', 'left');
        $this->db->where('n.product_id IN (' . $subquery . ')', NULL, FALSE);

        // 검색어가 있는 경우
        if ($keyword) {
            $this->db->group_start();
            $this->db->like('n.content', $keyword);
            $this->db->or_like('p.name', $keyword);
            $this->db->or_like('m.biz_name', $keyword);
            $this->db->group_end();
        }

        // 정렬
        $this->db->order_by('n.noti_date', 'DESC');
        $this->db->order_by('n.noti_crisis_level', 'ASC');

        // 페이징
        if ($limit !== NULL) {
            $this->db->limit($limit, $start);
        }

        $query = $this->db->get();
        return $query->result();
    }

  
   /**
     * 전체 공지사항 개수를 반환하는 메서드 (페이징용)
     * (제조사 ID가 130인 제품의 공지만 개수 계산)
     * @param array $admin 관리자 정보 배열
     * @param string|null $keyword 검색 키워드
     * @return int 전체 레코드 수
     */
    public function count_all_notices($admin, $keyword = NULL)
    {
        // 서브쿼리 - 다른 제조사의 제품만 필터링
        $subquery = $this->db->select('p.id')
                            ->from('tb_product p')
                            ->where('p.manufacturer_id !=', $admin['user_id'])
                            ->get_compiled_select();

        $this->db->select('COUNT(DISTINCT n.id) as total_count');
        $this->db->from('tb_product_notice n');
        $this->db->join('tb_product p', 'n.product_id = p.id', 'left');
        $this->db->join('tb_manufacturer m', 'p.manufacturer_id = m.id', 'left');
        $this->db->where('n.product_id IN (' . $subquery . ')', NULL, FALSE);

        if ($keyword) {
            $this->db->group_start();
            $this->db->like('n.content', $keyword);
            $this->db->or_like('p.name', $keyword);
            $this->db->or_like('m.biz_name', $keyword);
            $this->db->group_end();
        }

        $result = $this->db->get()->row();
        return $result->total_count;
    }

    /**
     * 대시보드용 경쟁사 제품 공지사항 목록을 가져옵니다.
     * 
     * @param array $admin 관리자 정보 배열
     * @param int $limit 가져올 공지사항 수
     * @return array 공지사항 목록
     */
    public function get_product_notices($admin, $limit = 5) {
        // 서브쿼리 - 다른 제조사의 제품 공지만 필터링
        $subquery = $this->db->select('p.id')
                            ->from('tb_product p')
                            ->where('p.manufacturer_id !=', $admin['user_id'])
                            ->get_compiled_select();

        $select = "n.*, 
                  p.name as product_name, 
                  p.drug_class_cd,
                  ac.name as drug_class_name,
                  m.biz_name as manufacturer_name,
                  n.notice_class_cd,
                  c.name as notice_class_name,
                  CASE 
                    WHEN n.noti_crisis_level = 'A' THEN '긴급'
                    WHEN n.noti_crisis_level = 'B' THEN '중요'
                    ELSE '일반'
                  END as crisis_level_name,
                  CASE 
                    WHEN n.noti_category = 'L' THEN '법령'
                    WHEN n.noti_category = 'M' THEN '제조'
                    WHEN n.noti_category = 'S' THEN '안전'
                    ELSE '기타'
                  END as category_name";

        $this->db->select($select, FALSE);
        $this->db->from('tb_product_notice n');
        $this->db->join('tb_product p', 'n.product_id = p.id', 'left');
        $this->db->join('tb_manufacturer m', 'p.manufacturer_id = m.id', 'left');
        $this->db->join('administrative_code ac', 'ac.code = p.drug_class_cd AND ac.group_code = "DRG_CLS_NO" AND ac.state = 1', 'left');
        $this->db->join('pb_code c', 'c.code = n.notice_class_cd', 'left');
        $this->db->where('n.product_id IN (' . $subquery . ')', NULL, FALSE);
        $this->db->order_by('n.noti_date', 'DESC');
        $this->db->order_by('n.noti_crisis_level', 'ASC');
        $this->db->limit($limit);

        return $this->db->get()->result();
    }
}