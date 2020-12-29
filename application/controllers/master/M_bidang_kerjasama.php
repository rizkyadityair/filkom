
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class M_bidang_kerjasama extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$data['page_name'] = "m_bidang_kerjasama";
			$this->template->load('template/template','master/m_bidang_kerjasama/all-m_bidang_kerjasama',$data);
		}
		
		public function create()
		{
			$this->load->view('master/m_bidang_kerjasama/add-m_bidang_kerjasama');
		}
		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->form_validation->set_rules('dt[mbk_name]', '<strong>Mbk Name</strong>', 'required');
			
		}

		public function store()
		{
			$this->validate();
			if ($this->form_validation->run() == FALSE){
				echo validation_errors();    
	        }else{
				$dt = $this->input->post('dt');
				$dt['created_at'] = date('Y-m-d H:i:s');
				$dt['created_by'] = $this->session->userdata('id');
				$dt['status'] = "ENABLE";
				$str = $this->mymodel->insertData('m_bidang_kerjasama', $dt);
			echo 'success';

		   

			}
		}

		public function json()
		{
			$status = $_GET['status'];
			if($status=='') $status = 'ENABLE';
			
			header('Content-Type: application/json');
	        $this->datatables_search->select('m_bidang_kerjasama.mbk_id,m_bidang_kerjasama.mbk_name,status');
	        $this->datatables_search->where('m_bidang_kerjasama.status',$status);
	        $this->datatables_search->from('m_bidang_kerjasama');
	        if($status=="ENABLE"){
				$this->datatables_search->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit Data</button>
															</div>', 'mbk_id');
	    	}else{
				$this->datatables_search->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit Data</button>
															</div>', 'mbk_id');
	    	}
	        echo $this->datatables_search->generate();
		}
		
		public function edit($id)
		{
			$data['m_bidang_kerjasama'] = $this->mymodel->selectDataone('m_bidang_kerjasama',array('mbk_id'=>$id));		
			$data['page_name'] = "m_bidang_kerjasama";
			$this->load->view('master/m_bidang_kerjasama/edit-m_bidang_kerjasama',$data);
		}

		public function update()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->validate();

			if ($this->form_validation->run() == FALSE){
				echo validation_errors();   
	        }else{
				$id = $this->input->post('mbk_id', TRUE);		
				$dt = $this->input->post('dt');
				$dt['updated_at'] = date("Y-m-d H:i:s");
				$str = $this->mymodel->updateData('m_bidang_kerjasama', $dt , array('mbk_id'=>$id));
				if($str==true){
					echo "success";
				}else{
					echo "Something error in system";
				}  
			}
		}

		public function delete()
		{
			$id = $this->input->post('mbk_id', TRUE);
			$str = $this->mymodel->deleteData('m_bidang_kerjasama', array('mbk_id'=>$id));
			if($str==true){
				echo "success";
			}else{
				echo "Something error in system";
			}  
		
		}

		public function deleteData()
		{
			$data = $this->input->post('data');
			if($data!=""){
				$id = explode(',',$data);
				$this->db->where_in('mbk_id',$id);
				$this->db->delete('m_bidang_kerjasama',[]);
				if($str==true){
					echo "success";
				}else{
					echo "Something error in system";
				} 
			}else{
				echo "success";
			}
		}

		public function status($id,$status)
		{
			$this->mymodel->updateData('m_bidang_kerjasama',array('status'=>$status),array('mbk_id'=>$id));
			redirect('master/M_bidang_kerjasama');
		}
	}
?>