<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function ok(){
	$CI =& get_instance();
	return $CI->config->slash_item('base_url');
}

function p2kb_get_sidebar($sidebar,$posisi){	
	if ( isset($sidebar) && isset($sidebar[$posisi]) ){
		foreach ($sidebar[$posisi] as $v): 
			echo $v;
		endforeach;
	}
}

function setPermalink($input){
	return $input;
}

function currentURL(){
	$lurl = base_url().substr(uri_string(),1);
	return $lurl;
}
function getOutputByLang($data='',$publiclanguage = 'id'){	
	#global $_SESSION;
	
	if (is_array($data))
		$x = $data;
	else
		$x = unserialize($data);
	
	
	$bahasa = $publiclanguage;
	 
	if (!isset($x[$bahasa]))	
		return $x['id'];
	return $x[$bahasa];
}


function pre($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function getBrowser(){
echo $_SERVER['HTTP_USER_AGENT'];
}


/*
 * olah data serialize
 */
function olahDataSerialize($data, $bahasa, $datapembanding='', $newlang=''){	
	if ($datapembanding != ''){
		$dp = unserialize($datapembanding);
		$dp[$newlang] = $data;
	}else{
		foreach ($bahasa as $k=>$v):
			$dp[$k] = $data;
		endforeach;
	}
	
	$data = serialize($dp);
	return $data;
}

function waktuSekarang($hari=0,$bulan=0,$tahun=0, $jam=0,$menit=0,$detik=0){
	$waktu = mktime(date("H")+$jam, date("i")+$menit, date("s")+$detik, date("m")+$bulan  , date("d")+$hari, date("Y")+$tahun);	
	return date('Y-m-d H:i:s', $waktu);
}

function htmlLanguage($arr,$xx){	
	$rrr = explode('/',uri_string());

	
	foreach ($arr as $k=>$v){
		$vowels[] = "/{$k}";
	}
   
    $lurl = base_url().index_page()."/".substr(uri_string(),1);
    $s = "<ul>\n";
	foreach ($arr as $k=>$v){
	  
		$onlyconsonants = str_replace($vowels, "/{$k}", $lurl);		
		if (isset($rrr[$xx]) && $rrr[$xx] == $k){
			$s .= "<li>{$v}</li>\n";
		}else{
		    
			$s .= "<li><a href=\"{$onlyconsonants}\" title=\"{$v}\">{$v}</a></li>\n";
		}
	}
	$s .= "</ul>\n";
	
	return $s;	
}

/*
 * HTML FORM function 
 * gunakan untuk output berupa element form dengan data tertentu
 */
function htmlLabel($id,$label,$params=''){
	$param = ($params!='' ? ' '.$params:'');
	$s = "<label for=\"{$id}\"{$param}>{$label}</label>";
	return $s;
}

function htmlSelect($name,$data,$terpilih='',$params=''){
	$param = ($params!='' ? ' '.$params:'');
		
	$s = "<select name=\"{$name}\" id=\"{$name}\"{$param}>\n";
	foreach ($data as $k=>$v):
		$selected=($terpilih==$k ? " selected=\"selected\"" :'');
		$s.= "	<option value=\"{$k}\"{$selected}>{$v}</option>\n";
	endforeach;
	$s .= "</select>";
	return $s;
}

function htmlDateSelector($name,$data='',$delimeter=' - ',$thnmulai=1900, $thnakhir=0 ,$params=''){	
	#echo $data;
	if ( $data != '' ){
		$waktu = explode('-',$data);
		#pre($waktu);
		$dTglTerpilih = $waktu[2];
		$dBlnTerpilih = $waktu[1];
		$dThnTerpilih = $waktu[0];
		//$dTglTerpilih = date('d');
	}else{
		$dTglTerpilih = date('d');
		$dBlnTerpilih = date('m');
		$dThnTerpilih = date('Y');
	}
	
	$variabelbulan['en'] = array(1=>'Jan','Feb','Marc','Apr','May','Jun','Jul','Aug','Sep','Okt','Nov','Dec');
	$variabelbulan['id'] = array(1=>'Feb','Mar','Marc','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des');

	if ($data == '0000-00-00'){
		$variabelbulan['en'][0] = '-';
		$variabelbulan['id'][0] = '-';
		$dTgl['00'] = '-';
		$dBln['00'] = '-';
		$dThn['00'] = '-';
	}	
	
	#pre($dTgl);
	$bahasa = (!isset($_SESSION['outputbahasa']) || $_SESSION['outputbahasa']=='' ? 'id' : $_SESSION['outputbahasa']);
	
	for ($i=1;$i<=31;$i++){
		$sTgl = (strlen($i)==1 ? '0'.$i : $i);
		$dTgl[$sTgl] = $sTgl; 
	}	
	#pre($dTgl);
	$namaTgl = 'tgl_'.$name;
	// build tanggal selector
	$s = htmlSelect($namaTgl, $dTgl, $dTglTerpilih);
	
	for ($i=1;$i<=12;$i++){
		$aBln= (strlen($i)==1 ? '0'.$i : $i);
		$dBln[$aBln] = $variabelbulan[$bahasa][$i]; 
	}
	$s .= $delimeter;
	$namaBln= 'bln_'.$name;
	// build bulan selector
	$s .= htmlSelect($namaBln, $dBln, $dBlnTerpilih);
	
	$akhir = date('Y')+$thnakhir;
	for ($i=$thnmulai; $i<=$akhir; $i++){
		$dThn[$i] = $i;
	}
	$s .= $delimeter;
	$namaThn = 'thn_'.$name;	
	// build tahun selector
	$s .= htmlSelect($namaThn, $dThn, $dThnTerpilih);
	
	return $s;
}


function showIcon($path,$icon){
	$ico = $path."icon/ico".$icon.".png";
	return $ico;
}

function getIconType($file){
	if ( is_file("/media/$file") ){
		echo "file ada";
	}
}

function GetDataCombo($key,$value,$query){
		foreach ($query->result() as $row):
		$x=$row->$key;
			$r["$x"] = $row->$value;
		endforeach;
        return $r;
    }
    

if (!function_exists('setTanggal'))
	{
	function setTanggal($tanggal) {
		  $bln=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
			'September','Oktober','November','Desember');	
		  $tlen = sizeof($bln);  
		  $tgl=explode('-',$tanggal);
		  for ($t=0;$t<$tlen;$t++) {
			 if ($tgl[1]==$t+1) $tgl[1]=$bln[$t];
		  }
		  $tanggal=$tgl[2].' '.$tgl[1].' '.$tgl[0];
		  return $tanggal;
	}
}



 function konversiTgl($tanggal) 
	{
		list($thn,$bln,$tgl)=explode('-',$tanggal);
		$tmp = $tgl."-".$bln."-".$thn;
		return $tmp;
	}

