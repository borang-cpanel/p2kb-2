<?php
class Site extends CI_Model {

    var $title   	= '';
    var $breadcrumb = '';
    var $meta 		= '';
    var $css		= '';
    var $js			= '';
    var $header		= '';
    var $content 	= '';
    var $footer		= '';
    var $date    	= '';
    var $arr_tpl 	= array();
	var $intpl 		= array();

	var $langid 	= 'id';

    function Site() {
        parent::__construct();

		$langid = $this->uri->segment(1);
		if (! empty($langid))
			$this->langid = $langid;
		//$this->lang->load('main',$this->langid);
    }
	
    function set_menu() {
		#1
		//$arr_main_menu = $this->lang->line('main_menu');

        $c=0;
		$main_menu ='';
		$segment1 = $this->uri->segment(1);
		foreach($arr_main_menu as $menu_uri => $mnu_label) {
			$c++;
			$sel = '';
			if ($menu_uri == $this->uri->segment(2))
				$sel = 'class="current"';

            if (($c==1) and (empty($segment1) or ($segment1=='home')) ) {
			   $main_menu .= '<li>'.anchor($this->langid.'/'.$menu_uri,$mnu_label,$sel.' title="'.$mnu_label.'"').'</li>';                
            }else{
				$main_menu .= '<li>'.anchor($this->langid.'/'.$menu_uri,$mnu_label,$sel.' title="'.$mnu_label.'"').'</li>';
            }
        }
        return $main_menu;
	}
	
	function switch_lang($to='') {
		$current_uri = $this->uri->uri_string();
		if (!empty($to)) {
			$next_uri = $to.substr($current_uri,2);
		}else{
			switch ($this->langid) {
				case 'id':
					$next_uri = 'en'.substr($current_uri,2);
				break;
				case 'en':
					$next_uri = 'id'.substr($current_uri,2);
				break;
			}
		}
		return site_url($next_uri);
	}
	
	function translate_date ($date_string) {
		if ($this->langid == 'en')
			return $date_string;
		else {
			$datum = array(
				// days
				'Monday'	=> 'Senin',
				'Tuesday'	=> 'Selasa',
				'Wednesday'	=> 'Rabu',
				'Thursday'	=> 'Kamis',
				'Friday'	=> 'Jumat',
				'Saturday'	=> 'Sabtu',
				'Sunday'	=> 'Minggu',

				// months
				'January'	=> 'Januari',
				'February'	=> 'Februari',
				'March'		=> 'Maret',
				'April'		=> 'April',
				'May'		=> 'Mei',
				'June'		=> 'Juni',
				'July'		=> 'Juli',
				'August'	=> 'Agustus',
				'September'	=> 'September',
				'October'	=> 'Oktober',
				'November'	=> 'November',
				'December'	=> 'Desember'
				
			);
			return str_replace( array_keys($datum), array_values($datum), $date_string);
		}
	}
	
	function get_brand (){
		$q = $this->db->query("select * from pbrand order by brand");
		if ($q->num_rows()>0) {
			$q = $q;
			return $q;
		}else
			return false;
	}

	function get_model ($idbrand){
		$q = $this->db->query("select * from ptipe where idb='$idbrand' order by tipe");
		if ($q->num_rows()>0) {
			$q = $q;
			return $q;
		}else
			return false;
	}

	function get_model_year ($idmodel){
		$q = $this->db->query("select * from pcat where idt='$idmodel' order by tahun");
		if ($q->num_rows()>0) {
			$q = $q;
			return $q;
		}else
			return false;
	}

	function get_prolog() {
		$q = $this->db->query("select * from prolog limit 1");
		if ($q->num_rows()>0) {
			$rs = $q->row_array();
			return $rs;
		}else 
			return false;
	}
    
	function get_about() {
		$q = $this->db->query("select * from about limit 1");
		if ($q->num_rows()>0) {
			$rs = $q->row_array();
			return $rs;
		}else 
			return false;
	}
    
	function get_about_info() {
		$q = $this->db->query("select * from career_info limit 1");
		if ($q->num_rows()>0) {
			$rs = $q->row_array();
			return $rs;
		}else 
			return false;
	}
	
	function get_dealers($limit='limit 5',$year='') {
 		$arr_dealers=array();
		$q = $this->db->query("select * from dealers_loc order by sorder");
		if ($q->num_rows()>0) {
			foreach ($q->result_array() as $rsl) {
		 		$q2 = $this->db->query("select * from dealers where locid='".$rsl['id']."'");
				if ($q2->num_rows()>0) {
					foreach ($q2->result_array() as $rs) {
						$arr_dealers[$rsl['loc']][] = array('judul'=>$rs['judul'], 'teks' => $rs['teks']);
					}
				}
			}
		} 
		return $arr_dealers;
	}
	
