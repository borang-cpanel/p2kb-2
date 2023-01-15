			<div>
				<ul class="breadcrumb">
					<li><a href="<?=site_url()?>">Home</a> <span class="divider">/</span></li>
					<li><?=anchor(site_url('messages'),'Messages')?> <span class="divider">/</span></li>
					<li>Read</li>
				</ul>
			</div>
			
			<div class="row-fluid">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="icon-envelope"></i> Read Message</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
					  <?php
					  if (isset($row)) { ?>
						<table class="table table-messages">
							  <tbody>
							  	<tr>
									<th>
										<p>From : <?=$sender_name?></p>
										<p>To : <?=$receipt_name?></p>
										<p>Date : <?=$row->tanggal?></p>
										<p>Subject : <?=$row->title?></p>
									</th>
								</tr>
								<tr>
									<td><?=nl2br($row->message)?></td>
								</tr>
							  </tbody>
						 </table> 
						<?php
						}
						?>
					</div>
				</div><!--/span-->

			</div><!--/row-->

