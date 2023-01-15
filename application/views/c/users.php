			<div>
				<ul class="breadcrumb">
					<li>
						<a href="<?=site_url()?>">Home</a> <span class="divider">/</span>
					</li>
					<li><?=anchor(site_url('users'),'Users')?>
					</li>
				</ul>
			</div>


			<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2>Users</h2>
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
						<p class="text-right" align="right">
							<a href="<?php echo site_url('users/add')?>" class="btn btn-primary"><i class="icon-user icon-white"></i> Add New User</a>
						</p>
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>#</th>
								  <th>Tipe</th>
								  <th>NRA</th>
								  <!--<th>Anggota Sejak</th>-->
								  <th>Nama</th>
								  <!--<th>Gelar</th>-->
								  <th>Lahir</th>
								  <th>Sex</th>
								  <!--<th>Alamat</th>-->
								  <th>Registrasi</th>
								  <th>Foto</th>
								  <th>Status</th>
								  <th width="100">Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  <?php
						  if ( isset($q) && ($q !== false) && ($q->num_rows() > 0) ) {
						  	$i = 0;
							foreach ($q->result() as $row) { $i++; 
								switch ($row->acv) {
									case 0 : $ustatus = '<span class="label">Inactive</span>'; break;
									case 1 : $ustatus = '<span class="label label-success">Active</span>'; break;
									case 2 : $ustatus = '<span class="label label-important">BANNED</span>'; break;
								}
								switch ($row->tipe) {
									case 'doc' : $utype = 'Doctor'; break;
									case 'kol' : $utype = '<span class="label">Komisi P2KB</span>'; break;
									case 'adm' : $utype = '<span class="label">Administrator</span>'; break;
								}
								?>
							<tr>
								<td align="right"><?=$i?></td>
								<td><?=$utype?></td>
								<td><?=$row->nra?></td>
								<!--<td><?=$row->tahun?></td>-->
								<td><?=$row->nama?></td>
								<!--<td><?=$row->gelar?></td>-->
								<td><?= $row->lhr.', '.$row->lhrtgl?></td>
								<td><?=$row->sex?></td>
								<!--<td><?=$row->rumah?> <?=$row->rumahpos ? 'Kode POS: '.$row->rumahpos:''?></td>-->
								<td><?= $row->regstart != '0000-00-00' && !empty($row->regstart) ? date('d/m/Y',strtotime($row->regstart)) : '0'?> - <?= $row->regend != '0000-00-00' && !empty($row->regend) ? date('d/m/Y',strtotime($row->regend)) : '0' ?></td>
								<td align="center"><?= $row->foto ? anchor(base_url().'media/'. $row->foto,'View','target="_blank"') : '' ?></td>
								<td><?=$ustatus?></td>
								<td align="center" class="dataeditlink">
									<a class="btn btn-mini btn-info" href="<?=site_url('users/changepass/'.$row->id)?>" title="Change Password"> <i class="icon icon-white icon-key"></i>  </a>
									<a class="btn btn-mini btn-info" href="<?=site_url('users/edit/'.$row->id)?>" title="Edit"> <i class="icon-edit icon-white"></i>  </a>
									<a class="btn btn-mini btn-danger" href="#" onclick="if(confirm('Are you sure?')){window.location='<?=site_url('users/rm/'. str_replace('=','',base64_encode($row->id) ))?>';}" title="Delete"> <i class="icon-trash icon-white"></i> </a>
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
