			<div>
				<ul class="breadcrumb">
					<li>
						<a href="<?=site_url()?>">Home</a> <span class="divider">/</span>
					</li>
					<li>Sertifikat Kesehatan Dokter</li>
					</li>
				</ul>
			</div>
			
			<?php
			if ($this->P2kb->udata['tipe'] == 'doc') { ?>
			<div class="row-fluid">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="icon-edit"></i> Tambah Sertifikat Kesehatan</h2>
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
						}?>
						<form class="form-horizontal" method="post" enctype="multipart/form-data">
						  <fieldset>
							<div class="control-group">
							  <label class="control-label" for="date01">Periode</label>
							  <div class="controls">
								<select name="periode" id="periode" data-rel="chosen" class="input-xlarge validate[required]">
									<option></option>
									<?php
									if ( isset($periodeOptions) ) {
										echo $periodeOptions;
									}
									?>
								</select>
							  </div>
							</div>
							<div class="control-group">
								<label class="control-label">Scan Sertifikat Kesehatan</label>
								<div class="controls">
								  <input type="file" name="scanbukti">
								  <span class="help-inline">.gif, .jpg, .png, .pdf, .doc, .docx, .xls, .rtf, .txt &ndash; (<?=ini_get('upload_max_filesize')?> max.)</span>
								  <div id="upload_info"></div>
								</div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="keterangan">Keterangan</label>
							  <div class="controls">
								<textarea class="input-xxlarge validate[required]" id="keterangan" name="keterangan" rows="5"><?= set_value('keterangan') ?></textarea>
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
			<?php
			} ?>

			<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2>Sertifikat Kesehatan Dokter</h2>
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
								  <th> Periode</th>
								  <?php if ($this->P2kb->udata['tipe'] != 'doc') { ?>
								  <th>Dokter</th>
								  <?php } ?>
								  <th>Sertifikat Kesehatan</th>
								  <th>Keterangan</th>
								  <th>Actions</th>
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
								<td align="center"><?= $row->tgl != '0000-00-00' && !empty($row->tgl) ? date('d/m/Y',strtotime($row->tgl)) : '0'?> - <?= $row->tgl2 != '0000-00-00' && !empty($row->tgl2) ? date('d/m/Y',strtotime($row->tgl2)) : '0' ?></td>
								  <?php if ($this->P2kb->udata['tipe'] != 'doc') { ?>
								  <td><?=$row->nama?></td>
								  <?php } ?>
								<td align="center"><?= $row->scanhealthcert ? anchor(base_url().'media/'. $row->scanhealthcert,'View','target="_blank"') : '' ?></td>

								<td><?=$row->ket?></td>
								<td align="center" class="dataeditlink">
									<a class="btn btn-mini btn-info" href="<?=site_url('healthcert/edit/'.$row->id)?>" title="Edit"> <i class="icon-edit icon-white"></i>  </a>
									<?php
									if (  ($this->P2kb->udata['tipe'] != 'doc') ) { ?>
									<a class="btn btn-mini btn-danger" href="#" onclick="if(confirm('Are you sure?')){window.location='<?=site_url('healthcert/rm/'. str_replace('=','',base64_encode($row->id) ))?>';}" title="Delete"> <i class="icon-trash icon-white"></i> </a>
									<?php 
									} ?>
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

<script type="text/javascript">
	$("form").validationEngine('attach', {prettySelect : true, useSuffix: "_chzn", promptPosition : "topLeft", scroll: true, binded: true, focusFirstField : true});
	$(document).ready(function(){
		var upload_info = $(':selected',$('select#idkegiatan')).attr('dokumen');
		if (typeof upload_info != 'undefined'){
			$('#upload_info').html('<p class="help-block"><em>('+ upload_info +')</em></p>');
		}

		$('form select#idkegiatan').change(function() {
			//$('#skp').val( $(':selected',$(this)).attr('skpmax') );
			<?php if ( isset($enable_skp) && ($enable_skp) ) {
					if ($this->P2kb->udata['tipe'] == 'doc') { ?>
			if ( $(':selected',$(this)).attr('eskp') == 'true') {
				$('#eskp').show();
			}else{
				$('#eskp').hide();
			}
			<?php  } 
				} ?>
			$('#upload_info').html('<p class="help-block"><em>('+ $(':selected',$(this)).attr('dokumen') +')</em></p>');
		});
		
	});
</script>    
