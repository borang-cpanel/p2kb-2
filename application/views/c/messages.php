			<div>
				<ul class="breadcrumb">
					<li><a href="<?=site_url()?>">Home</a> <span class="divider">/</span></li>
					<li><?=anchor(site_url('messages'),'Messages')?></li>
				</ul>
			</div>
			
			<div class="row-fluid">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="icon-envelope"></i> Messages</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-messages datatable">
							  <thead>
								  <tr>
									  <th width="15">&nbsp;</th>
									  <th width="15">&nbsp;</th>
									  <?php if ($this->P2kb->udata['tipe'] == 'adm') { ?>
									  <th width="150">From</th>
									  <th width="150">To</th>
									  <?php } ?>
									  <th width="150">Date</th>
									  <th>Subject</th>
								  </tr>
							  </thead>   
							  <tbody>
							  <?php
							  if (isset($q) and is_object($q)) {
							  	foreach($q->result() as $row) { ?>
								<tr>
									<?php if ($this->P2kb->udata['tipe'] == 'adm') { ?>
									<td><?= !empty($row->receipt) ? '<span class="icon icon-reply" title="Sent message"/>':'<span class="icon icon-inbox" title="Inbox"/>'?></td>
									<?php }else{ ?>
									<td><?= $row->sender == $this->P2kb->udata['id'] ? '<span class="icon icon-reply" title="Sent message"/>':'<span class="icon icon-inbox" title="Inbox"/>'?></td>
									<?php } ?>
									<td><?php 
										if ($row->st == 0) {
											if ( $this->P2kb->udata['tipe'] == 'doc') { 
												if ($row->receipt == $this->P2kb->udata['id'])
													echo '<span class="icon icon-orange icon-mail-closed" title="Unread message"/>';
												elseif ($row->receipt == '0')
													echo '<span class="icon icon-darkgray icon-mail-closed" title="Unread by recipient"/>';
													
											}elseif ($this->P2kb->udata['tipe'] == 'adm') {
												if ($row->receipt == '0')
													echo '<span class="icon icon-orange icon-mail-closed" title="Unread message"/>';
												elseif ($row->sender == $this->P2kb->udata['id'])
													echo '<span class="icon icon-darkgray icon-mail-closed" title="Unread by recipient"/>';
													
											}else {
												echo '<span class="icon icon-mail-closed" title="Unread by recipient"/>';												
											}
										} else {
											echo '<span class="icon icon-mail-open" title="Read by recipient"/>';
										}
										?></td>                                       
									<?php if ($this->P2kb->udata['tipe'] == 'adm') { ?>
									<td class="center"><?=$row->tipe == 'adm' ? '<span class="label">Administrator</span>' : $row->nama?></td>
									<?php } ?>
									<?php if (($this->P2kb->udata['tipe'] == 'adm') && isset($arrDoctors) ) { 
											?> <td class="center"><?=isset($arrDoctors[$row->receipt])? $arrDoctors[$row->receipt] : '<span class="label">Administrator</span>'?></td> <?php
										  }
									?>
									<td class="center"><?=$row->tanggal?></td>
									<td class="center"><a href="<?=site_url('messages/read/'.$row->id)?>"><?=$row->title?></a></td>
								</tr><?php
								}
							   } ?>
							  </tbody>
						 </table> 

					</div>
				</div><!--/span-->

			</div><!--/row-->

			<div class="row-fluid">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="icon-edit"></i> Compose message</h2>
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
							<strong>Sent</strong><br /> <?=$sql_info?>
						</div>
						<?php
						} ?>
						<form class="form-horizontal" method="post" id="composemsg">
						  <fieldset>
							<div class="control-group">
							  <label class="control-label">To</label>
							  <div class="controls">
							  	<?php if (($this->P2kb->udata['tipe'] == 'adm') && isset($arrDoctors) ) { 
										echo form_dropdown('receipt',$arrDoctors,'','data-rel="chosen" ');
								?>
								<?php } else { ?>
								<strong style="margin-top:6px;display:inline-block">Admin</strong>
								<?php } ?>
							  </div>
							</div>          
							<div class="control-group">
							  <label class="control-label" for="date01">Subject</label>
							  <div class="controls">
								<input type="text" class="input-xxlarge validate[required]" id="mtitle" name="mtitle">
							  </div>
							</div>          
							<div class="control-group">
							  <label class="control-label" for="keterangan">Message</label>
							  <div class="controls">
								<textarea class="input-xxlarge autogrow validate[required]" id="message" name="message" rows="5"></textarea>
							  </div>
							</div>
							  
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary">Send message</button>
							  <button type="reset" class="btn">Cancel</button>
							</div>
						  </fieldset>
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->

<script type="text/javascript">
	$("form#composemsg").validationEngine('attach', {prettySelect : true, promptPosition : "bottomLeft", scroll: true, binded: true, focusFirstField : true});
	//$("form").validationEngine('attach', {promptPosition : "bottomLeft", scroll: false, binded: true});
</script>    
