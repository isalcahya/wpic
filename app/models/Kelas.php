<?php
Namespace Models;
use Illuminate\Database\Eloquent\Model;
/**
 *
 */
class Kelas extends Model {

	protected $table   = 'kelas';
	protected $guarded = [];
	public static function get_columns_fillable () {
		return array(
			'nama_kelas' => '%s',
			'angkatan_kelas' => '%d',
			'wali_kelas' => '%s',
		);
	}

}