function konversiBulan($bln) {
	switch($bln) {
		case "01": $bulan="Januari"; break;
		case "02": $bulan="Februari"; break;
		case "03": $bulan="Maret"; break;
		case "04": $bulan="April"; break;
		case "05": $bulan="Mei"; break;
		case "06": $bulan="Juni"; break;
		case "07": $bulan="Juli"; break;
		case "08": $bulan="Agustus"; break;
		case "09": $bulan="September"; break;
		case "10": $bulan="Oktober"; break;
		case "11": $bulan="Nopember"; break;
		case "12": $bulan="Desember"; break;
		default  : $bulan="Tidak Boleh";
	}
	return $bulan;
}

function konversiTanggal($tanggal) 
{
	list($thn,$bln,$tgl)=explode('-',$tanggal);
	$tmp = $tgl." ".konversiBulan($bln)." ".$thn;
	return $tmp;
}    


function seojudul($judul)
{
	$vowels = array("/","(",")","'","`","~",",",".","!","@","[","]","%","$","!","{","}","<",">","");
	$op = str_replace($vowels, "-", $judul);

	return $op;
}

function Harus(){
	echo "&nbsp;<img src='".base_url()."images/checked.gif"."' />";
}

function judulApplikasi(){
	echo "";
}

function format_the_date($data, $format='j F Y', $empty_str='-') {
	return $data != '0000-00-00' && !empty($data) ? date($format,strtotime($data)) : $empty_str;
}

