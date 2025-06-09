<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drug_class extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('drug_class_model');
        $this->load->library('pagination');
        
        // 로그인 체크
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('auth/login');
        }
    }
    
    public function index() {
        // 정렬 파라미터
        $sort_by = $this->input->get('sort_by');
        $sort_dir = $this->input->get('sort_dir');

        // 디버그 로깅
        log_message('debug', '[Before] Received Parameters - sort_by: ' . $sort_by . ', sort_dir: ' . $sort_dir);

        // 유효성 검사 및 기본값 설정
        if (!in_array($sort_by, ['product_count', 'avg_commission_rate', 'avg_commission'])) {
            $sort_by = 'product_count';
        }
        
        // sort_dir이 null이거나 빈 문자열인 경우 기본값 'DESC' 설정
        $sort_dir = ($sort_dir === null || trim($sort_dir) === '') ? 'DESC' : strtoupper(trim($sort_dir));
        
        // 정렬 방향 유효성 검사
        if (!in_array($sort_dir, ['ASC', 'DESC'])) {
            $sort_dir = 'DESC';
        }

        // 디버그 로깅
        log_message('debug', '[After] Processed Parameters - sort_by: ' . $sort_by . ', sort_dir: ' . $sort_dir);
        
        // 페이징 설정
        $config['base_url'] = site_url('drug_class');
        $config['total_rows'] = $this->drug_class_model->get_total_count();
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;

        // Bootstrap 5 스타일 페이징 설정
        $config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        
        $config['first_link'] = '처음';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['first_url'] = site_url('drug_class') . '?page=0';
        
        $config['last_link'] = '마지막';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        
        $config['next_link'] = '다음';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        
        $config['prev_link'] = '이전';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        
        $config['attributes'] = array('class' => 'page-link');
        
        $this->pagination->initialize($config);
        
        // 현재 페이지 (0부터 시작)
        $page = ($this->input->get($config['query_string_segment'])) ? $this->input->get($config['query_string_segment']) : 0;
        
        // 디버깅 정보
        $debug = array(
            'requested_sort_by' => $this->input->get('sort_by'),
            'requested_sort_dir' => $this->input->get('sort_dir'),
            'actual_sort_by' => $sort_by,
            'actual_sort_dir' => $sort_dir,
            'page' => $page,
            'per_page' => $config['per_page']
        );
        
        // 데이터 가져오기
        $data['classes'] = $this->drug_class_model->get_class_statistics($config['per_page'], $page, $sort_by, $sort_dir);
        $data['pagination'] = $this->pagination->create_links();
        
        // 정렬 변수를 뷰에 전달
        $data['sort_by'] = $sort_by;
        $data['sort_dir'] = $sort_dir;
        
        // 뷰 로드
        $this->load->view('templates/header');
        $this->load->view('drug_class/list', $data);
        $this->load->view('templates/footer');
    }

    /**
     * 분류 상세 정보를 보여주는 메소드
     * 
     * @param string $drug_class_cd 의약품 분류 코드
     */
    public function detail($drug_class_cd) {
        // 분류 상세 정보 가져오기
        $data['class_info'] = $this->drug_class_model->get_class_detail($drug_class_cd);
        
        if (!$data['class_info']) {
            show_404();
            return;
        }
        
        // 해당 분류의 제품 목록 가져오기
        $data['products'] = $this->drug_class_model->get_class_products($drug_class_cd);
        
        // 뷰 로드
        $this->load->view('templates/header');
        $this->load->view('drug_class/detail', $data);
        $this->load->view('templates/footer');
    }
} 