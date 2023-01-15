			<div>
				<ul class="breadcrumb">
					<li><a href="<?=site_url()?>">Home</a> <span class="divider">/</span></li>
					<li><a href="<?=site_url('healthcert')?>">Sertifikat Kesehatan Dokter</a> <span class="divider">/</span></li>
					<li>Edit</li>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="icon-edit"></i> Edit Sertifikat Kesehatan Dokter</h2>
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
							if ($edit_status == 'success') { ?>
							<strong>Updated !</strong> You have successfully update row data.
							<?php
							}else{ ?>
							<strong>Error !</strong> An error occurred while updating data.
							<?php
							}
							?>
						</div>
						<?php
						}?>
						<form class="form-horizontal" method="post" enctype="multipart/form-data">
						  <fieldset>
							<?php if ( $this->P2kb->udata['tipe'] != 'doc' ) { ?>
							<div class="control-group">
							  <label class="control-label">Doctor</label>
							  <div class="controls">
								<strong class="control-label" style="width:auto"><?php echo $row->nama; ?></strong>
							  </div>
							</div>
							<?php } ?>
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
									<?php
									if ($row->scanhealthcert) { ?>
									<p class="help-block"><a href="<?=base_url().'media/'.$row->scanhealthcert?>" target="_blank">View document attachment &ndash; <?=$row->scanhealthcert?></a>
									  <label class="checkbox inline">
										<input type="checkbox" id="delete_attc" name="delete_att" value="1"> delete attachment
									  </label>
									</p>
									<?php } ?>
								</div>
							</div>							  
							<div class="control-group">
							  <label class="control-label" for="keterangan">Keterangan</label>
							  <div class="controls">
								<textarea class="input-xxlarge validate[required]" id="keterangan" name="keterangan" rows="5"><?=set_value('keterangan',$row->ket)?></textarea>
							  </div>
							</div>

							<div class="form-actions">
							  <button type="submit" class="btn btn-primary">Save changes</button>
							  <button type="reset" class="btn">Cancel</button>
							</div>
						  </fieldset>
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->

<script type="text/javascript">
	$("form").validationEngine('attach', {prettySelect : true, useSuffix: "_chzn", promptPosition : "bottomLeft", scroll: true, binded: true, focusFirstField : true});
	//$("form").validationEngine('attach', {promptPosition : "bottomLeft", scroll: false, binded: true});
	$(document).ready(function(){
		var upload_info = $(':selected',$('select#idkegiatan')).attr('dokumen');
		if (typeof upload_info != 'undefined'){
			$('#upload_info').html('<p class="help-block"><em>('+ upload_info +')</em></p>');
		}
		if ( $(':selected',$('select#idkegiatan')).attr('eskp') == 'true') {
			$('#eskp').show();
		}
		$('form select#idkegiatan').change(function() {
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
