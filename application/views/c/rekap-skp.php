
			<div>
				<ul class="breadcrumb">
					<li><a href="<?=site_url()?>">Home</a> <span class="divider">/</span></li>
					<li><a href="<?=site_url()?>reports">Reports</a> <span class="divider">/</span></li>
					<li>Rekap SKP Dokter</li>
				</ul>
			</div>
						
			<div class="row-fluid">
				<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> Rekap Nilai SKP Dokter</h2>
						
					</div>
					<div class="box-content">
						<h4><?php if (isset($doc)) { echo ''.$doc->nama.''; }?></h4>

						<form class="form-inline change-period" method="post" enctype="multipart/form-data">
						  <fieldset>
							<div class="control-group">
								<div class="controls">
									<label for="periode">Periode</label>
									<select name="periode" id="periode" class="input-xlarge validate[required]">
										<option></option>
										<?php
										if ( isset($periodeOptions) ) {
										    //2021-08-09 ganti sementara karena ada perubahan aturan periode mengikuti STR, ini dr Susworo
										    if($doc->id==40){
										        echo '<option value="2011-03-18|2016-03-17">18/03/2011 - 17/03/2016</option><option value="2016-03-18|2022-01-15">18/03/2016 - 15/01/2022</option><option value="2021-03-18|2026-03-17">18/03/2021 - 17/03/2026</option>';
										    }else if($doc->id==135){
										    //2021-08-23 untuk dr. Tjachja 
										       echo '<option value="2012-01-24|2017-01-23">24/01/2012 - 23/01/2017</option><option value="2017-01-24|2022-03-15">24/01/2017 - 15/03/2022</option>';
										    }else if($doc->id==138){
										    //2021-08-23 untuk dr. Daksa 
										       echo '<option value="2012-01-24|2017-01-23">24/01/2012 - 23/01/2017</option><option value="2017-01-24|2022-03-15">24/01/2017 - 15/03/2022</option>';
										    }else{
											    echo $periodeOptions;
										    }
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
					
