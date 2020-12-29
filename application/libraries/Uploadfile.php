<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploadfile extends CI_Controller  {

	protected $CI;

	public function __construct()
	{	
		$this->CI =& get_instance();
	}
	public function upload($files,$filename=null,$filedirectory=null,$allowed_types=null)
	{
		$config['upload_path'] = $filedirectory;
		$config['allowed_types'] = $allowed_types;
		$config['file_name']  = $filename;
		// $config['max_size']  = 1024; 

		if (!is_dir($filedirectory)) {
		    mkdir('./'.$filedirectory, 0777, TRUE);

		}
		
		$this->CI->load->library('upload', $config);
		
		if ( ! $this->CI->upload->do_upload($files)){
			$error = array('error' => $this->CI->upload->display_errors());
			$msg['message'] = $error['error'];
			$msg['alert'] =  'gagal';
		}
		else{
			$file = $this->CI->upload->data();
			$data = array(
		   				'name'=> $file['file_name'],
		   				'mime'=> $file['file_type'],
		   				'dir'=> $filedirectory.$file['file_name'],
		   	 		);

			$msg['message'] = $data;
			$msg['alert'] ='success';
		}

		return $msg;
	
	}



}
