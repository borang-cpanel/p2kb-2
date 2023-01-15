			<?php $table_label = 'Master Data Kegiatan';?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="<?=site_url()?>">Home</a> <span class="divider">/</span>
					</li>
					<li><?=anchor(site_url('data/kegiatan'),$table_label)?>
					</li>
				</ul>
			</div>
			<?php
			$act = 'add';
			if (isset($row) ) { // edit
				$act = 'edit/'.$row['id'];
			}
			?>
			<div class="row-fluid">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="icon-edit"></i> <?= $act == 'add' ? 'Tambah' : 'Edit' ?> <?=$table_label?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<?php
						if (isset($edit_status) && !empty($edit_status)) {
						?>
						<div class="alert alert-<?=$edit_status?>">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?php 
							if ($edit_status != 'success') { ?>
							<strong>Error !</strong> An error occurred, please verify your data.
							<?php
								if (isset($upload_error)) { echo $upload_error; }
							}
							?>
						</div>
						<?php
						}
						?>
						<form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?=site_url('data/kegiatan/'.$act)?>">
						  <fieldset>
							<div class="control-group">
							  <label class="control-label" for="id_kat">Kategori Kegiatan</label>
							  <div class="controls">
								<select name="id_kat" id="id_kat" data-rel="chosen" class="input-xxlarge validate[required]">
									<option></option>
									<?php
									if ( isset($kategoriOptions) ) {
										echo $kategoriOptions;
									}
									?>
								</select>
							  </div>
							</div>          
							<div class="control-group">
							  <label class="control-label" for="kegiatan">Kegiatan</label>
							  <div class="controls">
								<input type="text" class="input-xxlarge validate[required]" id="kegiatan" name="kegiatan" value="<?= isset($row) ? $row['kegiatan'] : '' ?>">
							  </div>
							</div>

							<div class="control-group">
							  <label class="control-label" for="skp">SKP Max</label>
							  <div class="controls">
								<input type="text" class="input-small validate[required]" id="skpmax" name="skpmax" value="<?= isset($row) ? $row['skpmax'] : '' ?>">
							  </div>
							</div>

							<div class="control-group">
							  <label class="control-label" for="dokumen">Dokumen Pendukung</label>
							  <div class="controls">
								<textarea class="input-xxlarge validate[required]" rows="3" id="dokumen" name="dokumen"><?= isset($row) ? $row['dokumen'] : '' ?></textarea>
							  </div>
							</div>

							<div class="form-actions">
							  <button type="submit" class="btn btn-primary">Save</button>
							  <button type="reset" class="btn">Cancel</button>
							</div>
						  </fieldset>
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->

			<?php // is edit ?
			if (! isset($row) ) { ?>
			<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><?=$table_label?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<?php
						$sql_info = $this->session->flashdata('sql_info');
						if ($sql_info) {
						?>
						<div class="alert alert-info">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Information</strong><br /> <?=$sql_info?>
						</div>
						<?php
						} ?>
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>#</th>
								  <th>Jenis</th>
								  <th>Kegiatan</th>
								  <th>SKP Max</th>
								  <th>Dokumen Pendukung</th>
								  <th width="60">Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  <?php
						  if ( isset($q) && ($q !== false) && ($q->num_rows() > 0) ) {
						  	$i = 0;
							foreach ($q->result() as $row) { $i++; 
								?>
							<tr>
								<td align="right"><?=$i?></td>
								<td><?=$row->jenis?></td>
								<td><?=$row->kegiatan?></td>
								<td align="right"><?=$row->skpmax?></td>
								<td><?=$row->dokumen?></td>
								<td align="center" class="dataeditlink">
									<a class="btn btn-mini btn-info" href="<?=site_url('data/kegiatan/edit/'.$row->id)?>" title="Edit"> <i class="icon-edit icon-white"></i>  </a>
									<a class="btn btn-mini btn-danger" href="#" onclick="if(confirm('Are you sure?')){window.location='<?=site_url('data/kegiatan/rm/'. str_replace('=','',base64_encode($row->id) ))?>';}" title="Delete"> <i class="icon-trash icon-white"></i> </a>
								</td>
							</tr>								
							<?php
							}
						  }
						  ?>
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
			<?php } ?>

<script type="text/javascript">
	$("form").validationEngine('attach', {prettySelect : true, useSuffix: "_chzn", promptPosition : "topLeft", scroll: true, binded: true, focusFirstField : true});
	//$("form").validationEngine('attach', {promptPosition : "bottomLeft", scroll: false, binded: true});
	$(document).ready(function(){
		var upload_info = $(':selected',$('select#idkegiatan')).attr('dokumen');
		if (typeof upload_info != 'undefined'){
			$('#upload_info').html('<p class="help-block"><em>('+ upload_info +')</em></p>');
		}
		$('form select#idkegiatan').change(function() {
			if ( $(':selected',$(this)).attr('eskp') == 'true') {
				$('#eskp').show();
			}else{
				$('#eskp').hide();
			}
			$('#upload_info').html('<p class="help-block"><em>('+ $(':selected',$(this)).attr('dokumen') +')</em></p>');
		});
		
	});
</script>    
