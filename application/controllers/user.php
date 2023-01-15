<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {
	var $content = '';
	
	public function User()	{
		parent::__construct();	

	}	

	/* signup / register */
	function signup(){
		die(''); //Menonaktifkan register karena disalahgunakan oleh hacker
		$this->Webpage->set_title('Registrasi');	
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="help-inline red"><em class="icon icon-color icon-cross"></em> ', '</span>');
		
		$this->form_validation->set_rules('nra', 'Nomor Register Anggota (NRA)', 'trim|required|xss_clean|callback_checkduplicate_nra');
		$this->form_validation->set_rules('nrapass', 'Password', 'trim|required|matches[nrapass2]|md5|xss_clean');
		$this->form_validation->set_rules('nrapass2', 'Password Confirmation', 'trim|required|xss_clean');
		$this->form_validation->set_rules('tahun', 'Tahun', 'trim|required|numeric|length[4]|xss_clean');
		$this->form_validation->set_rules('nama', 'Nama lengkap', 'trim|required|min_length[5]|xss_clean');
		$this->form_validation->set_rules('gelar[]', 'Gelar', 'required|xss_clean');
		
		$this->form_validation->set_rules('idi', 'Nomor Anggota IDI', 'trim|xss_clean');
		$this->form_validation->set_rules('lhr', 'Tempat lahir', 'trim|required|min_length[2]|xss_clean');
		$this->form_validation->set_rules('lhrtgl', 'Tanggal lahir', 'trim|required|length[10]|xss_clean|callback_checkvalid_date');
		$this->form_validation->set_rules('ktp', 'Nomor Identitas', 'trim|required|min_length[5]|xss_clean');
		$this->form_validation->set_rules('sex', 'Jenis Kelamin', 'trim|required|length[1]|xss_clean');
		
		$this->form_validation->set_rules('rumah', 'Alamat Rumah', 'trim|required|min_length[5]|xss_clean');
		$this->form_validation->set_rules('rumahpos', 'Kode POS', 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('rumahtelp', 'Nomor Telepon', 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('rumahfax', 'Nomor Fax', 'trim|min_length[4]|xss_clean');
		$this->form_validation->set_rules('rumahhp', 'Nomor Handphone', 'trim|min_length[4]|xss_clean');

		$this->form_validation->set_rules('praktek1', 'Nama dan Alamat', 'trim|required|min_length[5]|xss_clean');
		$this->form_validation->set_rules('praktek1pos', 'Kode POS', 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('praktek1telp', 'Nomor Telepon', 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('praktek1fax', 'Nomor Fax', 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('sip1', 'Nomor SIP', 'trim|required|xss_clean');
		$this->form_validation->set_rules('sip1start', 'Tanggal Mulai', 'trim|required|length[10]|xss_clean|callback_checkvalid_date');
		$this->form_validation->set_rules('sip1end', 'Tanggal Akhir', 'trim|required|length[10]|xss_clean|callback_checkvalid_date');

		$this->form_validation->set_rules('praktek2', 'Nama dan Alamat', 'trim|min_length[5]|xss_clean');
		$this->form_validation->set_rules('praktek2pos', 'Kode POS', 'trim|min_length[4]|xss_clean');
		$this->form_validation->set_rules('praktek2telp', 'Nomor Telepon', 'trim|min_length[4]|xss_clean');
		$this->form_validation->set_rules('praktek2fax', 'Nomor Fax', 'trim|min_length[4]|xss_clean');
		$this->form_validation->set_rules('sip2', 'Nomor SIP', 'trim|xss_clean');
		$this->form_validation->set_rules('sip2start', 'Tanggal Mulai', 'trim|length[10]|xss_clean|callback_checkvalid_date');
		$this->form_validation->set_rules('sip2end', 'Tanggal Akhir', 'trim|length[10]|xss_clean|callback_checkvalid_date');

		$this->form_validation->set_rules('praktek3', 'Nama dan Alamat', 'trim|min_length[5]|xss_clean');
		$this->form_validation->set_rules('praktek3pos', 'Kode POS', 'trim|min_length[4]|xss_clean');
		$this->form_validation->set_rules('praktek3telp', 'Nomor Telepon', 'trim|min_length[4]|xss_clean');
		$this->form_validation->set_rules('praktek3fax', 'Nomor Fax', 'trim|min_length[4]|xss_clean');
		$this->form_validation->set_rules('sip3', 'Nomor SIP', 'trim|xss_clean');
		$this->form_validation->set_rules('sip3start', 'Tanggal Mulai', 'trim|length[10]|xss_clean|callback_checkvalid_date');
		$this->form_validation->set_rules('sip3end', 'Tanggal Akhir', 'trim|length[10]|xss_clean|callback_checkvalid_date');


		$this->form_validation->set_rules('sekolah', 'Asal Sekolah', 'trim|required|min_length[5]|xss_clean');
		$this->form_validation->set_rules('sekolahlulus', 'Tahun Lulus', 'trim|required|numeric|length[4]|xss_clean');
		$this->form_validation->set_rules('regstart', 'Tanggal Mulai', 'trim|required|length[10]|xss_clean|callback_checkvalid_date');
		$this->form_validation->set_rules('regend', 'Tanggal Selesai', 'trim|required|length[10]|xss_clean|callback_checkvalid_date');

		//$this->form_validation->set_rules('regscan', 'Bukti Scan Surat Registrasi', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('foto', 'Foto diri', 'trim|required|xss_clean');
		$this->form_validation->set_rules('surat', 'Alamat Surat Menyurat', 'trim|required|xss_clean');

		if ($this->session->flashdata('regstatus') == 'OK' ){
			redirect('user/signup'); die();
		}

		if (isset($_POST) && !empty($_POST)) {
		
			// upload foto/scanreg
			$config['upload_path'] = './media/';	
			
			// save dokumen attachments
			$this->load->library('upload');
			if(isset($_FILES['regscan']) && $_FILES['regscan']['error'] != 4){ // if upload file
	
				$config['allowed_types'] = 'gif|jpg|png|doc|docx|pdf';
				$this->upload->initialize($config);
	
				if ( ! $this->upload->do_upload('regscan')) {
					$upload_regscan_error = $this->upload->display_errors('','');				
				}else{
					$upload_regscan_data = $this->upload->data();
				}
			}else{
				$upload_regscan_error = 'Please select a file to upload.';
			}
			if(isset($_FILES['foto']) && $_FILES['foto']['error'] != 4){ // if upload file
	
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_width']  	= '500'; 
				$config['max_height']  	= '500';
				$this->upload->initialize($config);
	
				if ( ! $this->upload->do_upload('foto')) {
					$upload_foto_error = $this->upload->display_errors('','');				
				}else{
					$upload_foto_data = $this->upload->data();
				}
			}else{
				$upload_foto_error = 'Please select a file to upload.';
			}
		
		}
		
		// got file error ?
		if (isset($upload_foto_error) && isset($upload_regscan_data['file_name'])) {
			@unlink ( './media/'.$upload_regscan_data['file_name'] ); // delete prev. sucess upload
		}

		if (($this->form_validation->run() == FALSE) || isset($upload_regscan_error) || isset($upload_foto_error) || ($this->session->flashdata('regstatus') == 'OK' ) )	{	
		
			$view_data = array(			
			);
			if (!empty($_POST)) {
				$view_data['formfield_error'] = 'Form belum diisi dengan benar, silakan periksa!';	
			}
			if (isset($upload_regscan_error)) { $view_data['upload_regscan_error'] = $upload_regscan_error; }
			if (isset($upload_foto_error)) { $view_data['upload_foto_error'] = $upload_foto_error; }
			
			$this->Webpage->content = $this->load->view('c/register',$view_data,true);

		} else {
		
			$uid = uniqid();
			
			$arr_gelar = array();
			$gelars = '';
			$p_gelar = $this->input->post('gelar');
			if (is_array($p_gelar) && !empty($p_gelar) ){ 
				foreach ($p_gelar as $_k => $_v) {
					if ($_v != 'lainnya') {
						//if (($_k == 'lain') && in_array('lainnya',$p_gelar) )
						$arr_gelar[] = $_v;
					}
				}
				$gelars = join('|',array_values($arr_gelar));
			}
				
			// insert data 
			$docdata = array (
				'id' 			=> '', 
				'tipe' 			=> 'doc', 
				'nra' 			=> $this->input->post('nra'), 
				'nrapass' 		=> $this->input->post('nrapass'), 
				'tahun' 		=> $this->input->post('tahun'), 
				'nama' 			=> $this->input->post('nama'), 
				'gelar' 		=> $gelars, 
				'idi' 			=> $this->input->post('idi'), 
				'lhr' 			=> $this->input->post('lhr'), 
				'lhrtgl' 		=> $this->input->post('lhrtgl'), 
				'ktp' 			=> $this->input->post('ktp'), 
				'sex' 			=> $this->input->post('sex'), 
				'email'			=> $this->input->post('email'),
				'rumah' 		=> $this->input->post('rumah'), 
				'rumahpos' 		=> $this->input->post('rumahpos'), 
				'rumahtelp' 	=> $this->input->post('rumahtelp'), 
				'rumahfax' 		=> $this->input->post('rumahfax'), 
				'rumahhp' 		=> $this->input->post('rumahhp'), 
				'praktek1' 		=> $this->input->post('praktek1'), 
				'praktek1pos' 	=> $this->input->post('praktek1pos'), 
				'praktek1telp' 	=> $this->input->post('praktek1telp'), 
				'praktek1fax' 	=> $this->input->post('praktek1fax'),
				'sip1' 			=> $this->input->post('sip1'),
				'sip1start' 	=> $this->input->post('sip1start'),
				'sip1end' 		=> $this->input->post('sip1end'),
				'praktek2' 		=> $this->input->post('praktek2'), 
				'praktek2pos' 	=> $this->input->post('praktek2pos'), 
				'praktek2telp' 	=> $this->input->post('praktek2telp'), 
				'praktek2fax' 	=> $this->input->post('praktek2fax'), 
				'sip2' 			=> $this->input->post('sip2'),
				'sip2start' 	=> $this->input->post('sip2start'),
				'sip2end' 		=> $this->input->post('sip2end'),
				'praktek3' 		=> $this->input->post('praktek3'), 
				'praktek3pos' 	=> $this->input->post('praktek3pos'), 
				'praktek3telp' 	=> $this->input->post('praktek3telp'), 
				'praktek3fax' 	=> $this->input->post('praktek3fax'), 
				'sip3' 			=> $this->input->post('sip3'),
				'sip3start' 	=> $this->input->post('sip3start'),
				'sip3end' 		=> $this->input->post('sip3end'),
				'sekolah' 		=> $this->input->post('sekolah'), 
				'sekolahlulus' 	=> $this->input->post('sekolahlulus'), 
				'regstart' 		=> $this->input->post('regstart'),
				'regend' 		=> $this->input->post('regend'),
				//'regscan' 		=> $this->input->post('regscan'), 
				//'foto' 			=> $this->input->post('foto'), 
				'surat' 		=> $this->input->post('surat'),
				'acv' 			=> '0',
			);
			
			if ( isset($upload_regscan_data) && isset($upload_regscan_data['file_name']) ) {
				$regscan = $upload_regscan_data['file_name'];
				$docdata['regscan'] = $regscan;
			}
			if ( isset($upload_foto_data) && isset($upload_foto_data['file_name']) ) {
				$foto = $upload_foto_data['file_name'];
				$docdata['foto'] = $foto;
			}
	
			$this->db->insert('userdoc', $docdata); 			
			$this->session->set_flashdata('regstatus', 'OK');
			
			$this->Webpage->content = $this->load->view('c/register-ok','',true);
			//redirect('user/signup', 'refresh');

		}
		
		$this->signView();
		
	
	}
	
	/* profile / edit */
	function profile(){

		if ($this->session->userdata('logged_in')) {

		}else {
			redirect('user/login'); die();
				
		}

		$this->Webpage->set_title('Profile');	
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="help-inline red"><em class="icon icon-color icon-cross"></em> ', '</span>');
		
		//$this->form_validation->set_rules('nra', 'Nomor Register Anggota (NRA)', 'trim|required|xss_clean|callback_checkduplicate_nra');
		//$this->form_validation->set_rules('nrapass', 'Password', 'trim|required|matches[nrapass2]|md5|xss_clean');
		//$this->form_validation->set_rules('nrapass2', 'Password Confirmation', 'trim|required|xss_clean');
		$this->form_validation->set_rules('tahun', 'Tahun', 'trim|required|numeric|length[4]|xss_clean');
		$this->form_validation->set_rules('nama', 'Nama lengkap', 'trim|required|min_length[5]|xss_clean');
		$this->form_validation->set_rules('gelar[]', 'Gelar', 'required|xss_clean');
				
		$this->form_validation->set_rules('idi', 'Nomor Anggota IDI', 'trim|xss_clean');
		$this->form_validation->set_rules('lhr', 'Tempat lahir', 'trim|required|min_length[2]|xss_clean');
		$this->form_validation->set_rules('lhrtgl', 'Tanggal lahir', 'trim|required|length[10]|xss_clean|callback_checkvalid_date');
		$this->form_validation->set_rules('ktp', 'Nomor Identitas', 'trim|required|min_length[5]|xss_clean');
		$this->form_validation->set_rules('sex', 'Jenis Kelamin', 'trim|required|length[1]|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|length[255]|xss_clean');
		
		$this->form_validation->set_rules('rumah', 'Alamat Rumah', 'trim|required|min_length[5]|xss_clean');
		$this->form_validation->set_rules('rumahpos', 'Kode POS', 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('rumahtelp', 'Nomor Telepon', 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('rumahfax', 'Nomor Fax', 'trim|min_length[4]|xss_clean');
		$this->form_validation->set_rules('rumahhp', 'Nomor Handphone', 'trim|min_length[4]|xss_clean');

		$this->form_validation->set_rules('praktek1', 'Nama dan Alamat', 'trim|required|min_length[5]|xss_clean');
		$this->form_validation->set_rules('praktek1pos', 'Kode POS', 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('praktek1telp', 'Nomor Telepon', 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('praktek1fax', 'Nomor Fax', 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('sip1', 'Nomor SIP', 'trim|required|xss_clean');
		$this->form_validation->set_rules('sip1start', 'Tanggal Mulai', 'trim|required|length[10]|xss_clean|callback_checkvalid_date');
		$this->form_validation->set_rules('sip1end', 'Tanggal Akhir', 'trim|required|length[10]|xss_clean|callback_checkvalid_date');

		$this->form_validation->set_rules('praktek2', 'Nama dan Alamat', 'trim|min_length[5]|xss_clean');
		$this->form_validation->set_rules('praktek2pos', 'Kode POS', 'trim|min_length[4]|xss_clean');
		$this->form_validation->set_rules('praktek2telp', 'Nomor Telepon', 'trim|min_length[4]|xss_clean');
		$this->form_validation->set_rules('praktek2fax', 'Nomor Fax', 'trim|min_length[4]|xss_clean');
		$this->form_validation->set_rules('sip2', 'Nomor SIP', 'trim|xss_clean');
		$this->form_validation->set_rules('sip2start', 'Tanggal Mulai', 'trim|length[10]|xss_clean|callback_checkvalid_date');
		$this->form_validation->set_rules('sip2end', 'Tanggal Akhir', 'trim|length[10]|xss_clean|callback_checkvalid_date');

		$this->form_validation->set_rules('praktek3', 'Nama dan Alamat', 'trim|min_length[5]|xss_clean');
		$this->form_validation->set_rules('praktek3pos', 'Kode POS', 'trim|min_length[4]|xss_clean');
		$this->form_validation->set_rules('praktek3telp', 'Nomor Telepon', 'trim|min_length[4]|xss_clean');
		$this->form_validation->set_rules('praktek3fax', 'Nomor Fax', 'trim|min_length[4]|xss_clean');
		$this->form_validation->set_rules('sip3', 'Nomor SIP', 'trim|xss_clean');
		$this->form_validation->set_rules('sip3start', 'Tanggal Mulai', 'trim|length[10]|xss_clean|callback_checkvalid_date');
		$this->form_validation->set_rules('sip3end', 'Tanggal Akhir', 'trim|length[10]|xss_clean|callback_checkvalid_date');


		$this->form_validation->set_rules('sekolah', 'Asal Sekolah', 'trim|required|min_length[5]|xss_clean');
		$this->form_validation->set_rules('sekolahlulus', 'Tahun Lulus', 'trim|required|numeric|length[4]|xss_clean');
		$this->form_validation->set_rules('regstart', 'Tanggal Mulai', 'trim|required|length[10]|xss_clean|callback_checkvalid_date');
		$this->form_validation->set_rules('regend', 'Tanggal Selesai', 'trim|required|length[10]|xss_clean|callback_checkvalid_date');

		//$this->form_validation->set_rules('regscan', 'Bukti Scan Surat Registrasi', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('foto', 'Foto diri', 'trim|required|xss_clean');
		
		$this->form_validation->set_rules('surat', 'Alamat Surat Menyurat', 'trim|required|xss_clean');

		if ( ($this->form_validation->run() == FALSE) )	{	
		
			$r_doc = $this->P2kb->get_userdoc($this->P2kb->udata['id']);
			$view_data = array(
				'row'	=> $r_doc,
			);
			
			$this->Webpage->content = $this->load->view('c/profile',$view_data,true);

		} else {
		
			$uid = uniqid();
			
			$arr_gelar = array();
			$gelars = '';
			$p_gelar = $this->input->post('gelar');
			if (is_array($p_gelar) && !empty($p_gelar) ){ 
				foreach ($p_gelar as $_k => $_v) {
					if ($_v != 'lainnya') {
						//if (($_k == 'lain') && in_array('lainnya',$p_gelar) )
						$arr_gelar[] = $_v;
					}
				}
				$gelars = join('|',array_values($arr_gelar));
			}
			
			$delete_regscan = $this->input->post('delete_regscan', true);
			$delete_foto 	= $this->input->post('delete_foto', true);

			//delete attachement
			if ($delete_regscan == 1) {
				$is_deleted = $this->P2kb->delete_userdoc_att('regscan',$this->P2kb->udata['id']);
				$regscan	= '';			
			}
			if ($delete_foto == 1) {
				$is_deleted = $this->P2kb->delete_userdoc_att('foto',$this->P2kb->udata['id']);
				$foto	= '';			
			}
			
			//
	
			$config['upload_path'] = './media/';
			//$config['max_size']	= '100';// KB
			//$config['max_width']  = '1024'; 
			//$config['max_height']  = '768';
	
			
			// save dokumen attachments
			$this->load->library('upload');
			if($_FILES['regscan']['error'] != 4){ // if upload file

				$config['allowed_types'] = 'gif|jpg|png|doc|docx|pdf';
				//$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if ( ! $this->upload->do_upload('regscan')) {
					$upload_regscan_error = $this->upload->display_errors('','');				
				}else{
					$upload_regscan_data = $this->upload->data();
				}
			}
			if($_FILES['foto']['error'] != 4){ // if upload file

				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_width']  	= '500'; 
				$config['max_height']  	= '500';
				$this->upload->initialize($config);

				if ( ! $this->upload->do_upload('foto')) {
					$upload_foto_error = $this->upload->display_errors('','');				
				}else{
					$upload_foto_data = $this->upload->data();
				}
			}
			
			// got file error ?
			if (isset($upload_regscan_error)) {
				$this->session->set_flashdata('regscan_error',$upload_regscan_error);
			}
			if (isset($upload_foto_error)) {
				@unlink ( './media/'.$upload_regscan_data['file_name'] ); // delete prev. sucess upload
				$this->session->set_flashdata('foto_error',$upload_foto_error);
			}
			if (isset($upload_regscan_error) || isset($upload_foto_error)) {
				redirect('user/profile');
				die();
			}
			
			if ( isset($upload_regscan_data) && isset($upload_regscan_data['file_name']) ) {
				$regscan = $upload_regscan_data['file_name'];
			}
			if ( isset($upload_foto_data) && isset($upload_foto_data['file_name']) ) {
				$foto = $upload_foto_data['file_name'];
			}
	
			// data 
			$docdata = array (
			
				//'id' 			=> '', 
				//'tipe' 			=> 'doc', 
				//'nra' 			=> $this->input->post('nra'), 
				//'nrapass' 		=> $this->input->post('nrapass'), 
				'tahun' 		=> $this->input->post('tahun'), 
				'nama' 			=> $this->input->post('nama'), 
				'gelar' 		=> $gelars, 
				'idi' 			=> $this->input->post('idi'), 
				'lhr' 			=> $this->input->post('lhr'), 
				'lhrtgl' 		=> $this->input->post('lhrtgl'), 
				'ktp' 			=> $this->input->post('ktp'), 
				'sex' 			=> $this->input->post('sex'), 
				'email' 		=> $this->input->post('email'), 
				'rumah' 		=> $this->input->post('rumah'), 
				'rumahpos' 		=> $this->input->post('rumahpos'), 
				'rumahtelp' 	=> $this->input->post('rumahtelp'), 
				'rumahfax' 		=> $this->input->post('rumahfax'), 
				'rumahhp' 		=> $this->input->post('rumahhp'), 
				'praktek1' 		=> $this->input->post('praktek1'), 
				'praktek1pos' 	=> $this->input->post('praktek1pos'), 
				'praktek1telp' 	=> $this->input->post('praktek1telp'), 
				'praktek1fax' 	=> $this->input->post('praktek1fax'),
				'sip1' 			=> $this->input->post('sip1'),
				'sip1start' 	=> $this->input->post('sip1start'),
				'sip1end' 		=> $this->input->post('sip1end'),
				'praktek2' 		=> $this->input->post('praktek2'), 
				'praktek2pos' 	=> $this->input->post('praktek2pos'), 
				'praktek2telp' 	=> $this->input->post('praktek2telp'), 
				'praktek2fax' 	=> $this->input->post('praktek2fax'), 
				'sip2' 			=> $this->input->post('sip2'),
				'sip2start' 	=> $this->input->post('sip2start'),
				'sip2end' 		=> $this->input->post('sip2end'),
				'praktek3' 		=> $this->input->post('praktek3'), 
				'praktek3pos' 	=> $this->input->post('praktek3pos'), 
				'praktek3telp' 	=> $this->input->post('praktek3telp'), 
				'praktek3fax' 	=> $this->input->post('praktek3fax'), 
				'sip3' 			=> $this->input->post('sip3'),
				'sip3start' 	=> $this->input->post('sip3start'),
				'sip3end' 		=> $this->input->post('sip3end'),
				'sekolah' 		=> $this->input->post('sekolah'), 
				'sekolahlulus' 	=> $this->input->post('sekolahlulus'), 
				'regstart' 		=> $this->input->post('regstart'), 
				'regend' 		=> $this->input->post('regend'), 
				//'regscan' 		=> $this->input->post('regscan'), 
				//'foto' 			=> $this->input->post('foto'), 
				'surat' 		=> $this->input->post('surat'), 
				//'acv' 			=> '0',
				'completed'		=> 1, // Sistem akan by default set complete menjadi 1, karena kalau berhasil save, otomatis menandakan datanya semuanya sudah lengkap & benar
			);
			
			if (isset($regscan)){ 
				$docdata['regscan'] = $regscan;
				if (!empty($regscan)) {
					$is_deleted = $this->P2kb->delete_userdoc_att('regscan',$this->P2kb->udata['id']);
				} 
			}
			if (isset($foto)) 	{ 
				$docdata['foto'] = $foto;
				if (!empty($foto)) {
					$is_deleted = $this->P2kb->delete_userdoc_att('foto',$this->P2kb->udata['id']);
				} 
			}
			
			$this->db->update( 'userdoc', $docdata, array('id' => $this->P2kb->udata['id']) ); 			
			$this->session->set_flashdata('userupdate', 'OK');
			
			redirect('user/profile');
			die();

		}
		
		$this->finalView();
		//$this->signView();
		
	
	}
	
	/* change password */
	function changepass(){

		if ($this->session->userdata('logged_in')) {

		}else {
			redirect('user/login'); die();
				
		}

		$this->Webpage->set_title('Change Password');	
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="help-inline red"><em class="icon icon-color icon-cross"></em> ', '</span>');
		
		//$this->form_validation->set_rules('nra', 'Nomor Register Anggota (NRA)', 'trim|required|xss_clean|callback_checkduplicate_nra');
		$this->form_validation->set_rules('nrapass', 'Password', 'trim|required|matches[nrapass2]|md5|xss_clean');
		$this->form_validation->set_rules('nrapass2', 'Password Confirmation', 'trim|required|xss_clean');

		if ( ($this->form_validation->run() == FALSE) )	{	
		
			$r_doc = $this->P2kb->get_userdoc($this->P2kb->udata['id']);
			$view_data = array(
				'row'	=> $r_doc,
			);
			
			$this->Webpage->content = $this->load->view('c/user-password',$view_data,true);

		} else {
		
			$uid = uniqid();
			
	
			// data 
			$docdata = array (
				'nrapass' 		=> $this->input->post('nrapass'), 
			);
			
			$this->db->update( 'userdoc', $docdata, array('id' => $this->P2kb->udata['id']) ); 			
			$this->session->set_flashdata('userupdate', 'OK');
			
			redirect('user/changepass');
			die();

		}
		
		$this->finalView();
		//$this->signView();
		
	
	}
	
	function checkduplicate_nra ($nra) {
		$this -> db -> select('id, nra');
		$this -> db -> from('userdoc');
		$this -> db -> where('nra', $nra);
		$this -> db -> limit(1);
		
		$query = $this->db->get();
		
		if($query->num_rows() == 1){
			$this->form_validation->set_message('checkduplicate_nra', 'Nomor Register Anggota (NRA) ini sudah didaftakan !');
			return FALSE;
			
		}else{
			return TRUE;
		}
	
	}

	function checkvalid_date ($date) {
		if ( !empty($date) ) {
			$arr_date = explode('-',$date);
			if (count($arr_date) >= 3) {
				list($y,$m,$d) = $arr_date;
			}
			if (isset($y) && isset($m) && isset($d) && checkdate($m,$d,$y)) {
				return true;
			}else{
				$this->form_validation->set_message('checkvalid_date', '%s is invalid !');
				return false;
			}
		}
	} 
	
	/* login */
	function login(){
	
		$sdata = $this->session->userdata('logged_in');
		if (!empty($sdata)) { redirect('dashboard','refresh'); die(); }

		// redir to nexturl if login success
		$nexturl = $this->session->flashdata('nexturl');
		if ($nexturl) {
			$this->session->set_userdata('redirurl', $nexturl);
		}
		
		$this->Webpage->set_title('Login');	
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('nra', 'Nomor Register Anggota (NRA)', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nrapass', 'Password', 'trim|required|xss_clean|callback_validate_login');

		if ($this->form_validation->run() == FALSE)	{
		
		
			$view_data = array(

			);
			$this->Webpage->content = $this->load->view('c/login',$view_data,true);

		} else {
			/*
			*/
			$redir = $this->session->userdata('redirurl'); 
			if (!empty($redir)) {
				$this->session->unset_userdata('redirurl');
				redirect($redir,'refresh');
			}else
				redirect('dashboard', 'refresh');
		}

		$this->signView();
		
	
	}
    
	function validate_login($passwd) {

		$eml = $this->input->post('nra');
		$tipe = $this->input->post('utype');
		
		$this -> db -> select('id, tipe, nra, nama, acv');
		$this -> db -> from('userdoc');
		$this -> db -> where('tipe', $tipe);
		$this -> db -> where('nra', $eml);
		//$this -> db -> where('acv', '1');
		$this -> db -> where('nrapass', md5($passwd));
		$this -> db -> limit(1);
		
		$query = $this->db->get();
		//echo $this -> db -> last_query();
		
		if($query->num_rows() == 1){
			$result = $query->result();
			$sess_array = array();
			$row = $query->row();

			if ($row->acv != '1') {
				$this->form_validation->set_message('validate_login', 'Inactive NRA !');
				return FALSE;
			
			}else{
				$sess_array = array(
					'id' 	=> $row->id,
					'nra' 	=> $row->nra,
					'nama'	=> $row->nama,
					'tipe'	=> $tipe,
					'app'	=> 'P2KBPORI'
				);
				
				$this->session->set_userdata('logged_in', $sess_array);
				return TRUE;
			}
			
		}else{
			$this->form_validation->set_message('validate_login', 'Invalid Login');
			return false;
		}
			
	}
	
	function logout() {
		$this->session->unset_userdata('logged_in');
		session_destroy();

		redirect('dashboard', 'refresh');
	
	}
	
}

