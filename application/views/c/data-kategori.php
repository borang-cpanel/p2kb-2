			<?php $table_label = 'Master Data Kategori Kegiatan';?>
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="<?=site_url()?>">Home</a> <span class="divider">/</span>
					</li>
					<li><?=anchor(site_url('data/kategori'),$table_label)?>
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
						<form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?=site_url('data/kategori/'.$act)?>">
						  <fieldset>
							<div class="control-group">
							  <label class="control-label" for="jenis">Kategori Kegiatan</label>
							  <div class="controls">
								<input type="text" class="input-xxlarge validate[required]" id="jenis" name="jenis" value="<?= isset($row) ? $row['jenis'] : '' ?>">
							  </div>
							</div>

							<div class="control-group">
							  <label class="control-label" for="skp">SKP</label>
							  <div class="controls">
								<input type="text" class="input-small validate[required]" id="skp" name="skp" value="<?= isset($row) ? $row['skp'] : '' ?>">
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
								  <th>SKP</th>
								  <th width="100">Actions</th>
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
								<td align="right"><?=$row->skp?></td>
								<td align="center" class="dataeditlink">
									<a class="btn btn-mini btn-info" href="<?=site_url('data/kategori/edit/'.$row->id)?>" title="Edit"> <i class="icon-edit icon-white"></i>  </a>
									<a class="btn btn-mini btn-danger" href="#" onclick="if(confirm('Are you sure?')){window.location='<?=site_url('data/kategori/rm/'. str_replace('=','',base64_encode($row->id) ))?>';}" title="Delete"> <i class="icon-trash icon-white"></i> </a>
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
