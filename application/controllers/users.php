<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

	public function Users()	{
		parent::__construct();	

		if ($this->session->userdata('logged_in')) {
			if ($this->P2kb->udata['tipe'] != 'adm') {
				redirect('dashboard'); die();				
			}

		}else {
			redirect('user/login'); die();				
		}
	}

	function index(){
	
		$this->Webpage->set_title('Users');

		if (!empty ($_POST) ) {
			
			$row_edit = $this->P2kb->get_kegiatandoc($edit_ID);

			// save
			//id, id_doc, tgl, id_keg, skp, ket, dokumen
			$kdate		= $this->input->post('kdate', true);
			$idKegiatan	= $this->input->post('idkegiatan', true);
			$keterangan = $this->input->post('keterangan', true);
			$delete_att = $this->input->post('delete_att', true);
			$acv 		= $this->input->post('acv', true);
			$skp 		= $this->P2kb->get_kegiatan_skp($idKegiatan);
			
			if ($this->P2kb->is_kegiatan_customskp($idKegiatan)) {
				$skp = $this->input->post('skp', true);					
			}
			
			//delete attachement
			if ($delete_att == 1) {
				$is_deleted = $this->P2kb->delete_kegiatandoc_att($edit_ID);
				$dokumen	= '';
			
			}
	

			
			if ($idCat == 2) {
				$kegiatanOptions = $this->P2kb->get_kegiatan_options($idCat,'kegiatan desc', set_value('idkegiatan'));
			}else{
				$kegiatanOptions = $this->P2kb->get_kegiatan_options($idCat,'', set_value('idkegiatan'));
			}
			
			if ($data_edit == true) {
				
			}else{
			
			}
	
		} // end if specific category
		
		$this->data = array(
			'q'	=> $this->P2kb->get_users(),
		);
		
		$this->Webpage->content = $this->load->view('c/users',$this->data,TRUE);
		

		$this->Webpage->add_js(base_url().'js/jquery.validationEngine.js');
		$this->Webpage->add_js(base_url().'js/jquery.validationEngine-en.js');
		$this->Webpage->add_css(base_url().'css/validationEngine.jquery.css');

		$this->finalView();	
	
	}
	
	/* new user */
	function add(){

		$this->Webpage->set_title('Add New User');	
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="help-inline red"><em class="icon icon-color icon-cross"></em> ', '</span>');
		
		//Rule di create sederhana saja, karena Admin yang penting buat dulu statusnya terisi semua. Nanti
		//Detailnya baru dilengkapi oleh dokter.
		$this->form_validation->set_rules('tipe', 'Tipe User', 'trim|required');
		$this->form_validation->set_rules('nra', 'Nomor Register Anggota (NRA)', 'trim|required|xss_clean|callback_checkexist_nra');
		$this->form_validation->set_rules('nrapass', 'Password', 'trim|required|matches[nrapass2]|md5|xss_clean');
		$this->form_validation->set_rules('nrapass2', 'Password Confirmation', 'trim|required|xss_clean');
		
		$this->form_validation->set_rules('acv', 'Status User', 'trim|required');

		if ($this->session->flashdata('regstatus') == 'OK' ){
			redirect('users'); die();
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
				//di Admin create user tidak wajib upload file, biar dokter yang lengkapi sendiri.
				//Matikan comment jika admin wajib upload file.
				//$upload_regscan_error = '';
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
				//di Admin create user tidak wajib upload file, biar dokter yang lengkapi sendiri.
				//Matikan comment jika admin wajib upload file.
				//$upload_foto_error = 'Please select a file to upload.';
			}
		
		}
		
		// got file error ?
		if (isset($upload_foto_error) && isset($upload_regscan_data['file_name'])) {
			@unlink ( './media/'.$upload_regscan_data['file_name'] ); // delete prev. sucess upload
		}
		if (isset($upload_regscan_error) && isset($upload_foto_data['file_name'])) {
			@unlink ( './media/'.$upload_foto_data['file_name'] ); // delete prev. sucess upload
		}

		if (($this->form_validation->run() == FALSE) || isset($upload_regscan_error) || isset($upload_foto_error) || ($this->session->flashdata('regstatus') == 'OK' ) )	{	
		
			$view_data = array(			
			);
			if (!empty($_POST)) {
				$view_data['formfield_error'] = 'Form belum diisi dengan benar, silakan periksa!';	
			}
			if (isset($upload_regscan_error)) { $view_data['upload_regscan_error'] = $upload_regscan_error; }
			if (isset($upload_foto_error)) { $view_data['upload_foto_error'] = $upload_foto_error; }

			if (isset($upload_regscan_data['file_name'])) {
				@unlink ( './media/'.$upload_regscan_data['file_name'] ); // delete prev. sucess upload
			}
			if (isset($upload_foto_data['file_name'])) {
				@unlink ( './media/'.$upload_foto_data['file_name'] ); // delete prev. sucess upload
			}
			
			$this->Webpage->content = $this->load->view('c/user-new',$view_data,true);

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
				'tipe' 			=> $this->input->post('tipe'), 
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
				'acv' 			=> $this->input->post('acv'),
			);
			
			
			//Kalau kita buat Admin atau Komisi, 
			//Maka otomatis statusnya completed langsung. Karena mereka tidak perlu data lengkap
			if($tipe != 'doc'){
				$docdata['completed'] = 1;
			}
			
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
			$this->session->set_flashdata('sql_info', 'Successfully add new user.');
			
			//$this->Webpage->content = $this->load->view('c/register-ok','',true);
			redirect('users');

		}
		
		$this->finalView();
		
	
	} // end new user


	
	/* profile / edit */
	function edit($id_doc){
		if (!is_numeric($id_doc) or empty($id_doc)) {
			show_404();
			die();
		}
		$this->load->helper('form');
	
		$this->Webpage->set_title('Edit User');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="help-inline red"><em class="icon icon-color icon-cross"></em> ', '</span>');
		
		$this->form_validation->set_rules('nra', 'Nomor Register Anggota (NRA)', 'trim|required|xss_clean|callback_checkduplicate_nra');
		//$this->form_validation->set_rules('nrapass', 'Password', 'trim|required|matches[nrapass2]|md5|xss_clean');
		//$this->form_validation->set_rules('nrapass2', 'Password Confirmation', 'trim|required|xss_clean');
		
		//21-03-2019: HILANGKAN VALIDASI AGAR USER BISA AKTIVASI
		/*
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
        */
        
		if ( ($this->form_validation->run() == FALSE) )	{	
		
			$r_doc = $this->P2kb->get_userdoc($id_doc);
			$view_data = array(
				'row'	=> $r_doc,
			);
			if (!empty($_POST)) {
				$view_data['formfield_error'] = 'Form belum diisi dengan benar, silakan periksa!';	
			}

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
				$is_deleted = $this->P2kb->delete_userdoc_att('regscan',$id_doc);
				$regscan	= '';			
			}
			if ($delete_foto == 1) {
				$is_deleted = $this->P2kb->delete_userdoc_att('foto',$id_doc);
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
				redirect( current_url() );
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
				'tipe' 			=> $this->input->post('tipe'),
				'nra' 			=> $this->input->post('nra'),
				//'nrapass' 		=> $this->input->post('nrapass'), 
				'tahun' 		=> $this->input->post('tahun'), 
				'nama' 			=> $this->input->post('nama'), 
				'gelar' 		=> $gelars,
				'idi' 			=> $this->input->post('idi'), 
				'lhr' 			=> $this->input->post('lhr'), 
				'lhrtgl' 		=> $this->input->post('lhrtgl'), 
				'ktp' 			=> $this->input->post('ktp'), 
				'sex' 			=> $this->input->post('sex'), 
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
				'acv' 			=> $this->input->post('acv'),
			);
			
			if (isset($regscan)){ 
				$docdata['regscan'] = $regscan;
				if (!empty($regscan)) {
					$is_deleted = $this->P2kb->delete_userdoc_att('regscan',$id_doc);
				} 
			}
			if (isset($foto)) 	{ 
				$docdata['foto'] = $foto;
				if (!empty($foto)) {
					$is_deleted = $this->P2kb->delete_userdoc_att('foto',$id_doc);
				} 
			}

			$this->db->update( 'userdoc', $docdata, array('id' => $id_doc) ); 			
			$this->session->set_flashdata('userupdate', 'OK');
			
			redirect( current_url() );
			die();

		}
		
		$this->finalView();
		//$this->signView();
		
	
	} // end user edit
	
	/* profile / edit */
	function rm($id_doc){
		if ( empty($id_doc) ) {
			show_404();
			die();
		}
		$rm_ID = base64_decode( $id_doc );
		
		$userdoc_data = $this->P2kb->get_userdoc($rm_ID);
		if ($userdoc_data == false) {
			show_404();
			die();
		}else{
			// remove associated images
			@unlink ( './media/'.$userdoc_data->regscan ); 
			@unlink ( './media/'.$userdoc_data->foto ); 
		}
		
		// removing data:
		if ( is_numeric($rm_ID) ) {
			$deleted = $this->P2kb->remove_userdoc($rm_ID);
			$this->session->set_flashdata('sql_info', "$deleted Data successfully deleted.");
			redirect( 'users');
			die();
		}

		$r_doc = $this->P2kb->get_userdoc($id_doc);
	}
		
	/* change password */
	function changepass($id_doc){

		if (!is_numeric($id_doc) or empty($id_doc)) {
			show_404();
			die();
		}

		$this->Webpage->set_title('Change Password');	
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="help-inline red"><em class="icon icon-color icon-cross"></em> ', '</span>');
		
		//$this->form_validation->set_rules('nra', 'Nomor Register Anggota (NRA)', 'trim|required|xss_clean|callback_checkduplicate_nra');
		$this->form_validation->set_rules('nrapass', 'Password', 'trim|required|matches[nrapass2]|md5|xss_clean');
		$this->form_validation->set_rules('nrapass2', 'Password Confirmation', 'trim|required|xss_clean');

		if ( ($this->form_validation->run() == FALSE) )	{	
		
			$r_doc = $this->P2kb->get_userdoc($id_doc);
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
			
			$this->db->update( 'userdoc', $docdata, array('id' => $id_doc) ); 			
			$this->session->set_flashdata('userupdate', 'OK');
			
			redirect( current_url() );
			die();

		}
		
		$this->finalView();
		//$this->signView();
		
	
	}
	
	function checkexist_nra ($nra) {
		$this -> db -> select('id, nra');
		$this -> db -> from('userdoc');
		$this -> db -> where('nra', $nra);
		$this -> db -> limit(1);
		
		$query = $this->db->get();
		
		if($query->num_rows() == 1){
			$this->form_validation->set_message('checkexist_nra', 'Nomor Register Anggota (NRA) ini sudah didaftakan !');
			return FALSE;
			
		}else{
			return TRUE;
		}
	
	}

	function checkduplicate_nra ($nra) {
		$id_doc = $this->uri->segment(3);
		if (empty($id_doc) || ! is_numeric($id_doc)) {
			return FALSE;
		}else{
			$this -> db -> select('id, nra');
			$this -> db -> from('userdoc');
			$this -> db -> where('id', $id_doc);
			$this -> db -> limit(1);
			
			$query = $this->db->get();
			if($query->num_rows() == 1){
				$rDoc = $query->row();
			
				$this -> db -> select('id, nra');
				$this -> db -> from('userdoc');
				$this -> db -> where('nra', $nra);
				$this -> db -> where('id !=', $rDoc->id);
				$this -> db -> limit(1);
				
				$query = $this->db->get();
				
				if($query->num_rows() == 1){
					$this->form_validation->set_message('checkduplicate_nra', 'Nomor Register Anggota (NRA) ini sudah didaftakan !');
					return FALSE;
					
				}else{
					return TRUE;
				}
			}
	
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
	
}

