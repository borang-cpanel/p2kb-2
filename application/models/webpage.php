<?
class Webpage extends CI_Model {

    var $title   	= 'Sistem Pengembangan Pendidikan Keprofesian Berkelanjutan (P2KB)';
	var $arr_main_menu= array();
    var $breadcrumb = '';
    var $meta 		= '';
    var $css		= array();
    var $js			= array();
    var $header		= '';
    var $sidebar1	= '';
    var $sidebar2	= '';
    var $content 	= '';
    var $footer		= '';
    var $date    	= '';
    var $arr_tpl = array();

	var $langid = 'en';
	var $voting = 0;
	var $emailer = array('email'=>'','name'=>'');

    function Webpage() {
        // Call the Model constructor
        parent::__construct();
		$this->load->helper('url');
		$this->load->helper('common');
		$this->load->helper('seotool');
		
		$this->load->database();
		if(session_id() == '') {
			session_start();
		}
		
		$this->arr_main_menu = array(
			''				=> 'Home',
			'gallery'		=> 'Gallery',
			'joincontest'	=> 'Join Contest',
			'contact'		=> 'Contact Us',
			'user/signup'	=> 'Signup',
			'user/login'	=> 'Login',
			);
    }
    
    function set_menu() {
		#1
		
        $c=0;
		$main_menu ='';
		$segment1 = $this->uri->segment(1);
		foreach($this->arr_main_menu as $menu_uri => $mnu_label) {
			$uri = site_url($menu_uri);
			#if (!empty($menu_uri))
			#	$uri = site_url('#');
            
			if ($uri == $this->uri->segment(1))
				$sel = ' class="active"';
			elseif (empty($segment1) and ($menu_uri=='home'))
				$sel = ' class="active"';
			else
				$sel = '';

			$c++;
            $li_class = ($c==1) ? (' class="first"'):('');
            //print $segment1; die();
			if ($c==1){
	 			if (empty($segment1) or ($segment1=='home') or ($menu_uri == $this->uri->segment(1)) )
	               $main_menu .= '<li class="first active">'.anchor($menu_uri,$mnu_label,$sel.' title="'.$mnu_label.'"').'</li>';                
				else
	               $main_menu .= '<li class="first">'.anchor($menu_uri,$mnu_label,'title="'.$mnu_label.'"').'</li>';                
            }else{
            	if ( ( $menu_uri == $this->uri->segment(1) ) || ($menu_uri == $this->uri->uri_string() ) )
					$sel = ' class="active"';
				else
					$sel = '';

				$main_menu .= '<li'.$sel.'>'.anchor($menu_uri,$mnu_label,' title="'.$mnu_label.'"').'</li>';
            }
			/*
            switch ($menu_uri) {
            	default:
            		$main_menu .= '<li'.$li_class.'>'.anchor($uri,$mnu_label,$sel).'</li>';
            }
            */
       
        }
        
        return $main_menu;
        
	}
	
	function get_upinfo($t,$id,$limit='limit 1') {
		$q = $this->db->query("select * from $t where id = $id $limit");
		if ($q->num_rows()>0) {
			$r = $q->row_array();
			return $r;
		}
	}
	
	function set_sidebar($title,$menu,$t) {
		$sidebar = array(); 
		$thesidebar = '';
		$qs = $this->db->query("select * from $t where up=0 and aktif=1");
		if ($qs->num_rows()>0) {
			$sidebar['title'] = $title;
			$sidebar['slug'] = $menu;
			$item = '';
			$segmn2 = $this->uri->segment(1);
			foreach($qs->result_array() as $rs) {
				$sel = ($segmn2 == $rs['slug'])?(' class="active"'):('');
				$item .= '<li>'.anchor($menu.'/'.$rs['slug'],$rs['categoriIn'],$sel);
				
				$item .= '</li>';
			}
			$sidebar['item'] = $item;
			$thesidebar = $this->load->view('sidebar',$sidebar,TRUE);
		}
		return $thesidebar;
	}
	
	function set_title($title, $override=FALSE){
		if ($override == TRUE)
			$this->title = $title;
		else {
			$this->title = $title. ' | '.$this->title;
		}
		
		//$this->add_meta('title', $this->title);
	}
	
	function add_meta($metaname,$metacontent){
		$this->meta .= '<meta name="'.$metaname.'" content="'.$metacontent.'" />'."\n";
	}
	
	function meta_keys($content){
		$this->meta .= '<meta name="keywords" content="'.$content.'" />'."\n";
	}
	
	function meta_desc($content) {
		$content = strip_tags(str_replace('...','',$content));
		$this->meta .= '<meta name="description" content="'.$content.'" />'."\n";		
	}
	
	/**
	add css rule
	**/
	function add_css($cssfile,$IEmarkup='') {
		$path='';
		if (is_array($cssfile)){
			foreach ($cssfile as $files) {
				$path .= '<link href="'.$files.'" rel="stylesheet" type="text/css" />'."\n";
			}
		}else
			$path = '<link href="'.$cssfile.'" rel="stylesheet" type="text/css" />';

		if ($IEmarkup){
			$path = '<!--[if '.$IEmarkup.']>'.$path.'<![endif]-->';			
		}
		$this->css[] = $path;
	}
	function css_queue() {
		if(!empty($this->css)){
			echo join("\n",$this->css)."\n";
		}
	}

	/**
	add javascript (in head section)
	**/
	function add_js($jsfile) {
		$js = '<script type="text/javascript" src="'.$jsfile.'"></script>';
		$this->js[] = $js;
	}
	function js_queue() {
		if(!empty($this->js)){
			echo join("\n",$this->js)."\n";
		}
	}

	
	function set_pagemeta($pageid=''){
		$seg1 = $this->uri->segment(1); if (empty($seg1)) $seg1 = 'home'; 
		if (empty($pageid)) $pageid = $seg1;
		$q= $this->db->query("select * from web_setting");
		if ($q->num_rows()>0){
			foreach($q->result_array() as $r){
				if ($seg1 =='home') {
					if ($r['var_name'] == 'web_keywords')
						$this->add_meta('keywords',$r['var_value']);
					if ($r['var_name'] == 'web_description')
						$this->add_meta('description',$r['var_value']);
				}
				if ($r['var_name'] == 'web_title')
					$this->title = $r['var_value'];
			}
		}
		//$this->add_meta('title',$this->title);
	}
	
	function get_contact_mail(){
		$ret='';
		$q = $this->db->get_where('web_setting',array('var_name'=>'contact_mail'),1);
		if ($q->num_rows()>0){
			$r=$q->row_array(0);
			$ret = $r['var_value'];
		}
		return $ret;
	}
	
	function get_home_info() {
		$ret = array();
		$q = $this->db->get('home_setup','1');
		if ($q->num_rows()>0) {
			$r = $q->row_array(0);
			$ret = $r;	
		}
		return $ret;
	}		
	
	function get_home_sliders() {
		$q = $this->db->get('web_sliders');
		if ($q->num_rows()>0) {
			return $q;	
		}else
			return false;
	}		
	
	function get_home_pages() {
		$qh = $this->db->query("select * from web_pages as wps, web_page as wp where wp.pid = wps.id");
		if ($qh->num_rows()>0) {
			return $qh;	
		}else
			return false;
	}		
	

    function setFooter() {
    }
}