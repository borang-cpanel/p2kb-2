<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Common Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/email_helper.html
 */

// ------------------------------------------------------------------------


// SEO tools
// sapta7@gmail.com | imajiku.com Feb 8,2010

function set_breadcrumb($arr){
	$breadcrumb = '';
	if (!is_array($arr)) return false;
	foreach($arr as $dlabel => $anarray){ //echo $dlabel. ' ';
		list ($slug,$label) = explode('|',$dlabel);
		$breadcrumb = '<li>'.anchor($slug,$label,'title="'.$label.'"').'<li>';
		if (is_array($anarray))
			$breadcrumb .= set_breadcrumb($anarray);
	}
	if ($breadcrumb) $breadcrumb = '<ul>'.$breadcrumb.'</ul>';
	
	return $breadcrumb;
}

/**
 * Create recursively a nested HTML UL of array keys.(deprecated)
 * @param array $array Array
 * @return string Nested UL string
 */
function aray2breadcrumb($array=array(),&$depth=0) {
	$depth++; //echo $depth.' ';
	$recursion=__FUNCTION__;
	if (empty($array)) return '';
	$out=($depth==1)?('<ul id="breadcrumb">'):('<ul>')."\n";
	if (is_array($array))
		foreach ($array as $key => $elem){
			$arr = explode('|',$key); //echo $label;
			if (!isset($arr[1]))
				$uri = ''.$arr[0].'';			
			else
				$uri = anchor($arr[0], $arr[1], 'title="'.$arr[1].'"');
			if ($uri=='0') $uri='';
			$out .= '<li>'.$uri.$recursion($elem,$depth).'</li>'."\n";
		}
	else
		return $array;
	$out .= '</ul>'."\n";  
	return $out;
}

/**
 * Create recursively a nested HTML UL of array keys.
 * @param array $array Array
 * @return string Nested UL string
 */
function array2breadcrumb($array=array(),&$depth=0) {
	$depth++; //echo $depth.' ';
	$recursion=__FUNCTION__;
	if (empty($array)) return '';
	$out=($depth==1)?('<ul id="breadcrumb">'):('<ul>')."\n";
	if (is_array($array))
		foreach ($array as $key => $elem){
			$arr = explode('|',$key); //print_r($arr); //=> [URI , label]
			if (!isset($arr[1]))
				$uri = ''.$arr[0].'';
			else
				$uri = anchor($arr[0] , $arr[1].' &raquo;', 'title="'.$arr[1].'"');
			if ($uri=='0') $uri='';
			$out .= '<li>'.$uri.$recursion($elem,$depth).'</li>'."\n";
		}
	else
		return $array;
	$out .= '</ul>'."\n";
	return $out;
}



