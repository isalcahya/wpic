<?php
Namespace Models;
use Illuminate\Database\Eloquent\Model;
/**
 *
 */
class Tagihan extends Model {

	protected $table   = 'tagihan';
	protected $guarded = [];
	public static function get_columns_fillable () {
		return array(
			'nama_tagihan' => '%s',
			'jangka_waktu_tagihan' => '%s',
			'angkatan_kelas' => '%d',
			'bulan' => '%s',
			'tahun' => '%s',
			'target' => '%s',
			'total_tagihan' => '%s',
			'catatan' => '%s'
		);
	}

}