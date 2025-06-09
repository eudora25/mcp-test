<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_total_count() {
        return $this->db->count_all_results('tb_product');
    }
    
    public function get_on_sale_count() {
        return $this->db->where('state', '1')
                       ->count_all_results('tb_product');
    }
    
    public function get_off_sale_count() {
        return $this->db->where('state', '0')
                       ->count_all_results('tb_product');
    }
    
    public function get_recent_products($limit = 5) {
        return $this->db->select('p.*, p.name as product_name, m.biz_name as manufacturer_name')
                       ->from('tb_product p')
                       ->join('tb_manufacturer m', 'm.id = p.manufacturer_id')
                       ->order_by('p.created_at', 'DESC')
                       ->limit($limit)
                       ->get()
                       ->result();
    }

    /**
     * 제조사별 제품 수와 순위를 계산
     * @param int $manufacturer_id
     * @return array
     */
    public function get_product_count_rank($manufacturer_id)
    {
        // 제조사별 제품 수 계산
        $this->db->select('m.id, COUNT(p.id) as product_count');
        $this->db->from('tb_manufacturer m');
        $this->db->join('tb_product p', 'm.id = p.manufacturer_id', 'left');
        $this->db->group_by('m.id');
        $this->db->order_by('product_count', 'DESC');
        $query = $this->db->get();
        $results = $query->result_array();
        
        // 순위 계산
        $rank = 0;
        $last_count = null;
        $real_rank = 0;
        
        foreach ($results as $row) {
            $real_rank++;
            if ($last_count !== $row['product_count']) {
                $rank = $real_rank;
            }
            if ($row['id'] == $manufacturer_id) {
                return array(
                    'count' => $row['product_count'],
                    'rank' => $rank,
                    'total' => count($results)
                );
            }
            $last_count = $row['product_count'];
        }
        
        return array('count' => 0, 'rank' => 0, 'total' => count($results));
    }

    /**
     * 제조사별 평균 수수료율과 순위를 계산
     * @param int $manufacturer_id
     * @return array
     */
    public function get_commission_rate_rank($manufacturer_id)
    {
        // 제조사별 평균 수수료율 계산
        $this->db->select('m.id, AVG(p.sales_commission_rate) as avg_rate');
        $this->db->from('tb_manufacturer m');
        $this->db->join('tb_product p', 'm.id = p.manufacturer_id', 'left');
        $this->db->group_by('m.id');
        $this->db->having('avg_rate IS NOT NULL');
        $this->db->order_by('avg_rate', 'DESC');
        $query = $this->db->get();
        $results = $query->result_array();
        
        // 순위 계산
        $rank = 0;
        $last_rate = null;
        $real_rank = 0;
        
        foreach ($results as $row) {
            $real_rank++;
            if ($last_rate !== $row['avg_rate']) {
                $rank = $real_rank;
            }
            if ($row['id'] == $manufacturer_id) {
                return array(
                    'rate' => $row['avg_rate'],
                    'rank' => $rank,
                    'total' => count($results)
                );
            }
            $last_rate = $row['avg_rate'];
        }
        
        return array('rate' => 0, 'rank' => 0, 'total' => count($results));
    }

    /**
     * 제조사별 평균 수수료와 순위를 계산
     * @param int $manufacturer_id
     * @return array
     */
    public function get_commission_amount_rank($manufacturer_id)
    {
        // 제조사별 평균 수수료 계산
        $this->db->select('m.id, AVG(p.commission) as avg_amount');
        $this->db->from('tb_manufacturer m');
        $this->db->join('tb_product p', 'm.id = p.manufacturer_id', 'left');
        $this->db->group_by('m.id');
        $this->db->having('avg_amount IS NOT NULL');
        $this->db->order_by('avg_amount', 'DESC');
        $query = $this->db->get();
        $results = $query->result_array();
        
        // 순위 계산
        $rank = 0;
        $last_amount = null;
        $real_rank = 0;
        
        foreach ($results as $row) {
            $real_rank++;
            if ($last_amount !== $row['avg_amount']) {
                $rank = $real_rank;
            }
            if ($row['id'] == $manufacturer_id) {
                return array(
                    'amount' => $row['avg_amount'],
                    'rank' => $rank,
                    'total' => count($results)
                );
            }
            $last_amount = $row['avg_amount'];
        }
        
        return array('amount' => 0, 'rank' => 0, 'total' => count($results));
    }

    public function get_product_detail($product_id) {
        return $this->db->select('p.*, 
                                m.biz_name as manufacturer_name,
                                m.biz_name as manufacturer_biz_name,
                                ac.name as drug_class_name,
                                GROUP_CONCAT(DISTINCT ai.name) as ingredients')
                       ->from('tb_product p')
                       ->join('tb_manufacturer m', 'm.id = p.manufacturer_id', 'left')
                       ->join('administrative_code ac', 'ac.code = p.drug_class_cd AND ac.group_code = "DRG_CLS_NO" AND ac.state = 1', 'left')
                       ->join('tb_product_active_ingredient pai', 'pai.product_id = p.id', 'left')
                       ->join('tb_active_ingredient ai', 'pai.ingredient_id = ai.id', 'left')
                       ->where('p.id', $product_id)
                       ->group_by('p.id')
                       ->get()
                       ->row();
    }

    public function get_class_rankings($product_id) {
        // 제품의 분류 코드 조회
        $product = $this->db->select('drug_class_cd, commission')
                           ->from('tb_product')
                           ->where('id', $product_id)
                           ->get()
                           ->row();
        
        if (!$product) {
            return null;
        }

        // 동일 분류 내 제품들의 수수료 순위 조회
        $this->db->select('p.id, p.name, p.commission')
                 ->from('tb_product p')
                 ->where('p.drug_class_cd', $product->drug_class_cd)
                 ->where('p.state', 1)  // 판매중인 제품만
                 ->order_by('p.commission', 'DESC');
        
        $query = $this->db->get();
        $products = $query->result();
        
        // 순위 계산
        $rank = 0;
        $last_commission = null;
        $real_rank = 0;
        $total_count = count($products);
        $current_rank = 0;
        $top_products = array();
        
        foreach ($products as $idx => $p) {
            $real_rank++;
            if ($last_commission !== $p->commission) {
                $rank = $real_rank;
            }
            
            if ($p->id == $product_id) {
                $current_rank = $rank;
            }
            
            // 상위 5개 제품 저장
            if ($idx < 5) {
                $top_products[] = array(
                    'name' => $p->name,
                    'commission' => $p->commission,
                    'rank' => $rank
                );
            }
            
            $last_commission = $p->commission;
        }
        
        return array(
            'current_rank' => $current_rank,
            'total_count' => $total_count,
            'top_products' => $top_products
        );
    }
} 