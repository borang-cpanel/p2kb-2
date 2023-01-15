<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $this->Webpage->title ?></title>
	<?php echo $this->Webpage->meta ?>
	<?php $this->Webpage->css_queue() ?>
	<?php $this->Webpage->js_queue() ?>
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
	<link href='<?=base_url()?>css/uniform.default.css' rel='stylesheet'>
	<link href='<?=base_url()?>css/jquery.cleditor.css' rel='stylesheet'>
	<link href='<?=base_url()?>css/jquery.noty.css' rel='stylesheet'>
	<link href='<?=base_url()?>css/noty_theme_default.css' rel='stylesheet'>
	<link href='<?=base_url()?>css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='<?=base_url()?>css/opa-icons.css' rel='stylesheet'>

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="<?=base_url()?>js/shiv/html5shiv.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="<?=base_url()?>img/favicon.ico">
		
</head>

<body>
	<noscript><div id="nojs"><p><span class="red">Browser anda tidak mendukung Javascript !.</span> <br />Silakan aktifkan fitur javascript atau gunakan browser lain seperti Mozilla Firefox atau Google Chrome.</p></div></noscript>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="row-fluid">
				<div class="span12 center login-header">
					<h2><a href="<?=site_url()?>"><img alt="PORI P2KB" src="<?=base_url()?>images/logo-PORI--p2kb.png" /></a> <br><span>Sistem Pengembangan Pendidikan Keprofesian Berkelanjutan</span></h2>
				</div><!--/span-->
			</div><!--/row-->
			
			<?=$this->Webpage->content?>
			
		</div><!--/fluid-row-->

		<footer>
			<p class="center">&copy; <?php echo date('Y') ?> Sistem Pengembangan Pendidikan Keprofesian Berkelanjutan (P2KB). Developed by <a href="http://www.computesta.com">Computesta</a></p>
			<p class="pull-right">&nbsp;</p>
		</footer>

	</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<!-- jQuery -->
	<script src="<?=base_url()?>js/jquery-1.7.2.min.js"></script>
	<!-- jQuery UI -->
	<script src="<?=base_url()?>js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- transition / effect library -->
	<script src="<?=base_url()?>js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="<?=base_url()?>js/bootstrap-alert.js"></script>
	<!-- scrolspy library -->
	<script src="<?=base_url()?>js/bootstrap-scrollspy.js"></script>
	<!-- library for advanced tooltip -->
	<script src="<?=base_url()?>js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="<?=base_url()?>js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="<?=base_url()?>js/bootstrap-button.js"></script>

	<!-- select or dropdown enhancer -->
	<script src="<?=base_url()?>js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="<?=base_url()?>js/jquery.uniform.min.js"></script>
	<!-- rich text editor library -->
	<script src="<?=base_url()?>js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="<?=base_url()?>js/jquery.noty.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="<?=base_url()?>js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="<?=base_url()?>js/jquery.autogrow-textarea.js"></script>
	<!-- application script -->
	<script src="<?=base_url()?>js/p2kb-sign.js"></script>
	<script type="text/javascript" language="javascript">
	
	$(document).ready(function(){

	});

	</script>
	
</body>
</html>
