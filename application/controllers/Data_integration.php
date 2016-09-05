<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Data_integration extends CI_Controller {
    
    private $month = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    public function __construct() {
        parent::__construct();
        $this->load->model('kecamatanmodel');
        $this->load->model('atmakelompokresikomodel');
    }

    public function index() {
//        $this->ajax('barchart2');
        $listkec = $this->kecamatanmodel->lookup();
        $listsubvar = $this->atmakelompokresikomodel->lookup();
        $choropleth_data = $this->config->item('data') . 'choropleth_kios.csv';
        $topojson_data = $this->config->item('data') . 'jakarta.topojson';

        $data = array(
            'listkec' => $listkec,
            'listsubvar' => $listsubvar,
            'choropleth_path' => $choropleth_data,
            'topojson_path' => $topojson_data
        );

        $this->load->view('data_integration/index', $data);
    }

    function ajax($par = NULL) {
        $kecamatan = ($this->input->get('kecamatan') != '') ? $this->input->get('kecamatan') : 'TAMBORA';
        $subvar = ($this->input->get('subvar') != '') ? $this->input->get('subvar') : 'Kelompok Risiko Yang Berkunjung Bulan Ini';

        if ($par == "choropleth") {
            $data = array();
            $sql = "SELECT kecamatan, SUM(jumlah) as total FROM dummy_atma GROUP BY kecamatan";
            $rs = $this->db->query($sql);

            foreach ($rs->result() as $row) {
                $data[] = array(
                    "kecamatan" => $row->kecamatan,
                    "jumlah" => $row->total
                );
            }

            echo json_encode($data);
        } else if ($par == "linechart") {
            $min_tahun = 2010;
            $max_tahun = 2015;

            $data = array();
            $sql = "SELECT min(tahun) as min, max(tahun) as max FROM dummy_atma";
            $rs = $this->db->query($sql);

            foreach ($rs->result() as $row) {
                $min_tahun = $row->min;
                $max_tahun = $row->max;
            }

            for ($tahun = $min_tahun; $tahun <= $max_tahun; $tahun++) {
                $sql = "SELECT layanan, SUM(jumlah) as total FROM dummy_atma WHERE kecamatan = '" . $kecamatan . "' AND tahun = " . $tahun . " GROUP BY layanan";
                $rs2 = $this->db->query($sql);

                $temp_data = array();
                $temp_data["tahun"] = $tahun . "0101";

                foreach ($rs2->result() as $row) {
                    $temp_data[$row->layanan] = $row->total;
                }

                $data[] = $temp_data;
            }

            echo json_encode($data);
        } else if ($par == "linechart2") {
            $tahun = 2015;
            $min_bln = 1;
            $max_bln = 12;

//            for ($bln = $min_bln; $bln <= $max_bln; $bln++) {
//                $sql = "SELECT sub_variabel, SUM(jumlah) as total
//                    FROM atma_kelompok_risiko 
//                    WHERE tahun = '$tahun' 
//                    AND bulan = '$bln'
//                    AND kecamatan = '$kecamatan' 
//                    AND kategori = 'VCT'
//                    GROUP BY sub_variabel, bulan";
//                $rs2 = $this->db->query($sql);
//
//                $temp_data = array();
//                $temp_data["tahun"] = "$tahun$bln".'01';
//
//                foreach ($rs2->result() as $row) {
//                    $temp_data[$row->sub_variabel] = $row->total;
//                }
//
//                $data[] = $temp_data;
//            }
            
            for ($bln = $min_bln; $bln <= $max_bln; $bln++) {
                $sql = "SELECT bulan, sub_variabel, SUM(jumlah) as total
                    FROM atma_kelompok_risiko 
                    WHERE tahun = '$tahun' 
                    AND kecamatan = '$kecamatan' 
                    AND bulan = '$bln' 
                    AND kategori = 'VCT'
                    GROUP BY sub_variabel, bulan ORDER BY bulan";
                
                $rs2 = $this->db->query($sql);

                $temp_data = array();
                $myDateTime = DateTime::createFromFormat('Y-n-d', $tahun . '-' . $bln . '-01');
                $newDateString = $myDateTime->format('Ymd');
                

                foreach ($rs2->result() as $row) {
                    $temp_data["tahun"] = $newDateString;
                    $temp_data[$row->sub_variabel] = $row->total;
                    
                }
                $data[] = $temp_data;
            }            

            echo json_encode($data);
        } else if ($par == "groupedbarchart") {
            $data = array();

            $sql = "SELECT distinct(populasi) FROM dummy_atma";
            $rs = $this->db->query($sql);

            foreach ($rs->result() as $row) {
                $data["labels"][] = $row->populasi;
            }

            $min_tahun = 2010;
            $max_tahun = 2015;


            $sql = "SELECT min(tahun) as min, max(tahun) as max FROM dummy_atma";
            $rs = $this->db->query($sql);

            foreach ($rs->result() as $row) {
                $min_tahun = $row->min;
                $max_tahun = $row->max;
            }

            for ($tahun = $min_tahun; $tahun <= $max_tahun; $tahun++) {
                $sql = "SELECT populasi, SUM(jumlah) as total FROM dummy_atma WHERE kecamatan = '" . $kecamatan . "' AND tahun = " . $tahun . " AND layanan = 'VCT' GROUP BY populasi";
                $rs2 = $this->db->query($sql);

                $temp_data = array();
                $temp_data["label"] = $tahun;

                foreach ($rs2->result() as $row) {
                    $temp_data["values"][] = $row->total;
                }

                $data["series"][] = $temp_data;
            }

            echo json_encode($data);
        } else if ($par == "barchart") {
            $tahun = 2015;

            $data = array();
            $sql = "SELECT max(tahun) as max FROM dummy_atma";
            $rs = $this->db->query($sql);

            foreach ($rs->result() as $row) {
                $tahun = $row->max;
            }

            $sql = "SELECT DISTINCT(usia) as usia FROM dummy_atma";
            $rs = $this->db->query($sql);

            foreach ($rs->result() as $row) {
                $sql = "SELECT gender, SUM(jumlah) as total FROM dummy_atma WHERE kecamatan = '" . $kecamatan . "' AND tahun = " . $tahun . " AND usia = '" . $row->usia . "' AND layanan = 'VCT' AND populasi = 'PSK' GROUP BY gender";
                $rs2 = $this->db->query($sql);

                $temp_data = array();
                $temp_data["tahun"] = $row->usia;

                foreach ($rs2->result() as $row2) {
                    $gender = ($row2->gender == 'L') ? 'Laki-laki' : 'Perempuan';
                    $temp_data[$gender] = $row2->total;
                }

                $data[] = $temp_data;
            }

            echo json_encode($data);
        } else if ($par == 'barchart2') {
            $tahun = 2015;
            $min_bln = 1;
            $max_bln = 12;
            for ($bln = $min_bln; $bln <= $max_bln; $bln++) {
                $sql = "SELECT sub_sub_variabel, SUM(jumlah) as total
                        FROM atma_kelompok_risiko 
                        WHERE tahun = 2015 
                        AND kecamatan = '$kecamatan'
                        AND kategori = 'VCT'
                        AND bulan = '$bln' 
                        AND sub_variabel = '$subvar'
                        GROUP BY sub_variabel, bulan";

                $rs2 = $this->db->query($sql);

                $temp_data = array();
                $myDateTime = DateTime::createFromFormat('Y-n-d', $tahun . '-' . $bln . '-01');
                $newDateString = $myDateTime->format('Ymd');
                

                foreach ($rs2->result() as $row) {
                    $temp_data["tahun"] = $newDateString;
                    $temp_data[$row->sub_sub_variabel] = $row->total;
                    
                }
                $data[] = $temp_data;
            }            

            echo json_encode($data);
        }
    }

    function dummy_data() {
        //echo '<table border="1"><tr><td>KECAMATAN</td><td>TAHUN</td><td>LAYANAN</td><td>POPULASI</td><td>GENDER</td><td>USIA</td><td>JUMLAH</td></tr>';
        $arr_layanan = array("IDU", "VCT", "ARV", "PTRM");
        $arr_populasi = array("PSK", "WARIA", "ODHA", "LGBT");
        $arr_gender = array("P", "L");
        $arr_usia = array("12-25", "26-35", "36-45", "46-55");

        $sql = "SELECT nama_kec FROM kecamatan WHERE id_area = 'JAKPUS' ORDER BY nama_kec";
        $rs = $this->db->query($sql);

        foreach ($rs->result() as $row) {

            for ($tahun = 2010; $tahun <= 2015; $tahun++) {
                foreach ($arr_layanan as $layanan) {
                    foreach ($arr_populasi as $populasi) {
                        foreach ($arr_gender as $gender) {
                            foreach ($arr_usia as $usia) {
                                $jumlah = rand(100, 1000);
                                /*
                                  echo '<tr>';
                                  echo '<td>'.$row->nama_kec.'</td>';
                                  echo '<td>'.$tahun.'</td>';
                                  echo '<td>'.$layanan.'</td>';
                                  echo '<td>'.$populasi.'</td>';
                                  echo '<td>'.$gender.'</td>';
                                  echo '<td>'.$usia.'</td>';
                                  echo '<td>'.$jumlah.'</td>';
                                  echo '</tr>';
                                 */

                                $sql_insert = "INSERT INTO dummy_atma VALUES('" . $row->nama_kec . "',$tahun,'" . $layanan . "','" . $populasi . "','" . $gender . "','" . $usia . "',$jumlah)";
                                $this->db->query($sql_insert);
                            }
                        }
                    }
                }
            }
        }
        //echo "</table>";
    }

}
