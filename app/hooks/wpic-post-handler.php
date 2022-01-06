<?php
use Models\Siswa;
/**
 *
 */
class WpicPostHandler {
	public function register(){

	}

	public function init(){
		add_action( 'wp_ajax_nopriv_wp_ajax_call', array( $this, 'wcic_post_handler_reg_page' ) );
		add_action( 'wp_ajax_search_siswa', array( $this, 'search_siswa' ) );
	}

	public function search_siswa () {

		$search   = input()->get('q') ? input()->get('q')->value : '';
		$page     = input()->get('page') ? (int) max( input()->get('page')->value, 1 ) : 1;
		$per_page = 20;

		$args = array(
			's'       => $search,
			'page'    => $page,
			'limit'   => $per_page
		);

		$siswa = Siswa::select('id','nama_lengkap as text')->where('nama_lengkap', 'like', "%{$search}%")->limit($per_page)->offset(($page - 1) * $per_page)->get()->toArray();

		$response = array(
			'success'  => true,
			'message'  => 'Success',
			'data'     => $siswa,
			'page'     => $page,
			'per_page' => $per_page,
			'count'    => count( $siswa )
		);

		wp_send_json($response);
	}

	public function wcic_post_handler_reg_page(){

	}
}