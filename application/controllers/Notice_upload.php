<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice_upload extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('notice_model');
        $this->load->library('upload');
        $this->load->library('SimpleXLSX');
        $this->load->helper(array('form', 'url', 'file'));
        
        // 로그인 체크
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('auth/login');
        }
    }
    
    /**
     * 업로드 페이지 표시
     */
    public function index() {
        $data['page_title'] = '공지사항 업로드';
        $data['page_description'] = '엑셀 파일을 업로드하여 공지사항 데이터를 일괄 등록하세요';
        $data['page_icon'] = 'fas fa-upload'; 
        $this->load->view('notice_upload/index', $data);
    }
    
    /**
     * 엑셀 파일 업로드 및 처리
     */
    public function upload() {
        log_message('debug', '파일 업로드 시작');
        
        // 업로드 설정
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size'] = 10240; // 10MB
        $config['encrypt_name'] = TRUE;
        
        // 업로드 디렉토리 생성
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
            log_message('debug', '업로드 디렉토리 생성: ' . $config['upload_path']);
        }
        
        log_message('debug', '업로드 설정: ' . print_r($config, true));
        
        $this->upload->initialize($config);
        
        // 업로드된 파일 정보 확인
        if (empty($_FILES['excel_file']['name'])) {
            log_message('error', '업로드된 파일이 없습니다.');
            $this->session->set_flashdata('error', '업로드할 파일을 선택해주세요.');
            redirect('notice_upload');
        }
        
        log_message('debug', '업로드된 파일 정보: ' . print_r($_FILES['excel_file'], true));
        
        if (!$this->upload->do_upload('excel_file')) {
            $error = $this->upload->display_errors();
            log_message('error', '파일 업로드 실패: ' . $error);
            $this->session->set_flashdata('error', '파일 업로드 실패: ' . $error);
            redirect('notice_upload');
        }
        
        $upload_data = $this->upload->data();
        $file_path = $upload_data['full_path'];
        
        log_message('debug', '업로드 성공: ' . print_r($upload_data, true));
        
        try {
            // ZipArchive 클래스 확인
            if (!class_exists('ZipArchive')) {
                throw new Exception('ZipArchive 클래스를 사용할 수 없습니다. PHP zip 확장이 설치되어 있는지 확인하세요.');
            }
            
            // 파일 확장자에 따른 처리
            $file_extension = strtolower($upload_data['file_ext']);
            
            log_message('debug', '파일 확장자: ' . $file_extension);
            
            if ($file_extension === '.csv') {
                $result = $this->process_csv($file_path);
            } else {
                $result = $this->process_excel($file_path);
            }
            
            // 임시 파일 삭제
            unlink($file_path);
            log_message('debug', '임시 파일 삭제: ' . $file_path);
            
            log_message('debug', '처리 결과: ' . print_r($result, true));
            
            if ($result['success']) {
                $this->session->set_flashdata('success', 
                    "성공적으로 처리되었습니다! 총 {$result['total']}개 중 {$result['inserted']}개 삽입, {$result['updated']}개 업데이트, {$result['failed']}개 실패");
            } else {
                $this->session->set_flashdata('error', '데이터 처리 중 오류가 발생했습니다: ' . $result['message']);
            }
            
        } catch (Exception $e) {
            // 임시 파일 삭제
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            
            $error_message = '파일 처리 중 오류가 발생했습니다: ' . $e->getMessage();
            log_message('error', $error_message);
            $this->session->set_flashdata('error', $error_message);
        }
        
        redirect('notice_upload');
    }
    
    /**
     * CSV 파일 처리
     */
    private function process_csv($file_path) {
        $result = array(
            'success' => true,
            'total' => 0,
            'inserted' => 0,
            'updated' => 0,
            'failed' => 0,
            'message' => ''
        );
        
        if (($handle = fopen($file_path, "r")) !== FALSE) {
            $header = true;
            
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // 헤더 행 건너뛰기
                if ($header) {
                    $header = false;
                    continue;
                }
                
                // 빈 행 건너뛰기
                if (empty(array_filter($data))) {
                    continue;
                }
                
                $result['total']++;
                
                // B행(인덱스 1): 공지일자, G행(인덱스 6): 제품명
                $noti_date = isset($data[1]) ? trim($data[1]) : '';
                $product_name = isset($data[6]) ? trim($data[6]) : '';
                
                // 공지일자와 제품명이 모두 있어야 처리
                if (empty($noti_date) || empty($product_name)) {
                    $result['failed']++;
                    continue;
                }
                
                // 제품명으로 제품 ID 찾기
                $product_id = $this->get_product_id_by_name($product_name);
                
                if (!$product_id) {
                    $result['failed']++;
                    log_message('error', "제품을 찾을 수 없습니다: " . $product_name);
                    continue;
                }
                
                // 공지사항 데이터 구성
                $notice_data = array(
                    'noti_date' => $this->format_date($noti_date),
                    'product_id' => $product_id,
                    'noti_content' => isset($data[2]) ? trim($data[2]) : '공지사항 내용', // C행: 내용
                    'noti_crisis_level' => isset($data[3]) ? $this->map_crisis_level(trim($data[3])) : '3', // D행: 중요도
                    'noti_category' => isset($data[4]) ? $this->map_category(trim($data[4])) : 'E', // E행: 카테고리
                    'notice_class_cd' => isset($data[5]) ? trim($data[5]) : '001', // F행: 공지분류코드
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                
                if ($this->insert_product_notice($notice_data)) {
                    $result['inserted']++;
                } else {
                    $result['failed']++;
                }
            }
            
            fclose($handle);
        }
        
        return $result;
    }
    
    /**
     * Excel 파일 처리 (SimpleXLSX 라이브러리 사용)
     */
    private function process_excel($file_path) {
        $result = array(
            'success' => true,
            'total' => 0,
            'inserted' => 0,
            'updated' => 0,
            'failed' => 0,
            'message' => ''
        );
        
        try {
            log_message('debug', 'Excel 파일 처리 시작: ' . $file_path);
            
            $xlsx = new SimpleXLSX();
            
            if (!$xlsx->parse($file_path)) {
                $result['success'] = false;
                $result['message'] = 'Excel 파일 파싱 실패: ' . $xlsx->error();
                log_message('error', $result['message']);
                return $result;
            }
            
            log_message('debug', 'Excel 파일 파싱 성공');
            
            // 공지사항 시트 찾기
            $sheets = $xlsx->sheetNames();
            log_message('debug', '시트 목록: ' . print_r($sheets, true));
            
            $notice_sheet_index = -1;
            
            foreach ($sheets as $index => $sheet_name) {
                if (strpos(strtolower($sheet_name), '공지') !== false || 
                    strpos(strtolower($sheet_name), 'notice') !== false) {
                    $notice_sheet_index = $index;
                    break;
                }
            }
            
            // 공지사항 시트가 없으면 첫 번째 시트 사용
            if ($notice_sheet_index === -1) {
                $notice_sheet_index = 0;
            }
            
            log_message('debug', '사용할 시트 인덱스: ' . $notice_sheet_index);
            
            $rows = $xlsx->rows($notice_sheet_index);
            
            if (empty($rows)) {
                $result['success'] = false;
                $result['message'] = 'Excel 파일에 데이터가 없습니다.';
                log_message('error', $result['message']);
                return $result;
            }
            
            log_message('debug', '총 행 수: ' . count($rows));
            log_message('debug', '첫 번째 행 데이터: ' . print_r($rows[0], true));
            
            $header_skipped = false;
            
            foreach ($rows as $row_index => $row) {
                // 헤더 행 건너뛰기
                if (!$header_skipped) {
                    $header_skipped = true;
                    log_message('debug', '헤더 행 건너뛰기: ' . print_r($row, true));
                    continue;
                }
                
                // 빈 행 건너뛰기
                if (empty(array_filter($row))) {
                    continue;
                }
                
                $result['total']++;
                
                log_message('debug', '처리 중인 행 ' . $row_index . ': ' . print_r($row, true));
                
                // B행(인덱스 1): 공지일자, G행(인덱스 6): 제품명
                $noti_date = isset($row[1]) ? trim($row[1]) : '';
                $product_name = isset($row[6]) ? trim($row[6]) : '';
                
                log_message('debug', '공지일자: ' . $noti_date . ', 제품명: ' . $product_name);
                
                // 공지일자와 제품명이 모두 있어야 처리
                if (empty($noti_date) || empty($product_name)) {
                    $result['failed']++;
                    log_message('debug', '필수 데이터 누락으로 건너뛰기');
                    continue;
                }
                
                // 제품명으로 제품 ID 찾기
                $product_id = $this->get_product_id_by_name($product_name);
                
                if (!$product_id) {
                    $result['failed']++;
                    log_message('error', "제품을 찾을 수 없습니다: " . $product_name);
                    continue;
                }
                
                log_message('debug', '제품 ID 찾음: ' . $product_id);
                
                // 공지사항 데이터 구성
                $notice_data = array(
                    'noti_date' => $this->format_date($noti_date),
                    'product_id' => $product_id,
                    'noti_content' => isset($row[2]) ? trim($row[2]) : '공지사항 내용', // C행: 내용
                    'noti_crisis_level' => isset($row[3]) ? $this->map_crisis_level(trim($row[3])) : '3', // D행: 중요도
                    'noti_category' => isset($row[4]) ? $this->map_category(trim($row[4])) : 'E', // E행: 카테고리
                    'notice_class_cd' => isset($row[5]) ? trim($row[5]) : '001', // F행: 공지분류코드
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                
                log_message('debug', '공지사항 데이터: ' . print_r($notice_data, true));
                
                if ($this->insert_product_notice($notice_data)) {
                    $result['inserted']++;
                    log_message('debug', '공지사항 삽입 성공');
                } else {
                    $result['failed']++;
                    log_message('error', '공지사항 삽입 실패');
                }
            }
            
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = 'Excel 파일 처리 중 오류 발생: ' . $e->getMessage();
            log_message('error', $result['message']);
        }
        
        return $result;
    }
    
    /**
     * 날짜 포맷 변환
     */
    private function format_date($date_string) {
        if (empty($date_string)) {
            return date('Y-m-d');
        }
        
        // 다양한 날짜 형식 처리
        $date = DateTime::createFromFormat('Y-m-d', $date_string);
        if (!$date) {
            $date = DateTime::createFromFormat('Y/m/d', $date_string);
        }
        if (!$date) {
            $date = DateTime::createFromFormat('m/d/Y', $date_string);
        }
        if (!$date) {
            return date('Y-m-d');
        }
        
        return $date->format('Y-m-d');
    }
    
    /**
     * 샘플 데이터 다운로드
     */
    public function download_sample() {
        $filename = 'product_notice_sample.csv';
        
        // CSV 헤더 (A~G 컬럼)
        $csv_data = "A열(미사용),B열(공지일자),C열(내용),D열(중요도),E열(카테고리),F열(공지분류코드),G열(제품명)\n";
        $csv_data .= ",2024-01-15,제품 안전성 관련 공지사항입니다.,A,S,001,타이레놀정\n";
        $csv_data .= ",2024-01-16,제조 공정 변경 안내입니다.,B,M,002,아스피린정\n";
        $csv_data .= ",2024-01-17,법령 개정 관련 공지입니다.,C,L,003,게보린정\n";
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . strlen($csv_data));
        
        echo "\xEF\xBB\xBF"; // UTF-8 BOM
        echo $csv_data;
        exit;
    }
    
    /**
     * 기존 공지사항 목록 (참고용)
     */
    public function preview() {
        $data['notices'] = $this->notice_model->get_all_notices(20, 0);
        $data['page_title'] = '공지사항 미리보기';
        $data['page_description'] = '현재 등록된 공지사항 목록';
        $data['page_icon'] = 'fas fa-eye';
        
        $this->load->view('notice_upload/preview', $data);
    }
    
    /**
     * 제품명으로 제품 ID 찾기
     */
    private function get_product_id_by_name($product_name) {
        $this->db->select('id');
        $this->db->from('tb_product');
        $this->db->where('name', $product_name);
        $this->db->where('state', 1); // 활성 상태인 제품만
        $this->db->limit(1);
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row()->id;
        }
        
        return false;
    }
    
    /**
     * 중요도 매핑 (텍스트를 숫자로 변환)
     */
    private function map_crisis_level($level) {
        $level = strtoupper(trim($level));
        
        switch($level) {
            case 'A':
            case '긴급':
            case '1':
                return '1';
            case 'B':
            case '중요':
            case '2':
                return '2';
            case 'C':
            case '일반':
            case '3':
            default:
                return '3';
        }
    }
    
    /**
     * 카테고리 매핑 (텍스트를 코드로 변환)
     */
    private function map_category($category) {
        $category = strtoupper(trim($category));
        
        switch($category) {
            case 'L':
            case '법령':
                return 'L';
            case 'M':
            case '제조':
                return 'M';
            case 'S':
            case '안전':
                return 'S';
            case 'E':
            case '기타':
            default:
                return 'E';
        }
    }
    
    /**
     * 제품 공지사항 데이터 삽입
     */
    private function insert_product_notice($notice_data) {
        // 중복 체크 (같은 제품, 같은 날짜의 공지사항이 있는지 확인)
        $this->db->where('product_id', $notice_data['product_id']);
        $this->db->where('noti_date', $notice_data['noti_date']);
        $existing = $this->db->get('tb_product_notice');
        
        if ($existing->num_rows() > 0) {
            // 업데이트
            $this->db->where('product_id', $notice_data['product_id']);
            $this->db->where('noti_date', $notice_data['noti_date']);
            return $this->db->update('tb_product_notice', $notice_data);
        } else {
            // 새로 삽입
            return $this->db->insert('tb_product_notice', $notice_data);
        }
    }
    
    /**
     * 테스트용 메소드 - 라이브러리와 DB 연결 확인
     */
    public function test() {
        echo "<h2>Notice Upload Test</h2>";
        
        // ZipArchive 확인
        echo "<h3>1. ZipArchive 확인</h3>";
        if (class_exists('ZipArchive')) {
            echo "✅ ZipArchive 클래스 사용 가능<br>";
            $zip = new ZipArchive();
            echo "✅ ZipArchive 인스턴스 생성 성공<br>";
        } else {
            echo "❌ ZipArchive 클래스 사용 불가<br>";
        }
        
        // SimpleXLSX 라이브러리 확인
        echo "<h3>2. SimpleXLSX 라이브러리 확인</h3>";
        try {
            $xlsx = new SimpleXLSX();
            echo "✅ SimpleXLSX 라이브러리 로드 성공<br>";
        } catch (Exception $e) {
            echo "❌ SimpleXLSX 라이브러리 오류: " . $e->getMessage() . "<br>";
        }
        
        // 데이터베이스 연결 확인
        echo "<h3>3. 데이터베이스 연결 확인</h3>";
        try {
            $query = $this->db->query("SELECT COUNT(*) as count FROM tb_product LIMIT 1");
            $result = $query->row();
            echo "✅ 데이터베이스 연결 성공 (제품 수: " . $result->count . ")<br>";
        } catch (Exception $e) {
            echo "❌ 데이터베이스 연결 오류: " . $e->getMessage() . "<br>";
        }
        
        // 제품 검색 테스트
        echo "<h3>4. 제품 검색 테스트</h3>";
        $test_products = array('타이레놀정', '아스피린정', '게보린정');
        foreach ($test_products as $product_name) {
            $product_id = $this->get_product_id_by_name($product_name);
            if ($product_id) {
                echo "✅ 제품 찾음: {$product_name} (ID: {$product_id})<br>";
            } else {
                echo "❌ 제품 없음: {$product_name}<br>";
            }
        }
        
        // 업로드 디렉토리 확인
        echo "<h3>5. 업로드 디렉토리 확인</h3>";
        $upload_dir = './uploads/';
        echo "디렉토리: {$upload_dir}<br>";
        echo "존재 여부: " . (is_dir($upload_dir) ? "✅ 존재" : "❌ 없음") . "<br>";
        echo "쓰기 권한: " . (is_writable($upload_dir) ? "✅ 가능" : "❌ 불가") . "<br>";
        
        echo "<h3>6. PHP 설정</h3>";
        echo "업로드 최대 크기: " . ini_get('upload_max_filesize') . "<br>";
        echo "POST 최대 크기: " . ini_get('post_max_size') . "<br>";
        echo "최대 실행 시간: " . ini_get('max_execution_time') . "초<br>";
    }
} 