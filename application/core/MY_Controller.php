<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class MY_Controller extends CI_Controller{

	public function __construct() {
		parent::__construct();
        $this->core = & get_instance();
		date_default_timezone_set("Asia/Jakarta");
		$folder = $this->router->directory;
		$class = $this->router->class;
		$method = $this->router->method;
		$role = $this->session->userdata('role_id');

		if($folder==""){
			$link = $class."/".$method;
		}else{
			$link = $folder.$class."/".$method;
		}
		
		// $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));


		// if($this->session->userdata('session_sop')==true){
		// 	$get_link = $this->mymodel->selectDataone('access_control',array('val'=>$link));
		// 	$cek = $this->mymodel->selectWhere('access',array('access_control_id'=>$get_link['id'],'role_id'=>$role));
		// 	if($link!=""){
		// 		if(count($cek)==0){
		// 			// redirect('/');
		// 		}	
		// 	}

  //       	$check_restricting = $this->mmodel->selectWhere('access_block',['ab_role_id'=>$role,'ab_link'=>$link])->num_rows();
  //       	if ($check_restricting) {
  //       		redirect('restricted');
  //       	}
		// }


		$this->konfig();
		// JIKA INGIN MENGAKTIFKAN LOG AKTIVITAS
		// $this->log_activity();
		define('KEY', '!2261%^^&!*&@**@#&');
		define('IV', '**#$7843874^^&$*#&7');
	}

	function konfig()
	{
		$konfig = $this->mymodel->selectData('konfig');
		foreach ($konfig as $knf) {
			define($knf['slug'], $knf['value']);
		}
	}

	public function get_uri($folder="")
	{
		# code...
		if($folder!="api/"){
			$dir    =  dirname(__FILE__) .'/../controllers'.$folder;
			$files1 = scandir($dir);
			foreach ($files1 as $file) {
				$a = $file;
				if (strpos($a, '.php') !== false) {
				    $data['file'][] = $a;
				}else{
					if($a!="." AND $a!=".." AND strpos($a, '.') === false)
				    $data['folder'][] = $a;
				}
			}
			return $data;
		}
	}

	public function button_restrict($role,$type="allow") // $type diisi allow atau restrict
	{
		$me = $this->session->userdata('role_slug');

		if ($type=="allow") {
			if (in_array($me, $role)) {
				$return = "allow";
			} else {
				$return = "restricted";
			}
		} elseif ($type=="restrict") {
			if (in_array($me, $role)) {
				$return = "restricted";
			} else {
				$return = "allow";
			}
		}

		return $return;
	}

}