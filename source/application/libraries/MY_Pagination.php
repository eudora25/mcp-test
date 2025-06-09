<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Pagination extends CI_Pagination {
    
    // 기본 속성 정의
    public $attributes = array('class' => 'page-link');
    public $total_rows = 0;
    public $per_page = 10;
    public $num_links = 5;
    public $page_query_string = TRUE;
    public $query_string_segment = 'per_page';
    public $reuse_query_string = TRUE;
    public $use_page_numbers = FALSE;
    public $base_url = '';
    public $first_link = '처음';
    public $next_link = '다음';
    public $prev_link = '이전';
    public $last_link = '마지막';
    public $full_tag_open = '<nav><ul class="pagination justify-content-center">';
    public $full_tag_close = '</ul></nav>';
    public $first_tag_open = '<li class="page-item">';
    public $first_tag_close = '</li>';
    public $last_tag_open = '<li class="page-item">';
    public $last_tag_close = '</li>';
    public $next_tag_open = '<li class="page-item">';
    public $next_tag_close = '</li>';
    public $prev_tag_open = '<li class="page-item">';
    public $prev_tag_close = '</li>';
    public $num_tag_open = '<li class="page-item">';
    public $num_tag_close = '</li>';
    public $cur_tag_open = '<li class="page-item active"><a class="page-link" href="#">';
    public $cur_tag_close = '</a></li>';

    public function __construct() {
        parent::__construct();
        $this->CI =& get_instance();
        $this->initialize();
    }

    /**
     * 설정 초기화
     */
    public function initialize($params = array()) {
        foreach ($params as $key => $val) {
            if (property_exists($this, $key)) {
                $this->$key = $val;
            }
        }
        return $this;
    }

    /**
     * Generate the pagination links
     *
     * @return    string
     */
    public function create_links() {
        if ($this->total_rows == 0 || $this->per_page == 0) {
            return '';
        }

        // 페이지네이션 링크를 저장할 변수
        $output = '';

        // 총 페이지 수 계산
        $num_pages = ceil($this->total_rows / $this->per_page);

        // 현재 페이지/오프셋 계산
        $curr_offset = $this->page_query_string === TRUE 
            ? (int)$this->CI->input->get($this->query_string_segment) 
            : 0;
        
        $curr_page = floor($curr_offset / $this->per_page) + 1;

        // 시작 태그
        $output .= $this->full_tag_open;

        // "처음" 링크
        if ($curr_page > 1) {
            $output .= $this->first_tag_open 
                    . $this->get_first_page_link() 
                    . $this->first_tag_close;
        }

        // "이전" 링크
        if ($curr_page > 1) {
            $output .= $this->prev_tag_open 
                    . $this->get_prev_page_link($curr_offset) 
                    . $this->prev_tag_close;
        }

        // 숫자 링크
        $start = max(1, $curr_page - floor($this->num_links / 2));
        $end = min($num_pages, $start + $this->num_links - 1);

        for ($i = $start; $i <= $end; $i++) {
            $offset = ($i - 1) * $this->per_page;
            
            if ($curr_page == $i) {
                // 현재 페이지
                $output .= $this->cur_tag_open . $i . $this->cur_tag_close;
            } else {
                // 다른 페이지
                $output .= $this->num_tag_open 
                        . $this->get_page_link($offset, $i) 
                        . $this->num_tag_close;
            }
        }

        // "다음" 링크
        if ($curr_page < $num_pages) {
            $output .= $this->next_tag_open 
                    . $this->get_next_page_link($curr_offset) 
                    . $this->next_tag_close;
        }

        // "마지막" 링크
        if ($curr_page < $num_pages) {
            $last_offset = ($num_pages - 1) * $this->per_page;
            $output .= $this->last_tag_open 
                    . $this->get_last_page_link($last_offset, $num_pages) 
                    . $this->last_tag_close;
        }

        // 종료 태그
        $output .= $this->full_tag_close;

        return $output;
    }

    /**
     * "처음" 페이지 링크 생성
     */
    protected function get_first_page_link() {
        $url = $this->base_url;
        if ($this->page_query_string) {
            $url .= '?' . $this->query_string_segment . '=0';
            if ($this->reuse_query_string) {
                $url = $this->maintain_query_string($url);
            }
        }
        return '<a ' . $this->get_attributes() . ' href="' . $url . '">' 
             . $this->first_link . '</a>';
    }

    /**
     * "이전" 페이지 링크 생성
     */
    protected function get_prev_page_link($curr_offset) {
        $prev_offset = max(0, $curr_offset - $this->per_page);
        $url = $this->base_url;
        if ($this->page_query_string) {
            $url .= '?' . $this->query_string_segment . '=' . $prev_offset;
            if ($this->reuse_query_string) {
                $url = $this->maintain_query_string($url);
            }
        }
        return '<a ' . $this->get_attributes() . ' href="' . $url . '">' 
             . $this->prev_link . '</a>';
    }

    /**
     * 일반 페이지 링크 생성
     */
    protected function get_page_link($offset, $page_num) {
        $url = $this->base_url;
        if ($this->page_query_string) {
            $url .= '?' . $this->query_string_segment . '=' . $offset;
            if ($this->reuse_query_string) {
                $url = $this->maintain_query_string($url);
            }
        }
        return '<a ' . $this->get_attributes() . ' href="' . $url . '">' 
             . $page_num . '</a>';
    }

    /**
     * "다음" 페이지 링크 생성
     */
    protected function get_next_page_link($curr_offset) {
        $next_offset = $curr_offset + $this->per_page;
        $url = $this->base_url;
        if ($this->page_query_string) {
            $url .= '?' . $this->query_string_segment . '=' . $next_offset;
            if ($this->reuse_query_string) {
                $url = $this->maintain_query_string($url);
            }
        }
        return '<a ' . $this->get_attributes() . ' href="' . $url . '">' 
             . $this->next_link . '</a>';
    }

    /**
     * "마지막" 페이지 링크 생성
     */
    protected function get_last_page_link($last_offset, $num_pages) {
        $url = $this->base_url;
        if ($this->page_query_string) {
            $url .= '?' . $this->query_string_segment . '=' . $last_offset;
            if ($this->reuse_query_string) {
                $url = $this->maintain_query_string($url);
            }
        }
        return '<a ' . $this->get_attributes() . ' href="' . $url . '">' 
             . $this->last_link . '</a>';
    }

    /**
     * 기존 쿼리 스트링 유지
     */
    protected function maintain_query_string($url) {
        $query_string = $this->CI->input->server('QUERY_STRING');
        if ($query_string) {
            $query_array = array();
            parse_str($query_string, $query_array);
            unset($query_array[$this->query_string_segment]);
            if (count($query_array) > 0) {
                $url .= '&' . http_build_query($query_array);
            }
        }
        return $url;
    }

    /**
     * 링크 속성 문자열 생성
     */
    protected function get_attributes() {
        $attributes = '';
        foreach ($this->attributes as $key => $value) {
            $attributes .= ' ' . $key . '="' . $value . '"';
        }
        return $attributes;
    }
} 