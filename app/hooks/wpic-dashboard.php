<?php
/**
 *
 */
class DashboardApp {
	protected $pathDist;

	// if you want to activated this class just set from unregister to register
	public function register(){
		$this->pathDist = untrailingslashit( WCIC()->get_path( 'dist', true ) );
	}

	public function init(){
		add_action( 'admin_init', array( $this, 'add_menu_dashboard_page' ) );
		add_action( 'user_init', array( $this, 'add_user_dashboard_page' ) );
	}

	public function add_user_dashboard_page( ){
		add_dashboard_page(
			'dashboard.user',
			__( 'Dashboard User', 'wpic' ),
			'manage-account',
			'dashboard',
			array( $this, 'render_main_dashboard' ),
			'ni ni-shop'
		);
	}

	public function add_menu_dashboard_page( ){
		add_dashboard_page(
			'dashboard',
			__( 'Dashboard', 'wpic' ),
			'manage',
			'dashboard',
			array( $this, 'render_main_dashboard' ),
			'ni ni-shop'
		);

		add_dashboard_page(
			'example',
			__( 'Example', 'wpic' ),
			'manage',
			'example',
			array( $this, 'render_example_dashboard' ),
			'ni ni-shop'
		);

		// add_sub_page_dashboard(
		// 	'isal',
		// 	__( 'Ixample', 'wpic' ),
		// 	'manage',
		// 	'isal',
		// 	array( $this, 'render_isal_dashboard' ),
		// 	'dashboard',
		// 	2
		// );
	}

	public function render_example_dashboard(){

	}

 	public function render_main_dashboard(){
 		view()->render( 'parts/dashboard/main-content' );
 	}

 	public static function dashboard_content_example(){

 		if ( isset( $_GET['profile'] ) && !empty( $_GET['profile'] ) ) {
 			echo "profile";
 			return;
 		}

 		view()->render( 'parts/dashboard/example' );
 	}
}