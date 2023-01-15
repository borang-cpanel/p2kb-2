			<div>
				<ul class="breadcrumb">
					<li>
						<a href="<?=site_url()?>">Home</a> <span class="divider">/</span>
					</li>
					<li><?=anchor(site_url('kegiatan/category/'.$r['id']),$r['jenis'])?>
					</li>
				</ul>
			</div>
			
			<?php
			if ($this->P2kb->udata['tipe'] == 'doc') { ?>
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Tambah <?=$r['jenis']?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" id="kegiatanpro" method="post" enctype="multipart/form-data">
							<fieldset>
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
								
							<?php foreach ($this->P2kb->arrKanker as $name => $label): ?> 
								<div class="control-group">
									<label class="control-label" for=""><?php echo $label ?></label>
									<div class="controls">
										<input type="text" class="input-small kanker validate[required]" name="<?php echo $name ?>" value="<?= set_value($name, 0) ?>">
									</div>
								</div>
							<?php endforeach; ?>
								
							<div class="control-group">
							  <label class="control-label" for="">Total Pasien</label>
							  <div class="controls">
								<input type="text" class="input-small" name="pasien" value="<?= set_value('pasien') ?>" disabled="disabled">
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="">SKP</label>
							  <div class="controls">
								<input type="text" class="input-small" name="skp" value="<?= set_value('skp') ?>" disabled="disabled">
							  </div>
							</div>

							  <div class="control-group">
								<label class="control-label">Scan Bukti Kegiatan</label>
								<div class="controls">
									<input type="file" name="scanbukti" class="validate[required]">
									<span class="help-inline">.gif, .jpg, .png, .pdf, .doc, .docx, .xls, .rtf, .txt &ndash; (<?=ini_get('upload_max_filesize')?> max.)</span>
									<div id="upload_info"></div>
								</div>
							  </div>
								<div class="control-group">
									<em><sup>*</sup>Data yang dimasukkan adalah tumor primer</em>
								</div>
							  
							  <div class="form-actions">
								<button type="submit" class="btn btn-primary">Save changes</button>
								<button class="btn">Cancel</button>
							  </div>
							</fieldset>
						</form>
					</div>
				</div>

			</div>
			<?php
			} ?>

			<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><?=$r['jenis']?></h2>
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
								  <th>Periode</th>
								  <?php if ($this->P2kb->udata['tipe'] != 'doc') { ?>
								  <th>Doctor</th>
								  <?php } ?>
								  <th>Kegiatan</th>
								  <th>Keterangan</th>
								  <th>Pasien</th>
								  <th>SKP</th>
								  <th>Komisi P2KB status</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  <?php
						  if ( isset($q) && ($q !== false) && ($q->num_rows() > 0) ) {
						  	$i = 0;
							foreach ($q->result() as $row) { $i++; 
								$data_pasien = array();
								$arrPasien = unserialize( $row->pasien );
								foreach($arrPasien as $kn => $jum) {
									$data_pasien[] = '<span class="label">'.'Kanker '.$this->P2kb->arrKanker[$kn].'&nbsp;=&nbsp;'.$jum.'</span> ';
								}
								switch ($row->acv) {
									case 0 : $kol_status = '<span class="label">Pending</span>'; break;
									case 1 : $kol_status = '<span class="label label-success" title="Approved, non-editable.">Approved</span>'; break;
									case 2 : $kol_status = '<span class="label label-important">Rejected</span>'; break;
								}
								?>
							<tr>
								<td align="right"><?=$i?></td>
								<td><?=date('Y-m-d', strtotime($row->tanggal)) ?> - <?= date('Y-m-d', strtotime($row->tanggal2)) ?></td>
								  <?php if ($this->P2kb->udata['tipe'] != 'doc') { ?>
								  <td><?=$row->nama?></td>
								  <?php } ?>
								<!--<td><?=$row->jenis?></td>-->
								<td><?=$row->kegiatan?></td>
								<td><?=$row->ket ?></td>
								<td><?= !empty($data_pasien) ? join(' &mdash; ',$data_pasien) : '';?></td>
								<td align="right"><?=$row->skp?></td>
								<td align="center"><?=$kol_status ?></td>
								<td align="center" class="dataeditlink">
									<?php
									if ( ($row->acv == 0) or ($this->P2kb->udata['tipe'] != 'doc') ) { ?>
									<a class="btn btn-mini btn-info" href="<?=site_url('kegiatan/category/'.$row->id_kat.'/edit/'.$row->id)?>" title="Edit"> <i class="icon-edit icon-white"></i>  </a>
										<?php
										if ($this->P2kb->udata['tipe'] == 'doc') { ?>
									<a class="btn btn-mini btn-danger" href="#" onclick="if(confirm('Are you sure?')){window.location='<?=site_url('kegiatan/category/'.$row->id_kat.'/rm/'. str_replace('=','',base64_encode($row->id) ))?>';}" title="Delete"> <i class="icon-trash icon-white"></i> </a>
										<?php 
										}
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
			} else if (tot >= 151) {
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
});
</script>