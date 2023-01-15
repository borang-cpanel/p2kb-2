<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends MY_Controller {
	var $content = '';
	
	public function Profile() {
		parent::__construct();	
	}
	
	function index(){
		// check if loged in
		$udata = $this->session->userdata('logged_in');
		if( empty($udata) ) {
			$this->session->set_flashdata('logintip', 'Please login to access your profile page');
			redirect('user/login','refresh');
		}
		
		
		$sesdata = $udata;
		
		// add datepicker javascript and css
		$this->Webpage->add_css(base_url().'css/redmond.datepick.css');
		$this->Webpage->add_js(base_url().'js/jquery.datepick.min.js');

		// add jQuery autocomplete
		$this->Webpage->add_js(base_url().'js/jquery.autocomplete.min.js');
		$this->Webpage->add_css(base_url().'css/jquery.autocomplete.css');
				
		// get member data 
		$qm = $this->db->query("select * from members where id='".$sesdata['id']."'");
		if ($qm->num_rows() > 0) {
			$rmember = $qm->row();
		}
		
		$profile_data = array(
			'm_active'	=> $rmember->acv,
			'm_uid'		=> $rmember->uid,
			'fbid'		=> $rmember->fbid,
			'nama'		=> $rmember->namalkp,
			'm_name'	=> $rmember->namalkp,
			'm_email'	=> $rmember->eml,
			'enotif'	=> $rmember->enotif,
			'eletter'	=> $rmember->eletter
		);
		
		
		// upload img handle
		$this->load->library('form_validation');
		
		//$this->form_validation->set_rules('pimg', 'Photo', 'callback_valid_photo');
		$this->form_validation->set_rules('pcap', 'Caption', 'trim|required|min_length[5]|xss_clean');
		$this->form_validation->set_rules('ptour', 'Tour', 'trim|required|min_length[5]|xss_clean');
		$this->form_validation->set_rules('pleader', 'Tour Leader', 'trim|required|min_length[5]|xss_clean');
		//$this->form_validation->set_rules('ploc', 'Location', 'trim|required|min_length[5]|xss_clean');
		$this->form_validation->set_rules('pdate', 'Departure Date', 'trim|required|min_length[5]|xss_clean');

		$upload_dir = FCPATH.'data/photos/'.$rmember->uid.'/';
		if ( !is_dir($upload_dir) ) {
			$preparedir = mkdir($upload_dir);
			# extra check :
			if ( !is_really_writable( $upload_dir ) ) {
				die('Unable write to : '.$upload_dir);
			}
		}
		$upload_path 	= FCPATH.'data/photos/'.$rmember->uid.'/';

		$config['upload_path'] 	= $upload_dir;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']		= '1024';
		$config['max_width']  	= '2000';
		$config['max_height']  	= '2000';
		
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('pfile')) {
			$this->form_validation->set_rules('pimg', 'Photo', 'callback_valid_photo');
			$this->pimg_err = $this->upload->display_errors('','');

		}else{
			$uploaded_file = $this->upload->data();

		}
		
		if ($this->form_validation->run() == FALSE)	{
		

		} else {

			#resize using excellent PHPThumb resizer 
			require_once( APPPATH . './libraries/PHPThumb/ThumbLib.inc.php');
			$thumb = PhpThumbFactory::create($uploaded_file['full_path']);
			$thumb->adaptiveResize(155, 155)->save($upload_path.'thumb_'.$uploaded_file['file_name']);

			$thumb = PhpThumbFactory::create($uploaded_file['full_path']);
			$thumb->adaptiveResize(358, 358)->save($upload_path.'medium_'.$uploaded_file['file_name']);
			
			//640,425
			//unlink($uploaded_file['full_path']);
			
			//insert data 
			$photodata = array (
				'id'		=> '', 
				'uid'		=> $rmember->id, 
				//'tid'		=> $this->input->post('ptour'), 
				'tid'		=> $this->input->post('tourid'), 
				'tstamp'	=> date('Y-m-d H:i:s'),
				'pimg'		=> $rmember->uid.'/'.$uploaded_file['file_name'], 
				'cap'		=> $this->input->post('pcap'), 
				'des'		=> strip_tags($this->input->post('pdesc')), 
				'tleader'	=> $this->input->post('pleader'), 
				'loc'		=> $this->input->post('ploc'), 
				'pdate'		=> $this->input->post('pdate'),
			);
			$this->db->insert('members_photo',$photodata); 
			
			$this->session->set_flashdata('pupload','uploaded');
			redirect('profile','refresh');

		}
		
		$gal = $this->Photos->mine($rmember->id);
		$profile_data['mygal'] = $this->load->view('c/tn-gal',array('qp'=>$gal), TRUE);

		
		//my photos which included in finalist
		$qfin = $this->Photos->get_contest_finalist_by_member($udata['id']);
		$profile_data['qfin'] = $qfin;
		

		$this->content = $this->load->view('c/profile',$profile_data,true);

		$this->data = array(
			'CONTAINER'	=> $this->content,
		);
		
		$this->finalView($this->data,'container');
		
	}
    
	function popmodify(){
		$sdata = $this->session->userdata('logged_in');
		if (empty($sdata)) { redirect('user/login','refresh'); }

		// prepare user data
		$q = $this->db->query("select * from members where id='".$sdata['id']."' limit 1");
		if ($q->num_rows() != 1){
			redirect('user/login','refresh');
		}
		
		$rm = $q->row_array();
		
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('namal', 'Name', 'trim|required|min_length[5]|xss_clean');
		$this->form_validation->set_rules('pass', 'Password', 'trim|matches[pass2]|md5|xss_clean');
		$this->form_validation->set_rules('pass2', 'Password Confirmation', 'trim|xss_clean');
		$this->form_validation->set_rules('eml', 'Email', 'trim|required|valid_email|xss_clean|callback_checkduplicate_mail');

		if ($this->form_validation->run() == FALSE)	{
		

		} else {
		
			// update query
			$newpass = $this->input->post('pass');
			$memberdata = array (
				'namalkp'	=> $this->input->post('namal'),
				'eml'		=> $this->input->post('eml'),
				'passwd'	=> $newpass,
			);
			if ( empty($newpass) ){
				array_pop($memberdata);
			}
			// deactivate email if update email
			if ( $rm['eml'] != $this->input->post('eml') ) {
				$memberdata['acv'] = '';
			}
			
			$this->db->where('id', $sdata['id']);
			$this->db->update('members', $memberdata);
			
			$rm['_updated'] = 'Success';

		}
		
		$c = $this->load->view('c/profile-modify',$rm, true);
		
		$this->Webpage->content = $c;
		$this->Webpage->header = 'profile';
		
		$this->popupFinal();

	}

	
	function checkduplicate_mail ($eml) {
		$sdata = $this->session->userdata('logged_in');
		
		if ($eml == $sdata['eml']){ return true; }
	
		$this -> db -> select('id, eml');
		$this -> db -> from('members');
		$this -> db -> where('eml', $eml);
		$this -> db -> limit(1);
		
		$query = $this->db->get();
		
		if($query->num_rows() == 1){
			$this->form_validation->set_message('checkduplicate_mail', 'Sorry, this email address is already associated with account !');
			return FALSE;
			
		}else{
			return TRUE;
		}
	
	}

	
	function popsubscribe(){
		$sdata = $this->session->userdata('logged_in');
		if (empty($sdata)) { redirect('user/login','refresh'); die(); }

		//$this->load->library('form_validation');
		$submit = $this->input->post('s');
		if ($submit=='Submit'){
			$memberdata = array (
				'enotif'	=> $this->input->post('enotif') ? '1':'0',
				'eletter'	=> $this->input->post('eletter') ? '1':'0',
			);

			$this->db->where('id', $sdata['id']);
			$r = $this->db->update('members', $memberdata); //echo $this->db->last_query();
			
			$_updated = 'Success';
			
		}
		
		
		// get user data
		$q = $this->db->query("select * from members where id='".$sdata['id']."' limit 1");
		if ($q->num_rows() != 1){
			redirect('user/login','refresh');
		}
		
		$rm = $q->row_array();
		if (isset($_updated)) $rm['updated'] = $_updated;

		$c = $this->load->view('c/profile-subscribe',$rm, true);
		
		$this->Webpage->content = $c;
		$this->Webpage->header = 'profile';
		
		$this->popupFinal();
		
	
	}
	
}

