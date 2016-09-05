<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Photo_archive extends CI_Controller {
	
	public function index( $id_project = null )
	{

        $data = array();
        $data['id_project'] = $id_project;

        $qry_desa = $this->db->get('project_photoarchive');

        if($qry_desa)
        {            
            $data['rs_project'] = $qry_desa->result();
        }

        $this->load->view('home/photo_archive',$data);
    }

    public function ajax( $par = '' )
    {
        if( $par == 'marker' )
        {
            $id = $this->input->get('id');

            $data = array();

            if($id != '' )
            {
                $this->db->where('id_project',$id);
            }

            $rs = $this->db->get('marker');
            if($rs)
            {
                foreach( $rs->result() as $row )
                {
                    $temp = array();
                    $temp['lat'] = $row->latitude;
                    $temp['long'] = $row->longitude;
                    $temp['title'] = $row->id;

                    $data[] = $temp;
                }

                echo json_encode($data);
            }
        }
    }

}