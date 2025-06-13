<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ProductSearch 컨트롤러
 * 
 * 의약품 검색 기능을 담당합니다
 * 
 * @author 개발팀
 * @since 2024
 */
class Product_search extends CI_Controller {
    
    /**
     * 생성자
     * 필요한 모델과 라이브러리를 로드하고 인증을 확인합니다
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('product_search_model');
        $this->load->library('pagination');
        $this->load->helper('url');
        
        // 로그인 체크
        $this->_check_auth();
    }
    
    /**
     * 메인 검색 페이지
     * 
     * @return void
     */
    public function index() {
        $search_keyword = $this->input->get('search');
        $current_page = $this->input->get('page') ? $this->input->get('page') : 1;
        $items_per_page = 10;
        
        $view_data = array(
            'search_keyword' => $search_keyword,
            'products' => array(),
            'pagination_links' => '',
            'page_title' => '제품 검색',
            'page_description' => '원하는 의약품을 빠르게 검색하고 상세 정보를 확인하세요',
            'page_icon' => 'fas fa-search'
        );
        
        if ($search_keyword) {
            // 전체 검색 결과 수 계산
            $total_rows = $this->product_search_model->count_search_results($search_keyword);
            
            // 페이지네이션 설정
            $pagination_config = $this->_get_pagination_config($search_keyword, $total_rows, $items_per_page);
            $this->pagination->initialize($pagination_config);
            
            // 검색 결과 가져오기
            $offset = ($current_page - 1) * $items_per_page;
            $view_data['products'] = $this->product_search_model->search_products($search_keyword, $items_per_page, $offset);
            $view_data['pagination_links'] = $this->pagination->create_links();
        } else {
            // 검색어가 없으면 최근 제품 10개 표시
            $view_data['products'] = $this->product_search_model->search_products('', 10, 0);
        }
        
        $this->load->view('product_search/index', $view_data);
    }
    
    /**
     * 사용자 인증 확인
     * 
     * @return void
     */
    private function _check_auth()
    {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('auth/login');
        }
    }
    
    /**
     * 페이지네이션 설정을 반환합니다
     * 
     * @param string $search_keyword 검색 키워드
     * @param int $total_rows 전체 행 수
     * @param int $items_per_page 페이지당 아이템 수
     * @return array 페이지네이션 설정 배열
     */
    private function _get_pagination_config($search_keyword, $total_rows, $items_per_page)
    {
        $config = array();
        $config['base_url'] = site_url('product_search');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $items_per_page;
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
        $config['suffix'] = '&search=' . urlencode($search_keyword);
        $config['first_url'] = $config['base_url'] . '?search=' . urlencode($search_keyword);
        
        return $config;
    }
} 