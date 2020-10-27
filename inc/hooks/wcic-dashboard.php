<?php
namespace App\hooks;
/**
 *
 */
class DashboardHooks {
	protected $pathDist;

	// if you want to activated this class just set from unregister to register
	public function register(){
		$this->pathDist = untrailingslashit( WCIC()->get_path( 'dist', true ) );
	}

	public function init(){
		add_action( 'init', array( $this, 'register_scripts' ) );
		add_action( 'wcic-render-dashboard', array( $this, 'prepare_dashboard' ), 12 );
	}

	public function register_scripts(){
		//scripts
		wp_register_script( 'cookie', $this->pathDist . '/assets/vendor/js-cookie/js.cookie.js', false, false, true );
 		wp_register_script( 'scrollbar', $this->pathDist . '/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js', false, false, true );
 		wp_register_script( 'scrollock', $this->pathDist . '/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js', false, false, true );
 		wp_register_script( 'chart', $this->pathDist . '/assets/vendor/chart.js/dist/Chart.min.js', false, false, true );
		wp_register_script( 'chartExt', $this->pathDist . '/assets/vendor/chart.js/dist/Chart.extension.js', false, false, true );
		wp_register_script( 'dashboard', $this->pathDist . '/assets/js/dashboard.js', array( 'jquery', 'bootstrap', 'cookie', 'scrollbar', 'scrollock', 'chart', 'chartExt' ), false, true );

		// styles
		wp_register_style( 'dashboard', $this->pathDist . '/css/dashboard.css', false, false, 'all' );
		wp_register_style( 'fullcalendar', $this->pathDist . '/assets/vendor/fullcalendar/dist/fullcalendar.min.css', false, false, 'all' );
 		wp_register_style( 'sweatallert', $this->pathDist . '/assets/vendor/sweetalert2/dist/sweetalert2.min.css', false, false, 'all' );
	}

	public function prepare_dashboard( $page ){
 		wp_dequeue_style('prism');
 		wp_enqueue_style('fullcalendar');
 		wp_enqueue_style('sweatallert');
 		wp_enqueue_script('dashboard');
 		switch ( $page ) {
 			case 'dash':
 				$callback = 'dashboard_content_example';
 				break;
 			case 'dash.example':
 				$callback = 'dashboard_content_example';
 				break;
 			case 'dash.dashboard':
 				$callback = 'dashboard_content';
 				break;
 		}
 		add_action( 'render-dashboard-content', array( $this, $callback ) );
 	}

 	public function dashboard_content(){
 		view()->render( 'parts/dashboard/main-content' );
 	}

 	public function dashboard_content_example(){

 		if ( isset( $_GET['profile'] ) && !empty( $_GET['profile'] ) ) {
 			echo "profile";
 			return;
 		}

 		view()->render( 'parts/dashboard/example' );
 	}
}