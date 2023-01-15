<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MY_Controller {

	public function Data()	{
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
	}
	
	function kategori() {

		$data_edit 	= false;
		$seg3 = $this->uri->segment(3);
		$seg4 = $edit_ID = $this->uri->segment(4);
		
		// editing data:
		$data_edit = false;
		$edit_status = '';
		if ( ($seg3 == 'edit') && is_numeric($seg4) ) {
			$data_edit 	= true;
			$row_edit 	= $this->P2kb->get_kategori($edit_ID);

		}
		
		// removing data:
		$rm_ID = base64_decode( $seg4 );
		if ( ($seg3 == 'rm') && is_numeric($rm_ID) ) {
			$deleted = $this->P2kb->remove_kategori($rm_ID);
			$this->session->set_flashdata('sql_info', "$deleted Data successfully deleted.");
			redirect( 'data/kategori');
			die();
		}
		

		$this->Webpage->set_title('Master Data Kategori Kegiatan');

		if (!empty ($_POST) ) {
			
			// save
			//id, jenis, skp
			$jenis 	= $this->input->post('jenis', true);
			$skp 	= $this->input->post('skp', true);
			
			$data_row = array(
				'id'	=> '',
				'jenis'	=> $jenis,
				'skp'	=> $skp
			);
			
			if ($data_edit == true) {
				unset($data_row['id']);
				$this->db->update('kategori', $data_row, 'id = '.$edit_ID);
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('sql_info', "Data successfully updated.");
					$edit_status = 'success';
				}
			
			}else{
				$this->db->insert('kategori', $data_row);
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('sql_info', "New data successfully saved.");
				}
			}
			redirect( 'data/kategori' );die();
			
		} // end if
		
		$this->data = array(
			'q'	=> $this->P2kb->get_catlist(),
		);
		if ($data_edit) {
			$this->data['row'] = $row_edit;
		}
		
		$this->Webpage->content = $this->load->view('c/data-kategori',$this->data,TRUE);
		

		$this->Webpage->add_js(base_url().'js/jquery.validationEngine.js');
		$this->Webpage->add_js(base_url().'js/jquery.validationEngine-en.js');
		$this->Webpage->add_css(base_url().'css/validationEngine.jquery.css');

		$this->finalView();	

	}
		
	function kegiatan() {

		$data_edit 	= false;
		$seg3 = $this->uri->segment(3);
		$seg4 = $edit_ID = $this->uri->segment(4);
		
		// editing data:
		$data_edit = false;
		$edit_status = '';
		if ( ($seg3 == 'edit') && is_numeric($seg4) ) {
			$data_edit 	= true;
			$row_edit 	= $this->P2kb->get_kegiatan($edit_ID);

		}
		
		// removing data:
		$rm_ID = base64_decode( $seg4 );
		if ( ($seg3 == 'rm') && is_numeric($rm_ID) ) {
			$deleted = $this->P2kb->remove_kegiatan($rm_ID);
			$this->session->set_flashdata('sql_info', "$deleted Data successfully deleted.");
			redirect( 'data/kegiatan');
			die();
		}
		

		$this->Webpage->set_title('Master Data Kegiatan');

		if (!empty ($_POST) ) {
			
			// save
			//id, id_kat, kegiatan, skpmax, dokumen
			$id_kat 	= $this->input->post('id_kat', true);
			$kegiatan 	= $this->input->post('kegiatan', true);
			$skpmax 	= $this->input->post('skpmax', true);
			$dokumen 	= $this->input->post('dokumen', true);
			
			$data_row = array(
				'id'	=> '',
				'id_kat'	=> $id_kat,
				'kegiatan'	=> $kegiatan,
				'skpmax'	=> $skpmax,
				'dokumen'	=> $dokumen
			);
			
			if ($data_edit == true) {
				unset($data_row['id']);
				$this->db->update('kegiatan', $data_row, 'id = '.$edit_ID);
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('sql_info', "Data successfully updated.");
					$edit_status = 'success';
				}
			
			}else{
				$this->db->insert('kegiatan', $data_row);
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('sql_info', "New data successfully saved.");
				}
			}
			redirect( 'data/kegiatan' );die();
			
		} // end if
		
		$this->data = array(
			'kategoriOptions'	=> $this->P2kb->get_kategori_options(),
			'q'					=> $this->P2kb->get_list_kegiatan(),
		);
		if ($data_edit) {
			$this->data['kategoriOptions'] = $this->P2kb->get_kategori_options($row_edit['id_kat']);
			$this->data['row'] = $row_edit;
		}
		
		$this->Webpage->content = $this->load->view('c/data-kegiatan',$this->data,TRUE);
		

		$this->Webpage->add_js(base_url().'js/jquery.validationEngine.js');
		$this->Webpage->add_js(base_url().'js/jquery.validationEngine-en.js');
		$this->Webpage->add_css(base_url().'css/validationEngine.jquery.css');

		$this->finalView();	

	}
		
  
	
}

