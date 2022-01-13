<?php
namespace Controllers;
use Models\Siswa;
/**
 *
 */
class SiswaController {

	public $default_url = 'wp-admin/dashboard/';

	public function __construct(){

	}

	public function delete ( $id ) {
		try {

			$siswa = Siswa::find($id);

			$siswa->delete();

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
			$siswa 				= Siswa::findOrFail($id);
			$default_columns 	= Siswa::get_columns_fillable();
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
			$siswa->update( $forms );
			redirect( url( $this->default_url ) );
		} catch (\Exception $e) {
			dd( $e->getMessage() );
		}
	}

	public function added ( ) {

		$default_columns 	= Siswa::get_columns_fillable();
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

		$privelege = input()->post( 'privelege' );

		try {

			$auth = get_wpauth();

			$user_id = $auth->register( $privelege['email']->value, $privelege['password']->value, $privelege['username']->value );

			$auth->admin()->addRoleForUserByEmail($privelege['email']->value, \Delight\Auth\Role::AUTHOR);

			$args = array(
				'id_privelege' 	=> $user_id,
				'password' 		=> $privelege['password']->value
			);

			$forms = \array_merge( $args, $forms );

			$id = Siswa::create( $forms );

			redirect( url( $this->default_url ) );

		} catch (\Exception $e) {

			dd( $e->getMessage() );
		}
	}

	public function search () {

		$param = input()->post( 'q' )->value;

		$select_query=  array( 'siswa.*', 'kelas.nama_kelas', 'kelas.angkatan_kelas' );

		$siswa = Siswa::leftJoin('kelas', function($join){
			$join->on( 'siswa.kelas_id', '=', 'kelas.id' );
		})
		->select($select_query)
		->where(function($query) use ($param){
			$query->where('siswa.id', 'like', "%$param%")
				->orWhere('siswa.nama_lengkap', 'like', "%$param%");
		})->get()->toArray();

		wp_send_json( $siswa );
	}

	public function tagihan ($id) {
		echo '<pre>';
		print_r( $id );
		echo '</pre>';
		exit();
	}

}