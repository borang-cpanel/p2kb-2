<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kegiatan extends MY_Controller {
	
	public function Kegiatan()	{
		parent::__construct();		

	}

	function index($id=''){ }
	
	function category($idCat=''){
	
		if (! is_numeric($idCat) ){
			show_404();
			die();
		}
		
		$seg4 = $this->uri->segment(4);
		$seg5 = $edit_ID = $this->uri->segment(5);
		
		// editing data:
		$data_edit = false;
		$edit_status = '';
		if ( ($seg4 == 'edit') && is_numeric($seg5) ) {
			$data_edit = true;
		}
		
		// removing data:
		$rm_ID = base64_decode( $seg5 );
		if ( ($seg4 == 'rm') && is_numeric($rm_ID) ) {
			$deleted = $this->P2kb->remove_kegiatandoc($rm_ID);
			$this->session->set_flashdata('sql_info', "$deleted Data successfully deleted.");
			redirect( 'kegiatan/category/'.$idCat );
			die();
		}
		
		$r = $this->P2kb->get_kategori($idCat);
		if (empty($r)) {
			show_404();
			die();
		}
		
		$config['upload_path'] = './media/';
		$config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|xls|rtf|txt';
		$config['max_size']	= '6000';// KB
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';
		$this->load->library('upload', $config);

		$this->load->helper('form');
		
		// =============================================
		// if specific category -- Kegiatan Profesional
		// =============================================
		if ($idCat == '3') {
			
			$arrKanker = $this->P2kb->arrKanker;
			if (!empty ($_POST) ) {
				
				// save
				//id, id_doc, tgl, tgl2, id_keg, pasien, skp, ket, dokumen
				$periode			= $this->input->post('periode', true);
				list($tgl1,$tgl2) 	= explode('|',$periode);
				$idKegiatan			= $this->input->post('idkegiatan', true);
				$delete_att 		= $this->input->post('delete_att', true);
				$acv 				= $this->input->post('acv', true);
				// calc data pasien kanker
				$tot = 0;
				$skp = 0;
				$dataPasien = array();
				foreach($arrKanker as $kn => $kname) {
					$iKanker 	= (int) $this->input->post($kn, true); 
					$dataPasien[$kn] = $iKanker;
					$tot 		= $tot + $iKanker;
				}
				$skp = $this->P2kb->calc_skppro($idKegiatan,$tot);
				
				//$keterangan = $this->input->post('keterangan', true);
				$dokumen	= '';

				//delete attachement
				if ($delete_att == 1) {
					$is_deleted = $this->P2kb->delete_kegiatandoc_att($edit_ID);
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
	
				$rcount = 0;
				if ( !empty($idKegiatan) && !isset($upload_error) ) {
					if ( isset($upload_data) && isset($upload_data['file_name']) ) {
						$dokumen = $upload_data['file_name'];
					}

					$data_row = array(
						'id'		=> '',
						'id_doc'	=> $this->P2kb->udata['id'],
						'tgl'		=> $tgl1,
						'tgl2'		=> $tgl2,
						'id_keg'	=> $idKegiatan,
						'pasien'	=> serialize($dataPasien),
						'skp'		=> $skp,
						//'ket'		=> $keterangan,
						//'dokumen'	=> $dokumen,
						'acv'		=> 0,
					); 

					// if on Komisi P2KB(kolegium)/admin login : set approval 
					if ($this->P2kb->udata['tipe'] != 'doc') {
						unset($data_row['id_doc']);
						$data_row['acv'] = $acv;
					}
					
					if (isset($upload_data)) {
						$data_row ['dokumen'] = $dokumen;
						if ($data_edit == true) { // delete previously attachment
							$is_deleted = $this->P2kb->delete_kegiatandoc_att($edit_ID);
						}
					}

					if ($data_edit == true) {
						unset($data_row['id']);
						unset($data_row['id_doc']);
						$this->db->update('kegiatandoc', $data_row, 'id = '.$edit_ID);
						if ($this->db->affected_rows() > 0) {
							$edit_status = 'success';
						}
					
					}else{
						$this->db->insert('kegiatandoc', $data_row);
						if ($this->db->affected_rows() > 0) {
							$this->session->set_flashdata('sql_info', "New data successfully saved.");
							redirect( 'kegiatan/category/'.$idCat );die();
						}
					}

				}else{
					$edit_status = 'error';
				}
				
			}// end !empty ($_POST)
	
			if ($data_edit == true) {
				$row_edit = $this->P2kb->get_kegiatandoc($edit_ID);
				if ( ($this->P2kb->udata['tipe'] == 'doc') and ($row_edit->acv != 0) ) {
					show_error('Violation! This is non-editable data !');
				}else{
					$this->data = array(
						'r'					=> $r,
						'row'				=> $row_edit,
						'periodeOptions'	=> $this->P2kb->get_periode_options($row_edit->id_doc,$row_edit->tgl.'|'.$row_edit->tgl2),
						'kegiatanOptions'	=> $this->P2kb->get_kegiatan_options($idCat,'',$row_edit->id_keg),
						'edit_status'		=> $edit_status
						//'paging'			=> $paging,
					);
				}
				
				$this->Webpage->content = $this->load->view('c/kegiatan-pro-edit',$this->data,TRUE);
				
			}else{
				// default : list/add data
				$this->data = array(
					'q'					=> $this->P2kb->get_kegiatandoc_list($idCat),
					'r'					=> $r,
					'periodeOptions'	=> $this->P2kb->get_periode_options($this->P2kb->udata['id']),
					'kegiatanOptions'	=> $this->P2kb->get_kegiatan_options($idCat),
					//'paging'			=> $paging,
				);
				
				$this->Webpage->content = $this->load->view('c/kegiatan-pro',$this->data,TRUE);
			}
		
		}else{
		// ================================
		// rest of the category :
		// ================================
		
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
				
				if ($this->P2kb->is_kegiatan_customskp($idKegiatan) || ($this->P2kb->udata['tipe'] != 'doc')) { // kolegium/admin may override
					$skp = $this->input->post('skp', true);					
				}
				
				//delete attachement
				if ($delete_att == 1) {
					$is_deleted = $this->P2kb->delete_kegiatandoc_att($edit_ID);
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
	
				$rcount = 0;
				if ( !empty($idKegiatan) && !isset($upload_error) ) {
					if ( isset($upload_data) && isset($upload_data['file_name']) ) {
						$dokumen = $upload_data['file_name'];
					}
					
					$data_row = array(
						'id'		=> '',
						'id_doc'	=> $this->P2kb->udata['id'],
						'tgl'		=> $kdate,
						'id_keg'	=> $idKegiatan,
						'skp'		=> $skp,
						'ket'		=> $keterangan,
						'acv'		=> 0,
					);
					
					// if on kolegium/admin login : set approval 
					if ($this->P2kb->udata['tipe'] != 'doc') {
						unset($data_row['id_doc']);
						$data_row['acv'] = $acv;
						
						// if kolegium/admin modify SKP
						if ($this->P2kb->is_kegiatan_customskp($idKegiatan)) {
							if ($row_edit->skp != $skp) {
								$data_row['skp_reject'] = $row_edit->skp;
							}
						}
					}
					
					if (isset($dokumen)) {
						$data_row ['dokumen'] = $dokumen;
						if ($data_edit == true) { // delete previously attachment
							$is_deleted = $this->P2kb->delete_kegiatandoc_att($edit_ID);
						}
					}

					if ($data_edit == true) {
						unset($data_row['id']);
						$this->db->update('kegiatandoc', $data_row, 'id = '.$edit_ID);
						if ($this->db->affected_rows() > 0) {
							$edit_status = 'success';
						}
					
					}else{
					
						$this->db->insert('kegiatandoc', $data_row);
						if ($this->db->affected_rows() > 0) {
							$this->session->set_flashdata('sql_info', "New data successfully saved.");
							redirect( 'kegiatan/category/'.$idCat ); die();
						}
						
					}

				}else{
					$edit_status = 'error';
				}
				
			}
	

			
			if ($idCat == 2) {
				$kegiatanOptions = $this->P2kb->get_kegiatan_options($idCat,'kegiatan desc', set_value('idkegiatan'));
			}else{
				$kegiatanOptions = $this->P2kb->get_kegiatan_options($idCat,'', set_value('idkegiatan'));
			}
			
			if ($data_edit == true) {
				// editing data
				$row_edit = $this->P2kb->get_kegiatandoc($edit_ID);
				if ( ($this->P2kb->udata['tipe'] == 'doc') and ($row_edit->acv != 0) ) {
					show_error('Violation! This is non-editable data !');
				}else{
					$this->data = array(
						'r'					=> $r,
						'row'				=> $row_edit,
						'kegiatanOptions'	=> $this->P2kb->get_kegiatan_options($idCat,'',$row_edit->id_keg),
						'edit_status'		=> $edit_status,
					);
					if ( ($idCat !== 1) || ($this->P2kb->udata['tipe'] != 'doc') ) {
						$this->data['enable_skp'] = 'true';
					}
					if ( isset($upload_error) ) {
						$this->data['upload_error'] = $upload_error;
					}
				}
				
				$this->Webpage->content = $this->load->view('c/kegiatan-edit',$this->data,TRUE);
				
			}else{
				// default : list/add data
				$this->data = array(
					'q'					=> $this->P2kb->get_kegiatandoc_list($idCat),
					'r'					=> $r,
					'kegiatanOptions'	=> $kegiatanOptions,
					'edit_status'		=> $edit_status
					//'paging'			=> $paging,
				);
				if ( ($idCat !== 1) || ($this->P2kb->udata['tipe'] != 'doc') ) {
					$this->data['enable_skp'] = 'true';
				}
				if ( isset($upload_error) ) {
					$this->data['upload_error'] = $upload_error;
				}
				
				$this->Webpage->content = $this->load->view('c/kegiatan',$this->data,TRUE);
			
			}
	
		} // end if specific category
		
		$this->Webpage->set_title($r['jenis']);

		$this->Webpage->add_js(base_url().'js/jquery.validationEngine.js');
		$this->Webpage->add_js(base_url().'js/jquery.validationEngine-en.js');
		$this->Webpage->add_css(base_url().'css/validationEngine.jquery.css');

		$this->finalView();
		
	
	}
    	
}

