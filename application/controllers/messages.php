<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends MY_Controller {

	public function Messages()	{
		parent::__construct();	

		if ($this->session->userdata('logged_in')) {
			if ($this->P2kb->udata['tipe'] == 'kol') {
				redirect('dashboard'); die();				
			}

		}else {
			redirect('user/login'); die();				
		}
	}

	function index(){
	
		$this->Webpage->set_title('Messages');

		if (!empty ($_POST) ) {
			
			// save
			$title		= $this->input->post('mtitle', true);
			$message	= $this->input->post('message', true);
			$receipt	= $this->input->post('receipt', true);
		
			$data_row = array(
				'id'		=> '',
				'mdate'		=> date('Y-m-d H:i:s'),
				'sender'	=> $this->P2kb->udata['id'],
				'receipt'	=> '',
				'title'		=> $title,
				'message'	=> $message
			);
			
			if ($this->P2kb->udata['tipe'] == 'adm') {
				$data_row['receipt'] = $receipt;
                
                $this->sendMail($data_row);
			}

            $this->db->insert('messages', $data_row);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('sql_info', "Message has been sent.");
                $uri = $this->uri->uri_string();
                redirect( $uri ); die();
            }			
			
		}

		$this->data = array(
			'q'	=> $this->P2kb->get_messages($this->P2kb->udata['id'])
		);
		if ($this->P2kb->udata['tipe'] == 'adm') {
			$this->data['arrDoctors'] = $this->P2kb->get_arrDoctors();
		}
		
		$this->Webpage->content = $this->load->view('c/messages',$this->data,TRUE);

		$this->Webpage->add_js(base_url().'js/jquery.validationEngine.js');
		$this->Webpage->add_js(base_url().'js/jquery.validationEngine-en.js');
		$this->Webpage->add_css(base_url().'css/validationEngine.jquery.css');

		$this->finalView();	
	
	}
	
	function read($id) {
		if (empty($id) || !is_numeric($id)) {
			show_404();
			die();
		}
		$this->Webpage->set_title('Messages');
		
		$message_row = $this->P2kb->read_message($this->P2kb->udata['id'], $id);
		
		$receipt_name = $sender_name = 'Administrator';
		if ($message_row != false){
			if (!empty($message_row->receipt)) {
				$r_receipt 	= $this->P2kb->get_userdoc($message_row->receipt);
				if ( $r_receipt != false ) {
					$receipt_name = $r_receipt->nama;
				}else{
					$receipt_name = '--non-existent-user--';
				}
			} 
			if (!empty($message_row->sender)) {
				$r_sender 	= $this->P2kb->get_userdoc($message_row->sender);
				if ( $r_sender != false ) {
					$sender_name = $r_sender->nama;
				}else{
					$sender_name = '--non-existent-user--';
				}
			} 
		}
		
		$this->data = array(
			'row'	=> $message_row,
			'receipt_name'	=> $receipt_name,
			'sender_name'	=> $sender_name,
		);
		$this->Webpage->content = $this->load->view('c/messages-single',$this->data,TRUE);

		$this->finalView();	
	
	}
    
    function sendMail($data)
    {
        $config = $this->config->item('mail');
        $this->load->library('email', $config);
        $from = $config['smtp_user'];
        $user = $this->P2kb->get_email($data['receipt']);
        $to = $user !== FALSE ? $user['email'] : '';
        
        if(empty($to))
        {
            return;
        }
        
        $this->email->from($from);
        $this->email->to($to);
        
        $this->email->subject($data['title']);
        $this->email->message($data['message']);        
        
        $this->email->send();
    }
}
