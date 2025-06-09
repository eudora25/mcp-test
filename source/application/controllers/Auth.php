<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model'); // Admin_model 로드
		$this->load->model('notice_model'); // Admin_model 로드
		$this->load->model('manufacturer_model'); // Admin_model 로드
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index() {
        // 이미 로그인된 경우 대시보드로 이동
        if ($this->session->userdata('admin_logged_in')) {
            redirect('dashboard');
            return;
        }
        // 로그인되지 않은 경우 로그인 페이지로
        redirect('auth/login');
    }

    public function login() {
        // 이미 로그인된 경우 대시보드로 이동
        if ($this->session->userdata('admin_logged_in')) {
            redirect('dashboard');
            return;
        }

        $this->form_validation->set_rules('admin_id', '아이디', 'required|trim');
        $this->form_validation->set_rules('admin_pw', '비밀번호', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            // 폼 유효성 검사 실패 시 로그인 뷰 표시
            $this->load->view('auth/login');
        } else {
            // 폼 유효성 검사 성공 시 로그인 처리
            $admin_id = $this->input->post('admin_id');
            $admin_pw = $this->input->post('admin_pw');
            $admin = $this->admin_model->get_admin_by_id($admin_id);

            if ($admin && password_verify($admin_pw, $admin['admin_pw'])) {
                // 로그인 성공
                $session_data = array(
                    'manufacturer_id' => $admin['manufacturer_id'],
                    'admin_id' => $admin['admin_id'],
                    'admin_name' => $admin['admin_name'],
                    'admin_logged_in' => TRUE,
                    'username' => $admin['admin_name'] // 대시보드에서 사용할 username 추가
                );
                $this->session->set_userdata($session_data);
                
                // 대시보드로 직접 이동
                redirect('dashboard');
            } else {
                // 로그인 실패
                $this->session->set_flashdata('error_msg', '아이디 또는 비밀번호가 일치하지 않습니다.');
                $this->load->view('auth/login');
            }
        }
    }

    public function logout() {
        // 모든 세션 데이터 삭제
        $this->session->sess_destroy();
        
        // 로그인 페이지로 이동
        redirect('auth/login');
    }

    public function dashboard() {
        // 로그인이 되어 있지 않으면 로그인 페이지로 리디렉션
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('/auth/login');
        }

		$admin['user_id'] = $this->session->userdata('manufacturer_id');

		$this->load->model('Notice_model');
		$data['notices'] = $this->Notice_model->get_notices_full_info(5,'','', $admin);

		  // 로그인한 제조사의 이름 가져오기
		  $data['current_manufacturer_name'] = $this->manufacturer_model->get_manufacturer_name($admin['user_id']);

		// 로그인한 제조사의 총 제품 수 가져오기
		$data['current_manufacturer_total_products'] = $this->manufacturer_model->get_total_products_by_manufacturer($admin['user_id']);
		
		// 로그인한 제조사의 제품 수 순위 가져오기
		$data['current_manufacturer_rank'] = $this->manufacturer_model->get_manufacturer_rank($admin['user_id']);
		
		// 다른 대시보드 데이터들 포함 가능
		$this->load->view('auth/dashboard', $data);
    }
}