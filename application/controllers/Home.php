<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function index()
	{
        $choropleth_data = 'sample/choropleth_kios.csv';
        $topojson_data = 'map/jakarta.topojson';
        $template = $_SERVER['DOCUMENT_ROOT'].'/nous/assets/'.$choropleth_data;
        $this->_generate_choropleth_data($template);

        $data = array(
            'choropleth_data' => $choropleth_data,
            'topojson_data' => $topojson_data
        );

        $this->load->view('home/index',$data);
    }

    private function _generate_choropleth_data($template = '')
    {
        if(!file_exists($template))
        {
            $strsql = "SELECT 'kecamatan','jumlah' UNION ";
            $strsql .= "SELECT kecamatan, SUM(jumlah) as jumlah FROM `kios_detail` GROUP BY kecamatan ";
            $strsql .= "INTO OUTFILE '".$template."' ";
            $strsql .= "FIELDS TERMINATED BY ',' ";
            $strsql .= "ENCLOSED BY '\"' ";
            $strsql .= "LINES TERMINATED BY '\\n'";
            $this->db->query($strsql);
        }
    }

    public function ajax( $par1 = '', $par2 = '')
    {
        if($par1 == 'kios_detail' && $par2 == 'barchart')
        {
            $data = array();
            $kecamatan = $this->input->get('kecamatan');
            $sql = "SELECT MIN(tahun) as min_tahun, MAX(tahun) as max_tahun FROM kios_detail";
            $query = $this->db->query($sql);
            $rs = $query->result();

            $min_year = 0;
            $min_max = 0;
            foreach($rs as $row)
            {
                $min_year = $row->min_tahun;
                $max_year = $row->max_tahun;
            }
            $query->free_result();

            for( ;$min_year <= $max_year; $min_year++)
            {
                $sql = "SELECT tipe, jumlah FROM kios_detail WHERE kecamatan = '$kecamatan' AND tahun = $min_year";
                $query = $this->db->query($sql);
                $rs = $query->result();

                $temp_data = array( 'tahun' => $min_year );
                foreach($rs as $row)
                {
                    $temp_data[$row->tipe] = $row->jumlah;
                }
                $data[] = $temp_data;
            }
            echo json_encode($data);    
        }

        if($par1 == 'kios_detail' && $par2 == 'linechart')
        {
            $data = array();
            $kecamatan = $this->input->get('kecamatan');
            $sql = "SELECT MIN(tahun) as min_tahun, MAX(tahun) as max_tahun FROM kios_detail";
            $query = $this->db->query($sql);
            $rs = $query->result();

            $min_year = 0;
            $min_max = 0;
            foreach($rs as $row)
            {
                $min_year = $row->min_tahun;
                $max_year = $row->max_tahun;
            }
            $query->free_result();

            for( ;$min_year <= $max_year; $min_year++)
            {
                $sql = "SELECT tipe, jumlah FROM kios_detail WHERE kecamatan = '$kecamatan' AND tahun = $min_year";
                $query = $this->db->query($sql);
                $rs = $query->result();

                $temp_data = array( 'tahun' => $min_year.'0101' );
                foreach($rs as $row)
                {
                    $temp_data[$row->tipe] = $row->jumlah;
                }
                $data[] = $temp_data;
            }
            echo json_encode($data);    
        }

        if($par1 == 'kios_detail' && $par2 == 'piechart')
        {
            $data = array();
            $kecamatan = $this->input->get('kecamatan');
            $sql = "SELECT tipe, SUM(jumlah) as jumlah FROM kios_detail WHERE kecamatan = '$kecamatan' GROUP BY tipe";
            $query = $this->db->query($sql);
            $rs = $query->result();
            foreach($rs as $row)
            {
                $data[] = array(
                        'tipe' => $row->tipe,
                        'jumlah' => $row->jumlah
                    );
            }
            echo json_encode($data);    
        }
    }

    public function export()
    {
        $full_path = './assets/sample/kios.csv';
        $strsql = "LOAD DATA LOCAL INFILE '".$full_path."' INTO TABLE kios_detail ";
        $strsql .= "FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' ";
        $this->db->query($strsql);
    }

    public function summary()
    {
        $strsql = "SELECT kecamatan, SUM(jumlah) as jumlah FROM kios_detail GROUP BY kecamatan";
        $strsql .= "FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' ";
        $this->db->query($strsql);
    }

    public function import()
    {
        $full_path = 'C:/xampp/htdocs/nous/assets/sample/2014_coropleth.csv';
        $strsql = "SELECT area, kecamatan, SUM(kepadatan) FROM `dummy` GROUP BY area, kecamatan ORDER BY `dummy`.`kepadatan`  DESC ";
        $strsql .= "INTO OUTFILE '".$full_path."' ";
        $strsql .= "FIELDS TERMINATED BY ',' ";
        $strsql .= "ENCLOSED BY '\"' ";
        $strsql .= "LINES TERMINATED BY '\\n'";
        $this->db->query($strsql);
    }

    public function generate()
    {
        $sql = "SELECT provinsi, area, kecamatan, kepadatan FROM dummy";
        $query = $this->db->query($sql);
        $rs = $query->result();

        for($i = 1995; $i < 2010; $i++)
        {
            $x = rand(1,65);
            foreach($rs as $row)
            {
               $sql = "INSERT INTO dummy VALUES($i, '".$row->provinsi."', '".$row->area."', '".$row->kecamatan."', '".($row->kepadatan - ($row->kepadatan * ($x /100)))."' )";
               $this->db->query($sql);
            }
        }
    }
}