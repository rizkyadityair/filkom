
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class M_sub_kerjasama extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$data['page_name'] = "m_sub_kerjasama";
			$this->template->load('template/template','master/m_sub_kerjasama/all-m_sub_kerjasama',$data);
		}
		
		public function create()
		{
			$this->load->view('master/m_sub_kerjasama/add-m_sub_kerjasama');
		}
		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->form_validation->set_rules('dt[msk_id_mbk]', '<strong>Bidang Kerjasama</strong>', 'required');
			$this->form_validation->set_rules('dt[msk_name]', '<strong>Sub Bidang Kerjasama</strong>', 'required');
			
		}

		public function store()
		{
			$this->validate();
			if ($this->form_validation->run() == FALSE){
				echo validation_errors();    
	        }else{
				$dt = $this->input->post('dt');
				$bidang_kerjasama = $this->mymodel->selectDataone('m_bidang_kerjasama',['mbk_id'=>$dt['msk_id_mbk']]);
				$dt['msk_name_mbk'] = $bidang_kerjasama['mbk_name'];
				$dt['created_at'] = date('Y-m-d H:i:s');
				$dt['created_by'] = $this->session->userdata('id');
				$dt['status'] = "ENABLE";
				$str = $this->mymodel->insertData('m_sub_kerjasama', $dt);
				
			echo 'success';

		   

			}
		}

		public function json()
		{
			$status = $_GET['status'];
			if($status=='') $status = 'ENABLE';
			
			$msk_name_mbk = $this->input->post('filter_msk_name_mbk');
			header('Content-Type: application/json');
	        $this->datatables_search->select('m_sub_kerjasama.msk_id,m_sub_kerjasama.msk_name_mbk,m_sub_kerjasama.msk_name,status');
			if($msk_name_mbk){
				$this->datatables_search->where('m_sub_kerjasama.msk_name_mbk',$msk_name_mbk);
			}
		
	        $this->datatables_search->where('m_sub_kerjasama.status',$status);
	        $this->datatables_search->from('m_sub_kerjasama');
	        if($status=="ENABLE"){
				$this->datatables_search->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit Data</button>
															</div>', 'msk_id');
	    	}else{
				$this->datatables_search->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit Dara</button>
															</div>', 'msk_id');
	    	}
	        echo $this->datatables_search->generate();
		}
		
		public function edit($id)
		{
			$data['m_sub_kerjasama'] = $this->mymodel->selectDataone('m_sub_kerjasama',array('msk_id'=>$id));		
			$data['page_name'] = "m_sub_kerjasama";
			$this->load->view('master/m_sub_kerjasama/edit-m_sub_kerjasama',$data);
		}

		public function update()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->validate();

			if ($this->form_validation->run() == FALSE){
				echo validation_errors();   
	        }else{
				$id = $this->input->post('msk_id', TRUE);		
				$dt = $this->input->post('dt');
				$bidang_kerjasama = $this->mymodel->selectDataone('m_bidang_kerjasama',['mbk_id'=>$dt['msk_id_mbk']]);
				$dt['msk_name_mbk'] = $bidang_kerjasama['mbk_name'];
				$dt['updated_at'] = date("Y-m-d H:i:s");
				$str = $this->mymodel->updateData('m_sub_kerjasama', $dt , array('msk_id'=>$id));
				if($str==true){
					echo "success";
				}else{
					echo "Something error in system";
				}  
			}
		}

		public function delete()
		{
			$id = $this->input->post('msk_id', TRUE);
			$str = $this->mymodel->deleteData('m_sub_kerjasama', array('msk_id'=>$id));
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
				$this->db->where_in('msk_id',$id);
				$this->db->delete('m_sub_kerjasama',[]);
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
			$this->mymodel->updateData('m_sub_kerjasama',array('status'=>$status),array('msk_id'=>$id));
			redirect('master/M_sub_kerjasama');
		}
	}
?>