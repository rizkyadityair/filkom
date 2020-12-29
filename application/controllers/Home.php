<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data['page_name'] = "home";
		$data['bidang'] = $this->mymodel->selectWhere('m_bidang_kerjasama',['status'=>'ENABLE']);
		$this->template->load('template/template','template/index',$data);
		
	}

	public function test()
	{
		// echo json_encode($this->controllerlist->getControllers());

		$file = $this->get_uri();
		foreach ($file['file'] as $controller) {
			$con[] = $controller;
			$fol[] = '';
		}
		foreach ($file['folder'] as $folder) {
			$files = $this->get_uri('/'.$folder);
			foreach ($files['file'] as $controller) {
				$con[] = $controller;
				$fol[] = $folder.'/';
			}
		}
		$i=0;
		foreach ($con as $ctrl) {
			if($fol[$i]!="api/"){
	    		include_once APPPATH . 'controllers/' . $fol[$i] .$ctrl;
	    		$methods = get_class_methods( str_replace( '.php', '', $ctrl ) );
	    		foreach ($methods as $mt) {
	    			$data[] = array(
	    						'folder'=>str_replace("/","",$fol[$i]),
	    						'class'=>str_replace( '.php', '', $ctrl ),
	    						'method'=>$mt,
	    						'val'=>strtolower($fol[$i].str_replace( '.php', '', $ctrl )."/".$mt),
	    					);
	    		}
	    	}
			$i++;
		}

		echo json_encode($data);

	}

	public function test2()
	{
		echo $this->router->fetch_directory();
		echo $this->router->fetch_class();
		echo $this->router->fetch_method();
	}

	public function cache()
	{
		

	}

   

}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */