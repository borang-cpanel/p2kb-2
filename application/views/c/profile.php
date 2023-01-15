
<div class="row-fluid">
	<div class="span12 box center docreg">
		<div class="box-header" data-original-title>
			<div class="box-icon"> <a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a> </div>
		</div>
		<div class="box-content">
			<?php
					if ($this->session->flashdata('userupdate')) { ?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Updated !</strong> You have successfully updated profile data. </div>
			<?php
					}
					if (isset($row) && is_object($row)) : ?>
			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
				<fieldset>
				<legend>Profil Sertifikasi Ulang Dokter Spesialis Onkologi Radiasi</legend>
				<?php
						if ( isset($formfield_error) ) {
							echo '<p class="red"><span class="icon icon-red icon-alert"></span> '.$formfield_error.'</p>';
						}
						?>
				<div class="control-group grouping">
					<label class="control-label" style="margin-top:3px">Nomor Register Anggota</label>
					<div class="controls">
						<?php if ( $this->P2kb->udata['tipe'] == 'adm' ) { ?>
						<input name="nra" type="text" class="input-small" value="<? echo set_value('nra', $row->nra); ?>">
						<? echo form_error('nra'); ?>
						<?php }else{ ?>
						<strong><? echo $row->nra ?></strong>
						<?php } ?>
					</div>
					<?php if ( $this->P2kb->udata['tipe'] == 'adm' ) { ?>
					<label class="control-label" style="margin-top:3px">Tipe User</label>
					<div class="controls"> <?php echo form_dropdown('tipe',$this->P2kb->utype, $row->tipe,'id="tipe" class="validate[required]"'); ?> </div>
					<?php } ?>
				</div>
				<div class="control-group grouping">
					<label class="control-label" for="poritahun">Anggota PORI sejak tahun</label>
					<div class="controls">
						<input name="tahun" type="text" class="input-mini" value="<? echo set_value('tahun',$row->tahun); ?>" maxlength="4">
						<? echo form_error('tahun'); ?> </div>
					<label class="control-label">Nama lengkap</label>
					<div class="controls">
						<input name="nama" type="text" class="input-xxlarge" value="<? echo set_value('nama', $row->nama); ?>">
						<? echo form_error('nama'); ?> </div>
				</div>
				<div class="control-group">
					<?php 
							$arrGelar = array('Dokter Onk.Rad','Doktor/PhD','Profesor','Konsultan/Spesialis');
							$arrInGelar = explode('|',$row->gelar);
							if (is_array($arrInGelar)) {
								foreach( $arrInGelar as $gelar ) {
									if (!in_array($gelar,$arrGelar)) {
										$gelar_lain = $gelar;
									}
								}
							}
							?>
					<label class="control-label">Gelar Akademik</label>
					<div class="controls">
						<label class="checkbox inline">
						<input type="checkbox" id="inlineCheckbox1" name="gelar[]" value="Dokter Onk.Rad" <?php $ge_onk = in_array('Dokter Onk.Rad',$arrInGelar) ? TRUE : FALSE; echo set_checkbox('gelar[]', 'Dokter Onk.Rad', $ge_onk); ?>>
						Dokter Onk.Rad </label>
						<label class="checkbox inline">
						<input type="checkbox" id="inlineCheckbox2" name="gelar[]" value="Doktor/PhD" <?php $ge_onk = in_array('Doktor/PhD',$arrInGelar) ? TRUE : FALSE; echo set_checkbox('gelar[]', 'Doktor/PhD',$ge_onk); ?>>
						Doktor/PhD </label>
						<label class="checkbox inline">
						<input type="checkbox" id="inlineCheckbox3" name="gelar[]" value="Profesor" <?php $ge_onk = in_array('Profesor',$arrInGelar) ? TRUE : FALSE; echo set_checkbox('gelar[]', 'Profesor',$ge_onk); ?>>
						Profesor </label>
						<label class="checkbox inline">
						<input type="checkbox" id="inlineCheckbox3" name="gelar[]" value="Konsultan/Spesialis" <?php $ge_onk = in_array('Konsultan/Spesialis',$arrInGelar) ? TRUE : FALSE; echo set_checkbox('gelar[]', 'Profesor',$ge_onk); ?>>
						Konsultan/Spesialis </label>
						<br />
						<label class="checkbox inline">
						<input type="checkbox" id="gelarlain" name="gelar[]" value="lainnya" <?php $ge_onkl = isset($gelar_lain) ? TRUE : FALSE; echo set_checkbox('gelar[]', 'lainnya', $ge_onkl); ?>>
						Lainnya: </label>
						<input name="gelar[lain]" id="gelarlaintext" disabled="disabled" type="text" class="input-medium" value="<?php if (isset($gelar_lain)) {echo $gelar_lain;} elseif (isset($_POST['gelar'])) if (in_array('lainnya',$_POST['gelar']) && isset($_POST['gelar']['lain'])) echo @$_POST['gelar']['lain']; ?>">
						<br>
						<? echo form_error('gelar[]'); ?> </div>
				</div>
				<div class="control-group grouping">
					<label class="control-label">Nomor Anggota <abbr title="Ikatan Dokter Indonesia">IDI</abbr></label>
					<div class="controls">
						<input name="idi" type="text" class="input-medium" value="<? echo set_value('idi',$row->idi); ?>">
						<? echo form_error('idi'); ?> </div>
				</div>
				<div class="control-group grouping">
					<label class="control-label">Tempat lahir</label>
					<div class="controls">
						<input name="lhr" type="text" class="input-medium" value="<? echo set_value('lhr',$row->lhr); ?>">
						<? echo form_error('lhr'); ?> </div>
					<label class="control-label">Tanggal lahir</label>
					<div class="controls">
						<input name="lhrtgl" id="lhrtgl" class="input-small" type="text" value="<? echo set_value('lhrtgl',$row->lhrtgl) == '0000-00-00' ? '' : set_value('lhrtgl',$row->lhrtgl); ?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('lhrtgl'); ?> </div>
				</div>
				<div class="control-group">
					<label class="control-label">Nomor Identitas KTP</label>
					<div class="controls">
						<input name="ktp" type="text" class="input-xlarge" id="ktp" value="<? echo set_value('ktp',$row->ktp); ?>">
						<? echo form_error('ktp'); ?> </div>
				</div>
				<div class="control-group">
					<label class="control-label">Jenis Kelamin</label>
					<div class="controls">
						<label class="radio">
						<input type="radio" name="sex" id="optionsRadios1" value="L" <?php $sex_L = ($row->sex == 'L')? TRUE: FALSE; echo set_radio('sex', 'L', $sex_L); ?>>
						Laki-laki </label>
						<div style="clear:both"></div>
						<label class="radio">
						<input type="radio" name="sex" id="optionsRadios2" value="P" <?php $sex_P = ($row->sex == 'P')? TRUE: FALSE; echo set_radio('sex', 'P', $sex_P); ?>>
						Perempuan </label>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Email</label>
					<div class="controls">
						<input name="email" type="text" class="input-xlarge" id="email" value="<? echo set_value('email',$row->email); ?>">
						<? echo form_error('email'); ?> </div>
				</div>
				<div class="control-group grouping">
					<label class="control-label">Alamat Rumah</label>
					<div class="controls">
						<textarea name="rumah" class="input-xxlarge" id="rumah"><? echo set_value('rumah', $row->rumah); ?></textarea>
						<? echo form_error('rumah'); ?> </div>
					<label class="control-label">Kode POS</label>
					<div class="controls">
						<input name="rumahpos" type="text" class="input-mini" id="rumahpos" value="<? echo set_value('rumahpos', $row->rumahpos); ?>">
						<? echo form_error('rumahpos'); ?> </div>
					<label class="control-label">Telepon</label>
					<div class="controls">
						<input name="rumahtelp" type="text" class="input-large" id="rumahtelp" value="<? echo set_value('rumahtelp', $row->rumahtelp); ?>">
						<? echo form_error('rumahtelp'); ?> </div>
					<label class="control-label">Fax</label>
					<div class="controls">
						<input name="rumahfax" type="text" class="input-large" id="rumahfax" value="<? echo set_value('rumahfax', $row->rumahfax); ?>">
						<? echo form_error('rumahfax'); ?> </div>
					<label class="control-label">Handphone</label>
					<div class="controls">
						<input name="rumahhp" type="text" class="input-large" id="rumahhp" value="<? echo set_value('rumahhp', $row->rumahhp); ?>">
						<? echo form_error('rumahhp'); ?> </div>
				</div>
				<div class="control-group grouping">
					<p align="left">Data Kerja Praktek Dokter (1)</p>
					<label class="control-label">Nama &amp; Alamat</label>
					<div class="controls">
						<textarea name="praktek1" class="input-xxlarge" id="praktek1"><? echo set_value('praktek1', $row->praktek1); ?></textarea>
						<? echo form_error('praktek1'); ?> </div>
					<label class="control-label">Kode POS</label>
					<div class="controls">
						<input name="praktek1pos" type="text" class="input-mini" id="praktek1pos" value="<? echo set_value('praktek1pos', $row->praktek1pos); ?>">
						<? echo form_error('praktek1pos'); ?> </div>
					<label class="control-label">Telepon</label>
					<div class="controls">
						<input name="praktek1telp" type="text" class="input-large" id="praktek1telp" value="<? echo set_value('praktek1telp', $row->praktek1telp); ?>">
						<? echo form_error('praktek1telp'); ?> </div>
					<label class="control-label">Fax</label>
					<div class="controls">
						<input name="praktek1fax" type="text" class="input-large" id="praktek1fax" value="<? echo set_value('praktek1fax', $row->praktek1fax); ?>">
						<? echo form_error('praktek1fax'); ?> </div>
					<!-- SIP -->
					<label class="control-label">Surat Izin Praktik</label>
					<div class="controls">
						<input name="sip1" type="text" class="input-medium" id="sip1" value="<? echo set_value('sip1', $row->sip1) ?>">
						<span class="help-inline">Nomor Surat Izin Praktik (SIP)</span> <? echo form_error('sip1'); ?> </div>
					<label class="control-label">Tanggal Mulai SIP</label>
					<div class="controls">
						<input name="sip1start" type="text" class="input-small certificatedatum" id="sip1start" value="<? echo set_value('sip1start', $row->sip1start) == '0000-00-00' ? '' : set_value('sip1start', $row->sip1start) ?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('sip1start'); ?> </div>
					<label class="control-label">Tanggal Akhir SIP</label>
					<div class="controls">
						<input name="sip1end" type="text" class="input-small certificatedatum" id="sip1end" value="<? echo set_value('sip1end', $row->sip1end) == '0000-00-00' ? '' : set_value('sip2end', $row->sip1end)?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('sip1end'); ?> </div>

				</div>
				<div class="control-group grouping">
					<p align="left">Data Kerja Praktek Dokter (2)</p>
					<label class="control-label">Nama &amp; Alamat</label>
					<div class="controls">
						<textarea name="praktek2" class="input-xxlarge" id="praktek2"><? echo set_value('praktek2', $row->praktek2); ?></textarea>
						<? echo form_error('praktek2'); ?> </div>
					<label class="control-label">Kode POS</label>
					<div class="controls">
						<input name="praktek2pos" type="text" class="input-mini" id="praktek2pos" value="<? echo set_value('praktek2pos', $row->praktek2pos); ?>">
						<? echo form_error('praktek2pos'); ?> </div>
					<label class="control-label">Telepon</label>
					<div class="controls">
						<input name="praktek2telp" type="text" class="input-large" id="praktek2telp" value="<? echo set_value('praktek2telp', $row->praktek2telp); ?>">
						<? echo form_error('praktek2telp'); ?> </div>
					<label class="control-label">Fax</label>
					<div class="controls">
						<input name="praktek2fax" type="text" class="input-large" id="praktek2fax" value="<? echo set_value('praktek2fax', $row->praktek2fax); ?>">
						<? echo form_error('praktek2fax'); ?> </div>
					<!-- SIP -->
					<label class="control-label">Surat Izin Praktik</label>
					<div class="controls">
						<input name="sip2" type="text" class="input-medium" id="sip2" value="<? echo set_value('sip2', $row->sip2) ?>">
						<span class="help-inline">Nomor Surat Izin Praktik (SIP)</span> <? echo form_error('sip2'); ?> </div>
					<label class="control-label">Tanggal Mulai SIP</label>
					<div class="controls">
						<input name="sip2start" type="text" class="input-small certificatedatum" id="sip2start" value="<? echo set_value('sip2start', $row->sip2start) == '0000-00-00' ? '' : set_value('sip2start', $row->sip2start) ?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('sip2start'); ?> </div>
					<label class="control-label">Tanggal Akhir SIP</label>
					<div class="controls">
						<input name="sip2end" type="text" class="input-small certificatedatum" id="sip2end" value="<? echo set_value('sip2end', $row->sip2end) == '0000-00-00' ? '' : set_value('sip2end', $row->sip2end)?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('sip2end'); ?> </div>

				</div>
				<div class="control-group grouping">
					<p align="left">Data Kerja Praktek Dokter (3)</p>
					<label class="control-label">Nama &amp; Alamat</label>
					<div class="controls">
						<textarea name="praktek3" class="input-xxlarge" id="praktek3"><? echo set_value('praktek3', $row->praktek3); ?></textarea>
						<? echo form_error('praktek3'); ?> </div>
					<label class="control-label">Kode POS</label>
					<div class="controls">
						<input name="praktek3pos" type="text" class="input-mini" id="praktek3pos" value="<? echo set_value('praktek3pos', $row->praktek3pos); ?>">
						<? echo form_error('praktek3pos'); ?> </div>
					<label class="control-label">Telepon</label>
					<div class="controls">
						<input name="praktek3telp" type="text" class="input-large" id="praktek3telp" value="<? echo set_value('praktek3telp', $row->praktek3telp); ?>">
						<? echo form_error('praktek3telp'); ?> </div>
					<label class="control-label">Fax</label>
					<div class="controls">
						<input name="praktek3fax" type="text" class="input-large" id="praktek3fax" value="<? echo set_value('praktek3fax', $row->praktek3fax); ?>">
						<? echo form_error('praktek3fax'); ?> </div>
					<!-- SIP -->
					<label class="control-label">Surat Izin Praktik</label>
					<div class="controls">
						<input name="sip3" type="text" class="input-medium" id="sip3" value="<? echo set_value('sip3', $row->sip3) ?>">
						<span class="help-inline">Nomor Surat Izin Praktik (SIP)</span> <? echo form_error('sip3'); ?> </div>
					<label class="control-label">Tanggal Mulai SIP</label>
					<div class="controls">
						<input name="sip3start" type="text" class="input-small certificatedatum" id="sip3start" value="<? echo set_value('sip3start', $row->sip3start)  == '0000-00-00' ? '' : set_value('sip3start', $row->sip3start)?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('sip3start'); ?> </div>
					<label class="control-label">Tanggal Akhir SIP</label>
					<div class="controls">
						<input name="sip3end" type="text" class="input-small certificatedatum" id="sip3end" value="<? echo set_value('sip3end', $row->sip3end)  == '0000-00-00' ? '' : set_value('sip3end', $row->sip3end)?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('sip3end'); ?> </div>
						
				</div>
				<div class="control-group grouping">
					<p align="left">Asal Pendidikan Spesialis Onkologi Radiasi</p>
					<label class="control-label">Nama Sekolah</label>
					<div class="controls">
						<input name="sekolah" type="text" class="input-xxlarge" id="sekolah" value="<? echo set_value('sekolah', $row->sekolah) ?>">
						<? echo form_error('sekolah'); ?> </div>
					<label class="control-label">Tahun Lulus</label>
					<div class="controls">
						<input name="sekolahlulus" type="text" class="input-mini" id="sekolahlulus" value="<? echo set_value('sekolahlulus', $row->sekolahlulus) ?>" maxlength="4">
						<? echo form_error('sekolahlulus'); ?> </div>
				</div>
				<div class="control-group grouping">
					<p align="left">Surat Tanda Registrasi </p>
					<label class="control-label">Tanggal Mulai</label>
					<div class="controls">
						<input name="regstart" type="text" class="input-small" id="regstart" value="<? echo set_value('regstart', $row->regstart) ?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('regstart'); ?> </div>
					<label class="control-label">Tanggal Selesai</label>
					<div class="controls">
						<input name="regend" type="text" class="input-small" id="regend" value="<? echo set_value('regend', $row->regend) ?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('regend'); ?> </div>
					<label class="control-label" for="fileInput">Bukti Scan STR</label>
					<div class="controls">
						<input name="regscan" type="file" class="input-file uniform_on">
						<span class="help-inline">GIF, JPG, PNG, DOC, DOCX, PDF</span>
						<?php if ($this->session->flashdata('regscan_error')) { ?>
						<br />
						<span class="help-inline red"><em class="icon icon-color icon-cross"></em>
						<?=$this->session->flashdata('regscan_error')?>
						.</span>
						<?php } ?>
						<?php if ($row->regscan) { ?>
						<div class="help-block"><i class="icon-file"></i> <a target="_blank" href="<?=base_url().'media/'.$row->regscan?>">
							<?=$row->regscan?>
							</a>
							<input type="checkbox" name="delete_regscan" value="1" />
							Delete </div>
						<?php } ?>
					</div>
				</div>
				<div class="control-group grouping">
					<label class="control-label" for="fileInput">Foto diri</label>
					<div class="controls">
						<input name="foto" type="file" class="input-file uniform_on">
						<span class="help-inline">GIF, JPG, PNG / 500&times;500 pixels</span>
						<?php if ($this->session->flashdata('foto_error')) { ?>
						<br />
						<span class="help-inline red"><em class="icon icon-color icon-cross"></em>
						<?=$this->session->flashdata('foto_error')?>
						.</span>
						<?php } ?>
						<?php if ($row->foto) { ?>
						<div class="help-block"> <img src="<?=base_url().'media/'.$row->foto?>" alt="" /> <br />
							<input type="checkbox" name="delete_foto" value="1" />
							Delete </div>
						<?php } ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="fileInput">Alamat Surat Menyurat</label>
					<div class="controls">
						<select name="surat" id="selectsurat">
							<option value="rumah" <?php $surat_rumah = $row->surat == 'rumah' ? TRUE : FALSE; echo set_select('surat', 'rumah', $surat_rumah); ?>>Rumah</option>
							<option value="praktek1" <?php $s_pra1 = $row->surat == 'praktek1' ? TRUE : FALSE; echo set_select('surat', 'praktek1', $s_pra1); ?>>Tempat Kerja Praktek 1</option>
							<option value="praktek2" <?php $s_pra2 = $row->surat == 'praktek2' ? TRUE : FALSE; echo set_select('surat', 'praktek2', $s_pra2); ?>>Tempat Kerja Praktek 2</option>
							<option value="praktek3" <?php $s_pra3 = $row->surat == 'praktek3' ? TRUE : FALSE; echo set_select('surat', 'praktek3', $s_pra3); ?>>Tempat Kerja Praktek 3</option>
						</select>
					</div>
				</div>
				<?php if ( $this->P2kb->udata['tipe'] == 'adm' ) { ?>
				<div class="control-group">
					<label class="control-label" for="fileInput">Status User</label>
					<div class="controls"> <?php echo form_dropdown('acv',$this->P2kb->ustatus, $row->acv); ?> </div>
				</div>
				<?php } ?>
				<div class="form-actions">
					<button type="submit" class="btn btn-primary">Simpan Data</button>
					<!--<a class="btn" href="<?=site_url('user/login')?>">Batal</a>-->
				</div>
				</fieldset>
			</form>
			<?php endif; ?>
		</div>
	</div>
	<!--/span-->
</div>
<!--/row-->
