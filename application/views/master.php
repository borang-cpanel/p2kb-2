<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $this->Webpage->title ?></title>
	<?php echo $this->Webpage->meta ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">

	<!-- The styles -->
	<link id="bs-css" href="<?=base_url()?>css/bootstrap-cerulean.css" rel="stylesheet">
	<style type="text/css">
	  body {
		padding-bottom: 10px;
		background:#fff url(<?=base_url()?>images/abstract.jpg) center top no-repeat;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	</style>
	<link href="<?=base_url()?>css/bootstrap-responsive.css" rel="stylesheet">
	<link href="<?=base_url()?>css/p2kb-app.css" rel="stylesheet">
	<link href="<?=base_url()?>css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='<?=base_url()?>css/chosen.css' rel='stylesheet'>
	<link href='<?=base_url()?>css/uniform.default.css' rel='stylesheet'>
	<link href='<?=base_url()?>css/colorbox.css' rel='stylesheet'>
	<link href='<?=base_url()?>css/jquery.cleditor.css' rel='stylesheet'>
	<link href='<?=base_url()?>css/jquery.noty.css' rel='stylesheet'>
	<link href='<?=base_url()?>css/noty_theme_default.css' rel='stylesheet'>
	<link href='<?=base_url()?>css/elfinder.min.css' rel='stylesheet'>
	<link href='<?=base_url()?>css/elfinder.theme.css' rel='stylesheet'>
	<link href='<?=base_url()?>css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='<?=base_url()?>css/opa-icons.css' rel='stylesheet'>
	<link href='<?=base_url()?>css/uploadify.css' rel='stylesheet'>
	<?php $this->Webpage->css_queue() ?>

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="<?=base_url()?>js/shiv/html5shiv.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="<?=base_url()?>img/favicon.ico">
	<!-- jQuery -->
	<script src="<?=base_url()?>js/jquery-1.7.2.min.js"></script>
	<?php $this->Webpage->js_queue() ?>
		
</head>

<body>
			
	<noscript><div id="nojs"><p><span class="red">Browser anda tidak mendukung Javascript !.</span> <br />Silakan aktifkan fitur javascript atau gunakan browser lain seperti Mozilla Firefox atau Google Chrome.</p></div></noscript>

	<?php if(!isset($no_visible_elements) || !$no_visible_elements)	{ ?>
	<!-- topbar starts -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="<?=site_url()?>"> <img alt="PORI P2KB" src="<?=base_url()?>images/logo-PORI--p2kb.png" /> <br><span>Sistem Pengembangan Pendidikan Keprofesian Berkelanjutan</span></a>
				
				
				<!-- user dropdown starts -->
				<div class="btn-group pull-right" >
					<?
					if (isset($udata) && !empty($udata)) { ?>
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-user"></i><span class="hidden-phone"> <?=$udata['nama']?></span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?=site_url('user/profile')?>">Profile</a></li>
						<li><a href="<?=site_url('user/changepass')?>">Change Password</a></li>
						<li class="divider"></li>
						<li><a href="<?=site_url('user/logout')?>">Logout</a></li>
					</ul>
					<? 
					} ?>
				</div>
				<!-- user dropdown ends -->
				<!--/.nav-collapse -->
			</div>
		</div>
	</div>
	<!-- topbar ends -->
	<?php } ?>
	<div class="container-fluid">
		<div class="row-fluid">
		
			<!-- left menu starts -->
			<?php if($this->P2kb->is_profile_complete($this->P2kb->udata['id'])): ?>
			<div class="span3 main-menu-span">
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li class="nav-header hidden-tablet center">Data Kegiatan</li>
						<?php $seg1 = $this->uri->segment(1); $seg2 = $this->uri->segment(2); ?>
						<li<?= $seg1=='dashboard' || $seg1=='' ? ' class="active"':''?>><a class="ajax-link" href="<?=site_url('dashboard')?>"><i class="icon-home"></i><span class="hidden-tablet"> Dashboard</span></a></li>
						<?php
						if (isset($qcat) && ($qcat !== false) && ($qcat->num_rows > 0) ) {
							foreach ($qcat->result() as $row){
								$seg2 = $this->uri->segment(2);
								$seg3 = $this->uri->segment(3);
								$mselect = '';
								if ( ($seg1=='kegiatan') && ($seg2=='category') && ($row->id == $seg3) ) {
									$mselect = ' class="active"';
								}
								?><li<?=$mselect?>><a class="ajax-link" href="<?=site_url('kegiatan/category/'.$row->id)?>"><i class="icon-align-justify"></i><span class="hidden-tablet"> <?=$row->jenis?></span></a></li><?php
							}
						}
						
						// sertifikat kesehatan
						//if ($this->P2kb->udata['tipe'] != 'kol') {
						$msselect = '';
						if ( ($seg1=='healthcert') ) {
							$msselect = ' class="active"';
						}
						?><li<?=$msselect?>><a class="ajax-link" href="<?=site_url('healthcert')?>"><i class="icon icon-darkgray icon-contacts"></i><span class="hidden-tablet"> Sertifikat Kesehatan</span></a></li><?php
						
						//}
						
						// menu kategori & kegitan
						if ($this->P2kb->udata['tipe'] == 'adm') {
							$msselect = '';
							if ( ($seg1=='data')&&($seg2=='kategori') ) {
								$msselect = ' class="active"';
							}
							?><li<?=$msselect?>><a class="ajax-link" href="<?=site_url('data/kategori')?>"><i class="icon-th-list"></i><span class="hidden-tablet"> Master Data Kategori </span></a></li><?php

							$msselect = '';
							if ( ($seg1=='data') && ($seg2=='kegiatan') ) {
								$msselect = ' class="active"';
							}
							?><li<?=$msselect?>><a class="ajax-link" href="<?=site_url('data/kegiatan')?>"><i class="icon icon-black icon-treeview-corner"></i><span class="hidden-tablet"> Master Data Kegiatan</span></a></li><?php
						
						}

						// messaging menu
						if ($this->P2kb->udata['tipe'] != 'kol') {
						$msselect = '';
						if ( ($seg1=='messages') ) {
							$msselect = ' class="active"';
						}
						?><li<?=$msselect?>><a class="ajax-link" href="<?=site_url('messages')?>"><i class="icon-envelope"></i><span class="hidden-tablet"> Messages</span></a></li><?php
						
						}
						
						// report menu
						#if ($this->P2kb->udata['tipe'] != 'doc') {
						#}
						$msselect = '';
						if ( ($seg1=='reports') ) {
							$msselect = ' class="active"';
						}
						?><li<?=$msselect?>><a class="ajax-link" href="<?=site_url('reports')?>"><i class="icon-print"></i><span class="hidden-tablet"> Reports</span></a></li><?php
					
						
						// users menu
						if ($this->P2kb->udata['tipe'] == 'adm') {
							$msselect = '';
							if ( ($seg1=='users') ) {
								$msselect = ' class="active"';
							}
							?><li<?=$msselect?>><a class="ajax-link" href="<?=site_url('users')?>"><i class="icon-user"></i><span class="hidden-tablet"> Users</span></a></li><?php
						
						}
						?>
					</ul>
					<label id="for-is-ajax" class="hidden-tablet" for="is-ajax">
					<!--<input id="is-ajax" type="checkbox"> Ajax on menu-->&nbsp;
					</label>
				</div><!--/.well -->
				<div class="help-guide">
					<h6> Panduan / Buku Manual (pdf) :</h6>
					<div class=""><span class="icon icon-darkgray icon-book"></span> <a target="_blank" href="<?php base_url()?>media/guide/Buku Pedoman P2KB - 2021.pdf">Buku Pedoman P2KB 2021</a></div>
					<div class=""><span class="icon icon-darkgray icon-book"></span> <a target="_blank" href="<?php base_url()?>media/guide/Buku_Pedoman_P2KB.pdf">Buku Pedoman P2KB (Lama)</a></div>
					<div class=""><span class="icon icon-darkgray icon-book"></span> <a target="_blank" href="<?php base_url()?>media/guide/Penggunaan_Sistem_P2KB_PORI.pdf">Penggunaan Sistem P2KB PORI</a></div>
					<div class=""><span class="icon icon-darkgray icon-book"></span> <a target="_blank" href="<?php base_url()?>media/guide/Pedoman-Perhitungan-SKP.pdf">Pedoman Perhitungan SKP</a></div>
				</div>
			</div><!--/span-->
			<?php endif; ?>
			<!-- left menu ends -->
			
			<div id="content" class="span9">
			<!-- content starts -->
			
			<?=$this->Webpage->content?>
			
			<!-- content ends -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
		<hr>

		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">�</button>
				<h3>Settings</h3>
			</div>
			<div class="modal-body">
				<p>Here settings can be configured...</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>

		<footer>
			<p class="pull-left">&copy; <?php echo date('Y') ?> Sistem Pengembangan Pendidikan Keprofesian Berkelanjutan (P2KB). Developed by <a href="http://www.computesta.com">Computesta</a></p>
			<p class="pull-right">&nbsp;</p>
		</footer>

	</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<!-- jQuery UI -->
	<script src="<?=base_url()?>js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- transition / effect library -->
	<script src="<?=base_url()?>js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="<?=base_url()?>js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="<?=base_url()?>js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="<?=base_url()?>js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="<?=base_url()?>js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="<?=base_url()?>js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="<?=base_url()?>js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="<?=base_url()?>js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="<?=base_url()?>js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="<?=base_url()?>js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="<?=base_url()?>js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="<?=base_url()?>js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="<?=base_url()?>js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="<?=base_url()?>js/jquery.cookie.js"></script>
	<!-- data table plugin -->
	<script src='<?=base_url()?>js/jquery.dataTables.min.js'></script>

	<!-- select or dropdown enhancer -->
	<script src="<?=base_url()?>js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="<?=base_url()?>js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="<?=base_url()?>js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="<?=base_url()?>js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="<?=base_url()?>js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="<?=base_url()?>js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="<?=base_url()?>js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="<?=base_url()?>js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="<?=base_url()?>js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="<?=base_url()?>js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="<?=base_url()?>js/jquery.history.js"></script>
	<!-- application script -->
	<script src="<?=base_url()?>js/p2kb.js"></script>
	<?php
	$uri_str = $this->uri->uri_string();
	$uri_str = $this->uri->segment(1).'/'.$this->uri->segment(2);
	if (in_array( $uri_str, array('user/profile', 'users/add', 'users/edit') ) ) { ?>
	<script src="<?=base_url()?>js/p2kb-sign.js"></script>
	<?php
	}
	?>
	
</body>
</html>