function title2keywords($str_title,$idlang='id') {
	// http://yudiwbs.wordpress.com/2008/07/23/stop-words-untuk-bahasa-indonesia/
	// http://fpmipa.upi.edu/staff/yudi/stop_words_list.txt
	$stopword['id'] = 'yang di dan itu dengan untuk tidak ini dari dalam akan pada juga saya ke karena tersebut bisa ada mereka lebih kata tahun sudah atau saat oleh menjadi orang ia telah adalah seperti sebagai bahwa dapat para harus namun kita dua satu masih hari hanya mengatakan kepada kami setelah melakukan lalu belum lain dia kalau terjadi banyak menurut anda hingga tak baru beberapa ketika saja jalan sekitar secara dilakukan sementara tapi sangat hal sehingga seorang bagi besar lagi selama antara waktu sebuah jika sampai jadi terhadap tiga serta pun salah merupakan atas sejak membuat baik memiliki kembali selain tetapi pertama kedua memang pernah apa mulai sama tentang bukan agar semua sedang kali kemudian hasil sejumlah juta persen sendiri katanya demikian masalah  mungkin umum setiap bulan bagian bila lainnya terus luar cukup termasuk sebelumnya bahkan wib tempat perlu menggunakan memberikan rabu sedangkan kamis langsung apakah pihak melalui diri mencapai minggu aku berada tinggi ingin sebelum tengah kini the tahu bersama depan selasa begitu merasa berbagai mengenai maka jumlah masuk katanya mengalami sering ujar kondisi akibat hubungan empat paling mendapatkan selalu lima  meminta melihat sekarang mengaku mau kerja acara menyatakan masa proses tanpa selatan sempat  adanya hidup datang senin rasa maupun seluruh mantan lama jenis segera misalnya mendapat bawah jangan meski terlihat akhirnya jumat punya yakni terakhir kecil panjang badan juni of jelas jauh tentu semakin tinggal kurang mampu posisi asal sekali sesuai sebesar berat dirinya memberi pagi sabtu ternyata mencari sumber ruang menunjukkan biasanya nama  sebanyak utara berlangsung barat kemungkinan yaitu berdasarkan sebenarnya cara utama pekan terlalu membawa kebutuhan suatu menerima penting tanggal bagaimana terutama tingkat awal sedikit nanti pasti muncul dekat lanjut ketiga biasa dulu kesempatan ribu akhir membantu terkait sebab menyebabkan khusus  bentuk ditemukan diduga mana ya kegiatan sebagian tampil hampir bertemu usai berarti keluar pula digunakan justru padahal menyebutkan gedung  apalagi program milik teman menjalani keputusan sumber a upaya mengetahui mempunyai berjalan menjelaskan b mengambil benar lewat belakang ikut barang meningkatkan kejadian kehidupan keterangan penggunaan masing-masing menghadapi';

	// http://armandbrahaj.blog.al/2009/04/14/list-of-english-stop-words/
	$stopword['en'] = 'a about above across after afterwards again against all almost alone along already also although always am among amongst amoungst amount an and another any anyhow anyone anything anyway anywhere are around as at back be became because become becomes becoming been before beforehand behind being below beside besides between beyond bill both bottom but by call can cannot cant co computer con could couldnt cry de describe detail do done down due during each eg eight either eleven else elsewhere empty enough etc even ever every everyone everything everywhere except few fifteen fify fill find fire first five for former formerly forty found four from front full further get give go had has hasnt have he hence her here hereafter hereby herein hereupon hers herse him himse his how however hundred i ie if in inc indeed interest into is it its itse keep last latter latterly least less ltd made many may me meanwhile might mill mine more moreover most mostly move much must my myse name namely neither never nevertheless next nine no nobody none noone nor not nothing now nowhere of off often on once one only onto or other others otherwise our ours ourselves out over own part per perhaps please put rather re same see seem seemed seeming seems serious several she should show side since sincere six sixty so some somehow someone something sometime sometimes somewhere still such system take ten than that the their them themselves then thence there thereafter thereby therefore therein thereupon these they thick thin third this those though three through throughout thru thus to together too top toward towards twelve twenty two un under until up upon us very via was we well were what whatever when whence whenever where whereafter whereas whereby wherein whereupon wherever whether which while whither who whoever whole whom whose why will with within without would yet you your yours yourself yourselves';
	
	$arr_stop = explode(' ',$stopword[$idlang]);
	array_walk($arr_stop,'trim');
	
	// cleanup input
	$str_title = ereg_replace('\&.*\;','', $str_title); // remove non ascii chars eg. &xxx;
	
	$arr_invalid_chars = array('/','%','!','@','`','‘','&','$','^','*','(',')','+','=','|','{','}','[',']',"\\",'.',':','?','“','”','’'); // except ','
	foreach($arr_invalid_chars as $inv_char) {
		$str_title = str_replace($inv_char,'',$str_title);
	}

	$str_title = preg_replace('/\s\s+/', ' ', $str_title); //remove duplicate spaces
//	$str_title = preg_replace('/\-\-+/', '-', $str_title); //remove duplicate dash

	$pattern = "/[^a-zA-z0-9@?#%!&~.-]\ /";
	$str_title = preg_replace($pattern, '', $str_title); // remove any stupid chars!

	// process input
	$arr_words = explode(' ',$str_title);
	array_walk($arr_words,'trim');
	
	// cleanup
	$arr_sanitized = array();
	foreach ($arr_words as $key => $word) {
		if (!in_array($word,$arr_stop)) {
			$arr_sanitized[] = $word;
		}
	}
	
	if (!empty($arr_sanitized)){
		return join(', ',$arr_sanitized);
	}else
		return false;
	
}

function permalink ($str_title) {
	
	# trim `(xxxx)`
	$str_title = ereg_replace('\(.*\)','',$str_title);
	
	$str_title = strip_tags( trim($str_title) );
	$str_title = html_entity_decode($str_title);
//	$str_title = utf8_encode($str_title);
//	$str_title = utf8_decode($str_title);
	
	$str_title = ereg_replace('\&.*\;','', $str_title); // remove non ascii chars eg. &xxx;
	
	$arr_invalid_chars = array('%','!','@','`','‘','&','$','^','*','(',')','+','=','|','{','}','[',']',"\\",',','.',':','?','“','”','’');
	$arr_white_chars   = array("/",';',' ');
	
 	$str_title = str_replace('-',' ',$str_title);

	$str_title = strtoupper($str_title);
	$str_title = strtolower($str_title);
	$str_title = preg_replace('/\s\s+/', ' ', $str_title); //remove duplicate spaces
	
	foreach($arr_invalid_chars as $inv_char) {
		$str_title = str_replace($inv_char,'',$str_title);
	}

	foreach($arr_white_chars as $inv_char) {
		$str_title = str_replace($inv_char,'-',$str_title);
	}
	
	$str_title = preg_replace('/\-\-+/', '-', $str_title); //remove duplicate dash

	$pattern = "/[^a-zA-z0-9@?#%!&~.-]/";
	$str_title = preg_replace($pattern, '', $str_title); // remove stupid chars!

	return $str_title;
}
