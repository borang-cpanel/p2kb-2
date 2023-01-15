
			<div>
				<ul class="breadcrumb">
					<li><a href="<?=site_url()?>">Home</a> <span class="divider">/</span></li>
					<li>Dashboard</li>
				</ul>
			</div>
						
			<?php if ( ($this->P2kb->udata['tipe'] == 'adm') && (!empty($unread)) ) { ?>
			<div class="sortable row-fluid ui-sortable">
				<a data-rel="tooltip" class="well span12 top-block notif-unread" href="<?=site_url('messages')?>" data-original-title="<?=$unread?> new messages.">
					<span class="icon32 icon-orange icon-envelope-closed"></span>
					<div>You have <?=$unread?> unread message(s).</div>
					<span class="notification red"><?=$unread?></span>
				</a>
			</div>
			<?php }?>
							
			<div class="row-fluid">
				<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> Rekap Aktifitas Dokter</h2>
						
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable rekap-skp">
						  <thead>
							  <tr>
								  <th>Kategori</th>
								  <th>Aktivitas baru</th>
								  <th>Disetujui</th>
								  <th>Ditolak</th>
								  <th>Total</th>
							  </tr>
						  </thead>
						  <tbody>
						  <?php
						  if (isset($r) and !empty($r)) {
						  	foreach( $r as $k => $row ) { 

							?>
							<tr>
								<td><a href="<?=site_url('kegiatan/category/'.$row['id'])?>"><?=$row['jenis']?></a> </td>
								<td align="center" class="center"><strong class="yellow"><?=$row['act_0']?></strong></td>
								<td align="center" class="center"><strong class="green"><?=$row['act_1']?></strong></td>
								<td align="center" class="center"><strong class="red"><?=$row['act_2']?></strong></td>
								<td align="center" class="center"><strong><?=$row['act_tot']?></strong></td>
							</tr>									
								<?php
							}
						  }
						  ?>
						  </tbody>
					  </table>            
					
					</div>
				</div>
			</div>
					
