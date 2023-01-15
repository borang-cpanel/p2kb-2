<?php
class MY_Controller extends CI_Controller{
	
    function __construct() {
        //cek apakah login di wordpress
		    
		parent::__construct();

		parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
		
 	    $this->load->model('Webpage');
 	    $this->load->model('Site');
		$this->load->model('P2kb');

		//$this->Webpage->set_pagemeta();
		
		//Untuk mengecek user login di CI atau tidak
		$is_login = $this->session->userdata('logged_in');
		//var_dump($is_login);die('is_login');
		
		//kalau dia ada login wordpress maka dia otomatis login website
		$wordpresslogin = wp_get_current_user();
		//$wordpresslogin = null;
		//var_dump($wordpresslogin);die();
		
		if(isset($wordpresslogin->data->user_nicename)){
		    
		    $role = $wordpresslogin->roles[0];
		    //var_dump($role);die();
		    if($role=='administrator'){
		        $role = 'adm';
		    }
		    
		    //user login di wordpress, pastikan data login ada di database pori
		    $this -> db -> select('id, tipe, nra, nama, acv');
    		$this -> db -> from('userdoc');
    		$this -> db -> where('tipe', $role);
    		$this -> db -> where('nra', $wordpresslogin->data->user_login);
    		$this -> db -> limit(1);
    		
    		$query = $this->db->get();
    		//var_dump($this->db->last_query(),$query->num_rows());die('query');
    		if($query->num_rows() == 1){
    			$result = $query->result();
    			$sess_array = array();
    			$row = $query->row();
    		
        		  $sess_array = array(
        			'id' 	=> $row->id,
        			'nra' 	=> $row->nra,
        			'nama'	=> $row->nama,
        			'tipe'	=> $row->tipe,
        			'app'	=> 'P2KBPORI'
        		);
        		$this->session->set_userdata('logged_in', $sess_array);
    		    $this->P2kb->udata = $this->session->userdata('logged_in');
    		}else{
    		    redirect('http://www.pori.or.id/wp-login.php');
    		}
		}else{
		    redirect('http://www.pori.or.id/wp-login.php');
		}
		
		/*
		if ( $is_login && ($is_login['app'] == 'P2KBPORI') && $is_login['id']!=NULL) {
			$this->P2kb->udata = $this->session->userdata('logged_in');
		}else {
		    
    		}else{
    			$uri = $this->uri->uri_string();
    			if ( ! in_array($uri, array('user/login','user/signup') ) ) {
    				redirect('user/login'); die();
    			}	
    		}
		}*/
		
		//untuk dokter yang belum menyempurnakan akun maka akan dibawa 
		//ke halaman profile. 
		$seg1 = $this->uri->segment(1); 
		$seg2 = $this->uri->segment(2);
		if( 
				$seg1!='user' && $seg2!='profile' &&
				$this->P2kb->udata['tipe'] == 'doc' &&
				!$this->P2kb->is_profile_complete($this->P2kb->udata['id'])){
			redirect('user/profile'); die();
		}
		
	}
	
    function finalView($data='',$content=''){

		if ($this->session->userdata('logged_in')) {
			$udata = $this->session->userdata('logged_in');
			$this->Webpage->arr_tpl['udata'] = $udata;
			$this->Webpage->arr_tpl['qcat']	= $this->P2kb->get_catlist();
		}

		//$this->Webpage->content 	= $this->load->view('c/'.$content,$data,TRUE);
		$this->load->view('master',$this->Webpage->arr_tpl);

    } 
	
    function signView($data='',$content='',$sidebar1='sidebar1',$sidebar2='sidebar2'){

		//$this->Webpage->content 	= $this->load->view('c/'.$content,$data,TRUE);
		$this->load->view('sign',$this->Webpage->arr_tpl);

    }	
	
	
}