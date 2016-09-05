<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Testing
 *
 * @author root
 */
class Testing extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('kecamatanmodel');
    }

    public function index() {
        $data['listkec'] = $this->kecamatanmodel->lookup();
        $this->load->view('testing/testing', $data);
    }

    public function autosuggest() {
        $val = $this->input->post('inputkec');
        $result = $this->kecamatanmodel->lookup($val);
//        echo "<ul id='kec-list'>";
//        foreach ($result as $row) {
//            echo '<li onClick="selectCountry(\'' . trim($row['nama_kec']) . '\')">' . $row['nama_kec'] . '</li>';
//        }
//        echo '</ul>';
        
        foreach ($result as $row) {
            echo '<option data-tokens="' . trim($row['nama_kec']) . '" onClick="selectCountry(\'' . trim($row['nama_kec']) . '\')">' . $row['nama_kec'] . '</option>';
        }
        
    }

}
