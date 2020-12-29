
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Menu_master extends MY_Controller {

		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$data['page_name'] = "menu_master";
			$this->template->load('template/template','master/menu_master/all-menu_master',$data);
		}

		public function create()
		{
			$data['page_name'] = "menu_master";

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
		    			$data['data_url'][] = array(
    						'folder'=>str_replace("/","",$fol[$i]),
    						'class'=>str_replace( '.php', '', $ctrl ),
    						'method'=>$mt,
    						'val'=>strtolower($fol[$i].str_replace( '.php', '', $ctrl )."/".$mt),
    					);
		    		}
		    	}
				$i++;
			}

			$this->template->load('template/template','master/menu_master/add-menu_master',$data);
		}


		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->form_validation->set_rules('dt[name]', '<strong>Name</strong>', 'required');
			// $this->form_validation->set_rules('dt[icon]', '<strong>Icon</strong>', 'required');
			// $this->form_validation->set_rules('dt[link]', '<strong>Link</strong>', 'required');
			// $this->form_validation->set_rules('dt[urutan]', '<strong>Urutan</strong>', 'required');
			// $this->form_validation->set_rules('dt[parent]', '<strong>Parent</strong>', 'required');
			// $this->form_validation->set_rules('dt[notif]', '<strong>Notif</strong>', 'required');
	}

		public function store()
		{
			$this->validate();
	    	if ($this->form_validation->run() == FALSE){
				$this->alert->alertdanger(validation_errors());     
	        }else{
	        	$dt = $_POST['dt'];
				$dt['created_at'] = date('Y-m-d H:i:s');
				$dt['status'] = "ENABLE";
				$str = $this->db->insert('menu_master', $dt);
				$last_id = $this->db->insert_id();$this->alert->alertsuccess('Success Send Data');   
					
			}
		}

		public function json()
		{
			$status = $_GET['status'];
			if($status==''){
				$status = 'ENABLE';
			}
			header('Content-Type: application/json');
	        $this->datatables->select('id,name,icon,link,urutan,parent,notif,status');
	        $this->datatables->where('status',$status);
	        $this->datatables->from('menu_master');
	        if($status=="ENABLE"){
	        $this->datatables->add_column('view', '<div class="btn-group"><button type="button" class="btn btn-sm btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button><button type="button" class="btn btn-sm btn-warning" onclick="set_role($1)"><i class="fa fa-users"></i> Set Role</button></div>', 'id');

	    	}else{
	        $this->datatables->add_column('view', '<div class="btn-group"><button type="button" class="btn btn-sm btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button><button type="button" onclick="hapus($1)" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Hapus</button></div>', 'id');

	    	}
	        echo $this->datatables->generate();
		}
		public function edit($id)
		{
			$data['menu_master'] = $this->mymodel->selectDataone('menu_master',array('id'=>$id));$data['page_name'] = "menu_master";

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
		    			$data['data_url'][] = array(
		    						'folder'=>str_replace("/","",$fol[$i]),
		    						'class'=>str_replace( '.php', '', $ctrl ),
		    						'method'=>$mt,
		    						'val'=>strtolower($fol[$i].str_replace( '.php', '', $ctrl )."/".$mt),
		    					);
		    		}
		    	}
				$i++;
			}
			
			$this->template->load('template/template','master/menu_master/edit-menu_master',$data);
		}

		public function update()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			
			$this->validate();
			

	    	if ($this->form_validation->run() == FALSE){
				$this->alert->alertdanger(validation_errors());     
	        }else{
				$id = $this->input->post('id', TRUE);		
				$old_menu = $this->mmodel->selectWhere('menu_master',['id'=>$id])->row();
				$dt = $_POST['dt'];
				$dt['updated_at'] = date("Y-m-d H:i:s");
				$this->mymodel->updateData('menu_master', $dt , array('id'=>$id));

				$this->db->update('access_block', ['ab_link'=>$dt['function']], ['ab_link'=>$old_menu->function]);

				$this->alert->alertsuccess('Success Update Data');  }
		}

		public function delete()
		{
				$id = $this->input->post('id', TRUE);
				$this->mymodel->deleteData('menu_master',['id'=>$id]);
				$this->alert->alertdanger('Success Delete Data');     
		}

		public function status($id,$status)
		{
			$this->mymodel->updateData('menu_master',array('status'=>$status),array('id'=>$id));
			redirect('master/Menu_master');
		}

		public function ordering()
		{
			$data['page_name'] = "menu_master";
			$this->template->load('template/template','master/menu_master/ordering-menu_master',$data);
		}

		public function update_ordering()
		{
			$menu = json_decode($this->input->post('menu'));

			foreach ($menu as $kmenu => $vmenu) {
				$this->db->update('menu_master', ['urutan'=>($kmenu+1),'parent'=>0], ['id'=>$vmenu->id]);
				if (count(@$vmenu->children)) {
					foreach ($vmenu->children as $kchild => $vchild) {
						$this->db->update('menu_master', ['urutan'=>($kchild+1),'parent'=>$vmenu->id], ['id'=>$vchild->id]);
					}
				}
			}

			redirect('master/menu_master','refresh');
		}

		public function getRoleByMenu($id)
		{
			$role = $this->mmodel->selectWhere('role',['status'=>'ENABLE'])->result();
			$role_assigned = [];
			foreach ($role as $vrole) {
				if (in_array($id, json_decode($vrole->menu, true))) {
					$role_assigned[] = $vrole->id;
				}
			}
			// echo json_encode($role_assigned);
			?>
			<input type="hidden" name="menu" value="<?= $id ?>">
			<select name="role[]" class="form-control" id="sel-role" multiple="multiple">
				<?php foreach ($role as $v): ?>
				<option value="<?= $v->id ?>" <?= (in_array($v->id, $role_assigned))?"selected":"" ?>><?= $v->role ?></option>
				<?php endforeach ?>
			</select>	

			<script type="text/javascript">
				$('#sel-role').select2();
			</script>

			<?php
		}

		public function updateRoleMenu()
		{
			$role = $this->mmodel->selectWhere('role',['status'=>'ENABLE'])->result();
			$role_tba = $this->input->post('role');
			$menu = $this->input->post('menu');
			$get_menu = $this->mmodel->selectWhere('menu_master',['id'=>$menu])->row();

			foreach ($role as $vrole) {
				$menu_assigned = json_decode($vrole->menu,true); //set akses menu lama
				if (($key = array_search($menu, $menu_assigned)) !== false) { //hapus akses menu
				    unset($menu_assigned[$key]);
				}
				if (in_array($vrole->id, $role_tba)) { //reassign akses menu
					$menu_assigned[] = $menu;
					$this->db->delete('access_block', ['ab_role_id'=>$vrole->id,'ab_link'=>$get_menu->function]);
				} else {
					if ($get_menu->function) { //check if function is set
						$check_available = $this->mmodel->selectWhere('access_block',['ab_role_id'=>$vrole->id,'ab_link'=>$get_menu->function])->num_rows();
						if ($check_available==0) { // check if the link not blocked yet
							$this->db->insert('access_block', ['ab_role_id'=>$vrole->id,'ab_link'=>$get_menu->function]);
						}
					}
				}
				$this->db->update('role', ['menu'=>json_encode(array_values($menu_assigned))], ['id'=>$vrole->id]);
			}

			redirect('master/menu_master','refresh');
		}

		public function getParent($parent)
		{
			$this->db->order_by('urutan', 'desc');
			$urutan = $this->mmodel->selectWhere('menu_master',['Parent'=>$parent])->row();

			$urutan_available = ((@$urutan->urutan)?$urutan->urutan:0)+1;
			echo json_encode(['result'=>$urutan_available]);
		}

	}
?>