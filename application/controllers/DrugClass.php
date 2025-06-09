<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DrugClass extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('drug_class_model');
        $this->load->library('pagination');
    }

    public function index() {
        // 페이지네이션 설정
        $config['base_url'] = base_url('drug_class');
        $config['total_rows'] = $this->drug_class_model->get_total_count();
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        
        // 페이지네이션 스타일 설정
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '처음';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
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
        
        // 현재 페이지 오프셋 계산
        $page = $this->input->get('page') ? $this->input->get('page') : 0;
        
        // 데이터 가져오기
        $data['classes'] = $this->drug_class_model->get_class_statistics($config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
        
        // 뷰 로드
        $this->load->view('templates/header');
        $this->load->view('drug_class/list', $data);
        $this->load->view('templates/footer');
    }

    public function detail($drug_class_cd) {
        // 분류 상세 정보 가져오기
        $data['class_info'] = $this->drug_class_model->get_class_detail($drug_class_cd);
        $data['products'] = $this->drug_class_model->get_class_products($drug_class_cd);
        
        // 뷰 로드
        $this->load->view('templates/header');
        $this->load->view('drug_class/detail', $data);
        $this->load->view('templates/footer');
    }
} 