<?php
namespace Controllers;
use Models\Kelas;
/**
 *
 */
class KelasController {

	public $default_url = 'wp-admin/kelas/';

	public function __construct(){

	}

	public function delete ( $id ) {
		try {

			$kelas = Kelas::find($id);

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
			$kelas 				= Kelas::findOrFail($id);
			$default_columns 	= Kelas::get_columns_fillable();
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
			dd( $e->getMessage() );
		}
	}

	public function added ( ) {
		$default_columns 	= Kelas::get_columns_fillable();
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
			$id = Kelas::create( $forms );
			redirect( url( $this->default_url ) );
		} catch (\Exception $e) {
			dd( $e->getMessage() );
		}
	}

}