<?php

/**
 * SimpleXLSX - Simple XLSX Reader for CodeIgniter
 * 간단한 XLSX 파일 읽기 라이브러리
 * 
 * 기본적인 XLSX 파일 읽기 기능만 제공
 */
class SimpleXLSX {
    
    private $data = array();
    private $error = '';
    private $sheet_names = array();
    private $zip = null;
    private $shared_strings = array();
    
    /**
     * XLSX 파일 파싱
     */
    public function parse($file_path) {
        if (!file_exists($file_path)) {
            $this->error = "파일이 존재하지 않습니다: " . $file_path;
            return false;
        }
        
        // ZIP 아카이브로 XLSX 파일 열기
        $this->zip = new ZipArchive();
        $result = $this->zip->open($file_path);
        
        if ($result !== TRUE) {
            $this->error = "XLSX 파일을 열 수 없습니다. ZIP 오류: " . $result;
            return false;
        }
        
        try {
            // 워크북 정보 읽기
            $workbook_xml = $this->zip->getFromName('xl/workbook.xml');
            if ($workbook_xml) {
                $this->parseWorkbook($workbook_xml);
            }
            
            // SharedStrings 읽기
            $shared_strings_xml = $this->zip->getFromName('xl/sharedStrings.xml');
            if ($shared_strings_xml) {
                $this->shared_strings = $this->parseSharedStrings($shared_strings_xml);
            }
            
            return true;
            
        } catch (Exception $e) {
            $this->error = "파싱 중 오류 발생: " . $e->getMessage();
            if ($this->zip) {
                $this->zip->close();
            }
            return false;
        }
    }
    
    /**
     * 워크북 정보 파싱 (시트 이름들)
     */
    private function parseWorkbook($xml_string) {
        $xml = simplexml_load_string($xml_string);
        if ($xml === false) {
            return;
        }
        
        $this->sheet_names = array();
        if (isset($xml->sheets->sheet)) {
            foreach ($xml->sheets->sheet as $sheet) {
                $this->sheet_names[] = (string)$sheet['name'];
            }
        }
    }
    
    /**
     * 시트 이름들 반환
     */
    public function sheetNames() {
        return $this->sheet_names;
    }
    
    /**
     * SharedStrings 파싱
     */
    private function parseSharedStrings($xml_string) {
        $strings = array();
        
        $xml = simplexml_load_string($xml_string);
        if ($xml === false) {
            return $strings;
        }
        
        foreach ($xml->si as $si) {
            if (isset($si->t)) {
                $strings[] = (string)$si->t;
            } else if (isset($si->r)) {
                $text = '';
                foreach ($si->r as $r) {
                    if (isset($r->t)) {
                        $text .= (string)$r->t;
                    }
                }
                $strings[] = $text;
            }
        }
        
        return $strings;
    }
    
    /**
     * 워크시트 파싱
     */
    private function parseWorksheet($xml_string, $shared_strings) {
        $data = array();
        
        $xml = simplexml_load_string($xml_string);
        if ($xml === false) {
            return $data;
        }
        
        $rows = array();
        foreach ($xml->sheetData->row as $row) {
            $row_data = array();
            $col_index = 0;
            
            foreach ($row->c as $cell) {
                $cell_ref = (string)$cell['r'];
                $col_letter = preg_replace('/[0-9]/', '', $cell_ref);
                $col_num = $this->columnLetterToNumber($col_letter) - 1;
                
                // 빈 셀 채우기
                while ($col_index < $col_num) {
                    $row_data[] = '';
                    $col_index++;
                }
                
                $value = '';
                if (isset($cell->v)) {
                    $cell_value = (string)$cell->v;
                    $cell_type = (string)$cell['t'];
                    
                    if ($cell_type === 's') {
                        // Shared string
                        $string_index = (int)$cell_value;
                        if (isset($shared_strings[$string_index])) {
                            $value = $shared_strings[$string_index];
                        }
                    } else {
                        $value = $cell_value;
                    }
                }
                
                $row_data[] = $value;
                $col_index++;
            }
            
            $rows[] = $row_data;
        }
        
        return $rows;
    }
    
    /**
     * 컬럼 문자를 숫자로 변환
     */
    private function columnLetterToNumber($column) {
        $column = strtoupper($column);
        $length = strlen($column);
        $number = 0;
        
        for ($i = 0; $i < $length; $i++) {
            $number = $number * 26 + (ord($column[$i]) - ord('A') + 1);
        }
        
        return $number;
    }
    
    /**
     * 파싱된 데이터 반환
     */
    public function rows($sheet_index = 0) {
        if (!$this->zip) {
            return array();
        }
        
        try {
            // 워크시트 파일명 생성
            $sheet_file = 'xl/worksheets/sheet' . ($sheet_index + 1) . '.xml';
            $worksheet_xml = $this->zip->getFromName($sheet_file);
            
            if (!$worksheet_xml) {
                $this->error = "워크시트를 찾을 수 없습니다: " . $sheet_file;
                return array();
            }
            
            return $this->parseWorksheet($worksheet_xml, $this->shared_strings);
            
        } catch (Exception $e) {
            $this->error = "워크시트 읽기 중 오류 발생: " . $e->getMessage();
            return array();
        }
    }
    
    /**
     * 오류 메시지 반환
     */
    public function error() {
        return $this->error;
    }
    
    /**
     * 정적 메소드 - 파일을 바로 파싱
     */
    public static function parse_file($file_path) {
        $xlsx = new SimpleXLSX();
        if ($xlsx->parse($file_path)) {
            return $xlsx->rows();
        }
        return false;
    }
} 