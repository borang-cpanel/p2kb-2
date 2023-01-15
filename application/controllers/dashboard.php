<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function Dashboard()	{
		parent::__construct();	
	}

	function index(){
	
		if ($this->session->userdata('logged_in')) {

		}else {
			redirect('user/login'); die();
				
		}

		#$this->Webpage->title = 'Home';	
		#$this->Webpage->add_js(base_url().'js/jquery.cycle.lite.min.js');

		$id_doc 	= $this->P2kb->udata['id'];
		//var_dump($this->P2kb->udata);die('dashboard');
		$unread_msg = $this->P2kb->count_unread_messages($id_doc);
		
		switch($this->P2kb->udata['tipe']) {
			
			// doctor dashboard
			case 'doc' :
				$r		= false;
				if (!empty($_POST)) {
					$reqPeriode = $this->input->post('periode', true);
					$r 		 	= $this->P2kb->get_skp_terkumpul($id_doc,$reqPeriode);
					$periodeOpt	= $this->P2kb->get_periodecert_options($id_doc, $reqPeriode);
				}else{
					$periodeOpt	= $this->P2kb->get_periodecert_options($id_doc);
		
				}
				$isNearExpire   = $this->P2kb->is_almost_expire_user($id_doc, 180); //setengah tahun
				$isCompleted    = $this->P2kb->is_profile_complete($id_doc);

				$this->data = array(
					'unread'		=> $unread_msg,
					'r'				=> $r,
					'periodeOptions'=> $periodeOpt,
					'isNearExpire'  => $isNearExpire,
					'isCompleted'   => $isCompleted,
				);
				$this->Webpage->content = $this->load->view('c/dashboard',$this->data,TRUE);
			break;
			
			// Komisi P2KB (Kolegium) /admin dashboard
			case 'kol' :
			case 'adm':
				$r = $this->P2kb->get_aktiftas_for_kolegum();
				$this->data = array(
					'unread'	=> $unread_msg,
					'r'			=> $r,
				);
				$this->Webpage->content = $this->load->view('c/dashboard-kolegium',$this->data,TRUE);
			//break;
			
			break;
			
		}
		
		$this->finalView();	
	
	}
    
	
}

