<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// 기본 페이지네이션 설정
$config['page_query_string'] = TRUE;
$config['query_string_segment'] = 'per_page';
$config['reuse_query_string'] = TRUE;
$config['use_page_numbers'] = FALSE;
$config['num_links'] = 5;

// 페이지네이션 스타일 설정
$config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
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

// 페이지당 표시할 아이템 수
$config['per_page'] = 10;

// URI 세그먼트에서 페이지 번호가 위치할 인덱스
$config['uri_segment'] = 3;

// 페이지 번호가 유효하지 않을 경우 마지막 페이지로 리다이렉트
$config['use_page_numbers'] = TRUE; 