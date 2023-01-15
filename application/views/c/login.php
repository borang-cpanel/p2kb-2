			<div class="row-fluid">
				<div class="well span5 center login-box">
					<div class="alert alert-info">
						Silakan login dengan <abbr title="Nomor Registrasi Anggota">NRA</abbr> dan Password Anda.
					</div>
					<?php
						if (validation_errors()) { ?>
						<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<? echo validation_errors();?>
						</div>
						<?							
						}
					?>
					<form class="form-horizontal" action="" method="post">
						<fieldset>
							<div class="input-prepend" title="Nomor Registrasi Anggota" data-rel="tooltip">
								<span class="add-on"><i class="icon-user"></i></span><input autofocus class="input-large span10" name="nra" id="nra" type="text" value="" />
							</div>
							<div class="clearfix"></div>

							<div class="input-prepend" title="Password" data-rel="tooltip">
								<span class="add-on"><i class="icon icon-black icon-key"></i></span><input class="input-large span10" name="nrapass" id="nrapass" type="password" value="" />
							</div>
							<div class="clearfix"></div>

							<div class="control-group">
								<label class="control-label">Login as</label>
								<div class="controls" style="text-align:left">
								  <label class="radio">
									<div class="radio" id="uniform-optionsRadios1"><span class="checked"><input type="radio" name="utype" id="optionsRadios1" value="doc" checked="" style="opacity: 0;"></span></div>
									Doctor
								  </label>
								  <div style="clear:both"></div>
								  <label class="radio">
									<div class="radio" id="uniform-optionsRadios2"><span class=""><input type="radio" name="utype" id="optionsRadios2" value="kol" style="opacity: 0;"></span></div>
									Komisi P2KB
								  </label>
								  <div style="clear:both"></div>
								  <label class="radio">
									<div class="radio" id="uniform-optionsRadios2"><span class=""><input type="radio" name="utype" id="optionsRadios2" value="adm" style="opacity: 0;"></span></div>
									Administrator
								  </label>
								</div>
							  </div>

							<div class="clearfix"></div>

							<p class="center span5">
							<button type="submit" class="btn btn-primary">Login</button>
							</p>
							
						</fieldset>
						
						<p style="">
						<br />
<?php /*
						<span class="icon icon-darkgray icon-book"></span> <a href="<?=site_url('user/signup')?>">Silakan klik disini untuk registrasi Dokter</a> 
*/ ?>
						</p>
					</form>
				</div><!--/span-->
			</div><!--/row-->

