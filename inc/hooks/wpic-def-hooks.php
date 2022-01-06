<?php
/**
 *
 */
class DefHooks {

	public function register( ){
		$this->pathDist = untrailingslashit( WCIC()->get_path( 'dist', true ) );
		$this->pathRoute = untrailingslashit( WCIC()->get_path( 'admin-route' ) );
	}

	public function init( ){
		add_action( 'init', array( $this, 'register_scripts' ) );
		if ( is_admin() || is_user_page() ) {
			add_action( 'wpic_setup_dashboard', array( $this, 'smart_setup_dashboard' ), 9 );
		}
		add_action( 'admin_init', array( $this, 'add_menu_dashboard_page' ) );
	}

	public function add_menu_dashboard_page( ){
		add_dashboard_page(
			'dashboard',
			__( apply_filters( 'wpic_main_menu_name', 'Dashboard' ), 'wpic' ),
			'manage',
			'dashboard',
			array( $this, 'render_main_dashboard' ),
			'ni ni-shop'
		);
	}

	public function render_main_dashboard(){
		do_action( 'render_main_dashboard' );
 	}

	public function smart_setup_dashboard( $page ){
		// dequeue
		wp_dequeue_style('front');
 		wp_dequeue_style('prism');

 		// enqueue
 		wp_enqueue_style('fullcalendar');

 		wp_enqueue_style('sweetallert');
 		wp_enqueue_script('sweetallert');

 		wp_enqueue_script('dashboard');
 		wp_enqueue_style('dashboard');

 		/**
		* do action before specific content dashboard while rendered
		*/
 		do_action( 'wpic_setup_' . $page .'_page' );
 	}

	public function register_scripts(){
		//scripts
		wp_register_script( 'cookie', $this->pathDist . '/assets/vendor/js-cookie/js.cookie.js', false, false, true );
 		wp_register_script( 'scrollbar', $this->pathDist . '/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js', false, false, true );
 		wp_register_script( 'scrollock', $this->pathDist . '/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js', false, false, true );
 		wp_register_script( 'chart', $this->pathDist . '/assets/vendor/chart.js/dist/Chart.min.js', false, false, true );
		wp_register_script( 'chartExt', $this->pathDist . '/assets/vendor/chart.js/dist/Chart.extension.js', false, false, true );
		wp_register_script( 'dashboard', $this->pathDist . '/assets/js/dashboard.js', array( 'jquery', 'bootstrap', 'cookie', 'scrollbar' ), false, true );
		wp_register_script( 'sweetallert', $this->pathDist . '/assets/js/sweetalert2.js', array( 'jquery', 'bootstrap' ), false, true );

		// styles
		wp_register_style( 'dashboard', $this->pathDist . '/css/dashboard.css', false, false, 'all' );
		wp_register_style( 'fullcalendar', $this->pathDist . '/assets/vendor/fullcalendar/dist/fullcalendar.min.css', false, false, 'all' );
 		wp_register_style( 'sweetallert', $this->pathDist . '/assets/vendor/sweetalert2/dist/sweetalert2.min.css', false, false, 'all' );
	}
}