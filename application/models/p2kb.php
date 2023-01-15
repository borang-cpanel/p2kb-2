<?php
class P2kb extends CI_Model {

    var $udata;
	var	$utype = array(
				'adm'	=> 'Admin',
				'doc'	=> 'Doctor',
				'kol'	=> 'Komisi P2KB'
			);
	var	$ustatus = array(
				'0'	=> 'Inactive',
				'1'	=> 'Active',
			);
	// kegiatan profesional
	var $arrKegPro = array(
				'PB' => 'Pasien Baru',
				'BK' => 'Brakhiterapi'
			);
	// score kegiatan profesional pertahun
	var $kegProScore = array (
				'PB' => array(	'100-149'	=> 5,
								'150-199'	=> 15,
								'200'		=> 25
							),
				'BK' => array(	'25-49'		=> 5,
								'50-74'		=> 15,
								'75-100'	=> 25,
								'100'		=> 25
							)
			);
	// Array jenis kanker
	var $arrKanker = array(	
							'serviks'	=> 'Kanker Serviks',
							'payudara'	=> 'Kanker Payudara',
							'nasofaring'=> 'Kanker Nasofaring',
							'otak'=>'Tumor Otak',
							'paru'=>'Kanker Paru dan Mediastinum',
							'kolorektal'=>'Kanker Kolorektal',
							'kepala-leher'=>'Kanker Kepala-Leher',
							'prostat'=>'Kanker Prostat',
							'limfoma'=>'Limfoma dan Keganasan Darah',
							'tiroid'=>'Kanker Tiroid',
							'muskuloskeletal'=>'Kanker Muskuloskeletal',
							'endometrium'=>'Kanker Endometrium',
							'kulit'=>'Kanker Kulit',
							'retinoblastoma'=>'Retinoblastoma',
							'buli'=>'Kanker Buli',
							'hepatocellular'=>'Hepatocellular Karsinoma',
							'kankers'	=> 'Kanker Lain-lain');
	
	var $optApproval = array (
		'0'	=> 'Pending',
		'1'	=> 'Approved',
		'2'	=> 'Rejected'
		);

    function P2kb() {
        parent::__construct();

    }
    
	function get_kategori($id) {
	
		$q = $this->db->query("select * from `kategori` where id='".$id."'");
		if ($q->num_rows()>0) {
			$r = $q->row_array();
			return $r;
		}else{
			return false;
		}
	}
	
	function get_kegiatan($id) {
	
		$q = $this->db->query("select * from `kegiatan` where id='".$id."'");
		if ($q->num_rows()>0) {
			$r = $q->row_array();
			return $r;
		}else{
			return false;
		}
	}
	
	function remove_kategori($id) {
	
		$q = $this->db->query("delete from `kategori` where id='".$id."'");
		$aff = $this->db->affected_rows();
		if ($aff) {
			$q = $this->db->query("delete from `kegiatan` where id_kat='".$id."'");
			return $aff;
		}else
			return 0;
	}
	
	function remove_kegiatan($id) {
	
		$q = $this->db->query("delete from `kegiatan` where id='".$id."'");
		$aff = $this->db->affected_rows();
		if ($aff) {
			return $aff;
		}else
			return 0;
	}
	
	function get_catlist($orderBy='id asc') {
	
		if (!empty($orderBy)) {
			$orderBy = 'order by '.$orderBy;
		}
		
		$q = $this->db->query("select * from `kategori` ".$orderBy);
		if ($q->num_rows()>0) {
			//$r = $q->row_array();
			return $q;
		}else{
			return false;
		}
	}
	
	function get_list_kegiatan($orderBy='id asc') {
		
		if (!empty($orderBy)) {
			$orderBy = 'order by '.$orderBy;
		}
		
		$q = $this->db->query("select b.*, a.jenis from kategori as a, kegiatan as b where a.id=b.id_kat ".$orderBy);
		if ($q->num_rows()>0) {
			return $q;
		}else{
			return false;
		}
		
	}
	
	//function get_kegiatan_list($orderBy='kategori.id asc, kegiatan.id asc') {
	function get_kegiatan_list($idCat,$orderBy='id asc') {
		$idCat = (int) $idCat;
		
		if (!empty($orderBy)) {
			$orderBy = 'order by '.$orderBy;
		}
		
		$q = $this->db->query("select * from kegiatan where id_kat='$idCat' ".$orderBy);
		if ($q->num_rows()>0) {
			return $q;
		}else{
			return false;
		}
		
	}
	
