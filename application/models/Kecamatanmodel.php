<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KecamatanModel
 *
 * @author root
 */
class KecamatanModel extends CI_Model {
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function lookup($look = '') {
        $sql = "SELECT nama_kec FROM kecamatan WHERE nama_kec LIKE '%$look%'";
//        $sql = "SELECT nama_kec FROM kecamatan";
        $query = $this->db->query($sql);
        $kec = [];
        $rs = $query->result_array();
        return $rs;
//        echo json_encode($rs);
//        foreach ($query->result_array() as $row) {
//            $kec[] = $row['nama_kec'];
//        }
//        echo json_encode($kec);
//        return $kec;
    }
}
