 			<div>
				<ul class="breadcrumb">
					<li>
						<a href="<?=site_url()?>">Home</a> <span class="divider">/</span>
					</li>
					<li>Generate Report
					</li>
				</ul>
			</div>
			
			<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2>Reports</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<?php
						$sql_info = $this->session->flashdata('report_sql_info');
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
								  <?php if ($this->P2kb->udata['tipe'] != 'doc') { ?>
								  <th>Dokter</th>
								  <?php } ?>
								  <th>No. Surat</th>
								  <th>Tanggal Surat</th>
								  <th>Periode</th>
								  <th>Hasil</th>
								  <th width="120">Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  <?php
						  if ( isset($qR) && ($qR !== false) && ($qR->num_rows() > 0) ) {
						  	$i = 0;
							foreach ($qR->result() as $row) { $i++; 
								$arr_periodes = explode('|', $row->periode);
								?>
							<tr>
								<td align="right"><?=$i?></td>
								<?php if ($this->P2kb->udata['tipe'] != 'doc') { ?>
								  <td><?=$row->nama?></td>
								<?php } ?>
								<td><?=$row->nosurat?></td>
								<td><?=format_the_date($row->tglsurat,'d/m/Y')?></td>
								<td align="center"><?= $arr_periodes[0] != '0000-00-00' && !empty($arr_periodes[0]) ? date('d/m/Y',strtotime($arr_periodes[0])) : '0'?> - <?= $arr_periodes[1] != '0000-00-00' && !empty($arr_periodes[1]) ? date('d/m/Y',strtotime($arr_periodes[1])) : '0' ?></td>
								<td><?=$arr_hasil[$row->hasil]?></td>
								<td align="center" class="dataeditlink">
									<a class="btn btn-mini btn-info" href="<?=site_url('reports/generate/'.$row->rid)?>" title="Laporan Sertifikasi Dokter"> <i class="icon-print icon-white"></i>&nbsp;Sertifikasi </a>
									<?php
									if (  ($this->P2kb->udata['tipe'] != 'doc') ) { ?>
									<a class="btn btn-mini btn-danger" href="#" onclick="if(confirm('Are you sure?')){window.location='<?=site_url('reports/rm/'. str_replace('=','',base64_encode($row->rid) ))?>';}" title="Delete"> <i class="icon-trash icon-white"></i> </a>
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
			
			<?php
			if ( $this->P2kb->udata['tipe'] != 'doc' ) { ?>
			<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2>Generate New Report</h2>
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
								  <th>NRA</th>
								  <th>Nama</th>
								  <th>Surat Registrasi</th>
								  <th>Foto</th>
								  <th width="135">Actions</th>
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
								<td><?=$row->nra?></td>
								<td><?=$row->nama?></td>
								<td align="center"><?= $row->regstart != '0000-00-00' && !empty($row->regstart) ? date('d/m/Y',strtotime($row->regstart)) : '0'?> - <?= $row->regend != '0000-00-00' && !empty($row->regend) ? date('d/m/Y',strtotime($row->regend)) : '0' ?></td>
								<td align="center"><?= $row->foto ? anchor(base_url().'media/'. $row->foto,'View','target="_blank"') : '' ?></td>
								<td align="center" class="dataeditlink">
									<?php
									if ( $this->P2kb->udata['tipe'] != 'doc' ) { ?>
									<a class="btn btn-mini btn-info" href="<?=site_url('reports/skp/'.$row->id)?>" title="Rekap SKP Dokter"> <i class="icon-file icon-white"></i>&nbsp;SKP </a>
									<a class="btn btn-mini btn-info" href="<?=site_url('reports/create/'.$row->id)?>" title="Create Laporan Sertifikasi Dokter"> <i class="icon-print icon-white"></i>&nbsp;Sertifikasi </a>
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
			<?php
			} 
			?>

