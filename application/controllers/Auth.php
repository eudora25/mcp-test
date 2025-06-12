<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth 컨트롤러
 * 
 * 사용자 인증 및 세션 관리 기능을 담당합니다
 * 
 * @author 개발팀
 * @since 2024
 */
class Auth extends CI_Controller {

    /**
     * 생성자
     * 필요한 모델과 라이브러리를 로드합니다
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model'); // Admin_model 로드
		$this->load->model('notice_model'); // Admin_model 로드
		$this->load->model('manufacturer_model'); // Admin_model 로드
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    /**
     * 메인 인덱스 페이지
     * 로그인 상태에 따라 적절한 페이지로 리다이렉트합니다
     * 
     * @return void
     */
    public function index() {
        // 이미 로그인된 경우 대시보드로 이동
        if ($this->session->userdata('admin_logged_in')) {
            redirect('dashboard');
            return;
        }
        // 로그인되지 않은 경우 로그인 페이지로
        redirect('auth/login');
    }

    /**
     * 로그인 처리
     * 
     * @return void
     */
    public function login() {
        // 이미 로그인된 경우 대시보드로 이동
        if ($this->session->userdata('admin_logged_in')) {
            redirect('dashboard');
            return;
        }

        // 폼 유효성 검사 규칙 설정
        $this->_set_login_validation_rules();

        if ($this->form_validation->run() == FALSE) {
            // 폼 유효성 검사 실패 시 로그인 뷰 표시
            $this->load->view('auth/login');
        } else {
            // 폼 유효성 검사 성공 시 로그인 처리
            $this->_process_login();
        }
    }

    /**
     * 로그아웃 처리
     * 
     * @return void
     */
    public function logout() {
        // 모든 세션 데이터 삭제
        $this->session->sess_destroy();
        
        // 로그인 페이지로 이동
        redirect('auth/login');
    }

    /**
     * 대시보드 페이지
     * 로그인한 사용자의 대시보드 정보를 표시합니다
     * 
     * @return void
     */
    public function dashboard() {
        // 로그인이 되어 있지 않으면 로그인 페이지로 리디렉션
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('/auth/login');
        }

        $admin_info = array('user_id' => $this->session->userdata('manufacturer_id'));

        // 대시보드 데이터 준비
        $dashboard_data = $this->_prepare_dashboard_data($admin_info);
        
        // 대시보드 뷰 로드
        $this->load->view('auth/dashboard', $dashboard_data);
    }

    /**
     * 로그인 폼 유효성 검사 규칙 설정
     * 
     * @return void
     */
    private function _set_login_validation_rules()
    {
        // XSS 필터링은 input->post()에서 TRUE 파라미터로 처리
        $this->form_validation->set_rules('admin_id', '아이디', 'required|trim|max_length[50]|alpha_numeric');
        $this->form_validation->set_rules('admin_pw', '비밀번호', 'required|trim|max_length[255]');
    }

    /**
     * 로그인 처리 로직
     * 
     * @return void
     */
    private function _process_login()
    {
        // 입력 데이터 가져오기 (XSS 필터링 포함)
        $admin_id = $this->input->post('admin_id', TRUE);
        $admin_pw = $this->input->post('admin_pw', TRUE);
        
        // 추가 입력 데이터 정제
        $admin_id = $this->_sanitize_input($admin_id);
        
        // 입력 데이터 검증
        if (empty($admin_id) || empty($admin_pw)) {
            $this->session->set_flashdata('error_msg', '아이디와 비밀번호를 모두 입력해주세요.');
            $this->load->view('auth/login');
            return;
        }
        
        // 관리자 정보 조회
        $admin_info = $this->admin_model->get_admin_by_id($admin_id);

        if ($admin_info && password_verify($admin_pw, $admin_info['admin_pw'])) {
            // 로그인 성공
            $this->_set_login_session($admin_info);
            
            // 로그인 성공 로그 기록
            log_message('info', "로그인 성공: {$admin_id} - IP: " . $this->input->ip_address());
            
            redirect('dashboard');
        } else {
            // 로그인 실패
            log_message('error', "로그인 실패: {$admin_id} - IP: " . $this->input->ip_address());
            $this->session->set_flashdata('error_msg', '아이디 또는 비밀번호가 일치하지 않습니다.');
            $this->load->view('auth/login');
        }
    }

    /**
     * 입력 데이터 정제
     * 
     * @param string $input 정제할 입력 데이터
     * @return string 정제된 데이터
     */
    private function _sanitize_input($input)
    {
        // HTML 태그 제거
        $input = strip_tags($input);
        
        // 특수 문자 이스케이프
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        
        // 공백 제거
        $input = trim($input);
        
        // 영문자, 숫자, 밑줄만 허용 (사용자 ID의 경우)
        $input = preg_replace('/[^a-zA-Z0-9_]/', '', $input);
        
        return $input;
    }

    /**
     * 로그인 성공 시 세션 데이터 설정
     * 
     * @param array $admin_info 관리자 정보
     * @return void
     */
    private function _set_login_session($admin_info)
    {
        $session_data = array(
            'manufacturer_id' => $admin_info['manufacturer_id'],
            'admin_id' => $admin_info['admin_id'],
            'admin_name' => $admin_info['admin_name'],
            'admin_logged_in' => TRUE,
            'username' => $admin_info['admin_name'],
            'login_time' => time() // 로그인 시간 기록
        );
        $this->session->set_userdata($session_data);
    }

    /**
     * 대시보드 데이터 준비
     * 
     * @param array $admin_info 관리자 정보
     * @return array 대시보드 데이터
     */
    private function _prepare_dashboard_data($admin_info)
    {
        $data = array();
        
        // 공지사항 데이터
        $this->load->model('Notice_model');
        $data['notices'] = $this->Notice_model->get_notices_full_info(5, '', '', $admin_info);

        // 로그인한 제조사의 이름 가져오기
        $data['current_manufacturer_name'] = $this->manufacturer_model->get_manufacturer_name($admin_info['user_id']);

        // 로그인한 제조사의 총 제품 수 가져오기
        $data['current_manufacturer_total_products'] = $this->manufacturer_model->get_total_products_by_manufacturer($admin_info['user_id']);
        
        // 로그인한 제조사의 제품 수 순위 가져오기
        $data['current_manufacturer_rank'] = $this->manufacturer_model->get_manufacturer_rank($admin_info['user_id']);
        
        return $data;
    }
}