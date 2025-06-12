<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('drug_class_model');
        $this->load->model('manufacturer_model');
        $this->load->model('product_model');
        $this->load->model('notice_model');
        $this->load->library('session');
        
        // 로그인 체크
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('auth/login');
            return;
        }
    }
    
    public function index() {
        $manufacturer_id = $this->session->userdata('manufacturer_id');
        
        // 순위 정보 가져오기
        $product_rank = $this->product_model->get_product_count_rank($manufacturer_id);
        $commission_rate_rank = $this->product_model->get_commission_rate_rank($manufacturer_id);
        $commission_amount_rank = $this->product_model->get_commission_amount_rank($manufacturer_id);
        
        $admin = array('user_id' => $manufacturer_id);
        // 데이터 준비
        $data = array(
            // 상위 10개 분류 데이터
            'top_classes' => $this->drug_class_model->get_top_classes(10),
            
            // 제조사 통계
            'manufacturer_stats' => array(
                'total' => $this->manufacturer_model->get_total_count(),
                'active' => $this->manufacturer_model->get_active_count(),
                'inactive' => $this->manufacturer_model->get_inactive_count()
            ),
            
            // 제품 통계
            'product_stats' => array(
                'total' => $this->product_model->get_total_count(),
                'on_sale' => $this->product_model->get_on_sale_count(),
                'off_sale' => $this->product_model->get_off_sale_count()
            ),
            
            // 최근 데이터
            'recent_products' => $this->product_model->get_recent_products(5),
            'recent_manufacturers' => $this->manufacturer_model->get_recent_manufacturers(5),
            
            // 현재 제조사 정보
            'current_manufacturer_name' => $this->manufacturer_model->get_manufacturer_name($manufacturer_id),
            'current_manufacturer_total_products' => $this->manufacturer_model->get_total_products_by_manufacturer($manufacturer_id),
            'current_manufacturer_rank' => $this->manufacturer_model->get_manufacturer_rank($manufacturer_id),
            
            // 공지사항
            'notices' => $this->notice_model->get_notices_full_info($admin, 5, NULL, NULL),
            
            // 사용자 정보
            'username' => $this->session->userdata('admin_name'),
            
            // 최근 수정된 제조사 가져오기
            'recent_manufacturers' => $this->manufacturer_model->get_recent_manufacturers(5),
            
            // 최근 제품 공지사항 가져오기
            'recent_notices' => $this->notice_model->get_product_notices($admin, 5),
            
            // 순위 정보 추가
            'product_rank' => $product_rank,
            'commission_rate_rank' => $commission_rate_rank,
            'commission_amount_rank' => $commission_amount_rank
        );
        
        // 뷰 로드 (새로운 독립형 대시보드)
        $this->load->view('dashboard/index', $data);
    }

    public function product_analysis($product_id) {
        // 제품 기본 정보 조회
        $this->load->model('product_model');
        $product = $this->product_model->get_product_detail($product_id);
        
        if (!$product) {
            show_404();
            return;
        }
        
        // 동일 분류 내 순위 정보 조회
        $rankings = $this->product_model->get_class_rankings($product_id);
        
        $data = array(
            'product' => $product,
            'rankings' => $rankings
        );
        
        $this->load->view('dashboard/product_analysis', $data);
    }
} 