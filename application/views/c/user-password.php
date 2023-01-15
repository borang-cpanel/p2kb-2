
			<div class="row-fluid">
				<div class="span12 box center docreg">
					<div class="box-header" data-original-title>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">

					<?php
					if ($this->session->flashdata('userupdate')) { ?>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Updated !</strong> You have successfully update password data.
						</div>
					<?php
					}
					if (isset($row) && is_object($row)) : ?>
					<form class="form-horizontal" action="" method="post">
					  <fieldset>
						<legend>Change password</legend>

						<div class="control-group grouping">
						  <label class="control-label" for="docnra">Nomor Register Anggota</label>
						  <div class="controls">
							<input type="text" disabled="disabled" value="<? echo $row->nra ?>">
						  </div>
						  <label class="control-label" for="">Nama Lengkap</label>
						  <div class="controls">
						  	<input type="text" disabled="disabled" value="<? echo $row->nama ?>" class="input-xxlarge">
						  </div>
						  <label class="control-label" for="nrapass">Password untuk login</label>
						  <div class="controls">
							<input name="nrapass" type="password" class="input-medium">
							<? echo form_error('nrapass'); ?>
						  </div>
						  <label class="control-label" for="nrapass2">Ulangi password login</label>
						  <div class="controls">
							<input name="nrapass2" type="password" class="input-medium">
							<? echo form_error('nrapass2'); ?>
						  </div>
						</div>
						<div class="form-actions">
						  <button type="submit" class="btn btn-primary">Update Password</button>
						</div>
					  </fieldset>
					</form>
					<?php endif; ?>
					</div> 
				</div><!--/span-->
			</div><!--/row-->
