<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Healthcert extends MY_Controller {

	public function Healthcert()	{
		parent::__construct();	

		if ($this->session->userdata('logged_in')) {
		
		}else {
			redirect('user/login'); die();				
		}
	}

	function edit(){
		$this->index();
	}
	
	function rm(){
		$this->index();
	}
	
	function index(){
	
		$seg2 = $this->uri->segment(2);
		$seg3 = $edit_ID = $this->uri->segment(3);
		
		// editing data:
		$data_edit = false;
		$edit_status = '';
		if ( ($seg2 == 'edit') && is_numeric($seg3) ) {
			$data_edit = true;
		}
		
		// removing data:
		$rm_ID = base64_decode( $seg3 );
		if ( ($seg2 == 'rm') && is_numeric($rm_ID) ) {
			$deleted = $this->P2kb->remove_healthcert($rm_ID);
			$this->session->set_flashdata('sql_info', "$deleted Data successfully deleted.");
			redirect( 'healthcert' );
			die();
		}
		
		
		$this->Webpage->set_title('Sertifikat Kesehatan');

		$config['upload_path'] = './media/';
		$config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|xls|rtf|txt';
		//$config['max_size']	= '100';// KB
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';
		$this->load->library('upload', $config);

		$this->load->helper('form');
		
		if (!empty ($_POST) ) {
			// save 
			// (id, id_doc, tgl, tgl2, scanhealthcert, ket)
			$periode			= $this->input->post('periode', true);
			list($tgl,$tgl2) 	= explode('|',$periode);
			$delete_att 		= $this->input->post('delete_att', true);

			//delete attachement
			if ($delete_att == 1) {
				$is_deleted = $this->P2kb->delete_healthcert_att($edit_ID);
				$dokumen	= '';			
			}

			// save dokumen attachment		
			if($_FILES['scanbukti']['error'] != 4){ // if upload file

				if ( ! $this->upload->do_upload('scanbukti')) {
					$upload_error = $this->upload->display_errors('','');				
				}else{
					$upload_data = $this->upload->data();
				}
				
			}
	
			if ( !isset($upload_error) ) {
				if ( isset($upload_data) && isset($upload_data['file_name']) ) {
					$dokumen = $upload_data['file_name'];
				}
				
				$data_row = array (
					'id'		=> '',
					'id_doc'	=> $this->P2kb->udata['id'],
					'tgl'		=> $tgl,
					'tgl2'		=> $tgl2,
					//'scanhealthcert'	=> $dokumen,
					'ket'		=> strip_tags( $this->input->post('keterangan', true) )
				);

				// if on Komisi P2KB(kolegium)/admin login
				if ($this->P2kb->udata['tipe'] != 'doc') {
					unset($data_row['id_doc']);
				}
				
				if (isset($dokumen)) {
					$data_row ['scanhealthcert'] = $dokumen;
					if ($data_edit == true) { // delete previously attachment
						$is_deleted = $this->P2kb->delete_healthcert_att($edit_ID);
					}
				}

				if ($data_edit == true) {
					unset($data_row['id']);
					unset($data_row['id_doc']);
					$this->db->update('healthcert', $data_row, 'id = '.$edit_ID);
					if ($this->db->affected_rows() > 0) {
						$edit_status = 'success';
					}
				
				}else{
					$this->db->insert('healthcert', $data_row);
					if ($this->db->affected_rows() > 0) {
						$this->session->set_flashdata('sql_info', "New data successfully saved.");
						redirect( 'healthcert' );die();
					}
				}

			}else{
				$edit_status = 'error';
			}	

		}// end !empty POST
		
		if ($data_edit == true) {
			$row_edit = $this->P2kb->get_healthcert($edit_ID);
			$this->data = array(
				'row'			=> $row_edit,
				'periodeOptions'=> $this->P2kb->get_periodecert_options($row_edit->id_doc,$row_edit->tgl.'|'.$row_edit->tgl2),
				'edit_status'	=> $edit_status
			);
			
			$this->Webpage->content = $this->load->view('c/healthcert-edit',$this->data,TRUE);
			
		}else{
			// default : list/add data
			
			if ($this->P2kb->udata['tipe'] == 'doc') {
				$id_doc = $this->P2kb->udata['id'];
			}else{
				$id_doc = '';
			}	
			$this->data = array(
				'q'				=> $this->P2kb->get_healthcerts($id_doc),
				'periodeOptions'=> $this->P2kb->get_periodecert_options($this->P2kb->udata['id']),
				
			);
			$this->Webpage->content = $this->load->view('c/healthcert',$this->data,TRUE);
			
		}

		$this->Webpage->add_js(base_url().'js/jquery.validationEngine.js');
		$this->Webpage->add_js(base_url().'js/jquery.validationEngine-en.js');
		$this->Webpage->add_css(base_url().'css/validationEngine.jquery.css');

		$this->finalView();	
	
	}	
    
	
}

