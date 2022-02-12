<?php
namespace Controllers;
use Models\Transaksi;


/**
 * Fungsi untuk menangani proses crud tagihan
 */

class LaporanController {

	public function __construct(){

	}

	public function cetak () {
		$params = $_GET;
		if ( ! $params['bulan'] || ! $params['status-tagihan'] || ! $params['tahun-ajaran'] ) {
			dd( 'filter tidak boleh kosong satupun' );
		}
		$select_query 	= array( 'siswa.nama_lengkap', 'siswa.nis', 'siswa.nama_wali', 'siswa.jenis_kelamin', 'siswa.tahun_ajaran', 'siswa.kelas_id', 'transaksi.status as status_transaksi', 'tagihan.nama_tagihan', 'tagihan.*' );
		$transaction 	= Transaksi::leftJoin('siswa', function($join) {
        	$join->on('transaksi.id_siswa', '=', 'siswa.id');
        })
        ->leftJoin('tagihan', function($join) {
        	$join->on('transaksi.id_tagihan', '=', 'tagihan.id');
        })
        ->select($select_query)
        ->where([
        	[ 'tagihan.bulan', '=', $params['bulan'] ],
        	[ 'transaksi.status', '=', $params['status-tagihan'] ],
        	[ 'siswa.kelas_id', '=', get_kelas_id($params['kelas']) ],
        	[ 'siswa.tahun_ajaran', '=', $params['tahun-ajaran'] ]
        ])
        ->get()->toArray();
        render_cetak_pdf( array( 'transaksi' => $transaction ) );
        exit;
	}
}