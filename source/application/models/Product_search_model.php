<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_search_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function search_products($keyword, $limit = 10, $offset = 0) {
        $this->db->select('p.id, p.name, p.reimbursement_price, p.state, p.edi_code,
                          ai.name as ingredient_name,
                          p.sales_commission_rate, p.commission, 
                          m.biz_name as manufacturer_name,
                          GROUP_CONCAT(DISTINCT ai.name) as ingredients')
                 ->from('tb_product p')
                 ->join('tb_manufacturer m', 'm.id = p.manufacturer_id', 'left')
                 ->join('tb_product_active_ingredient pai', 'pai.product_id = p.id', 'left')
                 ->join('tb_active_ingredient ai', 'pai.ingredient_id = ai.id', 'left')
                 ->where('p.state', 1)
                 ->group_start()
                    ->like('p.name', $keyword)
                    ->or_like('p.edi_code', $keyword)
                    ->or_like('ai.name', $keyword)
                 ->group_end()
                 ->group_by('p.id, m.biz_name')
                 ->order_by('p.name', 'ASC')
                 ->limit($limit, $offset);
        
        return $this->db->get()->result();
    }
    
    public function count_search_results($keyword) {
        $this->db->select('COUNT(DISTINCT p.id) as total')
                 ->from('tb_product p')
                 ->join('tb_manufacturer m', 'm.id = p.manufacturer_id', 'left')
                 ->join('tb_product_active_ingredient pai', 'pai.product_id = p.id', 'left')
                 ->join('tb_active_ingredient ai', 'pai.ingredient_id = ai.id', 'left')
                 ->where('p.state', 1)
                 ->group_start()
                    ->like('p.name', $keyword)
                    ->or_like('p.edi_code', $keyword)
                    ->or_like('ai.name', $keyword)
                 ->group_end();
        
        $result = $this->db->get()->row();
        return $result->total;
    }
} 