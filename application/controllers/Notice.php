<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('notice_model'); // Notice_model 로드
        $this->load->library('pagination'); // 페이징 라이브러리 로드
        $this->load->helper('url'); // URL 헬퍼 로드
        $this->load->helper('form'); // 폼 헬퍼 로드 (검색 폼에 필요)
        
        // UTF-8 인코딩 설정
        mb_internal_encoding('UTF-8');
        
        // 로그인 체크
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('auth/login');
        }
    }
	public function index()
    {
		// 검색어가 있는 경우
		$keyword = $this->input->get('search');
		$admin = array('user_id' => $this->session->userdata('manufacturer_id'));

		// 전체 레코드 수 계산
		$total_rows = $this->notice_model->count_all_notices($admin, $keyword);

		// 페이징 설정
		$config = array();
		$config['base_url'] = site_url('notice');
		$config['total_rows'] = $total_rows;
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

		// 현재 페이지 번호 가져오기
		$page = $this->input->get($config['query_string_segment']) ? $this->input->get($config['query_string_segment']) : 0;

		// 데이터 준비
		$data = array(
			'notices' => $this->notice_model->get_notices_full_info($admin, $config['per_page'], $page, $keyword),
			'pagination_links' => $this->pagination->create_links(),
			'search_keyword' => $keyword
		);

		// 뷰 로드
		$this->load->view('notices/list', $data);
	}
}