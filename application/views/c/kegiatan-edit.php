			<div>
				<ul class="breadcrumb">
					<li><a href="<?=site_url()?>">Home</a> <span class="divider">/</span></li>
					<li><?=anchor(site_url('kegiatan/category/'.$r['id']),$r['jenis'])?> <span class="divider">/</span></li>
					<li>Edit</li>
				</ul>
			</div>
			
			<div class="row-fluid">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="icon-edit"></i> Edit <?=$r['jenis']?></h2>
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
							  <label class="control-label" for="date01">Tanggal</label>
							  <div class="controls">
								<input type="text" class="input-small datepicker validate[required]" id="date01" name="kdate" value="<?=set_value('kdate',$row->tgl)?>">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="idkegiatan">Jenis Kegiatan</label>
							  <div class="controls">
								<select name="idkegiatan" id="idkegiatan" data-rel="chosen" class="input-xxlarge validate[required]">
									<option></option>
									<?php
									if ( isset($kegiatanOptions) ) {
										echo $kegiatanOptions;
									}
									?>
								</select>
							  </div>
							</div>          
							<div class="control-group">
							  <label class="control-label" for="keterangan">Keterangan</label>
							  <div class="controls">
								<textarea class="input-xxlarge validate[required]" id="keterangan" name="keterangan" rows="5"><?=set_value('keterangan',$row->ket)?></textarea>
							  </div>
							</div>
							<?php if ( isset($enable_skp) && ($enable_skp) ) { ?>
							<div class="control-group" id="eskp" <?= $this->P2kb->udata['tipe'] != 'doc' ? '' : 'style="display:none"'?>>
							  <label class="control-label" for="skp">SKP</label>
							  <div class="controls">
								<input type="text" class="input-small validate[required]" id="skp" name="skp" value="<?=set_value('skp',$row->skp)?>">
								<?php if ($row->skp_reject) {?><span class="help-inline"><span class="strikethru" title="SKP revised by Komisi P2KB !"><?=$row->skp_reject?></span></span> <?php } ?>
							  </div>
							</div>
							<?php } ?>
							  <div class="control-group">
								<label class="control-label">Scan Bukti Kegiatan</label>
								<div class="controls">
                                    <input type="file" name="scanbukti" class="<?php if(empty($row->dokumen)){echo 'validate[required]';} ?>">
									<span class="help-inline">.gif, .jpg, .png, .pdf, .doc, .docx, .xls, .rtf, .txt &ndash; (<?=ini_get('upload_max_filesize')?> max.)</span>
									<div id="upload_info"></div>
									<?php
									if ($row->dokumen) { ?>
									<p class="help-block"><a href="<?=base_url().'media/'.$row->dokumen?>" target="_blank">View document attachment &ndash; <?=$row->dokumen?></a>
									  <label class="checkbox inline">
										<input type="checkbox" id="delete_attc" name="delete_att" value="1"> delete attachment
									  </label>
									</p>
									<?php } ?>
								</div>
							  </div>
							<?php if ( $this->P2kb->udata['tipe'] != 'doc' ) { ?>
							<div class="control-group">
							  <label class="control-label" for="acv">Approval</label>
							  <div class="controls">
								<?php
								echo form_dropdown('acv',$this->P2kb->optApproval,$row->acv,'id="acv" class=""');
								?>
							  </div>
							</div>
							<?php } ?>
							  

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
        
        $('input[name="scanbukti"]').change(function(){
            disabledDeleteAtt();
        });

        disabledDeleteAtt();

        function disabledDeleteAtt()
        {
            if($('input[name="scanbukti"]').val() == '')
            {
                $('input#delete_attc').attr('disabled', true);
            }
            else
            {
                $('input#delete_attc').attr('disabled', false);
                $('input#delete_attc').parents().each(function(index, element){
                    if($(element).hasClass('disabled'))
                    {
                        $(element).removeClass('disabled');
                    }
                });
            }
        }		
	});
</script>    
