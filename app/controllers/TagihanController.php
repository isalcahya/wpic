<?php
namespace Controllers;
use Models\Tagihan;
use Models\Siswa;
use Models\Transaksi;
/**
 *
 */
class TagihanController {

	public $default_url = 'wp-admin/tagihan-spp/';

	public function __construct(){

	}

	public function delete ( $id ) {
		try {

			$tagihan = Tagihan::find($id);

			$tagihan->delete();

			$response = array(
				'success' => true,
				'type'    => 'success',
				'title'   => 'Success',
				'message' => 'Data berhasil dihapus'
			);

		} catch (Exception $e) {
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
			$tagihan 			= Tagihan::findOrFail($id);
			$default_columns 	= Tagihan::get_columns_fillable();
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
			$tagihan->update( $forms );
			redirect( url( $this->default_url ) );
		} catch (Exception $e) {
			dd( $e->getMessage() );
		}
	}

	public function added ( ) {
		$default_columns 	= Tagihan::get_columns_fillable();
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

			$tagihan = Tagihan::create( $forms );
			$target = array();

			if ( 'specific' === $forms['target'] ) {

				$target[] = Siswa::find(input()->post( 'pilihan_siswa' )->value)->toArray();

			} else {

				$target = Siswa::all()->toArray();
			}

			foreach ( $target as $key => $siswa ) {
				$args = array(
					'id_siswa' 		=> (int) $siswa['id'],
					'id_tagihan' 	=> (int) $tagihan->id
				);
				Transaksi::create( $args );
			}

			redirect( url( $this->default_url ) );

		} catch (Exception $e) {
			dd( $e->getMessage() );
		}
	}
}