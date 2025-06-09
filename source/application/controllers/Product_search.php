<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_search extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('product_search_model');
        $this->load->library('pagination');
        $this->load->helper('url');
        
        // 로그인 체크
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('auth/login');
        }
    }
    
    public function index() {
        $keyword = $this->input->get('search');
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $per_page = 10;
        
        $data = array(
            'search_keyword' => $keyword,
            'products' => array(),
            'pagination_links' => ''
        );
        
        if ($keyword) {
            // 전체 검색 결과 수 계산
            $total_rows = $this->product_search_model->count_search_results($keyword);
            
            // 페이지네이션 설정
            $config['base_url'] = site_url('product_search');
            $config['total_rows'] = $total_rows;
            $config['per_page'] = $per_page;
            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'page';
            
            // Bootstrap 5 스타일 페이지네이션
            $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
            $config['full_tag_close'] = '</ul></nav>';
            $config['first_link'] = '처음';
            $config['last_link'] = '마지막';
            $config['next_link'] = '다음';
            $config['prev_link'] = '이전';
            $config['num_tag_open'] = '<li class="page-item">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['next_tag_open'] = '<li class="page-item">';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li class="page-item">';
            $config['prev_tag_close'] = '</li>';
            $config['first_tag_open'] = '<li class="page-item">';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li class="page-item">';
            $config['last_tag_close'] = '</li>';
            $config['attributes'] = array('class' => 'page-link');
            
            // 검색어 유지
            $config['suffix'] = '&search=' . urlencode($keyword);
            $config['first_url'] = $config['base_url'] . '?search=' . urlencode($keyword);
            
            $this->pagination->initialize($config);
            
            // 검색 결과 가져오기
            $offset = ($page - 1) * $per_page;
            $data['products'] = $this->product_search_model->search_products($keyword, $per_page, $offset);
            $data['pagination_links'] = $this->pagination->create_links();
        }
        
        $this->load->view('product_search/index', $data);
    }
} 