	function get_kategori_options($selected_id='',$orderBy='id asc') {
		$q = $this->get_catlist($orderBy);
		if ( ($q) && ($q->num_rows > 0)) {
			$arr_opt = array();
			$options = '';
			$group_label = ''; 
			$i=0;
			foreach($q->result_array() as $r) {
				$selected = '';
				if ($selected_id == $r['id']) {
					$selected = ' selected="selected"';
				}
				$arr_opt[] = '<option'.$selected.' value="'.$r['id'].'">'.$r['jenis'].'</option>';

			}
			
			$options = join('',$arr_opt);
			
			return $options;
			
		}

	}
	
	function get_kegiatan_options($idCat, $orderBy='id asc', $selected_id='') {
		$idCat = (int) $idCat;
	
		$q = $this->get_kegiatan_list($idCat, $orderBy);
		if ( ($q) && ($q->num_rows > 0)) {
			$arr_opt = array();
			$options = '';
			$group_label = ''; 
			$i=0;
			foreach($q->result_array() as $r) {
				/*
				$i++;
				if (!empty($group_label)) {
					if ($r['jenis'] !== $group_label){
						$options .= '<optgroup label="'.$group_label.'">'.join('',$arr_opt).'</optgroup>';
						$group_label = $r['jenis']; // change group label with new one
						$arr_opt = array(); // clear temp option array
					}
				}else{
					$group_label = $r['jenis'];
				}
				*/

				$selected = '';
				if ($selected_id == $r['id']) {
					$selected = ' selected="selected"';
				}
				$enable_skp = ($idCat !== 1) && preg_match("/sertifikat/i", $r['dokumen']) ? ' eskp="true"' : ' eskp="false"';
				$arr_opt[] = '<option'.$selected.' value="'.$r['id'].'" dokumen="'.$r['dokumen'].'" skpmax="'.$r['skpmax'].'"'.$enable_skp.'>'.$r['kegiatan'].'</option>';

			}
			
			// check remaining ungrouped options
			if (count($arr_opt) > 0) {
				//$options .= '<optgroup label="'.$group_label.'">'.join('',$arr_opt).'</optgroup>';
			}
			
			$options = join('',$arr_opt);
			
			return $options;
			
		}

	}
	
	function get_kegiatan_skp($idKegiatan) {
		$idKegiatan = (int) $idKegiatan;
		$q = $this->db->query("select skpmax from `kegiatan` where id='".$idKegiatan."'");
		if ($q->num_rows()>0) {
			$r = $q->row_array();
			return $r['skpmax'];
		}else{
			return 0;
		}
	
	}
	
