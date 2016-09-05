<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Model_auth extends CI_Model {

	public function login($email = '', $password = '')
	{
		if($email == "" || $password == "")
		{
			return FALSE;
		}

		$email = addslashes($email); //just in case of SQL injection
		//$sql = "INSERT INTO `users` VALUES(NULL, 'bergas.haryo@gmail.com','$password','$salt',2,NOW())";
		$sql = "SELECT usr_id, usr_level FROM `users` WHERE usr_email = '$email' AND usr_password = SHA1(CONCAT(SHA1('$password'),usr_salt))";
		$query = $this->db->query($sql);
		if($query-> num_rows() == 1)
	   	{
	    	return $query->result();
	   	}
	   else
	   {
	    	return false;
	   }
	}

	public function freequery($sql)
	{
		$query = $this->db->query($sql);
		if($query-> num_rows() > 0)
	   	{
	    	return $query->result();
	   	}
	}

	public function freequery_insert($sql)
	{
		$query = $this->db->query($sql);
	}

	public function get_where($table = '', $where = array())
	{
		if($table != '')
		{
			$query = $this->db->get_where($table, $where);
			if($query-> num_rows() > 0)
		   	{
		    	return $query->result();
		   	}
		}
	}
}