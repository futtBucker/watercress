<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AtmaKelompokResikoModel
 *
 * @author root
 */
class AtmaKelompokResikoModel extends CI_Model {
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function lookup($look = '') {
        $sql = "SELECT DISTINCT sub_sub_variabel FROM atma_kelompok_risiko WHERE sub_sub_variabel LIKE '%$look%'";
        $query = $this->db->query($sql);
        $rs = $query->result_array();
        return $rs;
    }
    
    
}
