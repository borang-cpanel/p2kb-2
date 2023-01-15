
			<div>
				<ul class="breadcrumb">
					<li><a href="<?=site_url()?>">Home</a> <span class="divider">/</span></li>
					<li>Dashboard</li>
				</ul>
			</div>
			
			<?php if ($isNearExpire) { ?>
            <div class="sortable row-fluid ui-sortable">
				<a data-rel="tooltip" class="well span12 top-block notif-unread" href="#">
					<span class="icon32 icon-orange icon-envelope-closed"></span>
					<div style="color:#a00">Surat Tanda Registrasi Anda akan kadaluarsa kurang dari 6 bulan lagi. Mohon untuk segera lengkapi data agar dapat diurus perpanjangan tepat waktu.</div>
				</a>
			</div>
			<?php } ?>

            <?php if (!$isCompleted) { ?>
            <div class="sortable row-fluid ui-sortable">
				<a data-rel="tooltip" class="well span12 top-block notif-unread" href="<?=site_url('messages')?>" data-original-title="<?=$unread?> new messages.">
					<span class="icon32 icon-orange icon-envelope-closed"></span>
					<div style="color:#a00">Anda belum bisa melakukan pengisian karena data Anda belum lengkap. Mohon lengkapi data pribadi Anda terlebih dahulu.</div>
				</a>
			</div>
			<?php } ?>
			
			<?php if (!empty($unread)) { ?>
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
						<h2><i class="icon-info-sign"></i> Rekap Nilai SKP Yang Telah Terkumpul</h2>
						
					</div>
					<div class="box-content">

						<form class="form-inline change-period" method="post" enctype="multipart/form-data">
						  <fieldset>
							<div class="control-group">
								<div class="controls">
									<label for="periode">Periode</label>
									<select name="periode" id="periode" class="input-xlarge validate[required]">
										<option></option>
										<?php
										if ( isset($periodeOptions) ) {
											echo $periodeOptions;
										}
										?>
									</select>
									<button type="submit" class="btn btn-primary btn-small">Submit</button>			
								</div>
							</div>

						  </fieldset>
						</form>   

					
						<table class="table table-striped table-bordered bootstrap-datatable rekap-skp">
						  <thead>
							  <tr>
								  <th>Kategori</th>
								  <th>SKP</th>
								  <th align="center">SKP Max </th>
								  <th>Status</th>
							  </tr>
						  </thead>
						  <tbody>
						  <?php
						  $sum_skp_doc = 0; 
						  $sum_skp_max = 0; 
						  if (isset($r) and !empty($r)) {
						  	foreach( $r as $k => $row ) { 

								$sum_skp_doc += $row['skp_doc'];
								$sum_skp_max += $row['skp'];

								if ($row['skp_doc'] >= $row['skp']) {
									$class_skp = 'green';
									$class_stat = 'icon-check';
									$skp_status = 'Sudah mencapai target';
								}else{
									$class_skp = 'red';
									$class_stat = 'icon-alert';
									$skp_status = 'Belum mencapai target';
								}
								
							?>
							<tr>
								<td><a href="<?=site_url('kegiatan/category/'.$row['id'])?>"><?=$row['jenis']?></a> </td>
								<td align="center" class="center"><strong class="<?=$class_skp?>"><?=$row['skp_doc']?></strong></td>
								<td align="center" class="center"><strong class="blue"><?=$row['skp']?></strong></td>
								<td class="center"><span class="icon icon-color <?=$class_stat?>"></span> <?=$skp_status?></td>
							</tr>									
								<?php
							}
						  }else{ ?>
							<tr>
								<td colspan="4" align="center"><em>Silakan pilih periode terlebih dahulu.</td>
							</tr>
						  <?php
						  }
						  ?>
							<tr>
								<td>&nbsp;</td>
								<td align="center" class="center"><strong class="<?= $sum_skp_doc < $sum_skp_max ? 'red' : 'green'?>"><?=$sum_skp_doc?></strong></td>
								<td align="center" class="center"><strong class="blue"><?=$sum_skp_max?></strong></td>
								<td>&nbsp;</td>
							</tr>									
						  </tbody>
					  </table>            
					
					</div>
				</div>
			</div>
					
