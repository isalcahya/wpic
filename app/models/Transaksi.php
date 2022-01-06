<?php
Namespace Models;
use Illuminate\Database\Eloquent\Model;
/**
 *
 */
class Transaksi extends Model {

	protected $table   = 'transaksi';
	protected $guarded = [];
	public static function get_columns_fillable () {
		return array(
			'id_siswa' 	 => '%d',
			'id_tagihan' => '%d',
			'has_paid' 	 => '%d'
		);
	}

}