			<div>
				<ul class="breadcrumb">
					<li>
						<a href="<?=site_url()?>">Home</a> <span class="divider">/</span>
					</li>
					<li><?=anchor(site_url('reports'),'Generate Report')?>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2>Generate New Report</h2>
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
						<form class="form-horizontal" method="post">
						  <fieldset>
							<?php if ( $this->P2kb->udata['tipe'] != 'doc' ) { ?>
							<?php } ?>
							<div class="control-group">
							  <label class="control-label">Nama Dokter</label>
							  <div class="controls">
								<strong class="control-label" style="width:auto"><?php echo gelar_dokter($row->nama,$row->gelar); ?></strong>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="date01">Nomor Surat</label>
							  <div class="controls">
								<input type="text" name="nosurat" id="nosurat" class="input-medium validate[required]" />
							  </div>
							</div>
							<div class="control-group">
								<label class="control-label">Tanggal Surat</label>
								<div class="controls">
									<input name="tglsurat" class="input-small validate[required] datepicker" type="text" value="<? echo set_value('tglsurat'); ?>">
									<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('tglsurat'); ?> </div>
							</div>
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
							<div class="control-group" id="cert-info" style="display:none">
							  <label class="control-label" for="cert">Sertifikat Kesehatan</label>
							  <div class="controls">
							  	
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="etika">Etika Profesi</label>
							  <div class="controls">
							  	<?php echo form_dropdown('etika',$arr_etika,'','id="etika" class="validate[required]"'); ?>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="keterangan">Keterangan Etika Profesi</label>
							  <div class="controls">
								<textarea class="input-xxlarge" id="keterangan" name="keterangan" rows="5"></textarea>
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="kesehatan">Kondisi Kesehatan</label>
							  <div class="controls">
							  	<?php echo form_dropdown('kesehatan',$arr_kesehatan,'','id="kesehatan" class="validate[required]"'); ?>
							  </div>
							</div>							  
							<div class="control-group">
							  <label class="control-label" for="hasil">Hasil Evaluasi</label>
							  <div class="controls">
							  	<?php echo form_dropdown('hasil',$arr_hasil,'','id="hasil" class="input-xxlarge validate[required]"'); ?>
							  </div>
							</div>							  

							<div class="form-actions">
							  <button type="submit" class="btn btn-primary">Buat laporan</button>
							  <button type="reset" class="btn">Cancel</button>
							</div>
						  </fieldset>
						</form>   

					</div>
				</div><!--/span-->
			
			</div><!--/row-->

<script type="text/javascript">
	$("form").validationEngine('attach', {prettySelect : true, useSuffix: "_chzn", promptPosition : "topLeft", scroll: true, binded: true, focusFirstField : true});
	jQuery(document).ready(function($){
		var arr_periode = [<?= count($js_arrPeriode) > 0 ? '"'.implode('","',$js_arrPeriode).'"': '' ?>];
		var arr_hcerts = [<?= count($js_arrCerts) > 0 ? '"'.implode('","',$js_arrCerts).'"': ''?>];
		$('select#periode').change( function(){
			$('#cert-info').hide();
			period_index = arr_periode.indexOf( $(':selected',$(this)).val() );
			if ( period_index != -1 ) {
				$('#cert-info').children('div.controls').html('<p style="margin-top:5px"><a target="_blank" href="'+arr_hcerts[period_index]+'">View / Download Sertifikat Kesehatan periode '+$(':selected',$(this)).text()+'. </p>');
			}else{
				$('#cert-info').children('div.controls').html('<p class="red" style="margin-top:5px"><i class="icon-warning-sign"></i> Sertifikat Kesehatan periode '+$(':selected',$(this)).text()+' belum disertakan.</p>');
			}
			$('#cert-info').show('fast');
		});
	});
</script>