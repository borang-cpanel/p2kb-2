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


// a collection of custom defined function 
// sapta | imajiku.com Feb,2008

function a_tag($label="", $href="", $class="", $atributes="") {
	if ($class)
		$class = 'class="'.$class.'"';
	
	if ($href)
		$ret = '<a '.$atributes.' '.$class.' href="'.$href.'">'.$label.'</a>';
	else 	
		$ret = $label;
	
	return $ret;
}	

function thumbText ($text,$chunk=320, $stripTag = true, $stripExclude='',$more=' ...') {
	if ($stripTag == true or $stripTag == 'STRIPTAGS')
		$text = strip_tags($text,$stripExclude);
	
	$chunkAt = strrpos(substr($text,0,$chunk),' ');	
	if(strlen($text) > $chunk) #{$jh=strpos($potongan,"\n",300);}else{ $jh=350;}
		$text = substr($text,0,$chunkAt).$more;

	return $text;
}

# spider robot detector
function crawlerDetect($USER_AGENT) {
    $crawlers = array(
    array('Google', 'Google'),
    array('msnbot', 'MSN'),
    array('Rambler', 'Rambler'),
    array('Yahoo', 'Yahoo'),
    array('AbachoBOT', 'AbachoBOT'),
    array('accoona', 'Accoona'),
    array('AcoiRobot', 'AcoiRobot'),
    array('ASPSeek', 'ASPSeek'),
    array('CrocCrawler', 'CrocCrawler'),
    array('Dumbot', 'Dumbot'),
    array('FAST-WebCrawler', 'FAST-WebCrawler'),
    array('GeonaBot', 'GeonaBot'),
    array('Gigabot', 'Gigabot'),
    array('Lycos', 'Lycos spider'),
    array('MSRBOT', 'MSRBOT'),
    array('Scooter', 'Altavista robot'),
    array('AltaVista', 'Altavista robot'),
    array('IDBot', 'ID-Search Bot'),
    array('eStyle', 'eStyle Bot'),
    array('Scrubby', 'Scrubby robot')
    );

    foreach ($crawlers as $c) {
        if (stristr($USER_AGENT, $c[0])) {
            return($c[1]);
        }
    }

    return false;
}

function strip_selected_tags($text, $tags = array()) {
    $args = func_get_args();
    $text = array_shift($args);
    $tags = func_num_args() > 2 ? array_diff($args,array($text)) : (array)$tags;
    foreach ($tags as $tag){
        if(preg_match_all('/<'.$tag.'[^>]*>(.*)<\/'.$tag.'>/iU', $text, $found)){
            $text = str_replace($found[0],$found[1],$text);
      }
    }

    return $text;
}

function strip_only_tags($str, $tags, $stripContent=false) {
    $content = '';
    if(!is_array($tags)) {
        $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
        if(end($tags) == '') array_pop($tags);
    }
    foreach($tags as $tag) {
        if ($stripContent)
             $content = '(.+</'.$tag.'(>|\s[^>]*>)|)';
         $str = preg_replace('#</?'.$tag.'(>|\s[^>]*>)'.$content.'#is', '', $str);
    }
    return $str;
}


function retrieveYahooWeather($zipCode="92832") {
    $yahooUrl = "http://weather.yahooapis.com/forecastrss";
    $yahooZip = "?p=$zipCode";
    $yahooFullUrl = $yahooUrl . $yahooZip; 
    $curlObject = curl_init();
    curl_setopt($curlObject,CURLOPT_URL,$yahooFullUrl);
    curl_setopt($curlObject,CURLOPT_HEADER,false);
    curl_setopt($curlObject,CURLOPT_RETURNTRANSFER,true);
    $returnYahooWeather = curl_exec($curlObject);
    curl_close($curlObject);
    return $returnYahooWeather;
}

// date in Indonesian
function dateIn($varinput,$time=0){
	if($time==0)$time=time();
	$tgl	=date($varinput,$time);
	$hari	=array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
	$tgl	=str_replace(date("l",$time),$hari[date("w",$time)],$tgl);
	$hariSingkat=array('Ming','Sen','Sel','Rab','Kam','Jum','Sab');
	$tgl	=str_replace(date("D",$time),$hariSingkat[date("w",$time)],$tgl);
	$bulan	=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','Sepember','Oktober','November','Desember');
	$tgl	=str_replace(date("F",$time),$bulan[date("n",$time)-1],$tgl);
	$bulanSingkat=array('Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agus','Sept','Okt','Nov','Des');
	$tgl	=str_replace(date("M",$time),$bulanSingkat[date("n",$time)-1],$tgl);
	return $tgl;
}


function comparemail_check($str) {
	$cap_str = $this->input->post('email');
	if ($str != $cap_str)
	{
		$this->form_validation->set_message('comparemail_check', 'Please confirm your email address in %s field');
		return FALSE;
	}
	else
	{
		return TRUE;
	}
}

function get_hostname () {
	$host = '';
	$host_info = parse_url(site_url());
	extract($host_info,EXTR_OVERWRITE);
	return $host;
}

function create_breadcrumb($array,$devider='&lt;'){
	$breadcrumb = array();
	foreach($array as $l => $u) {
		if (empty($u))
			$breadcrumb[] = $l;
		elseif ($u=='home')
			$breadcrumb[] = anchor('',$l);
		else
			$breadcrumb[] = anchor($u,$l);
	}
	return join($devider,$breadcrumb);
}

function ago($time) {
   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");

   $now = time();
   
       $difference     = $now - $time;
       $tense         = "ago";

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       $difference /= $lengths[$j];
   }

   $difference = round($difference);

   if($difference != 1) {
       $periods[$j].= "s";
   }

   return "$difference $periods[$j] ago";
}