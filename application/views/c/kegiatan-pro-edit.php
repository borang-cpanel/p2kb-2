			<div>
				<ul class="breadcrumb">
					<li><a href="<?=site_url()?>">Home</a> <span class="divider">/</span></li>
					<li><?=anchor(site_url('kegiatan/category/'.$r['id']),$r['jenis'])?> <span class="divider">/</span></li>
					<li>Edit</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
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
						<form class="form-horizontal" id="kegiatanpro" method="post" enctype="multipart/form-data">
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
							  <label class="control-label" for="periode">Periode</label>
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
							  <label class="control-label" for="jeniskegiatan">Jenis Kegiatan</label>
							  <div class="controls">
								<select name="idkegiatan" id="jeniskegiatan" data-rel="chosen" class="input-xlarge validate[required]">
									<option></option>
									<?php
									if ( isset($kegiatanOptions) ) {
										echo $kegiatanOptions;
									}
									?>
								</select>
							  </div>
							</div>
							<?php
							$tot = 0;
							$arrKankerData = unserialize($row->pasien);
							foreach ($arrKankerData as $k => $v) {
								$tot = $tot+$v;
							}
							//print_r($arrKankerData);die();
							?>
							
							<?php foreach ($this->P2kb->arrKanker as $name => $label): ?> 
								<div class="control-group">
									<label class="control-label" for=""><?php echo $label ?></label>
									<div class="controls">
										<input type="text" class="input-small kanker validate[required]" name="<?php echo $name ?>" value="<?= set_value($name, $arrKankerData[$name]) ?>">
									</div>
								</div>
							<?php endforeach; ?>
								
							<div class="control-group">
							  <label class="control-label" for="">Total Pasien</label>
							  <div class="controls">
								<input type="text" class="input-small" name="pasien" value="<?= $tot ?>" disabled="disabled">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="">SKP</label>
							  <div class="controls">
								<input type="text" class="input-small" name="skp" value="<?= $row->skp ?>" disabled="disabled">
							  </div>
							</div>

							  <div class="control-group">
								<label class="control-label">Scan Bukti Kegiatan</label>
								<div class="controls">
								  <input type="file" name="scanbukti" class="<?php if(empty($row->dokumen)){echo 'validate[required]';} ?>">
									<span class="help-inline">.gif, .jpg, .png, .doc, .docx, .xls, .rtf, .txt &ndash; (<?=ini_get('upload_max_filesize')?> max.)</span>
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
								<div class="control-group">
									<em><sup>*</sup>Data yang dimasukkan adalah tumor primer</em>
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
								<button class="btn">Cancel</button>
							  </div>
							</fieldset>
						</form>
					</div>
				</div>

			</div>

<script language="javascript" type="text/javascript">
$("form#kegiatanpro").validationEngine('attach', {prettySelect : true, useSuffix: "_chzn", promptPosition : "bottomLeft", scroll: false, binded: true, focusFirstField : false});
$(document).ready(function(){
	var upload_info = $(':selected',$('select#jeniskegiatan')).attr('dokumen');
	if (typeof upload_info != 'undefined'){
		$('#upload_info').html('<p class="help-block"><em>('+ upload_info +')</em></p>');
	}
	function calc_skp() {
		var tot = 0;
		var skp = 0;
		$('input.kanker').each(function() {
			if ( ! isNaN( parseFloat ( $(this).val() ) ) ) {
				tot = tot + parseFloat ($(this).val());
			}
		});
		// get tipe; 20 = PB; 21 = BK 
		var jenis = parseFloat( $('select#jeniskegiatan').val() );

		if (jenis == 20) { // Eksterna 2D
			if ( tot >= 201 ) {
				skp = 25;
			} else if (tot >= 151)  {
				skp = 15;
			} else if ( tot >=100) {
				skp = 5;
			} else if (tot >0) {
			    skp = 3;
			}
		}else if (jenis == 21) { // Brakhiterapi 2D
			if ( tot >= 76 ) {
				skp = 25; 
			} else if ( tot >= 51 ) {
				skp = 15;
			} else if ( tot >=25 ) {
				skp = 5;
			} else if ( tot>0 ) {
				skp = 3;
			} 
		}else if(jenis == 74){ //eksterna 3d
		    if (tot >= 126){
		        skp = 30;
		    }else if (tot >= 101){
		        skp = 25;
		    }else if (tot >=76){
		        skp = 20;
		    }else if (tot >= 50){
		        skp = 15;
		    }else if (tot >0){
		        skp = 5;
		    }
		}else if(jenis == 75){//eksterna imrt
		    if (tot >= 76){
		        skp = 35;
		    }else if (tot >= 51){
		        skp = 30;
		    }else if (tot >=76){
		        skp = 20;
		    }else if (tot >= 25){
		        skp = 25;
		    }else if (tot>=0){
		        skp = 20;
		    }
		}else if (jenis==76){//eksterna srs/irts
		    if (tot >= 16){
		        skp = 45;
		    }else if (tot >= 11){
		        skp = 40;
		    }else if (tot >=5){
		        skp = 35;
		    }else if (tot >= 0){
		        skp = 25;
		    }
		}else if (jenis == 77){//brakhi 3d
		    if (tot >= 41){
		        skp = 30;
		    }else if (tot >= 30){
		        skp = 25;
		    }else if (tot >=20){
		        skp = 20;
		    }else if (tot >= 10){
		        skp = 15;
		    }else if (tot>=0){
		        skp = 10;
		    }
		}else if(jenis == 78){//nasofaring
		    if (tot >= 9){
		        skp = 20;
		    }else if (tot >= 6){
		        skp = 15;
		    }else if (tot >=3){
		        skp = 10;
		    }else if (tot >= 0){
		        skp = 5;
		    }
		}
		$('input[name="pasien"]').val( tot );
		$('input[name="skp"]').val( skp );

	}
	$('form#kegiatanpro input[type=text], form#kegiatanpro select#jeniskegiatan').change (function() {
		calc_skp();
	});
	$('select#jeniskegiatan').change (function() {
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