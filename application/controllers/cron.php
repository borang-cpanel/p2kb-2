<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class khusus untuk cron job
 */
class Cron extends CI_Controller
{
	public function __construct()
	{
		parent::__construct(); 
		
		//Memastikan hanya bisa diakses di CLI saja. 
		//Diluar itu tidak boleh 
		if (!$this->input->is_cli_request()){
			return false;
		}
		
		$this->load->model('P2kb');
		$this->load->library('email');
		
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
	}
	
	/**
	 * Fungsi reminder untuk memastikan 6 bulan sudah kirim email pemberitahuan ke
	 * user bahwa tinggal 6 bulan lagi STR-nya akan mati. 
	 * Diatur agar dieksekusi 1 hari satu kali.
	 */
	public function reminderHalfYear()
	{
		$q = $this->P2kb->get_almost_expire_user(180);
		if ($q->num_rows()>0) {
			foreach ($q->result() as $row){
				
				//Yang tidak punya email diskip
				if(!$row->email)
					continue;
				
				//Kirim ke yang bersangkutan.
				$this->email->from('no-reply@pori.or.id', 'Admin P2KB PORI');
				$this->email->to($row->email);
				$this->email->subject('[P2KB PORI] Pemberitahuan Masa Akhir Surat Kompetensi ');
				$this->email->message('
Selamat pagi<br/><br/>

Melalui surat ini kami ingin mengingatkan kepada Anda bahwa Surat Kompetensi Anda akan 
berakhir dalam 6 bulan lagi. <br/><br/>

Mohon dipersiapkan data agar tidak sampai berakhir. Untuk mengakses sistem P2KB PORI, silahkan <a href="http://www.pori.or.id/p2kb"> klik sini </a>

Terima kasih <br/>
Admin P2KB PORI
					');

				$this->email->send();
			}
		}else{
			return false;
		}
	}

	/**
	 * Fungsi reminder untuk memastikan 1,5 tahun sudah kirim email pemberitahuan ke
	 * user bahwa tinggal satu tahun lagi STR-nya akan mati. 
	 * Diatur agar dieksekusi 1 hari satu kali.
	 */
	public function reminder()
	{
		$q = $this->P2kb->get_almost_expire_user(540);//540 hari
		
		if ($q->num_rows()>0) {
			foreach ($q->result() as $row){
				
				//Yang tidak punya email diskip
				if(!$row->email)
					continue;
				
				//Kirim ke yang bersangkutan.
				$this->email->from('no-reply@pori.or.id', 'Admin P2KB PORI');
				$this->email->to($row->email);
				$this->email->subject('[P2KB PORI] Pengingat untuk Mempersiapkan Data Perpanjangan STR ');
				$this->email->message('
Selamat pagi<br/><br/>

Melalui surat ini kami sekedar ingin mengingatkan kepada Anda bahwa masa STR Anda akan 
berakhir dalam 1,5 tahun. Agar tidak membebani pekerjaan untuk menyiapkan data kegiatan 
guna pengurusan STR ini, kami menyarankan agar Anda sudah mulai mempersiapkannya semenjak 
saat ini. <br/><br/>

Untuk mengakses sistem P2KB PORI, silahkan <a href="http://www.pori.or.id/p2kb"> klik sini </a>

Terima kasih <br/>
Admin P2KB PORI
					');

				$this->email->send();
			}
		}else{
			return false;
		}
	}
}