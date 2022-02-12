<?php
namespace Controllers;
use Models\User;
use Delight\Cookie\Session;

/**
 * Fungsi untuk menangani proses crud kelas
 */
class UserController {

	public $default_url = 'wp-admin/kelas/';

	public function __construct(){

	}

	public function delete ( $id ) {
		try {

			$kelas = User::find($id);

			$kelas->delete();

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
			$kelas 				= User::findOrFail($id);
			$default_columns 	= User::get_columns_fillable();
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
			$kelas->update( $forms );
			redirect( url( $this->default_url ) );
		} catch (\Exception $e) {
			Session::set( 'msg.create.data', array( 'type' => 'error', 'msg' => $e->getMessage() ) );
			redirect( url( $this->default_url ) );
		}
	}

	public function added ( ) {
		$default_columns 	= User::get_columns_fillable();
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
			$id = User::create( $forms );
			Session::set( 'msg.create.data', 'sukses menambahkan data' );
			redirect( url( $this->default_url ) );
		} catch (\Exception $e) {
			Session::set( 'msg.create.data', array( 'type' => 'error', 'msg' => $e->getMessage() ) );
			redirect( url( $this->default_url ) );
		}
	}

}