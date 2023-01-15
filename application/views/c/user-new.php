
<div class="row-fluid">
	<div class="span12 box center docreg">
		<div class="box-header" data-original-title>
			<div class="box-icon"> <a href="#" class="btn btn-minimize"><i class="icon-chevron-up"></i></a> </div>
		</div>
		<div class="box-content">
			<div class="alert alert-info"> Silakan isi form registrasi dokter dengan lengkap. </div>
			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
				<fieldset>
				<legend>Formulir Sertifikasi Ulang Dokter Spesialis Onkologi Radiasi</legend>
				<?php
				if ( isset($formfield_error) ) {
					echo '<p class="red"><span class="icon icon-red icon-alert"></span> '.$formfield_error.'</p>';
				}
				?>
				<div class="control-group grouping">
					<label class="control-label" style="margin-top:3px">Tipe User</label>
					<?php
					$data_tipe_user = set_value('tipe');
					$tipe_user = empty( $data_tipe_user ) ? 'doc' : $data_tipe_user;
					?>
					<div class="controls"> <?php echo form_dropdown('tipe',$this->P2kb->utype, $tipe_user,'id="tipe"'); ?> </div>
					<label class="control-label" for="docnra">Nomor Register Anggota</label>
					<div class="controls">
						<input name="nra" type="text" class="input-medium" value="<? echo set_value('nra'); ?>" maxlength="10">
						<? echo form_error('nra'); ?> </div>
					<label class="control-label" for="docnra">Password untuk login</label>
					<div class="controls">
						<input name="nrapass" type="password" class="input-medium">
						<? echo form_error('nrapass'); ?> </div>
					<label class="control-label" for="docnra">Ulangi password</label>
					<div class="controls">
						<input name="nrapass2" type="password" class="input-medium">
						<? echo form_error('nrapass2'); ?> </div>
				</div>
				<div class="control-group grouping">
					<label class="control-label" for="poritahun">Anggota PORI sejak tahun</label>
					<div class="controls">
						<input name="tahun" type="text" class="input-mini" value="<? echo set_value('tahun'); ?>" maxlength="4">
						<? echo form_error('tahun'); ?> </div>
					<label class="control-label">Nama lengkap tanpa gelar</label>
					<div class="controls">
						<input name="nama" type="text" class="input-xxlarge" value="<? echo set_value('nama'); ?>">
						<? echo form_error('nama'); ?> </div>
				</div>
				<div class="control-group">
					<?php #print_r($_POST['gelar']); ?>
					<label class="control-label">Gelar Akademik</label>
					<div class="controls">
						<label class="checkbox inline">
						<input type="checkbox" id="inlineCheckbox1" name="gelar[]" value="Dokter Onk.Rad" <?php echo set_checkbox('gelar[]', 'Dokter Onk.Rad'); ?>>
						Dokter Onk.Rad </label>
						<label class="checkbox inline">
						<input type="checkbox" id="inlineCheckbox2" name="gelar[]" value="Doktor/PhD" <?php echo set_checkbox('gelar[]', 'Doktor/PhD'); ?>>
						Doktor/PhD </label>
						<label class="checkbox inline">
						<input type="checkbox" id="inlineCheckbox3" name="gelar[]" value="Profesor" <?php echo set_checkbox('gelar[]', 'Profesor'); ?>>
						Profesor </label>
						<label class="checkbox inline">
						<input type="checkbox" id="inlineCheckbox3" name="gelar[]" value="Konsultan/Spesialis" <?php echo set_checkbox('gelar[]', 'Konsultan/Spesialis'); ?>>
						Konsultan/Spesialis </label>
						<br />
						<label class="checkbox inline">
						<input type="checkbox" id="gelarlain" name="gelar[]" value="lainnya" <?php echo set_checkbox('gelar[]', 'lainnya'); ?>>
						Lainnya: </label>
						<input name="gelar[lain]" id="gelarlaintext" disabled="disabled" type="text" class="input-medium" value="<?php if (isset($_POST['gelar'])) if (in_array('lainnya',$_POST['gelar']) && isset($_POST['gelar']['lain'])) echo @$_POST['gelar']['lain']; ?>">
						<br>
						<? echo form_error('gelar[]'); ?> </div>
				</div>
				<div class="control-group grouping">
					<label class="control-label">Nomor Anggota <abbr title="Ikatan Dokter Indonesia">IDI</abbr></label>
					<div class="controls">
						<input name="idi" type="text" class="input-medium" value="<? echo set_value('idi'); ?>">
						<? echo form_error('idi'); ?> </div>
				</div>
				<div class="control-group grouping">
					<label class="control-label">Tempat lahir</label>
					<div class="controls">
						<input name="lhr" type="text" class="input-medium" value="<? echo set_value('lhr'); ?>">
						<? echo form_error('lhr'); ?> </div>
					<label class="control-label">Tanggal lahir</label>
					<div class="controls">
						<input name="lhrtgl" id="lhrtgl" class="input-small" type="text" value="<? echo set_value('lhrtgl'); ?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('lhrtgl'); ?> </div>
				</div>
				<div class="control-group">
					<label class="control-label">Nomor Identitas KTP</label>
					<div class="controls">
						<input name="ktp" type="text" class="input-xlarge" id="ktp" value="<? echo set_value('ktp'); ?>">
						<? echo form_error('ktp'); ?> </div>
				</div>
				<div class="control-group">
					<label class="control-label">Jenis Kelamin</label>
					<div class="controls">
						<label class="radio">
						<input type="radio" name="sex" id="optionsRadios1" value="L" <?php echo set_radio('sex', 'L', TRUE); ?>>
						Laki-laki </label>
						<div style="clear:both"></div>
						<label class="radio">
						<input type="radio" name="sex" id="optionsRadios2" value="P" <?php echo set_radio('sex', 'P'); ?>>
						Perempuan </label>
					</div>
				</div>
				<div class="control-group grouping">
					<label class="control-label">Alamat Rumah</label>
					<div class="controls">
						<textarea name="rumah" class="input-xxlarge" id="rumah"><? echo set_value('rumah'); ?></textarea>
						<? echo form_error('rumah'); ?> </div>
					<label class="control-label">Kode POS</label>
					<div class="controls">
						<input name="rumahpos" type="text" class="input-mini" id="rumahpos" value="<? echo set_value('rumahpos'); ?>">
						<? echo form_error('rumahpos'); ?> </div>
					<label class="control-label">Telepon</label>
					<div class="controls">
						<input name="rumahtelp" type="text" class="input-large" id="rumahtelp" value="<? echo set_value('rumahtelp'); ?>">
						<? echo form_error('rumahtelp'); ?> </div>
					<label class="control-label">Fax</label>
					<div class="controls">
						<input name="rumahfax" type="text" class="input-large" id="rumahfax" value="<? echo set_value('rumahfax'); ?>">
						<? echo form_error('rumahfax'); ?> </div>
					<label class="control-label">Handphone</label>
					<div class="controls">
						<input name="rumahhp" type="text" class="input-large" id="rumahhp" value="<? echo set_value('rumahhp'); ?>">
						<? echo form_error('rumahhp'); ?> </div>
				</div>
				<div class="control-group grouping">
					<p align="left">Data Kerja Praktek Dokter (1)</p>
					<label class="control-label">Nama &amp; Alamat</label>
					<div class="controls">
						<textarea name="praktek1" class="input-xxlarge" id="praktek1"><? echo set_value('praktek1'); ?></textarea>
						<? echo form_error('praktek1'); ?> </div>
					<label class="control-label">Kode POS</label>
					<div class="controls">
						<input name="praktek1pos" type="text" class="input-mini" id="praktek1pos" value="<? echo set_value('praktek1pos'); ?>">
						<? echo form_error('praktek1pos'); ?> </div>
					<label class="control-label">Telepon</label>
					<div class="controls">
						<input name="praktek1telp" type="text" class="input-large" id="praktek1telp" value="<? echo set_value('praktek1telp'); ?>">
						<? echo form_error('praktek1telp'); ?> </div>
					<label class="control-label">Fax</label>
					<div class="controls">
						<input name="praktek1fax" type="text" class="input-large" id="praktek1fax" value="<? echo set_value('praktek1fax'); ?>">
						<? echo form_error('praktek1fax'); ?> </div>
					<!-- SIP -->
					<label class="control-label">Surat Izin Praktik</label>
					<div class="controls">
						<input name="sip1" type="text" class="input-medium" id="sip1" value="<? echo set_value('sip1') ?>">
						<span class="help-inline">Nomor Surat Izin Praktik (SIP)</span> <? echo form_error('sip1'); ?> </div>
					<label class="control-label">Tanggal Mulai SIP</label>
					<div class="controls">
						<input name="sip1start" type="text" class="input-small certificatedatum" id="sip1start" value="<? echo set_value('sip1start') ?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('sip1start'); ?> </div>
					<label class="control-label">Tanggal Akhir SIP</label>
					<div class="controls">
						<input name="sip1end" type="text" class="input-small certificatedatum" id="sip1end" value="<? echo set_value('sip1end') ?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('sip1end'); ?> </div>
					</div>
				<div class="control-group grouping">
					<p align="left">Data Kerja Praktek Dokter (2)</p>
					<label class="control-label">Nama &amp; Alamat</label>
					<div class="controls">
						<textarea name="praktek2" class="input-xxlarge" id="praktek2"><? echo set_value('praktek2'); ?></textarea>
						<? echo form_error('praktek2'); ?> </div>
					<label class="control-label">Kode POS</label>
					<div class="controls">
						<input name="praktek2pos" type="text" class="input-mini" id="praktek2pos" value="<? echo set_value('praktek2pos'); ?>">
						<? echo form_error('praktek2pos'); ?> </div>
					<label class="control-label">Telepon</label>
					<div class="controls">
						<input name="praktek2telp" type="text" class="input-large" id="praktek2telp" value="<? echo set_value('praktek2telp'); ?>">
						<? echo form_error('praktek2telp'); ?> </div>
					<label class="control-label">Fax</label>
					<div class="controls">
						<input name="praktek2fax" type="text" class="input-large" id="praktek2fax" value="<? echo set_value('praktek2fax'); ?>">
						<? echo form_error('praktek2fax'); ?> </div>
					<!-- SIP 2-->
					<label class="control-label">Surat Izin Praktik</label>
					<div class="controls">
						<input name="sip2" type="text" class="input-medium" id="sip2" value="<? echo set_value('sip2') ?>">
						<span class="help-inline">Nomor Surat Izin Praktik (SIP)</span> <? echo form_error('sip2'); ?> </div>
					<label class="control-label">Tanggal Mulai SIP</label>
					<div class="controls">
						<input name="sip2start" type="text" class="input-small certificatedatum" id="sip2start" value="<? echo set_value('sip2start') ?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('sip2start'); ?> </div>
					<label class="control-label">Tanggal Akhir SIP</label>
					<div class="controls">
						<input name="sip2end" type="text" class="input-small certificatedatum" id="sip2end" value="<? echo set_value('sip2end') ?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('sip2end'); ?> </div>
					</div>
				<div class="control-group grouping">
					<p align="left">Data Kerja Praktek Dokter (3)</p>
					<label class="control-label">Nama &amp; Alamat</label>
					<div class="controls">
						<textarea name="praktek3" class="input-xxlarge" id="praktek3"><? echo set_value('praktek3'); ?></textarea>
						<? echo form_error('praktek3'); ?> </div>
					<label class="control-label">Kode POS</label>
					<div class="controls">
						<input name="praktek3pos" type="text" class="input-mini" id="praktek3pos" value="<? echo set_value('praktek3pos'); ?>">
						<? echo form_error('praktek3pos'); ?> </div>
					<label class="control-label">Telepon</label>
					<div class="controls">
						<input name="praktek3telp" type="text" class="input-large" id="praktek3telp" value="<? echo set_value('praktek3telp'); ?>">
						<? echo form_error('praktek3telp'); ?> </div>
					<label class="control-label">Fax</label>
					<div class="controls">
						<input name="praktek3fax" type="text" class="input-large" id="praktek3fax" value="<? echo set_value('praktek3fax'); ?>">
						<? echo form_error('praktek3fax'); ?> </div>
					<!-- SIP 3-->
					<label class="control-label">Surat Izin Praktik</label>
					<div class="controls">
						<input name="sip3" type="text" class="input-medium" id="sip3" value="<? echo set_value('sip3') ?>">
						<span class="help-inline">Nomor Surat Izin Praktik (SIP)</span> <? echo form_error('sip3'); ?> </div>
					<label class="control-label">Tanggal Mulai SIP</label>
					<div class="controls">
						<input name="sip3start" type="text" class="input-small certificatedatum" id="sip3start" value="<? echo set_value('sip3start') ?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('sip3start'); ?> </div>
					<label class="control-label">Tanggal Akhir SIP</label>
					<div class="controls">
						<input name="sip3end" type="text" class="input-small certificatedatum" id="sip3end" value="<? echo set_value('sip3end') ?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('sip3end'); ?> </div>
					</div>
				<div class="control-group grouping">
					<p align="left">Asal Pendidikan Spesialis Onkologi Radiasi</p>
					<label class="control-label">Nama Sekolah</label>
					<div class="controls">
						<input name="sekolah" type="text" class="input-xxlarge" id="sekolah" value="<? echo set_value('sekolah') ?>">
						<? echo form_error('sekolah'); ?> </div>
					<label class="control-label">Tahun Lulus</label>
					<div class="controls">
						<input name="sekolahlulus" type="text" class="input-mini" id="sekolahlulus" value="<? echo set_value('sekolahlulus') ?>" maxlength="4">
						<? echo form_error('sekolahlulus'); ?> </div>
				</div>
				<div class="control-group grouping">
					<p align="left">Surat Tanda Registrasi</p>
					<label class="control-label">Tanggal Mulai</label>
					<div class="controls">
						<input name="regstart" type="text" class="input-small certificatedatum" id="regstart" value="<? echo set_value('regstart') ?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('regstart'); ?> </div>
					<label class="control-label">Tanggal Akhir</label>
					<div class="controls">
						<input name="regend" type="text" class="input-small certificatedatum" id="regend" value="<? echo set_value('regend') ?>">
						<span class="help-inline">YYYY-MM-DD</span> <? echo form_error('regend'); ?> </div>
					<label class="control-label" for="fileInput">Bukti Scan STR</label>
					<div class="controls">
						<input name="regscan" type="file" class="input-file uniform_on">
						<span class="help-inline">GIF, JPG, PNG, PDF, DOC, DOCX atau PDF.</span>
						<?= isset($upload_regscan_error) ? '<br /><span class="help-inline red"><em class="icon icon-color icon-cross"></em> '.$upload_regscan_error.'</span>' : '' ?>
					</div>
				</div>
				<div class="control-group grouping">
					<label class="control-label" for="fileInput">Foto diri</label>
					<div class="controls">
						<input name="foto" type="file" class="input-file uniform_on">
						<span class="help-inline">GIF, JPG, PNG.</span>
						<?= isset($upload_foto_error) ? '<br /><span class="help-inline red"><em class="icon icon-color icon-cross"></em> '.$upload_foto_error.'</span>' : '' ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="fileInput">Alamat Surat Menyurat</label>
					<div class="controls">
						<select name="surat" id="selectsurat">
							<option value="rumah" <?php echo set_select('surat', 'rumah'); ?>>Rumah</option>
							<option value="praktek1" <?php echo set_select('surat', 'praktek1'); ?>>Tempat Kerja Praktek 1</option>
							<option value="praktek2" <?php echo set_select('surat', 'praktek2'); ?>>Tempat Kerja Praktek 2</option>
							<option value="praktek3" <?php echo set_select('surat', 'praktek3'); ?>>Tempat Kerja Praktek 3</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="fileInput">Status User</label>
					<div class="controls"> <?php echo form_dropdown('acv',$this->P2kb->ustatus, set_value('acv')); ?> </div>
				</div>
				<div class="form-actions">
					<button type="submit" class="btn btn-primary">Simpan Data</button>
				</div>
				</fieldset>
			</form>
		</div>
	</div>
	<!--/span-->
</div>
<!--/row-->
