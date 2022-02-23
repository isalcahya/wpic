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

		if ( ! $params['bulan'] && ! $params['status-tagihan'] && ! $params['tahun-ajaran'] && ! $params['kelas'] ) {
			dd( 'filter tidak boleh kosong' );
		}

		$where = array();

		if ( $params['bulan'] ) {
			$where[] = [ 'tagihan.bulan', '=', $params['bulan'] ];
		}

		if ( $params['status-tagihan'] ) {
			$where[] = [ 'transaksi.status', '=', $params['status-tagihan'] ];
		}

		if ( $params['kelas'] ) {
			$where[] = [ 'siswa.kelas_id', '=', get_kelas_id($params['kelas']) ];
		}

		if ( $params['tahun-ajaran'] ) {
			$where[] = [ 'tagihan.tahun', '=', $params['tahun-ajaran'] ];
		}

		$select_query 	= array( 'siswa.nama_lengkap', 'siswa.nis', 'siswa.nama_wali', 'siswa.jenis_kelamin', 'siswa.kelas_id', 'transaksi.status as status_transaksi', 'tagihan.*' );
		$transaction 	= Transaksi::leftJoin('siswa', function($join) {
        	$join->on('transaksi.id_siswa', '=', 'siswa.id');
        })
        ->leftJoin('tagihan', function($join) {
        	$join->on('transaksi.id_tagihan', '=', 'tagihan.id');
        })
        ->select($select_query)
        ->where($where)
        ->get()->toArray();
        render_cetak_pdf( array( 'transaksi' => $transaction ) );
        exit;
	}
}