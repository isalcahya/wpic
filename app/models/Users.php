<?php
Namespace Models;
use Illuminate\Database\Eloquent\Model;
/**
 *
 */
class Users extends Model {
	protected $table = 'users';
	protected $fillable = array( 'username', 'email', 'password', 'role_mask' );
	public static function get_columns_fillable () {
		return array(
			'username' => '%s',
			'role_mask' => '%d',
			'email' => '%s',
		);
	}
}