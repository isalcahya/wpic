<?php
Namespace Models;
use Illuminate\Database\Eloquent\Model;
/**
 *
 */
class Siswa extends Model {

	protected $table   = 'siswa';
	protected $guarded = [];
	public static function get_columns_fillable () {
		return array(
			'nama_lengkap' => '%s',
			'nis' => '%s',
			'kelas_id' => '%d',
			'nama_wali' => '%s',
			'tahun_ajaran' => '%s',
			'alamat' => '%s',
			'jenis_kelamin' => '%s',
			'status' => '%s',
			'password' => '%s',
			'id_privelege' => '%d'
		);
	}

}