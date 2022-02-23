<?php
namespace Controllers;
use Models\Users;
use Delight\Cookie\Session;

/**
 * Fungsi untuk menangani proses crud kelola-user
 */
class UserController {

	public $default_url = 'wp-admin/kelola-user/';

	public function __construct(){

	}

	public function delete ( $id ) {
		try {

			$users = Users::find($id);

			$users->delete();

			$response = array(
				'success' => true,
				'type'    => 'success',
				'title'   => 'Success',
				'message' => 'Data berhasil dihapus'
			);

		} catch (\Exception $e) {
			$response = array(
				'success' => false,
				'type'    => 'error',
				'title'   => 'Error',
				'message' => $e->getMessage()
			);
		}

		echo json_encode( $response );
	}

	public function updated ( $id ) {
		try {
			$users 				= Users::findOrFail($id);
			$default_columns 	= Users::get_columns_fillable();
			$forms 				= array();
			$columns 			= array_intersect_key( $default_columns, input()->all() );
			foreach ( $columns as $key => $value ) {
				if ( $value === '%s' ) {
					$the_value = ( string ) input()->post( $key )->value;
				} else if ( $value === '%d' ) {
					$the_value = ( int ) input()->post( $key )->value;
				} else {
					$the_value = input()->post( $key )->value;
				}
				$forms[$key] = $the_value;
			}
			$forms['roles_mask'] = $forms['role_mask'];
			unset($forms['role_mask']);
			$forms['passwordString'] = $forms['password'];
			$forms['password'] = \password_hash($forms['passwordString'], \PASSWORD_DEFAULT);

			$users->update( $forms );
			redirect( url( $this->default_url ) );
		} catch (\Exception $e) {
			Session::set( 'msg.create.data', array( 'type' => 'error', 'msg' => $e->getMessage() ) );
			redirect( url( $this->default_url ) );
		}
	}

	public function added ( ) {
		$default_columns 	= Users::get_columns_fillable();
		$forms 				= array();
		$columns 			= array_intersect_key( $default_columns, input()->all() );
		foreach ( $columns as $key => $value ) {
			if ( $value === '%s' ) {
				$the_value = ( string ) input()->post( $key )->value;
			} else if ( $value === '%d' ) {
				$the_value = ( int ) input()->post( $key )->value;
			} else {
				$the_value = input()->post( $key )->value;
			}
			$forms[$key] = $the_value;
		}

		try {
			$auth = get_wpauth();
			$userId = $auth->register($forms['email'], $forms['password'], $forms['username']);
			# todo make email confirmation for registered user
			if ( $userId ) {
				$auth->admin()->addRoleForUserById($userId, (int) $forms['role_mask']);
				$users = Users::find($userId);
				$users->update( array(
					'passwordString' => $forms['password']
				) );
			}
			Session::set( 'msg.create.data', 'sukses menambahkan data' );
			redirect( url( $this->default_url ) );
		} catch (\Exception $e) {
			Session::set( 'msg.create.data', array( 'type' => 'error', 'msg' => $e->getMessage() ) );
			redirect( url( $this->default_url ) );
		}
	}

}