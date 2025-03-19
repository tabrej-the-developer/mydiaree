<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH  . 'vendor/autoload.php';

class Pdf {
    function __construct() {
        $this->CI = &get_instance();
    }
    
    function load() {
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 16,
            'margin_bottom' => 16,
            'margin_header' => 9,
            'margin_footer' => 9
        ]);
        
        return $mpdf;
    }
}