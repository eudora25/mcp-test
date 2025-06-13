<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_search_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function search_products($keyword, $limit = 10, $offset = 0) {
        // 기본 제품 정보 가져오기
        $this->db->select('p.id, 
                          p.name as product_name, 
                          p.reimbursement_price, 
                          p.state, 
                          p.edi_code,
                          p.drug_class_cd,
                          p.sales_commission_rate as commission_rate, 
                          p.commission, 
                          p.created_at,
                          m.biz_name as manufacturer_name')
                 ->from('tb_product p')
                 ->join('tb_manufacturer m', 'm.id = p.manufacturer_id', 'left')
                 ->where('p.state', 1);
        
        // 검색 조건 추가
        if (!empty($keyword)) {
            $this->db->group_start()
                    ->like('p.name', $keyword)
                    ->or_like('p.edi_code', $keyword)
                    ->or_like('m.biz_name', $keyword)
                 ->group_end();
        }
        
        $this->db->order_by('p.name', 'ASC')
                 ->limit($limit, $offset);
        
        $result = $this->db->get()->result();
        
        // 각 제품에 대해 분류와 성분 정보를 별도로 가져오기
        foreach ($result as $product) {
            // 판매상태는 state 컬럼을 기준으로 설정
            $product->sale_yn = ($product->state == 1) ? 'Y' : 'N';
            
            // 분류 정보 가져오기
            if (!empty($product->drug_class_cd)) {
                $class_query = $this->db->select('name')
                                       ->from('administrative_code')
                                       ->where('code', $product->drug_class_cd)
                                       ->where('group_code', 'DRG_CLS_NO')
                                       ->where('state', 1)
                                       ->get();
                if ($class_query->num_rows() > 0) {
                    $product->drug_class_name = $class_query->row()->name;
                } else {
                    $product->drug_class_name = $product->drug_class_cd;
                }
            } else {
                $product->drug_class_name = 'N/A';
            }
            
            // 성분 정보 가져오기
            $ingredient_query = $this->db->select('GROUP_CONCAT(DISTINCT ai.name SEPARATOR ", ") as ingredients')
                                        ->from('tb_product_active_ingredient pai')
                                        ->join('tb_active_ingredient ai', 'pai.ingredient_id = ai.id')
                                        ->where('pai.product_id', $product->id)
                                        ->get();
            
            if ($ingredient_query->num_rows() > 0 && !empty($ingredient_query->row()->ingredients)) {
                $product->ingredient = $ingredient_query->row()->ingredients;
            } else {
                $product->ingredient = 'N/A';
            }
        }
        
        return $result;
    }
    
    public function count_search_results($keyword) {
        $this->db->select('COUNT(DISTINCT p.id) as total')
                 ->from('tb_product p')
                 ->join('tb_manufacturer m', 'm.id = p.manufacturer_id', 'left')
                 ->where('p.state', 1);
        
        // 검색 조건 추가
        if (!empty($keyword)) {
            $this->db->group_start()
                    ->like('p.name', $keyword)
                    ->or_like('p.edi_code', $keyword)
                    ->or_like('m.biz_name', $keyword)
                 ->group_end();
        }
        
        $result = $this->db->get()->row();
        return $result->total;
    }
} 