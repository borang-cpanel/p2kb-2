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
			<div class="row-fluid">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="icon-edit"></i> Tambah <?=$r['jenis']?></h2>
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
							  <label class="control-label" for="date01">Tanggal</label>
							  <div class="controls">
								<input type="text" class="input-small datepicker validate[required]" id="date01" name="kdate" value="<?= set_value('kdate') ?>">
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
								<textarea class="input-xxlarge validate[required]" id="keterangan" name="keterangan" rows="5"><?= set_value('keterangan') ?></textarea>
							  </div>
							</div>
							<?php if ( isset($enable_skp) && ($enable_skp) ) { ?>
							<div class="control-group" id="eskp" <?= $this->P2kb->udata['tipe'] != 'doc' ? '' : 'style="display:none"'?>>
							  <label class="control-label" for="skp">SKP</label>
							  <div class="controls">
								<input type="text" class="input-small validate[required]" id="skp" name="skp" value="<?= set_value('skp') ?>">
							  </div>
							</div>
							<?php } ?>
							  <div class="control-group">
								<label class="control-label">Scan Bukti Kegiatan</label>
								<div class="controls">
                                    <input type="file" name="scanbukti" class="input-small validate[required]">
								  <span class="help-inline">.gif, .jpg, .png, .pdf, .doc, .docx, .xls, .rtf, .txt &ndash; (<?=ini_get('upload_max_filesize')?> max.)</span>
								  <div id="upload_info"></div>
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
								  <th>Tanggal</th>
								  <?php if ($this->P2kb->udata['tipe'] != 'doc') { ?>
								  <th>Dokter</th>
								  <?php } ?>
								  <th>Kegiatan</th>
								  <th>Keterangan</th>
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
								switch ($row->acv) {
									case 0 : $kol_status = '<span class="label">Pending</span>'; break;
									case 1 : $kol_status = '<span class="label label-success" title="Approved, non-editable.">Approved</span>'; break;
									case 2 : $kol_status = '<span class="label label-important">Rejected</span>'; break;
								}
								?>
							<tr>
								<td align="right"><?=$i?></td>
								<td><?= date('Y-m-d', strtotime($row->tanggal)) ?></td>
								  <?php if ($this->P2kb->udata['tipe'] != 'doc') { ?>
								  <td><?=$row->nama?></td>
								  <?php } ?>
								<td><?=$row->kegiatan?></td>
								<td><?=$row->ket?></td>
								<td align="right"><?php if ($row->skp_reject) {?><em><span class="strikethru" title="SKP revised by Kolegium !"><?=$row->skp_reject?></span></em> <?php } ?><?=$row->skp?></td>
								<td align="center"><?=$kol_status ?></td>
								<td align="center" class="dataeditlink">
									<?php
									if ( ($row->acv != 1) or ($this->P2kb->udata['tipe'] != 'doc') ) { ?>
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

<script type="text/javascript">
	$("form").validationEngine('attach', {prettySelect : true, useSuffix: "_chzn", promptPosition : "topLeft", scroll: true, binded: true, focusFirstField : true});
	//$("form").validationEngine('attach', {promptPosition : "bottomLeft", scroll: false, binded: true});
	$(document).ready(function(){
		var upload_info = $(':selected',$('select#idkegiatan')).attr('dokumen');
		if (typeof upload_info != 'undefined'){
			$('#upload_info').html('<p class="help-block"><em>('+ upload_info +')</em></p>');
		}
		//$('#skp').val( $(':selected',$('select#idkegiatan')).attr('skpmax') );
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
