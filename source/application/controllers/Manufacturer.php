<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manufacturer extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('manufacturer_model'); // Manufacturer_model 로드
        $this->load->library('pagination'); // 페이징 라이브러리 로드
        $this->load->helper('url'); // URL 헬퍼 로드
        $this->load->helper('form'); // 폼 헬퍼 로드 (검색 폼에 필요)
    }

    /**
     * 제조사별 제품 수 순위 페이지를 보여주는 메서드
     */
    public function rank()
    {
        // 검색 키워드 가져오기
        $keyword = $this->input->get('q', TRUE);

        // 페이지네이션 설정
        $config = array(
            'base_url' => site_url('manufacturer/rank'),
            'total_rows' => $this->manufacturer_model->count_manufacturer_product_ranks($keyword),
            'per_page' => 10,
            'page_query_string' => TRUE,
            'query_string_segment' => 'per_page',
            'reuse_query_string' => TRUE,
            'use_page_numbers' => FALSE,
            
            'full_tag_open' => '<nav><ul class="pagination justify-content-center">',
            'full_tag_close' => '</ul></nav>',
            
            'first_link' => '처음',
            'first_tag_open' => '<li class="page-item">',
            'first_tag_close' => '</li>',
            
            'last_link' => '마지막',
            'last_tag_open' => '<li class="page-item">',
            'last_tag_close' => '</li>',
            
            'next_link' => '다음',
            'next_tag_open' => '<li class="page-item">',
            'next_tag_close' => '</li>',
            
            'prev_link' => '이전',
            'prev_tag_open' => '<li class="page-item">',
            'prev_tag_close' => '</li>',
            
            'cur_tag_open' => '<li class="page-item active"><a class="page-link" href="#">',
            'cur_tag_close' => '</a></li>',
            
            'num_tag_open' => '<li class="page-item">',
            'num_tag_close' => '</li>',
            
            'attributes' => array('class' => 'page-link')
        );

        $this->pagination->initialize($config);

        // 현재 오프셋 가져오기
        $offset = (int)$this->input->get('per_page');
        $offset = $offset ? $offset : 0;

        // 데이터 가져오기
        $data['manufacturers'] = $this->manufacturer_model->get_manufacturer_product_ranks(
            $config['per_page'],
            $offset,
            $keyword
        );

        // 뷰에 전달할 데이터
        $data['pagination_links'] = $this->pagination->create_links();
        $data['search_keyword'] = $keyword;
        $data['current_page_start_rank'] = $offset + 1;

        // 뷰 로드
        $this->load->view('manufacturer/rank', $data);
    }
}