
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class M_mitra extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$data['page_name'] = "m_mitra";
			$this->template->load('template/template','master/m_mitra/all-m_mitra',$data);
		}
		
		public function create()
		{
			$this->load->view('master/m_mitra/add-m_mitra');
		}
		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->form_validation->set_rules('dt[m_name]', '<strong>M Name</strong>', 'required');
			$this->form_validation->set_rules('dt[m_alamat]', '<strong>M Alamat</strong>', 'required');
			$this->form_validation->set_rules('dt[m_cp_name]', '<strong>M Cp Name</strong>', 'required');
			$this->form_validation->set_rules('dt[m_telp]', '<strong>M Telp</strong>', 'required');
			
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
				$str = $this->mymodel->insertData('m_mitra', $dt);
				
			echo 'success';

		   

			}
		}

		public function json()
		{
			$status = $_GET['status'];
			if($status=='') $status = 'ENABLE';
			
			header('Content-Type: application/json');
	        $this->datatables_search->select('m_mitra.m_id,m_mitra.m_name,m_mitra.m_alamat,m_mitra.m_cp_name,m_mitra.m_telp,status');
	        $this->datatables_search->where('m_mitra.status',$status);
	        $this->datatables_search->from('m_mitra');
	        if($status=="ENABLE"){
				$this->datatables_search->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit Data</button>
															</div>', 'm_id');
	    	}else{
				$this->datatables_search->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit Data</button>
															</div>', 'm_id');
	    	}
	        echo $this->datatables_search->generate();
		}
		
		public function edit($id)
		{
			$data['m_mitra'] = $this->mymodel->selectDataone('m_mitra',array('m_id'=>$id));		
			$data['page_name'] = "m_mitra";
			$this->load->view('master/m_mitra/edit-m_mitra',$data);
		}

		public function update()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->validate();

			if ($this->form_validation->run() == FALSE){
				echo validation_errors();   
	        }else{
				$id = $this->input->post('m_id', TRUE);		
				$dt = $this->input->post('dt');
				$dt['updated_at'] = date("Y-m-d H:i:s");
				$str = $this->mymodel->updateData('m_mitra', $dt , array('m_id'=>$id));
				if($str==true){
					echo "success";
				}else{
					echo "Something error in system";
				}  
			}
		}

		public function delete()
		{
			$id = $this->input->post('m_id', TRUE);
			$str = $this->mymodel->deleteData('m_mitra', array('m_id'=>$id));
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
				$this->db->where_in('m_id',$id);
				$this->db->delete('m_mitra',[]);
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
			$this->mymodel->updateData('m_mitra',array('status'=>$status),array('m_id'=>$id));
			redirect('master/M_mitra');
		}

		public function getalldatamitra()
		{
			$idmitra = $this->input->post('mitra_id');
			$mitra = $this->mymodel->selectDataone('m_mitra',['m_id'=>$idmitra]);
			$response = array('cp' => $mitra['m_cp_name'].' ('.$mitra['m_telp'].')',
							  'alamat' => $mitra['m_alamat'],
							 );
			echo json_encode($response);
		}
	}
?>