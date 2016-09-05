<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Story_map extends CI_Controller {
	
	public function index()
	{
        $this->load->view('home/story_map');
    }

}