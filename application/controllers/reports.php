<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends MY_Controller {
	var $arr_etika 		= array('Laik','Tidak Laik');
	var $arr_kesehatan 	= array('Baik','Kurang Baik','Tidak Layak');
	var $arr_hasil 		= array('Dapat diberikan Sertifikat Ulang tanpa syarat',
							'Dapat diberikan Sertifikat Ulang dengan program remedial dalam bidang yang tidak dipenuhi',
							'Ditolak/Degradasi');
	
	public function Reports()	{
		parent::__construct();	

		if ($this->session->userdata('logged_in')) {
			if ($this->P2kb->udata['tipe'] == 'doc') {
				#redirect('dashboard'); die();				
			}

		}else {
			redirect('user/login'); die();				
		}
	}

	function index(){
	
		$this->Webpage->set_title('Reports');

		$id_doc = '';
		if ($this->P2kb->udata['tipe'] == 'doc') {
			$id_doc = $this->P2kb->udata['id'];				
		}
		
		$qR = $this->P2kb->get_reports($id_doc,0,'reports.gendate desc'); // generate reports
		
		$this->data = array(
			'qR'			=> $qR,
			'arr_etika'		=> $this->arr_etika,
			'arr_kesehatan' => $this->arr_kesehatan,
			'arr_hasil'		=> $this->arr_hasil,
			
			'q'				=> $this->P2kb->get_doctors(0)
		);
		$this->Webpage->content = $this->load->view('c/reports',$this->data,TRUE);

		$this->finalView();	
	
	}
	
	function skp($id_doc){
		if (!is_numeric($id_doc) or empty($id_doc)) {
			show_404();
			die();
		}
		$this->Webpage->set_title('Rekap SKP Dokter');
		
		$doc_info = $this->P2kb->get_userdoc($id_doc);
		
		$r = false;
		if (!empty($_POST)) {
			$reqPeriode = $this->input->post('periode', true);
			$r 		 	= $this->P2kb->get_skp_terkumpul($id_doc,$reqPeriode);
			$periodeOpt	= $this->P2kb->get_periodecert_options($id_doc, $reqPeriode);

		}else{
			$periodeOpt	= $this->P2kb->get_periodecert_options($id_doc);

		}
		
		$this->data = array(
			'doc'			=> $doc_info,
			'r'				=> $r,
			'periodeOptions'=> $periodeOpt,
		);

		$this->Webpage->content = $this->load->view('c/rekap-skp',$this->data,TRUE);

		$this->finalView();	
	}

	function rm($id_report){
		if ( empty($id_report) || ($this->P2kb->udata['tipe'] == 'doc')) {
			show_404();
			die();
		}
		$rm_ID = base64_decode( $id_report );
		
		$report_data = $this->P2kb->get_report($rm_ID);
		if ($report_data == false) {
			show_404();
			die();
		}else{

			// removing data:
			$deleted = $this->P2kb->remove_report($rm_ID);
			$this->session->set_flashdata('report_sql_info', "$deleted Data successfully deleted.");
			redirect( 'reports');
			die();
			
		}
		

		//$r_doc = $this->P2kb->get_userdoc($id_doc);
	}
		

	function generate($id_report='') { // generate and send PDF file
		if (empty($id_report)) {
			show_404();
			die();
		}
		$this->load->helper('form');
	
		$this->Webpage->set_title('Generate Reports');

		// get report detail
		$rreport = $this->P2kb->get_report($id_report);
		if ($rreport != false) {
			
			$this->load->helper(array('dompdf', 'inflector', 'file'));

			$id_doc 		= $rreport->id_doc;
			$periode		= $rreport->periode;
		
			$rdoc 			= $this->P2kb->get_userdoc($id_doc);
			$pdf_filename 	= 'Laporan_Re-Sertifikasi_Dokter_Onkologi_periode_'.str_replace('|','_',$periode).'_'.underscore($rdoc->nama.'-'.date('Y-m-d His') );
			$pdf_data = array(
				'r'		=> $rdoc, // doc's personal data
				'rc'	=> $this->P2kb->get_skp_terkumpul($id_doc,$periode), 	// I. KREDIT PENDIDIKAN / PELATIHAN
				'qA'	=> $this->P2kb->get_skp_kegiatan(1,$id_doc,$periode),	// A. DATA KEGIATAN PEMBELAJARAN INDIVIDU - Kegiatan Pembelajaran Individu
				'qA2'	=> $this->P2kb->get_skp_kegiatan(2,$id_doc,$periode),	// A. DATA KEGIATAN PEMBELAJARAN INDIVIDU - Kegiatan Ilmiah
				'qB'	=> $this->P2kb->get_skp_kegiatan(3,$id_doc,$periode),	// B. DATA KEGIATAN PROFESIONAL
				'qC'	=> $this->P2kb->get_skp_kegiatan(4,$id_doc,$periode),	// C. DATA KEGIATAN PENGABDIAN MASYARAKAT DAN PENGEMBANGAN PROFESI
				'qD'	=> $this->P2kb->get_skp_kegiatan(5,$id_doc,$periode),	// D. DATA KEGIATAN PUBLIKASI ILMIAH
				'qE'	=> $this->P2kb->get_skp_kegiatan(6,$id_doc,$periode),	// E. DATA KEGIATAN PENGEMBANGAN KEILMUAN
				
				'nosurat'		=> $rreport->nosurat,
				'tglsurat'		=> $rreport->tglsurat,
				'periode'		=> $rreport->periode,
				'etika'			=> $rreport->etika,
				'keterangan'	=> $rreport->ket,
				'kesehatan'		=> $rreport->kesehatan,
				'hasil'			=> $rreport->hasil,				
				
				'arr_etika'		=> $this->arr_etika,
				'arr_kesehatan' => $this->arr_kesehatan,
				'arr_hasil'		=> $this->arr_hasil
				
			); 
			
			$html_template = $this->load->view('report-pdf', $pdf_data, true);
			//echo $html_template;
			pdf_create($html_template, $pdf_filename);
			
			/* or, if you want to write it to disk and/or send it as an attachment: */
			//$data = pdf_create($html, '', false);
			//write_file('name', $data);
		
		}else{ // no report found
			show_404();
			die();
		
		}			

	}
	  
	function create($id_doc){
		if (!is_numeric($id_doc) or empty($id_doc)) {
			show_404();
			die();
		}
		$this->load->helper('form');
	
		$this->Webpage->set_title('Create Reports');

		if (!empty($_POST)) {

			//save report
			$report_id = uniqid('r',true);
			$arr_insert_report = array (
				'id'		=> '',
				'rid'		=> $report_id,
				'id_doc'	=> $id_doc, 
				'gendate'	=> date('Y-m-d H:i'), 
				'nosurat'	=> $this->input->post('nosurat'), 
				'tglsurat'	=> $this->input->post('tglsurat'), 
				'periode'	=> $this->input->post('periode'), 
				'etika'		=> $this->input->post('etika'), 
				'ket'		=> $this->input->post('keterangan'), 
				'kesehatan'	=> $this->input->post('kesehatan'), 
				'hasil'		=> $this->input->post('hasil')		
			);
			$this->db->insert('reports', $arr_insert_report);
			
			redirect( site_url('reports/generate/'.$report_id) );
			
			//redirect( site_url('reports/'), 'refresh' );	
			
			
		}else{
			// get health certificates data :
			$js_arrPeriode 	= array();
			$js_arrCerts 	= array();
			$q = $this->P2kb->get_healthcerts($id_doc,0,'healthcert.tgl asc');
			if ( ($q !== false) && ($q->num_rows() > 0) ) {
				$i = 0;
				foreach ($q->result() as $row) { $i++; 
					$js_arrPeriode[] = $row->tgl.'|'.$row->tgl2;
					$js_arrCerts[] 	 = base_url().'media/'.$row->scanhealthcert;
				}
			}
		
			$this->data = array(
				'row'			=> $this->P2kb->get_userdoc($id_doc),
				'periodeOptions'=> $this->P2kb->get_periodecert_options($id_doc),
				'arr_etika'		=> $this->arr_etika,
				'arr_kesehatan'	=> $this->arr_kesehatan,
				'arr_hasil'		=> $this->arr_hasil,
				'js_arrPeriode'	=> $js_arrPeriode,
				'js_arrCerts'	=> $js_arrCerts,
			);
			$this->Webpage->content = $this->load->view('c/reports-generate',$this->data,TRUE);

			$this->Webpage->add_js(base_url().'js/jquery.validationEngine.js');
			$this->Webpage->add_js(base_url().'js/jquery.validationEngine-en.js');
			$this->Webpage->add_css(base_url().'css/validationEngine.jquery.css');
	
			$this->finalView();	
		
		}
	
	}
	
    
	
}

