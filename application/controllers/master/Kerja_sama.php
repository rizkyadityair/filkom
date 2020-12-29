
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Kerja_sama extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$data['page_name'] = "kerja_sama";
			$this->template->load('template/template','master/kerja_sama/all-kerja_sama',$data);
		}
		

		public function create()
		{
			$data['page_name'] = "kerja_sama";
			$data['bidang_kerjasama'] = $this->mymodel->selectWhere('m_bidang_kerjasama',['status'=>'ENABLE']);
			$this->template->load('template/template','master/kerja_sama/add-kerja_sama',$data);
		}
		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->form_validation->set_rules('ks_tipe', '<strong>Tipe</strong>', 'required');
			$this->form_validation->set_rules('ks_mitra_id', '<strong>Mitra</strong>', 'required');
			
		}

		public function store()
		{
			$this->validate();
			if ($this->form_validation->run() == FALSE){
				echo validation_errors();    
	        }else{
	        	$param = $this->input->post();
	        	if($param['ks_tipe']=='mou'){
	        		$cekdata = $this->mymodel->selectDataone('kerja_sama',['ks_mitra_id'=>$param['ks_mitra_id'],'ks_tipe'=>'mou']);
		        	$mitra = $this->mymodel->selectDataone('m_mitra',['m_id'=>$param['ks_mitra_id']]);
		        	if ($cekdata) {
		        		echo "Mou untuk mitra ".$mitra['m_name']." sudah ada";
		        	}else{
			        	if ($param['ks_tipe']=='mou') {
			        		$bidang_kerjasama = $this->mymodel->selectDataone('m_bidang_kerjasama',['mbk_id'=>$param['ks_bidang_id_mou']]);
			        		$dt = array('ks_tipe' => $param['ks_tipe'],
			        					'ks_mitra_id' => $param['ks_mitra_id'],
			        					'ks_mitra_name' => $mitra['m_name'],
			        					'ks_alamat_mitra' => $param['ks_alamat_mitra_moa'],
			        					'ks_cp_mitra' => $param['ks_cp_mitra_mou'],
			        					'ks_no_mou_filkom' => $param['ks_no_mou_filkom'],
			        					'ks_no_mou_mitra' => $param['ks_no_mou_mitra'],
			        					'ks_tgl_mulai' => $param['ks_tgl_mulai_mou'],
			        					'ks_tgl_selesai' => $param['ks_tgl_selesai_mou'],
			        					'ks_bidang_id' => $param['ks_bidang_id_mou'],
			        					'ks_bidang' => $bidang_kerjasama['mbk_name'],
			        					'ks_subidang_id' => '',
			        					'ks_subidang' => '',
			        					'ks_biaya' => str_replace(',', '', $param['ks_biaya_mou']),
			        					'ks_tindak_lanjut' => $param['ks_tindak_lanjut_mou'],
			        					'ks_progress' => 'On Going',
			        					'ks_jangka_waktu' => $param['ks_jangka_waktu_mou'],
			        					'ks_cp_filkom' => $param['ks_cp_filkom_mou'],
			        					'ks_semester' => $param['ks_semester'],
			        				   );
			        	}else{
			        		$bidang_kerjasama = $this->mymodel->selectDataone('m_bidang_kerjasama',['mbk_id'=>$param['ks_bidang_id_moa']]);
			        		$sub_bidang_kerjasama = $this->mymodel->selectDataone('m_sub_kerjasama',['msk_id'=>$param['ks_subidang_id_moa']]);
			        		$dt = array('ks_tipe' => $param['ks_tipe'],
			        					'ks_mitra_id' => $param['ks_mitra_id'],
			        					'ks_mitra_name' => $mitra['m_name'],
			        					'ks_alamat_mitra' => $param['ks_alamat_mitra_moa'],
			        					'ks_cp_mitra' => $param['ks_cp_mitra_mou'],
			        					'ks_no_moa_filkom' => $param['ks_no_moa_filkom'],
			        					'ks_no_moa_mitra' => $param['ks_no_moa_mitra'],
			        					'ks_tgl_mulai' => $param['ks_tgl_mulai_moa'],
			        					'ks_tgl_selesai' => $param['ks_tgl_selesai_moa'],
			        					'ks_bidang_id' => $param['ks_bidang_id_moa'],
			        					'ks_bidang' => $bidang_kerjasama['mbk_name'],
			        					'ks_subidang_id' => $param['ks_subidang_id_moa'],
			        					'ks_subidang' => $sub_bidang_kerjasama['msk_name'],
			        					'ks_biaya' => str_replace(',', '', $param['ks_biaya_mou']),
			        					'ks_tindak_lanjut' => $param['ks_tindak_lanjut_moa'],
			        					'ks_progress' => 'On Going',
			        					'ks_jangka_waktu' => $param['ks_jangka_waktu_moa'],
			        					'ks_cp_filkom' => $param['ks_cp_filkom_mou'],
			        					'ks_semester' => $param['ks_semester'],
			        				   );
			        	}
						$dt['created_at'] = date('Y-m-d H:i:s');
						$dt['created_by'] = $this->session->userdata('id');
						$dt['status'] = "ENABLE";
						$str = $this->mymodel->insertData('kerja_sama', $dt);
							    
						$last_id = $this->db->insert_id();
						if (!empty($_FILES['file']['name'])){
							$directory = 'webfile/';
							$filename = $_FILES['file']['name'];
							$allowed_types = '*';
							$max_size = '2000';
							$result = $this->uploadfile->upload('file',$filename,$directory,$allowed_types, $max_size);
							if($result['alert'] == 'success'){
								$data = array(
									'id' => '',
									'name'=> $result['message']['name'],
									'mime'=> $result['message']['mime'],
									'dir'=> $result['message']['dir'],
									'table'=> 'kerja_sama',
									'table_id'=> $last_id,
									'status'=>'ENABLE',
									'created_at'=>date('Y-m-d H:i:s')
								);
								$str = $this->mymodel->insertData('file', $data);
								echo 'success';
							}else{
								echo $result['message'];
							}
						}else{
							$data = array(
								'name'=> '',
								'mime'=> '',
								'dir'=> '',
								'table'=> 'kerja_sama',
								'table_id'=> $last_id,
								'status'=>'ENABLE',
								'created_at'=>date('Y-m-d H:i:s')
							);
							$str = $this->mymodel->insertData('file', $data);
							echo 'success';
						}
		        	}   
	        	}else{
	        		$mitra = $this->mymodel->selectDataone('m_mitra',['m_id'=>$param['ks_mitra_id']]);
		        	if ($cekdata) {
		        		echo "Mou untuk mitra ".$mitra['m_name']." sudah ada";
		        	}else{
			        	if ($param['ks_tipe']=='mou') {
			        		$bidang_kerjasama = $this->mymodel->selectDataone('m_bidang_kerjasama',['mbk_id'=>$param['ks_bidang_id_mou']]);
			        		$dt = array('ks_tipe' => $param['ks_tipe'],
			        					'ks_mitra_id' => $param['ks_mitra_id'],
			        					'ks_mitra_name' => $mitra['m_name'],
			        					'ks_alamat_mitra' => $param['ks_alamat_mitra_moa'],
			        					'ks_cp_mitra' => $param['ks_cp_mitra_mou'],
			        					'ks_no_mou_filkom' => $param['ks_no_mou_filkom'],
			        					'ks_no_mou_mitra' => $param['ks_no_mou_mitra'],
			        					'ks_tgl_mulai' => $param['ks_tgl_mulai_mou'],
			        					'ks_tgl_selesai' => $param['ks_tgl_selesai_mou'],
			        					'ks_bidang_id' => $param['ks_bidang_id_mou'],
			        					'ks_bidang' => $bidang_kerjasama['mbk_name'],
			        					'ks_subidang_id' => '',
			        					'ks_subidang' => '',
			        					'ks_biaya' => str_replace(',', '', $param['ks_biaya_mou']),
			        					'ks_tindak_lanjut' => $param['ks_tindak_lanjut_mou'],
			        					'ks_progress' => 'On Going',
			        					'ks_jangka_waktu' => $param['ks_jangka_waktu_mou'],
			        					'ks_cp_filkom' => $param['ks_cp_filkom_mou'],
			        					'ks_semester' => $param['ks_semester'],
			        				   );
			        	}else{
			        		$bidang_kerjasama = $this->mymodel->selectDataone('m_bidang_kerjasama',['mbk_id'=>$param['ks_bidang_id_moa']]);
			        		$sub_bidang_kerjasama = $this->mymodel->selectDataone('m_sub_kerjasama',['msk_id'=>$param['ks_subidang_id_moa']]);
			        		$dt = array('ks_tipe' => $param['ks_tipe'],
			        					'ks_mitra_id' => $param['ks_mitra_id'],
			        					'ks_mitra_name' => $mitra['m_name'],
			        					'ks_alamat_mitra' => $param['ks_alamat_mitra_moa'],
			        					'ks_cp_mitra' => $param['ks_cp_mitra_mou'],
			        					'ks_no_moa_filkom' => $param['ks_no_moa_filkom'],
			        					'ks_no_moa_mitra' => $param['ks_no_moa_mitra'],
			        					'ks_tgl_mulai' => $param['ks_tgl_mulai_moa'],
			        					'ks_tgl_selesai' => $param['ks_tgl_selesai_moa'],
			        					'ks_bidang_id' => $param['ks_bidang_id_moa'],
			        					'ks_bidang' => $bidang_kerjasama['mbk_name'],
			        					'ks_subidang_id' => $param['ks_subidang_id_moa'],
			        					'ks_subidang' => $sub_bidang_kerjasama['msk_name'],
			        					'ks_biaya' => str_replace(',', '', $param['ks_biaya_mou']),
			        					'ks_tindak_lanjut' => $param['ks_tindak_lanjut_moa'],
			        					'ks_progress' => 'On Going',
			        					'ks_jangka_waktu' => $param['ks_jangka_waktu_moa'],
			        					'ks_cp_filkom' => $param['ks_cp_filkom_mou'],
			        					'ks_semester' => $param['ks_semester'],
			        				   );
			        	}
						$dt['created_at'] = date('Y-m-d H:i:s');
						$dt['created_by'] = $this->session->userdata('id');
						$dt['status'] = "ENABLE";
						$str = $this->mymodel->insertData('kerja_sama', $dt);
							    
						$last_id = $this->db->insert_id();
						if (!empty($_FILES['file']['name'])){
							$directory = 'webfile/';
							$filename = $_FILES['file']['name'];
							$allowed_types = '*';
							$max_size = '2000';
							$result = $this->uploadfile->upload('file',$filename,$directory,$allowed_types, $max_size);
							if($result['alert'] == 'success'){
								$data = array(
									'id' => '',
									'name'=> $result['message']['name'],
									'mime'=> $result['message']['mime'],
									'dir'=> $result['message']['dir'],
									'table'=> 'kerja_sama',
									'table_id'=> $last_id,
									'status'=>'ENABLE',
									'created_at'=>date('Y-m-d H:i:s')
								);
								$str = $this->mymodel->insertData('file', $data);
								echo 'success';
							}else{
								echo $result['message'];
							}
						}else{
							$data = array(
								'name'=> '',
								'mime'=> '',
								'dir'=> '',
								'table'=> 'kerja_sama',
								'table_id'=> $last_id,
								'status'=>'ENABLE',
								'created_at'=>date('Y-m-d H:i:s')
							);
							$str = $this->mymodel->insertData('file', $data);
							echo 'success';
						}
		        	}
	        	}
			}
		}

		public function json()
		{
			$status = $_GET['status'];
			if($status=='') $status = 'ENABLE';
			$ks_mitra_name = $this->input->post('filter_ks_mitra_name');
			$searchdata = $this->input->post('searchdata');
			header('Content-Type: application/json');
	        $this->datatables->select('kerja_sama.ks_id,kerja_sama.ks_tipe,kerja_sama.ks_mitra_name,kerja_sama.ks_no_mou_filkom,kerja_sama.ks_no_mou_mitra,kerja_sama.ks_tgl_mulai,kerja_sama.ks_tgl_selesai,kerja_sama.ks_bidang,kerja_sama.ks_biaya,kerja_sama.ks_mitra_id,kerja_sama.ks_subidang,kerja_sama.ks_alamat_mitra,kerja_sama.ks_tindak_lanjut,kerja_sama.ks_progress,kerja_sama.ks_jangka_waktu,kerja_sama.status,file.dir,kerja_sama.ks_no_moa_filkom,kerja_sama.ks_no_moa_mitra');
			if($ks_mitra_name){
				$this->datatables->where('kerja_sama.ks_mitra_name',$ks_mitra_name);
			}
			if ($searchdata) {
				$this->db->group_start();
					$this->datatables->like('kerja_sama.ks_mitra_name', $searchdata, 'BOTH');
					$this->datatables->or_like('kerja_sama.ks_no_mou_filkom', $searchdata);
					$this->datatables->or_like('kerja_sama.ks_jangka_waktu', $searchdata);
					$this->datatables->or_like('kerja_sama.ks_bidang', $searchdata);
					$this->datatables->or_like('kerja_sama.ks_progress', $searchdata);
				$this->db->group_end();
				$this->datatables->where('kerja_sama.ks_tipe', 'mou');
			}
			$this->datatables->join('file', 'file.table_id = kerja_sama.ks_id AND table = "kerja_sama"', 'left');
	        $this->datatables->where('kerja_sama.status',$status);
	        $this->datatables->group_by('ks_mitra_id');
	        $this->datatables->from('kerja_sama');
	        if($status=="ENABLE"){
				$this->datatables->add_column('view', '<button type="button" class="btn btn-sm btn-primary btn-block" onclick="getstatus(\'$1\',$(this))"><i class="fa fa-pie-chart"></i> Status</button><button type="button" class="btn btn-sm btn-primary btn-block" onclick="preview(\'$2\',$(this))"><i class="fa fa-eye"></i> Preview</button><button type="button" class="btn btn-sm btn-primary btn-block" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>', 'ks_id,dir');
	    	}else{
				$this->datatables->add_column('view', '<div class="btn-group">
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>
																	<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
															</div>', 'ks_id');
	    	}
	        echo $this->datatables->generate();
		}

		public function edit($id)
		{
			$data['kerja_sama'] = $this->mymodel->selectDataone('kerja_sama',array('ks_id'=>$id));	
			$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'kerja_sama'));		
			$data['page_name'] = "kerja_sama";
			$data['bidang_kerjasama'] = $this->mymodel->selectWhere('m_bidang_kerjasama',['status'=>'ENABLE']);
			$this->template->load('template/template','master/kerja_sama/edit-kerja_sama',$data);
		}

		public function update()
		{
			$id = $this->input->post('ks_id', TRUE);
			if (!empty($_FILES['file']['name'])){
				$directory = 'webfile/';
				$filename = $_FILES['file']['name'];
				$allowed_types = '*';
				$max_size = '2000';
				$result = $this->uploadfile->upload('file',$filename,$directory,$allowed_types, $max_size);
				if($result['alert'] == 'success'){
					$data = array(
						'name'=> $result['message']['name'],
						'mime'=> $result['message']['mime'],
						'dir'=> $result['message']['dir'],
						'table'=> 'kerja_sama',
						'table_id'=> $id,
						'updated_at'=>date('Y-m-d H:i:s')
					);
					$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'kerja_sama'));
					@unlink($file['dir']);
					if($file==""){
						$this->mymodel->insertData('file', $data);
					}else{
						$this->mymodel->updateData('file', $data , array('id'=>$file['id']));
					}

					$param = $this->input->post();
		        	// $mitra = $this->mymodel->selectDataone('m_mitra',['m_id'=>$param['ks_mitra_id']]);
		        	if ($param['ks_tipe']=='mou') {
		        		$bidang_kerjasama = $this->mymodel->selectDataone('m_bidang_kerjasama',['mbk_id'=>$param['ks_bidang_id_mou']]);
		        		$dt = array('ks_tipe' => $param['ks_tipe'],
		        					// 'ks_mitra_id' => $param['ks_mitra_id'],
		        					// 'ks_mitra_name' => $mitra['m_name'],
		        					// 'ks_alamat_mitra' => $param['ks_alamat_mitra_moa'],
		        					// 'ks_cp_mitra' => $param['ks_cp_mitra_mou'],
		        					'ks_no_mou_filkom' => $param['ks_no_mou_filkom'],
		        					'ks_no_mou_mitra' => $param['ks_no_mou_mitra'],
		        					'ks_tgl_mulai' => $param['ks_tgl_mulai_mou'],
		        					'ks_tgl_selesai' => $param['ks_tgl_selesai_mou'],
		        					'ks_bidang_id' => $param['ks_bidang_id_mou'],
		        					'ks_bidang' => $bidang_kerjasama['mbk_name'],
		        					'ks_subidang_id' => '',
		        					'ks_subidang' => '',
		        					'ks_biaya' => str_replace(',', '', $param['ks_biaya_mou']),
		        					'ks_tindak_lanjut' => $param['ks_tindak_lanjut_mou'],
		        					'ks_jangka_waktu' => $param['ks_jangka_waktu_mou'],
		        					'ks_cp_filkom' => $param['ks_cp_filkom_mou'],
		        					'ks_semester' => $param['ks_semester'],
		        				   );
		        	}else{
		        		$bidang_kerjasama = $this->mymodel->selectDataone('m_bidang_kerjasama',['mbk_id'=>$param['ks_bidang_id_moa']]);
        				$sub_bidang_kerjasama = $this->mymodel->selectDataone('m_sub_kerjasama',['msk_id'=>$param['ks_subidang_id_moa']]);
		        		$dt = array('ks_tipe' => $param['ks_tipe'],
		        					// 'ks_mitra_id' => $param['ks_mitra_id'],
		        					// 'ks_mitra_name' => $mitra['m_name'],
		        					// 'ks_alamat_mitra' => $param['ks_alamat_mitra_moa'],
		        					// 'ks_cp_mitra' => $param['ks_cp_mitra_mou'],
		        					'ks_no_moa_filkom' => $param['ks_no_moa_filkom'],
        							'ks_no_moa_mitra' => $param['ks_no_moa_mitra'],
		        					'ks_tgl_mulai' => $param['ks_tgl_mulai_moa'],
		        					'ks_tgl_selesai' => $param['ks_tgl_selesai_moa'],
		        					'ks_bidang_id' => $param['ks_bidang_id_moa'],
		        					'ks_bidang' => $bidang_kerjasama['mbk_name'],
		        					'ks_subidang_id' => $param['ks_subidang_id_moa'],
		        					'ks_subidang' => $sub_bidang_kerjasama['msk_name'],
		        					'ks_biaya' => str_replace(',', '', $param['ks_biaya_mou']),
		        					'ks_tindak_lanjut' => $param['ks_tindak_lanjut_moa'],
		        					'ks_jangka_waktu' => $param['ks_jangka_waktu_moa'],
		        					'ks_cp_filkom' => $param['ks_cp_filkom_mou'],
		        					'ks_semester' => $param['ks_semester'],
		        				   );
		        	}
					$dt['updated_at'] = date("Y-m-d H:i:s");
					$dt['updated_by'] = $this->session->userdata('id');
					$str =  $this->mymodel->updateData('kerja_sama', $dt , array('ks_id'=>$id));
					if($str==true){
						echo 'success';
					}else{
						echo 'Something error in system';
					}
				}else{
					echo $result['message'];
				}

			}else{
				$param = $this->input->post();
	        	if ($param['ks_tipe']=='mou') {
	        		$bidang_kerjasama = $this->mymodel->selectDataone('m_bidang_kerjasama',['mbk_id'=>$param['ks_bidang_id_mou']]);
	        		$dt = array('ks_tipe' => $param['ks_tipe'],
	        					// 'ks_mitra_id' => $param['ks_mitra_id'],
	        					// 'ks_mitra_name' => $mitra['m_name'],
	        					// 'ks_alamat_mitra' => $param['ks_alamat_mitra_moa'],
	        					// 'ks_cp_mitra' => $param['ks_cp_mitra_mou'],
	        					'ks_no_mou_filkom' => $param['ks_no_mou_filkom'],
	        					'ks_no_mou_mitra' => $param['ks_no_mou_mitra'],
	        					'ks_tgl_mulai' => $param['ks_tgl_mulai_mou'],
	        					'ks_tgl_selesai' => $param['ks_tgl_selesai_mou'],
	        					'ks_bidang_id' => $param['ks_bidang_id_mou'],
	        					'ks_bidang' => $bidang_kerjasama['mbk_name'],
	        					'ks_subidang_id' => '',
	        					'ks_subidang' => '',
	        					'ks_biaya' => str_replace(',', '', $param['ks_biaya_mou']),
	        					'ks_tindak_lanjut' => $param['ks_tindak_lanjut_mou'],
	        					'ks_jangka_waktu' => $param['ks_jangka_waktu_mou'],
	        					'ks_cp_filkom' => $param['ks_cp_filkom_mou'],
	        					'ks_semester' => $param['ks_semester'],
	        				   );
	        	}else{
	        		$bidang_kerjasama = $this->mymodel->selectDataone('m_bidang_kerjasama',['mbk_id'=>$param['ks_bidang_id_moa']]);
    				$sub_bidang_kerjasama = $this->mymodel->selectDataone('m_sub_kerjasama',['msk_id'=>$param['ks_subidang_id_moa']]);
	        		$dt = array('ks_tipe' => $param['ks_tipe'],
	        					// 'ks_mitra_id' => $param['ks_mitra_id'],
	        					// 'ks_mitra_name' => $mitra['m_name'],
	        					// 'ks_alamat_mitra' => $param['ks_alamat_mitra_moa'],
	        					// 'ks_cp_mitra' => $param['ks_cp_mitra_mou'],
	        					'ks_no_moa_filkom' => $param['ks_no_moa_filkom'],
    							'ks_no_moa_mitra' => $param['ks_no_moa_mitra'],
	        					'ks_tgl_mulai' => $param['ks_tgl_mulai_moa'],
	        					'ks_tgl_selesai' => $param['ks_tgl_selesai_moa'],
	        					'ks_bidang_id' => $param['ks_bidang_id_moa'],
	        					'ks_bidang' => $bidang_kerjasama['mbk_name'],
	        					'ks_subidang_id' => $param['ks_subidang_id_moa'],
	        					'ks_subidang' => $sub_bidang_kerjasama['msk_name'],
	        					'ks_biaya' => str_replace(',', '', $param['ks_biaya_mou']),
	        					'ks_tindak_lanjut' => $param['ks_tindak_lanjut_moa'],
	        					'ks_jangka_waktu' => $param['ks_jangka_waktu_moa'],
	        					'ks_cp_filkom' => $param['ks_cp_filkom_mou'],
	        					'ks_semester' => $param['ks_semester'],
	        				   );
	        	}
				$dt['updated_at'] = date("Y-m-d H:i:s");
				$str = $this->mymodel->updateData('kerja_sama', $dt , array('ks_id'=>$id));
				if($str==true){
					echo 'success';
				}else{
					echo 'Something error in system';
				}
			}
		}

		public function delete()
		{
			$id = $this->input->post('ks_id', TRUE);
			$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'kerja_sama'));
			@unlink($file['dir']);
			$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'kerja_sama'));
			$str = $this->mymodel->deleteData('kerja_sama',  array('ks_id'=>$id));
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
				$this->db->where_in('ks_id',$id);
				$str = $this->db->delete('kerja_sama');
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
			$this->mymodel->updateData('kerja_sama',array('status'=>$status),array('ks_id'=>$id));
			redirect('master/Kerja_sama');
		}

		public function getstatus($id)
		{
			$data['page_name'] = "kerja_sama";
			$data['kerja_sama'] = $this->mymodel->selectDataone('kerja_sama',['ks_id'=>$id]);
			$this->template->load('template/template','master/kerja_sama/status-kerja_sama',$data);
		}

		public function getdatabidangkerjasama()
		{
			$m_bidang_kerjasama = $this->mymodel->selectWhere('m_bidang_kerjasama',null);
			echo "<option value=''>Pilih</option>";
	        foreach ($m_bidang_kerjasama as $m_bidang_kerjasama_record) {
	            echo "<option value=".$m_bidang_kerjasama_record['mbk_id'].">".$m_bidang_kerjasama_record['mbk_name']."</option>";
	        }
		}

		public function getsubbidang()
		{
			$paramget = $this->input->get();
			$subbidang = $this->mymodel->selectWhere('m_sub_kerjasama',['msk_id_mbk'=>$paramget['bidang_kerjasama']]);
			foreach ($subbidang as $valsubbidang) { ?>
				<option value="<?= $valsubbidang['msk_id']?>" <?= ($paramget['selected']==$valsubbidang['msk_id'])?'selected':''?> ><?= $valsubbidang['msk_name']?></option>
			<?php
			}
		}

		public function exportkerjasama()
		{
			$this->db->group_by('ks_mitra_id');
			$data['kerjasama'] = $this->mymodel->selectData('kerja_sama');
			$this->load->view('master/kerja_sama/export-kerja_sama', $data, FALSE);
		}

		public function updatestatus($id)
		{
			$param = $this->input->post();
			if ($param['persentase']==100) {
				$this->db->where('ks_id', $id);
				$this->db->update('kerja_sama', ['ks_progress'=>'Selesai']);
			}
		}

		public function addsubbidangdata()
		{
        	$param = $this->input->post();
        	$dt = $this->input->post('dt');
        	$cekdata = $this->mymodel->selectWhere('kerja_sama_sub_bidang',['kssb_id_ks'=>$dt['kssb_id_ks']]);
        	$kerjasama = $this->mymodel->selectDataone('kerja_sama',['ks_id'=>$dt['kssb_id_ks']]);
        	if (count($cekdata)>=$kerjasama['ks_semester']) {
        		echo 'failed';
        	}else{
        		$dt['created_at'] = date('Y-m-d H:i:s');
				$str = $this->mymodel->insertData('kerja_sama_sub_bidang', $dt);
				$last_id = $this->db->insert_id();
				if (!empty($_FILES['file']['name'])){
					$directory = 'webfile/'.$param['no_moa'].'/'.$dt['kssb_sub_name'].'/';
					mkdir('./'.$directory, 0777, TRUE);
					$filename = $_FILES['file']['name'];
					$allowed_types = '*';
					$max_size = '2000';
					$result = $this->uploadfile->upload('file',$filename,$directory,$allowed_types, $max_size);
					if($result['alert'] == 'success'){
						$data = array(
							'id' => '',
							'name'=> $result['message']['name'],
							'mime'=> $result['message']['mime'],
							'dir'=> $result['message']['dir'],
							'table'=> 'kerja_sama_sub_bidang',
							'table_id'=> $last_id,
							'status'=>'ENABLE',
							'created_at'=>date('Y-m-d H:i:s')
						);
						if ($param['id']) {
							$this->db->where('id', $dt['file_id']);
							$str = $this->mymodel->update('file', $data);
						}else{
							$str = $this->mymodel->insertData('file', $data);
						}
						echo 'success';
					}else{
						echo $result['message'];
					}
				}else{
					$data = array(
						'name'=> '',
						'mime'=> '',
						'dir'=> '',
						'table'=> 'kerja_sama_sub_bidang',
						'table_id'=> $last_id,
						'status'=>'ENABLE',
						'created_at'=>date('Y-m-d H:i:s')
					);
					if ($param['file_id']) {
						echo 'success';	
					}else{
						$str = $this->mymodel->insertData('file', $data);
						echo 'success';
					}
				}
        	}
		}

		public function getdatastatus($id)
		{
			$kerja_sama_sub_bidang = $this->mymodel->selectWhere('kerja_sama_sub_bidang',['kssb_id_ks'=>$id]);
			?>
				<table class="table table-condensed table-striped table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Tanggal</th>
							<th>File</th>
							<th>#</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$no=1; 
							foreach ($kerja_sama_sub_bidang as $valsubbidang) {
								$file = $this->mymodel->selectDataone('file',['table'=>'kerja_sama_sub_bidang','table_id'=>$valsubbidang['kssb_id']]);
						?>
							<tr>
								<td><?= $no;?></td>
								<td><?= $valsubbidang['kssb_sub_name']?></td>
								<td><?= $valsubbidang['kssb_tgl']?></td>
								<td>
									<?php if ($file['dir']) {?>
										<a href="<?= base_url().$file['dir']?>" target="_blank"><i class="fa fa-download"></i> Download</a>
									<?php }else{?>
										File tidak ada
									<?php }?>
								</td>
								<td>
									<button class="btn btn-xs btn-danger" onclick="deletedata(<?= $valsubbidang['kssb_id']?>)"><i class="fa fa-trash"></i> Delete</button>
								</td>
							</tr>
						<?php $no++; } ?>
					</tbody>
				</table>
			<?php
		}

		public function deletesubkejasama()
		{
			$id = $this->input->post('id');
			$this->db->where('kssb_id', $id);
			$this->db->delete('kerja_sama_sub_bidang');
			echo "success";
		}

		public function getdatamoamitra($mitra_id)
		{
			$moa = $this->mymodel->selectWhere('kerja_sama',['ks_mitra_id'=>$mitra_id,'ks_tipe'=>'moa']);
			if ($moa) {
				echo '<a href="javascript:void(0);" onclick="getlistmoa('.$mitra_id.')">List moa</a>';
			}else{
				echo '<a href="'.base_url('master/kerja_sama/create').'?tipe=moa&mitra_id='.$mitra_id.'" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></a>';
			}
		}

		public function loadlistmoa($mitra_id)
		{
			$data['mitra_id'] = $mitra_id;
			$this->load->view('master/kerja_sama/modal-moa-kerja_sama', $data, FALSE);
		}

		public function jsonmoa()
		{
			$searchdata = $this->input->post('searchdata');
			$mitra_id = $this->input->post('mitra_id');
			header('Content-Type: application/json');
	        $this->datatables->select('kerja_sama.ks_id,kerja_sama.ks_tipe,kerja_sama.ks_mitra_name,kerja_sama.ks_no_mou_filkom,kerja_sama.ks_no_mou_mitra,kerja_sama.ks_tgl_mulai,kerja_sama.ks_tgl_selesai,kerja_sama.ks_bidang,kerja_sama.ks_biaya,kerja_sama.ks_mitra_id,kerja_sama.ks_subidang,kerja_sama.ks_alamat_mitra,kerja_sama.ks_tindak_lanjut,kerja_sama.ks_progress,kerja_sama.ks_jangka_waktu,kerja_sama.status,file.dir,kerja_sama.ks_no_moa_filkom,kerja_sama.ks_no_moa_mitra');
			if ($searchdata) {
				$this->db->group_start();
					$this->datatables->like('kerja_sama.ks_mitra_name', $searchdata);
					$this->datatables->or_like('kerja_sama.ks_no_moa_filkom', $searchdata);
					$this->datatables->or_like('kerja_sama.ks_jangka_waktu', $searchdata);
					$this->datatables->or_like('kerja_sama.ks_bidang', $searchdata);
					$this->datatables->or_like('kerja_sama.ks_progress', $searchdata);
				$this->db->group_end();
				$this->datatables->where('kerja_sama.ks_tipe', 'moa');
			}
			$this->datatables->join('file', 'file.table_id = kerja_sama.ks_id AND table = "kerja_sama"', 'left');
			$this->datatables->where('ks_mitra_id', $mitra_id);
			$this->datatables->where('ks_tipe', 'moa');
	        $this->datatables->from('kerja_sama');
			$this->datatables->add_column('view', '<button type="button" class="btn btn-sm btn-primary btn-block" onclick="getstatusmoa(\'$1\',$(this))"><i class="fa fa-pie-chart"></i> Status</button><button type="button" class="btn btn-sm btn-primary btn-block" onclick="previewmoa(\'$2\',$(this))"><i class="fa fa-eye"></i> Preview</button><button type="button" class="btn btn-sm btn-primary btn-block" onclick="editmoa($1,$(this))"><i class="fa fa-pencil"></i> Edit</button>', 'ks_id,dir');
	        echo $this->datatables->generate();
		}
	}
?>