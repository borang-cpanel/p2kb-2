<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
<title></title>
	<link href="pdf-style.css" rel="stylesheet" media="all" />
</head><body>
	<div class="certificate-image">
		<?php if ($r->foto) { ?>
		<img src="<?=BASEPATH.'../media/'. urldecode( $r->foto )?>" class=" foto-identitas" />
		<?php } ?>
	</div>
	<table class="heading">
		<tr>
			<td><img src="<?=BASEPATH?>../images/logo-p2kb-print.png" /></td>
			<td>
			<h1 class="aligncenter">BORANG KEGIATAN P2KB UNTUK RE-SERTIFIKASI<br />
				DOKTER SPESIALIS ONKOLOGI RADIASI <br />
				PERHIMPUNAN DOKTER SPESIALIS ONKOLOGI RADIASI INDONESIA</h1>
			</td>
		</tr>
	</table>
	<hr />
	<h3 class="aligncenter">IDENTITAS DIRI ANGGOTA</h3>
	<table class="tidentitas">
		<tr>
			<td>
			<ol class="identitas">
				<li>Nomor Registrasi Anggota (NRA) : <br /><span><?=$r->nra?></span></li>
				<li>Anggota PORI sejak tahun : <br /><span><?=$r->tahun?></span></li>
				<li>Nama Lengkap : <br /><span><?=$r->nama?></span></li>
				<!-- <li>Gelar Akademik : <br /> <span><?= str_replace ('|',' / ',$r->gelar) ?></span></li>-->
				<li>Gelar Akademik : <br /> <span><?= gelar_akademik ($r->gelar) ?></span></li>
			</ol>
			</td>
			<td align="right">
			</td>
		</tr>
	</table>
	<ol class="identitas" start="5">
		<li>Tempat lahir : <span><?=$r->lhr?></span><br />
			Tanggal lahir : <span><?=format_the_date($r->lhrtgl,'d/m/Y')?></span></li>
		<li>Nomor Identitas (KTP) : <span><?=$r->ktp?></span><br />
			Jenis Kelamin : <span><?= $r->sex == 'L' ? 'Laki-laki' : 'Perempuan'?></span></li>
		<li>Alamat Rumah :<br />
			<span><?=$r->rumah?></span><br />
			Kode POS : <span><?=$r->rumahpos?></span><br />
			Telp : <span><?=$r->rumahtelp?></span> &nbsp; &nbsp; Fax. : <span><?=$r->rumahfax?></span><br />
			HP : <span><?=$r->rumahhp?></span><br />
		</li>
		<li>Nama dan Alamat Tempat Kerja/ Praktek : <br /><br />
			<ol class="sub-child">
				<?php if ($r->praktek1) { ?>
				<li><span><?=nl2br($r->praktek1)?></span><br />
					Kode POS : <span><?=$r->praktek1pos?></span><br />
					Telp : <span><?=$r->praktek1telp?></span> &nbsp; &nbsp; Fax. : <span><?=$r->praktek1fax?></span><br />
					Nomor Surat Izin Praktik (SIP) : <?=$r->sip1?><br />
					Berlaku dari tanggal : <?= format_the_date( $r->sip1start ) ?> s/d <?= format_the_date( $r->sip1end ) ?> <br />
				</li>
				<?php } ?>
				<?php if ($r->praktek2) { ?>
				<li><span><?=nl2br($r->praktek2)?></span><br />
					Kode POS : <span><?=$r->praktek2pos?></span><br />
					Telp : <span><?=$r->praktek2telp?></span> &nbsp; &nbsp; Fax. : <span><?=$r->praktek2fax?></span><br />
					Nomor Surat Izin Praktik (SIP) : <?=$r->sip2?><br />
					Berlaku dari tanggal : <?= format_the_date( $r->sip2start ) ?> s/d <?= format_the_date( $r->sip2end ) ?> <br />
				</li>
				<?php } ?>
				<?php if ($r->praktek3) { ?>
				<li><span><?=nl2br($r->praktek3)?></span><br />
					Kode POS : <span><?=$r->praktek3pos?></span><br />
					Telp : <span><?=$r->praktek3telp?></span> &nbsp; &nbsp; Fax. : <span><?=$r->praktek3fax?></span><br />
					Nomor Surat Izin Praktik (SIP) : <?=$r->sip3?><br />
					Berlaku dari tanggal : <?= format_the_date( $r->sip3start ) ?> s/d <?= format_the_date( $r->sip3end ) ?> <br />
				</li>
				<?php } ?>
			</ol>	
		</li>
		<li>Asal Pendidikan Spesialis Onkologi Radiasi : <br />
			<span><?=$r->sekolah?></span> &nbsp;&ndash; Tahun lulus : <span><?=$r->sekolahlulus?></span><br />
		</li>
		<li>
			Alamat surat menyurat : <span><?=ucfirst($r->surat)?></span>
		</li>	
		
	</ol>
	<p class="counter"></p>
	
	<h3>A. DATA KEGIATAN PEMBELAJARAN INDIVIDU</h3>
	<br />
	<table class="tkegiatan">
		<tr>
			<th>Kegiatan Pembelajaran Individu</th>
			<th class="capaian">Capaian SKP</th>
		</tr>
		<?php
		$total_kegiatanA = 0;
		if (isset($qA) and is_object($qA)) {
		  	if ($qA->num_rows() >0 ) {
				foreach( $qA->result_array() as $rowA) { 
					$total_kegiatanA += (int) $rowA['skp_doc'];
				?>
		<tr>
			<td><?=$rowA['kegiatan']?></td>
			<td align="center"><?=$rowA['skp_doc']?></td>
		</tr>		
				<?php
				}
			}
		  }
		?>

		<tr>
			<th rowspan="1">Kegiatan Ilmiah</th>
			<th rowspan="1"><strong>Capaian SKP</strong></th>
		</tr>
		<?php
		if (isset($qA2) and is_object($qA2)) {
		  	if ($qA2->num_rows() >0 ) {
				foreach( $qA2->result_array() as $rowA2) { 
					$total_kegiatanA += (int) $rowA2['skp_doc'];
				?>
		<tr>
			<td><?=$rowA2['kegiatan']?></td>
			<td align="center"><?=$rowA2['skp_doc']?></td>
		</tr>
				<?php
				}
			}
		  }
		?>
		<tr>
			<td align="right"><strong>TOTAL</strong></td>
			<td align="center"><strong><?= $total_kegiatanA ?></strong></td>
		</tr>		
	</table>

	<p>&nbsp;</p>
	<h3>B. DATA KEGIATAN PROFESIONAL</h3>
	<br />
	<table class="tkegiatan">
		<tr>
			<th>Kinerja Kegiatan Profesional</th>
			<th class="capaian">Capaian SKP </th>
		</tr>
		<?php
		$total_kegiatanB = 0;
		if (isset($qB) and is_object($qB)) {
		  	if ($qB->num_rows() >0 ) {
				foreach( $qB->result_array() as $rowB) { 
					$total_kegiatanB += (int) $rowB['skp_doc'];
					?>
		<tr>
			<td><?=$rowB['kegiatan']?></td>
			<td align="center"><?=$rowB['skp_doc']?></td>
		</tr>		
				<?php
				}
			}
		  }
		?>
		<tr>
			<td align="right"><strong>TOTAL</strong></td>
			<td align="center"><strong><?= $total_kegiatanB ?></strong></td>
		</tr>		
	</table>
	<p>Note:<br /><em>* Diperuntukkan hanya bagi yang memiliki pesawat Brakhiterapi saja</em></p>

	<p class="counter"></p>
	<p>&nbsp;</p>
	<h3>C. DATA KEGIATAN PENGABDIAN MASYARAKAT DAN PENGEMBANGAN PROFESI</h3>
	<br />
	<table class="tkegiatan">
		<?php
		$total_kegiatanC = 0;
		if (isset($qC) and is_object($qC)) {
		  	if ($qC->num_rows() >0 ) {
				$arr_kegC['pengabdian'] 	= '';
				$arr_kegC['pengembangan'] 	= '';
				foreach( $qC->result_array() as $rowC) { 
					$total_kegiatanC += (int) $rowC['skp_doc'];
					if ( 0 == preg_match('/^Menjadi/s', $rowC['kegiatan']) ) { 
						$arr_kegC['pengabdian'] .= '<tr><td>'.$rowC['kegiatan'].'</td><td align="center">'.$rowC['skp_doc'].'</td></tr>';
					}else{ 
						$arr_kegC['pengembangan'] .= '<tr><td>'.$rowC['kegiatan'].'</td><td align="center">'.$rowC['skp_doc'].'</td></tr>';
					}
				}
				?>
		<tr>
			<th>Kegiatan Pengabdian Masyarakat *)</th>
			<th class="capaian">Capaian SKP </th>
		</tr>
		<?= $arr_kegC['pengabdian'] ?>
		<tr>
			<th>Kegiatan Pengembangan Profesi *)</th>
			<th class="capaian">Capaian SKP </th>
		</tr>
		<?= $arr_kegC['pengembangan'] ?>
				<?php
			}
		  }
		?>
		<tr>
			<td align="right"><strong>TOTAL</strong></td>
			<td align="center"><strong><?= $total_kegiatanC ?></strong></td>
		</tr>
	</table>

	<p>&nbsp;</p>
	<h3>D. DATA KEGIATAN PUBLIKASI ILMIAH</h3>
	<br />
	<table class="tkegiatan">
		<tr>
			<th>Media Publikasi</th>
			<th class="capaian">Capaian SKP</th>
		</tr>
		<?php
		$total_kegiatanD = 0;
		if (isset($qD) and is_object($qD)) {
		  	if ($qD->num_rows() >0 ) {
				foreach( $qD->result_array() as $rowD) { 
					$total_kegiatanD += (int) $rowD['skp_doc'];
				?>
		<tr>
			<td><?=$rowD['kegiatan']?></td>
			<td align="center"><?=$rowD['skp_doc']?></td>
		</tr>		
				<?php
				}
			}
		  }
		?>
		<tr>
			<td align="right"><strong>TOTAL</strong></td>
			<td align="center"><strong><?= $total_kegiatanD ?></strong></td>
		</tr>
	</table>
	
	<p>&nbsp;</p>

	<p class="counter"></p>
	<h3>E. DATA KEGIATAN PENGEMBANGAN KEILMUAN</h3>
	<br />
	<table class="tkegiatan">
		<tr>
			<th>Kegiatan/kali/tahun</th>
			<th class="capaian">Capaian SKP</th>
		</tr>
		<?php
		$total_kegiatanE = 0;
		if (isset($qE) and is_object($qE)) {
		  	if ($qE->num_rows() >0 ) {
				foreach( $qE->result_array() as $rowE) { 
					$total_kegiatanE += (int) $rowE['skp_doc'];
				?>
		<tr>
			<td><?=$rowE['kegiatan']?></td>
			<td align="center"><?=$rowE['skp_doc']?></td>
		</tr>		
				<?php
				}
			}
		  }
		?>
		<tr>
			<td align="right"><strong>TOTAL</strong></td>
			<td align="center"><strong><?= $total_kegiatanE ?></strong></td>
		</tr>
	</table>

	<p class="counter"></p>
	<table width="100%" border="0" class="heading">
		<tr>
			<td><img src="<?=BASEPATH?>../images/logo-p2kb-print.png" /></td>
			<td>
			<h1 class="aligncenter">KOMISI PENGEMBANGAN PENDIDIKAN KEPROFESIAN BERKELANJUTAN <br />(P2KB)<br />
				PERHIMPUNAN DOKTER SPESIALIS ONKOLOGI RADIASI INDONESIA (PORI)</h1>
			<p align="center">	
				Sekretariat : Gedung Dept. Radioterapi Lt.2 RSUPN Dr Cipto Mangunkusumo, Jl. Diponegoro No.71 Jakarta Pusat 10430. Telp./Fax: 021-3903306, Email:pori.iros@yahoo.com
				</p>
			</td>
		</tr>
	</table>
	<hr />
	<h3 class="aligncenter">RINGKASAN PENILAIAN EVALUATOR KOMISI P2KB PORI</h3>
	<?php
	$post_periode = $periode;
	$arr_periode = explode('|',$post_periode);
	?>
	<table border="0" cellpadding="4">
		<tr><td>Nama</td><td>:</td><td><?=gelar_dokter($r->nama,$r->gelar)?></td></tr>
		<tr><td>Tempat/Tanggal Lahir</td><td>:</td><td><?=$r->lhr?> / <?=format_the_date($r->lhrtgl)?></td></tr>
		<tr><td>Nomor Anggota IDI</td><td>:</td><td><?=$r->idi?></td></tr>
		<tr><td>Nomor Anggota PORI</td><td>:</td><td><?=$r->nra?></td></tr>
		<tr><td valign="top">Alamat</td><td>:</td><td><?=$r->rumah?> <?= $r->rumahpos ? 'Kode POS: '.$r->rumahpos :''?></td></tr>
		<tr><td>Periode 5 tahun</td><td>:</td><td><?= format_the_date($arr_periode[0],'d/m/Y') ?> - <?= format_the_date($arr_periode[1], 'd/m/Y') ?></td></tr>		
	</table>

	<br />
	<table class="tkegiatan">
		<tr>
			<th>No</th>
			<th>Jenis Kegiatan</th>
			<th>Standar SKP</th>
			<th>Capaian SKP</th>
		</tr>
	  <?php
	  if (isset($rc) and !empty($rc)) {
	  	$i = 0;
	  	$total_standarSKP = 0;
	  	$total_capaianSKP = 0;
		$arr_inum = array('1a','1b','2','3','4','5');
		foreach( $rc as $k => $row ) { 
			$total_standarSKP += (int) $row['skp'];
			$total_capaianSKP += (int) $row['skp_doc'];
			if ($row['skp_doc'] >= $row['skp']) {
			}
			?>
		<tr>
			<td align="center"><?=$arr_inum[$i]?></td>
			<td><?=$row['jenis']?></td>
			<td align="center"><?=$row['skp']?></td>
			<td align="center"><?=$row['skp_doc']?></td>
		</tr>
			<?php
			$i++;
		}
	   }
	   ?>
		<tr>
			<td colspan="2" align="right"><strong>TOTAL SKP</strong></td>
			<td align="center"><strong><?=$total_standarSKP?></strong></td>
			<td align="center"><strong><?=$total_capaianSKP?></strong></td>
		</tr>
	</table>
	
	
	<p>&nbsp;</p>

	<h3 class="underline">ETIKA PROFESI</h3>
	<p class="left25"><?= $arr_etika[$etika];?></p>
	<p>&nbsp;</p>
	<h3 class="underline">CATATAN / TEGURAN KOMISI ETIK</h3>
	<p class="left25"><?= $keterangan ? 'Ada, '.$keterangan : 'Tidak Ada';?></p>
	<p>&nbsp;</p>
	<h3 class="underline">KONDISI KESEHATAN</h3>
	<p class="left25"><?= $arr_kesehatan[$kesehatan];?></p>
	<p>&nbsp;</p>
	<h3 class="underline">HASIL EVALUASI</h3>
	<p class="left25"><?= $arr_hasil[$hasil];?></p>
	<p>&nbsp;</p>

	<p class="counter"></p>
	<table width="100%" border="0" class="heading">
		<tr>
			<td><img src="<?=BASEPATH?>../images/logo-p2kb-print.png" /></td>
			<td>
			<h1 class="aligncenter">KOMISI PENGEMBANGAN PENDIDIKAN KEPROFESIAN BERKELANJUTAN <br />(P2KB)<br />
				PERHIMPUNAN DOKTER SPESIALIS ONKOLOGI RADIASI INDONESIA (PORI)</h1>
			<p align="center">	
				Sekretariat : Gedung Dept. Radioterapi Lt.2 RSUPN Dr Cipto Mangunkusumo, Jl. Diponegoro No.71 Jakarta Pusat 10430. Telp./Fax: 021-3903306, Email:pori.iros@yahoo.com
				</p>
			</td>
		</tr>
	</table>
	<hr />
	<div class="font-times">
		<h1 align="center">SURAT REKOMENDASI RE-SERTIFIKASI KOMPETENSI<br />