function gelar_dokter($nama, $string_gelar) {
	$arr_gelar		= explode('|',$string_gelar);
	$gelar_lain 	= '';
	$gelar_awal 	= '';
	$gelar_akhir 	= '';
	$arrGelarLain 	= array();
	$arrGelarAwal 	= array('Profesor' => 'Prof.','Doktor/PhD'=> 'DR.');
	$arrGelarAkhir 	= array('Dokter Onk.Rad'=>'Sp.Onk.Rad','Konsultan/Spesialis'=>'SpRad(K)OnkRad');
	
	$arrGelar = array_merge($arrGelarAwal, $arrGelarAkhir);
	foreach ($arr_gelar as $x => $gelar) {
		if (!in_array( ucwords( $gelar ), array_keys($arrGelar)) && !in_array( ucwords( $gelar ), array_values($arrGelar))) {
			$arrGelarLain[] = $gelar;
		}
	}
	
	foreach($arrGelarAwal as $label => $gelar) {
		if (in_array($label,$arr_gelar)) {
			$gelar_awal .= $gelar.' ';
		}
	}

	if (in_array('Konsultan/Spesialis',$arr_gelar)) {
		$gelar_akhir = ', '.$arrGelarAkhir['Konsultan/Spesialis'];
	}elseif (in_array('Dokter Onk.Rad',$arr_gelar)) {
		$gelar_akhir = ', '.$arrGelarAkhir['Dokter Onk.Rad'];
	}else{
	}

	$gelar_lain = join(', ',$arrGelarLain);
	$nama_akademik = $gelar_awal
					 .'Dr. '
					 .$gelar_lain
					 .' '
					 .$nama
					 .' '
					 .$gelar_akhir;
	
	$nama_gelar = $gelar_awal.'Dr. '.$nama.$gelar_akhir;
	
	return $nama_akademik;
}

function gelar_akademik($string_gelar) {
	$arr_gelar		= explode('|',$string_gelar);
	$gelar_lain 	= '';
	$gelar_awal 	= '';
	$gelar_akhir 	= '';
	$arrGelarLain 	= array();
	$arrGelarAwal 	= array('Profesor' => 'Prof.','Doktor/PhD'=> 'DR.');
	$arrGelarAkhir 	= array('Dokter Onk.Rad'=>'Sp.Onk.Rad','Konsultan/Spesialis'=>'SpRad(K)OnkRad');
	
	$arrGelar = array_merge($arrGelarAwal, $arrGelarAkhir);
	foreach ($arr_gelar as $x => $gelar) {
		if (!in_array( ucwords( $gelar ), array_keys($arrGelar)) && !in_array( ucwords( $gelar ), array_values($arrGelar))) {
			$arrGelarLain[] = $gelar;
		}
	}
	
	foreach($arrGelarAwal as $label => $gelar) {
		if (in_array($label,$arr_gelar)) {
			$gelar_awal .= $gelar.' ';
		}
	}

	if (in_array('Konsultan/Spesialis',$arr_gelar)) {
		$gelar_akhir = ', '.$arrGelarAkhir['Konsultan/Spesialis'];
	}elseif (in_array('Dokter Onk.Rad',$arr_gelar)) {
		$gelar_akhir = ', '.$arrGelarAkhir['Dokter Onk.Rad'];
	}else{
	}
	
	$gelar_lain = join(', ',$arrGelarLain);
	$nama_akademik = $gelar_awal
					 .'Dr. '
					 .$gelar_lain
					 .' '
					 .$gelar_akhir;
	
	return $nama_akademik;
}