	function get_tech($sort='desc') {
 		$q = $this->db->query("select * from tech order by tgl $sort");
		if ($q->num_rows()>0) {
			return $q;
		}else 
			return false;
	}
	
	function get_careers($limit='limit 5') {
 		$q = $this->db->query("select * from careers order by tgl desc $limit");
		if ($q->num_rows()>0) {
			return $q;
		}else 
			return false;
	}
	
	function get_news($limit='limit 5',$year='') {
		if (!empty($year))
			$year = " where date_format(tgl,'%Y')='$year' "; 
			
 		//$q = $this->db->query("select *, date_format(tgl,'%W, %e %M %Y') as thedate from news $year order by tgl desc $limit");
		$q = $this->db->query("select news.*, date_format(news.tgl,'%W, %e %M %Y') as thedate, news_images.id as gid, news_videos.id as vid  from news left join news_images on news.id=news_images.idn LEFT join news_videos on news.id=news_videos.idn group by news.id order by news.tgl desc $limit");
		if ($q->num_rows()>0) {
			return $q;
		}else 
			return false;
	}
	
	function get_news_latest() {
 		$q = $this->db->query("select *, date_format(tgl,'%W, %e %M %Y') as thedate from news order by tgl desc limit 1");
		if ($q->num_rows()>0) {
			return $q->row_array();
		}else 
			return false;
	}
	
	function get_news_years() {
		$q = $this->db->query("select distinct year(tgl) as nyear from news order by tgl asc");
		if ($q->num_rows()>0) {
			return $q;
		}else 
			return false;
	}
	
	function get_pcategory($id) {
		$q = $this->db->query("select * from prod_category where id='$id'");
		if ($q->num_rows()>0) {
			return $q->row_array();
		}else 
			return false;
	}
	
	function get_prod_category($up='0') {
		$q = $this->db->query("select * from prod_category where up='$up'");
		if ($q->num_rows()>0) {
			return $q;
		}else 
			return false;
	}
	
	function get_prod_categories($limit='') {
		$q = $this->db->query("select * from prod_category $limit");
		if ($q->num_rows()>0) {
			return $q;
		}else 
			return false;
	}
	
	function get_slides() {
		$q = $this->db->query("select * from slider");
		if ($q->num_rows()>0) {
			return $q;
		}else 
			return false;
	}
	
	function get_prod_find($ifstring,$limit='limit 5') {
		$q = $this->db->query("select id,judul,judul_en,teksovr,teksovr_en,img from prod where $ifstring $limit"); #echo $this->db->last_query();
		if ($q->num_rows()>0) {
			return $q;
		}else 
			return false;
	}
	
	function get_prod_size($ifsz='',$limit='limit 5') {
		if ($ifsz){
			$ifsz = "where sz='$ifsz'"; 
		}
	
		$q = $this->db->query("select id,sz,judul,judul_en,teksovr,teksovr_en,img from prod $ifsz group by sz order by sz"); #echo $this->db->last_query();
		if ($q->num_rows()>0) {
			return $q;
		}else 
			return false;	
	}
	
	function get_prod_all() {
		$q = $this->db->query("select id,judul,judul_en from prod"); #echo $this->db->last_query();
		if ($q->num_rows()>0) {
			return $q;
		}else 
			return false;
	}
	
	function get_prod($id='') {
		$q = $this->db->query("select * from prod where id='$id'"); #echo $this->db->last_query();
		if ($q->num_rows()>0) {
			return $q;
		}else 
			return false;
	}
	
	function get_prods($limit='limit 5',$idc='') {
		if ($idc){
			$idc = "where idc='$idc'"; 
		}
		$q = $this->db->query("select * from prod $idc $limit"); #echo $this->db->last_query();
		if ($q->num_rows()>0) {
			return $q;
		}else 
			return false;
	}
	
	function get_prods_byvehicle($idc='',$limit='limit 5') {
		if ($idc){
			$idc = "where idc='$idc'"; 
		}
		$q = $this->db->query("select * from prod $idc $limit"); #echo $this->db->last_query();
		if ($q->num_rows()>0) {
			return $q;
		}else 
			return false;
	}
	
	function get_prod_tags($limit='') {
		$q = $this->db->query("select distinct tag as tags from prod $limit"); #echo $this->db->last_query();
		if ($q->num_rows()>0) {
			return $q;
		}else 
			return false;
	}
	
}