KEPADA KOLEGIUM ONKOLOGI RADIASI INDONESIA (KORI)
</h1>
		
		<p>&nbsp;</p>
		<table class="invistable">
			<tr><td>No</td><td>:</td><td><?= $nosurat ?></td></tr>
			<tr><td>Hal</td><td>:</td><td>Rekomendasi Re-Sertifikasi Kompetensi</td></tr>
			<tr><td>Lamp.</td><td>:</td><td>1 berkas</td></tr>
		</table>
		<p>&nbsp;</p>
		<p>Kepada Yth.<br />Ketua Kolegium Onkologi Radiasi Indonesia<br />Jakarta.</p>
		<p>&nbsp;</p>
		<p>Yang bertanda tangan di bawah ini menerangkan bahwa :</p>
		<p>&nbsp;</p>
		<?php
		$post_periode = $periode;
		$arr_periode = explode('|',$post_periode);
		?>
		<table border="0" cellpadding="4">
			<tr><td>Nama</td><td>:</td><td><?=gelar_dokter($r->nama,$r->gelar)?></td></tr>
			<tr><td>Tempat/Tanggal Lahir</td><td>:</td><td><?=$r->lhr?> / <?=format_the_date($r->lhrtgl)?></td></tr>
			<tr><td>Nomor Anggota IDI</td><td>:</td><td><?=$r->idi?></td></tr>
			<tr><td>Nomor Anggota PORI</td><td>:</td><td><?=$r->nra?></td></tr>
			<tr><td valign="top">Alamat</td><td>:</td><td><?=$r->rumah?> <?= $r->rumahpos ? 'Kode POS: '.$r->rumahpos :''?></td></tr>
			<tr><td>Periode 5 tahun</td><td>:</td><td><?= format_the_date($arr_periode[0],'d/m/Y') ?> - <?= format_the_date($arr_periode[1], 'd/m/Y') ?></td></tr>		
		</table>

		
		<p>&nbsp;</p>
		<p>Jumlah SKP yang dicapai selama 5 tahun (<?= format_the_date($arr_periode[0],'d/m/Y') ?> - <?= format_the_date($arr_periode[1], 'd/m/Y') ?>) : <?=$total_capaianSKP?> SKP.</p>
		<?php 
		switch($hasil) {
			case '0':
			case 0 : ?>
		<p align="justify">Berdasarkan penilaian atas dokumen P2KB, yang bersangkutan dinyatakan telah memenuhi syarat sehingga layak mendapat rekomendasi untuk memperoleh Sertifikat Kompetensi</p>
		<?php 
			break;
			case '1':
			case 1 :
		?>	
		<p align="justify">Berdasarkan penilaian atas dokumen P2KB, yang bersangkutan dinyatakan telah memenuhi syarat <em>(dengan program remedial dalam bidang yang tidak dipenuhi)</em> sehingga layak mendapat rekomendasi untuk memperoleh Sertifikat Kompetensi</p>
		<?php 
			break;
			case '2':
			case 2 :
		?>	
		<p align="justify">Berdasarkan penilaian atas dokumen P2KB, yang bersangkutan dinyatakan <strong>belum</strong> memenuhi syarat sehingga <strong>belum</strong> layak mendapat rekomendasi untuk memperoleh Sertifikat Kompetensi</p>
		<?php
			break;
		}
		?>
		<p>&nbsp;</p>
		<? $tanggal_surat = $tglsurat ?>
		<p>Jakarta, <?= strftime('%e %B %Y',strtotime($tanggal_surat))?><br />Atas Nama Komisi P2KB PORI,</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>(&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )</p>
	</div></body></html>