	function get_kegiatandoc_list($idCat, $limit='',$orderBy=' kd.acv, kd.id DESC '){
		if (!empty($limit)) {
			$limit = 'limit '.$limit;
		}
		if (!empty($orderBy)) {
			$orderBy = 'order by '.$orderBy;
		}
		$sql_cond = '';
		if ($this->udata['tipe'] == 'doc') {
			$sql_cond = "and d.id='".$this->udata['id']."' ";
		}
		
		$q = 	"select *, date_format(tgl,'%e %M %Y') as tanggal, date_format(tgl2,'%e %M %Y') as tanggal2 ".
				"from userdoc as d, kategori as c, kegiatan as kg, kegiatandoc as kd ".
				"where d.id = kd.id_doc and kg.id=kd.id_keg and (c.id = kg.id_kat) and c.id ='".$idCat."' ".$sql_cond.$orderBy." ".$limit;
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			return $q;
		}else{
			return false;
		}
	}
	
	
	// get users total
	function get_users_total() {
		$q = $this->db->query("select count(id) as total from `userdoc`");
		if ($q->num_rows()>0) {
			$r = $q->row_array();
			return $r['total'];
		}else{
			return 0;
		}
	}
	
	// get users list
	function get_users($limit=0,$orderBy='') {
		if (!empty($limit) and $limit != 0) {
			$limit = 'limit '.$limit;
		}else {
			$limit = '';
		}
		if (!empty($orderBy)) {
			$orderBy = 'order by '.$orderBy;
		}
		
		$q = $this->db->query("select * from `userdoc` ".$orderBy." ".$limit);
		if ($q->num_rows()>0) {
			//$r = $q->row_array();
			return $q;
		}else{
			return false;
		}
	}
	
	// get sertifikat kesehatan 
	function get_healthcerts($id_doc='',$limit=0,$orderBy='') {
		if (!empty($limit)) {
			$limit = 'limit '.$limit;
		}else{
			$limit = '';
		}
		if (!empty($orderBy)) {
			$orderBy = 'order by '.$orderBy;
		}
		$sql_cond = '';
		if (!empty($id_doc)) {
			$sql_cond = "where userdoc.id='".$id_doc."' ";
		}
		
		$q = "select userdoc.*, healthcert.* from healthcert left join userdoc on healthcert.id_doc = userdoc.id ".$sql_cond." ".$orderBy." ".$limit;
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			return $q;
		}else{
			return false;
		}
	}
	
	// get doctors total
	function get_doctors_total() {
		$q = $this->db->query("select count(id) as total from `userdoc` where tipe='doc'");
		if ($q->num_rows()>0) {
			$r = $q->row_array();
			return $r['total'];
		}else{
			return 0;
		}
	}
	
	// get doctors list
	function get_doctors($limit=10,$orderBy='') {
		if (!empty($limit)) {
			$limit = 'limit '.$limit;
		}else{
			$limit = '';
		}
		if (!empty($orderBy)) {
			$orderBy = 'order by '.$orderBy;
		}
		
		$q = $this->db->query("select * from `userdoc` where tipe='doc' ".$orderBy." ".$limit);
		if ($q->num_rows()>0) {
			//$r = $q->row_array();
			return $q;
		}else{
			return false;
		}
	}
	
	function get_arrDoctors(){
		$arrDoctors = array();
		$q = $this->get_doctors(0,'nama');
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$arrDoctors["".$row->id.""] = $row->nama;
			}
		}
		return $arrDoctors;
	}
	
		
	// get user row detail
	function get_userdoc($id_doc){
		$q = "select * from userdoc where id='$id_doc' limit 1";
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			$r = $q->row();
			return $r;
		}else{
			return false;
		}
	}
	
	// remove user row data
	function remove_userdoc($id_doc){
		$q = "delete from userdoc where id='$id_doc' limit 1";
		$q = $this->db->query($q);
		$aff = $this->db->affected_rows();
		if ($aff) {
			$q = "delete from kegiatandoc where id_doc='$id_doc'";
			return $aff;
		}else{
			return false;
		}
	}
	
	
	
	// get periode kegiatan profesional
	function get_periode_options($uid,$dateSelected='') {
		//$uid = $this->udata['id'];
		$q = "select regstart from userdoc where id='$uid'";
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			$r = $q->row();
			$dateStart = $r->regstart;
			if (empty($dateStart) || ($dateStart=='0000-00-00') ) {
				return false;
				//die('Gagal menghitung periode kegiatan! Silakan periksa tanggal mulai (Surat Registrasi) registrasi dokter!');
			}
		}

		if (empty($dateSelected)) {
		}
		list ($Y,$m,$d) = explode('-',$dateStart);
		$cY = date('Y'); 
			
		$options= '';
		
		//Kita sertakan satu periode sebelumnya (jadi plus 5 tahun)
		$Y = $Y-5;
		
		for ($i=0;$cY >= ($Y+$i);$i++) {
			//$options = $dateStart .' - '.date('Y-m-d',mktime(0, 0, 0, $m, $d, $Y+1));
			$optValue = date('Y-m-d',mktime(0, 0, 0, $m, $d, $Y+$i)) .'|'. date('Y-m-d',mktime(0, 0, 0, $m, $d-1, $Y+$i+1));
			$optLabel = date('d/m/Y',mktime(0, 0, 0, $m, $d, $Y+$i)) .' - '. date('d/m/Y',mktime(0, 0, 0, $m, $d-1, $Y+$i+1));

			$sel = '';
			$selected	= $dateSelected;
			if ($selected == $optValue) $sel = ' selected="selected"';

			$options .= '<option value="'.$optValue.'"'.$sel.'>'.$optLabel.'</option>';
		}
		
		return $options;
	}
	
	// get periode sertifikasi
	function get_periodecert_options($uid,$dateSelected='') {
		//$uid = $this->udata['id'];
		$q = "select regstart from userdoc where id='$uid'";
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			$r = $q->row();
			$dateStart = $r->regstart;
			if (empty($dateStart) || ($dateStart=='0000-00-00') ) {
				return false;
				//die('Gagal menghitung periode kegiatan! Silakan periksa tanggal mulai (Surat Registrasi) registrasi dokter!');
			}
		}

		if (empty($dateSelected)) {
		}
		list ($Y,$m,$d) = explode('-',$dateStart);
		
		$iY = date('Y');
		$options= '';

		//Kita mulai dari 5 tahun sebelum dia registrasi
		$Y = $Y-5;
		$dateStart = date('Y-m-d', strtotime($dateStart.' -5 year - 1 day'));
		
		//Looping dari tahun lalu sampai sekarang
		for ($i=$Y;$i<=$iY;$i=$i+5) {
			if (!isset($period_start)) {
				$period_start 	= strtotime($dateStart);
			}
			$period_end 	= strtotime("+5 year -1 day", $period_start);

			$optValue = date('Y-m-d', $period_start ) .'|'. date('Y-m-d', $period_end );
			$optLabel = date('d/m/Y', $period_start ) .' - '. date('d/m/Y', $period_end );
			
			$period_start =  strtotime("+1 day",$period_end);

			$sel = '';
			$selected	= $dateSelected;
			if ($selected == $optValue) $sel = ' selected="selected"';

			$options .= '<option value="'.$optValue.'"'.$sel.'>'.$optLabel.'</option>';
		}
		
		return $options;
	}
	
	function get_kegpro_options($selected='') {
		
		$options = '';
		foreach( $this->arrKegPro as $v => $l ) {
			$sel = '';
			if ($v == $selected) $sel = ' selected="selected"';
			$options = '<option value="'.$v.'".'.$sel.'>'.$l.'</option>';
		}
		return $options;
	}

	function is_kegiatan_customskp($idKegiatan) {
		$idKegiatan = (int) $idKegiatan;
		$q = $this->db->query("select id_kat, kegiatan, dokumen from `kegiatan` where id='".$idKegiatan."'");
		if ($q->num_rows()>0) {
			$r = $q->row_array();
			if ( ($r['id_kat'] != '1') && preg_match("/sertifikat/i", $r['dokumen']) ){
				return true;
			} else
				return false;
		}else{
			return false;
		}
	
	}
	
	function get_skp_terkumpul($id_doc='',$periode) {
		if (empty($id_doc)) {
			$id_doc = $this->udata['id'];
		}
		list ($periode_start, $periode_end) = explode('|',$periode);
		$r = array();
		$q = 'select kategori.*, sum(kegiatan.skpmax) as skp from kategori left join kegiatan on kegiatan.id_kat = kategori.id group by kategori.id';
		$q = "select id, jenis, skp from kategori";
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			foreach($q->result() as $row) {
				$q2 = "select kegiatan.id_kat, kegiatandoc.id_doc, if (isnull(sum(kegiatandoc.skp)), 0, sum(kegiatandoc.skp)) as skp_doc ".
							"from kegiatan left join kegiatandoc on kegiatandoc.id_keg = kegiatan.id ".
							"where kegiatandoc.id_doc='".$id_doc."' and kegiatandoc.acv=1 and kegiatan.id_kat = '".$row->id."' ".
									"and ( (tgl BETWEEN '$periode_start' AND '$periode_end') or (tgl2 BETWEEN '$periode_start' AND '$periode_end')) ";
				//echo $q2.'<br>';
				$q2 = $this->db->query($q2);
				if ($q2->num_rows()>0) {
					$rsub = $q2->row_array();
//				}else{
//					$rsub['skp_doc'] = 0;
				}
				$r[] = array('id'=>$row->id, 'jenis'=>$row->jenis, 'skp'=>$row->skp,'skp_doc'=>$rsub['skp_doc']);
			}
		}
		return $r;
	}
	
	// get skp list for report
	function get_skp_kegiatan($id_kat,$id_doc,$periode) {
		list ($periode_start, $periode_end) = explode('|',$periode);
		$q2 = "select kegiatan.id, kegiatan.id_kat, kegiatan.kegiatan, kegiatan.skpmax, kegiatandoc.id_doc, sum(kegiatandoc.skp) as skp_doc, kegiatandoc.acv   ".
					"from kegiatan left join kegiatandoc on kegiatandoc.id_doc='$id_doc' and kegiatandoc.acv='1' and kegiatan.id = kegiatandoc.id_keg and ( (kegiatandoc.tgl BETWEEN '$periode_start' AND '$periode_end') or (kegiatandoc.tgl2 BETWEEN '$periode_start' AND '$periode_end')) ".
					"where kegiatan.id_kat = '".$id_kat."' group by kegiatan.id";

		$q2 = $this->db->query($q2); //echo $this->db->last_query().'<br><br>';
		if ($q2->num_rows()>0) {
			return $q2;
		}else{
			return false;
		}
	}
	
	function get_aktiftas_for_kolegum() {
		$r = array();
		$q = "select id, jenis, skp from kategori";
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			foreach($q->result() as $row) {
				$q2 = "select kegiatan.id_kat, kegiatandoc.id_doc, ".
							"sum(case when kegiatandoc.acv = 0 then 1 else 0 end) as act_0, ".
							"sum(case when kegiatandoc.acv = 1 then 1 else 0 end) as act_1, ".
							"sum(case when kegiatandoc.acv = 2 then 1 else 0 end) as act_2, ".
							"sum(case when NOT ISNULL(kegiatandoc.acv) then 1 else 0 end) as act_tot ".
							//"count(kegiatan.id) as act_tot ".
							"from kegiatan left join kegiatandoc on kegiatandoc.id_keg = kegiatan.id ".
							"where kegiatan.id_kat = '".$row->id."'";
				$q2 = $this->db->query($q2);
				if ($q2->num_rows()>0) {
					$rsub = $q2->row_array();
//				}else{
//					$rsub['skp_doc'] = 0;
				}
				$r[] = array('id'=>$row->id, 'jenis'=>$row->jenis, 'skp'=>$row->skp,'act_0'=>$rsub['act_0'],'act_1'=>$rsub['act_1'],'act_2'=>$rsub['act_2'],'act_tot'=>$rsub['act_tot']);
			}
		}
		return $r;
	}
	
	// calculate skp kegiatan profesional
	function calc_skppro($idKegiatan, $tot) {
		$jenis = $idKegiatan;

        $skp = 0;
		if ($jenis == 20) { // Eksterna 2D
			if ( $tot >= 201 ) {
				$skp = 25;
			} else if ($tot >= 151)  {
				$skp = 15;
			} else if ( $tot >=100) {
				$skp = 5;
			} else if ($tot >0) {
			    $skp = 3;
			}
		}else if ($jenis == 21) { // Brakhiterapi 2D
			if ( $tot >= 76 ) {
				$skp = 25; 
			} else if ( $tot >= 51 ) {
				$skp = 15;
			} else if ( $tot >=25 ) {
				$skp = 5;
			} else if ( $tot>0 ) {
				$skp = 3;
			} 
		}else if($jenis == 74){ //eksterna 3d
		    if ($tot >= 126){
		        $skp = 30;
		    }else if ($tot >= 101){
		        $skp = 25;
		    }else if ($tot >=76){
		        $skp = 20;
		    }else if ($tot >= 50){
		        $skp = 15;
		    }else if ($tot >0){
		        $skp = 5;
		    }
		}else if($jenis == 75){//eksterna imrt
		    if ($tot >= 76){
		        $skp = 35;
		    }else if ($tot >= 51){
		        $skp = 30;
		    }else if ($tot >=76){
		        $skp = 20;
		    }else if ($tot >= 25){
		        $skp = 25;
		    }else if ($tot>=0){
		        $skp = 20;
		    }
		}else if ($jenis==76){//eksterna srs/irts
		    if ($tot >= 16){
		        $skp = 45;
		    }else if ($tot >= 11){
		        $skp = 40;
		    }else if ($tot >=5){
		        $skp = 35;
		    }else if ($tot >= 0){
		        $skp = 25;
		    }
		}else if ($jenis == 77){//brakhi 3d
		    if ($tot >= 41){
		        $skp = 30;
		    }else if ($tot >= 30){
		        $skp = 25;
		    }else if ($tot >=20){
		        $skp = 20;
		    }else if ($tot >= 10){
		        $skp = 15;
		    }else if ($tot>=0){
		        $skp = 10;
		    }
		}else if($jenis == 78){//nasofaring
		    if ($tot >= 9){
		        $skp = 20;
		    }else if ($tot >= 6){
		        $skp = 15;
		    }else if ($tot >=3){
		        $skp = 10;
		    }else if ($tot >= 0){
		        $skp = 5;
		    }
		}
		return $skp;
	}
	
	function get_kegiatandoc($id) {
		$sql_cond = '';
		if ($this->udata['tipe'] == 'doc') {
			$id_doc 	= $this->udata['id'];
			$sql_cond 	= "kegiatandoc.id_doc='$id_doc' and "; 
		}
		$q = "select * from userdoc, kegiatandoc where $sql_cond kegiatandoc.id_doc = userdoc.id and kegiatandoc.id='$id' limit 1";
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			$r = $q->row();
			return $r;
		}else{
			return false;
		}
	
	}
	
	/**
	 * Mengecek apakah dokter bersangkutan profile-nya sudah complete atau belum.
	 * @param int $id_doc id dari dokter yang ingin dicek
	 */
	function is_profile_complete($id_doc)
	{
		$q = "select completed from userdoc where id = '$id_doc'";
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			$r = $q->row();
			return $r->completed ==1; //return true saat nilai completed =1 
		}else{
			return false;
		}
	}
	
	/* get certificates row */ 
	function get_reports($id_doc='',$limit=0,$orderBy='') {
		if (!empty($limit)) {
			$limit = 'limit '.$limit;
		}else{
			$limit = '';
		}
		if (!empty($orderBy)) {
			$orderBy = 'order by '.$orderBy;
		}
		$sql_cond = '';
		if (!empty($id_doc)) {
			$sql_cond = "where userdoc.id='".$id_doc."' ";
		}
		
		$q = "select userdoc.*, reports.* from reports left join userdoc on reports.id_doc = userdoc.id ".$sql_cond." ".$orderBy." ".$limit;
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			return $q;
		}else{
			return false;
		}
	}

	function get_report($id_report) {
		$sql_cond = '';
		if ($this->udata['tipe'] == 'doc') {
			$id_doc 	= $this->udata['id'];
			$sql_cond 	= "reports.id_doc='$id_doc' and "; 
		}
		$q = "select * from userdoc, reports where $sql_cond reports.id_doc = userdoc.id and reports.rid='$id_report' limit 1";
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			$r = $q->row();
			return $r;
		}else{
			return false;
		}
	
	}
	
	function remove_report($id_report){
		$q = "delete from reports where rid='$id_report' limit 1";
		$q = $this->db->query($q);
		$aff = $this->db->affected_rows();
		if ($aff) {
			return $aff;
		}else{
			return false;
		}
	}
	
	
	
	/* get health certificate row */ 
	function get_healthcert($id) {
		$sql_cond = '';
		if ($this->udata['tipe'] == 'doc') {
			$id_doc 	= $this->udata['id'];
			$sql_cond 	= "healthcert.id_doc='$id_doc' and "; 
		}
		$q = "select * from userdoc, healthcert where $sql_cond healthcert.id_doc = userdoc.id and healthcert.id='$id' limit 1";
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			$r = $q->row();
			return $r;
		}else{
			return false;
		}
	
	}
	
	function remove_kegiatandoc($id) {
		$sql_cond = '';
		if ($this->udata['tipe'] == 'doc') {
			$id_doc 	= $this->udata['id'];
			$sql_cond 	= "id_doc='$id_doc' and "; 
		}
		
		$is_deleted = $this->delete_kegiatandoc_att($id);
		
		$q = "delete from kegiatandoc where $sql_cond id='$id' and acv != '1' limit 1";
		$q = $this->db->query($q);
		$aff = $this->db->affected_rows();

		return $aff;
	}
	
	function delete_kegiatandoc_att($id) {
		$sql_cond = '';
		if ($this->udata['tipe'] == 'doc') {
			$id_doc 	= $this->udata['id'];
			$sql_cond 	= "id_doc='$id_doc' and "; 
		}
		$q = "select id, dokumen from kegiatandoc where $sql_cond id='$id' limit 1";
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			$r = $q->row();
			if ($r->dokumen) {
				return @unlink('./media/'.$r->dokumen);
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	/* delete sertifikat kesehatan data row*/
	function remove_healthcert($id) {
		$sql_cond = '';
		if ($this->udata['tipe'] == 'doc') {
			$id_doc 	= $this->udata['id'];
			$sql_cond 	= "id_doc='$id_doc' and "; 
		}
		
		$is_deleted = $this->delete_healthcert_att($id);
		
		$q = "delete from healthcert where $sql_cond id='$id' limit 1";
		$q = $this->db->query($q);
		$aff = $this->db->affected_rows();

		return $aff;
	}
	
	/* physically delete FILE sertifikat kesehatan */
	function delete_healthcert_att($id) {
		$sql_cond = '';
		if ($this->udata['tipe'] == 'doc') {
			$id_doc 	= $this->udata['id'];
			$sql_cond 	= "id_doc='$id_doc' and "; 
		}
		$q = "select id, scanhealthcert from healthcert where $sql_cond id='$id' limit 1";
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			$r = $q->row();
			if ($r->scanhealthcert) {
				return @unlink('./media/'.$r->scanhealthcert);
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function delete_userdoc_att($mode, $id_doc) {
		$q = "select id, regscan, foto from userdoc where id='$id_doc' limit 1";
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			$r = $q->row_array();
			if ($r[$mode]) {
				return @unlink('./media/'.$r[$mode]);
			}else{
				return false;
			}
		}else{
			return false;
		}
	
	}

	// messaging 
	function count_unread_messages($id_doc) {
		if ($this->P2kb->udata['tipe'] == 'adm') {
			$q = $this->db->query("select count(id) as unread from `messages` where receipt='0' and st=0");
		}else{
			$q = $this->db->query("select count(id) as unread from `messages` where receipt='$id_doc' and st=0");
		}
		if ($q->num_rows()>0) {
			$r = $q->result();
			return $r[0]->unread;
		}else{
			return false;
		}
	}

	function get_messages($id_doc) {
		if ($this->P2kb->udata['tipe'] == 'adm') {
			$q = $this->db->query("select *, date_format(mdate,'%e %M %Y - %H:%I') as tanggal from userdoc, `messages` where messages.sender=userdoc.id order by mdate desc ");
		}else{
			$q = $this->db->query("select *, date_format(mdate,'%e %M %Y - %H:%I') as tanggal from `messages` where sender='$id_doc' or receipt='$id_doc' order by mdate desc ");
		}
		if ($q->num_rows()>0) {
			return $q;
		}else{
			return false;
		}
	}

	function read_message($id_doc, $id) {
		$sql_cond = '';
		$id_doc = $this->udata['id'];
		if ($this->udata['tipe'] != 'adm') {
			$sql_cond = "(sender='$id_doc' or receipt='$id_doc') and";
		}
		$q = "select *, date_format(mdate,'%e %M %Y - %H:%I:%S') as tanggal from `messages` where $sql_cond id='$id' limit 1";
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			$r = $q->row();
			// update read status
			if ( (($this->udata['tipe'] == 'adm') && empty($r->receipt)) // admin
				or ($r->receipt == $this->udata['id']) // user
				) {
				$qu = $this->db->update( 'messages', array('st' => 1), array('id' => $id) );
			}				
			return $r;
		}else{
			return false;
		}
	
	}
	
	/**
	 * Fungsi menapmilkan dokter yang 1,5 tahun lagi akan habis STR-nya
	 */
	public function get_almost_expire_user($day=540)
	{
		//Batas hari adalah 1,5 tahun, yang berarti kurang lebih 540 hari.
		
		$q = "select * from userdoc where datediff(regend, NOW()) = $day";
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			return $q;
		}
		
		return false;
	}
	
	public function is_almost_expire_user($id, $day=540){
	    $q = "select * from userdoc where id = $id AND datediff(regend, NOW()) <= $day";
		$q = $this->db->query($q);
		if ($q->num_rows()>0) {
			return true;
		}
		
		return false;
	}
    
    function get_email($id) {
	
		$q = $this->db->query("select * from userdoc where id='".$id."'");
		if ($q->num_rows()>0) {
			$r = $q->row_array();
			return $r;
		}else{
			return false;
		}
	}

}