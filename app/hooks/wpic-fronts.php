<?php
/**
 *
 */
class WpicFronts {

	protected $pathDist;

	// if you want to activated this class just set from unregister to register
	public function register(){
		$this->pathDist = untrailingslashit( WCIC()->get_path( 'dist', true ) );
	}

	public function init(){
		add_action( 'init', array( $this, 'register_script' ) );
		add_action( 'wpic_on_render', array( $this, 'wpic_fronts_enqueue' ) );
		add_action( 'wcic-render-login', array( $this, 'remove_front_dependency' ) );
		add_action( 'wcic-setup-register-page', array( $this, 'remove_front_dependency' ) );
		add_action( 'wcic-render-landpage', array( $this, 'prepare_landpage' ) );
		add_action( 'wcic_navbar_template', array( $this, 'navbar_default_template' ) );
		add_action( 'front_post_handler', array( $this, 'front_post_callback' ), 10, 2 );
		add_filter( 'wpic_main_menu_name', array( $this, 'change_the_main_menu_name' ) );
 	}

 	public function change_the_main_menu_name ( $origin_name ) {
 		return 'Data Siswa';
 	}

 	public function front_post_callback( $page, $postdata ){
 		try {

 			if ( ( empty($page) && !is_string($page) ) || empty( $postdata ) ) {
 				throw new \Exception("Error Processing Request", 1);
 			}

 			if ( ! ( $auth = get_wpauth() ) ) {
				throw new \Exception("Error Processing Request", 1);
			}

			if ( $auth->check() ) {
				if ( $auth->hasRole(\Delight\Auth\Role::ADMIN) ) {
					redirect(redirect_by_role('admin'));
				}
				if ( $auth->hasRole(\Delight\Auth\Role::AUTHOR) ) {
					redirect(redirect_by_role('author'));
				}
			}
 			$page = explode( '.', $page );
 			$page = isset($page[0]) ? $page[0] : 0;
 			switch ( $page ) {
 				case 'login':
 					if ( isset( $postdata['_login'] ) && $postdata['_login'] ) {
 						$auth->login($postdata['user_email'], $postdata['user_pass']);
 						if ( $auth->hasRole(\Delight\Auth\Role::ADMIN) ) {
 							redirect(redirect_by_role('admin'));
 						}
 						if ( $auth->hasRole(\Delight\Auth\Role::AUTHOR) ) {
 							redirect(redirect_by_role('author'));
 						}
			 		}
 					break;
 				case 'register':
 					if ( isset( $postdata['_register'] ) && $postdata['_register'] ) {
						$userId = $auth->register($postdata['user_email'], $postdata['user_pass'], $postdata['user_username']);
						# todo make email confirmation for registered user
						if ( $userId ) {
							$auth->admin()->addRoleForUserById($userId, \Delight\Auth\Role::ADMIN);
							$auth->login( $postdata['user_email'], $postdata['user_pass'] );
							if ( $auth->check() ) {
								if ( $auth->hasRole(\Delight\Auth\Role::ADMIN) ) {
		 							redirect(redirect_by_role('admin'));
		 						}
		 						if ( $auth->hasRole(\Delight\Auth\Role::AUTHOR) ) {
		 							redirect(redirect_by_role('author'));
		 						}
							}
						}
			 		}
 					break;
 				default:
 					throw new \Exception("Error Processing Request", 1);
 					break;
 			}
		}
		catch (\Delight\Auth\InvalidEmailException $e) {
		    die('Invalid email address');
		}
		catch (\Delight\Auth\InvalidPasswordException $e) {
		    die('Invalid password');
		}
		catch (\Delight\Auth\UserAlreadyExistsException $e) {
		    die('User already exists');
		}
		catch (\Delight\Auth\TooManyRequestsException $e) {
		    die('Too many requests');
		}
		catch (\Exception $e) {
		    die($e->getMessage());
		}
 	}

	public function navbar_default_template(){
		view()->render( 'parts/navbar-home' );
	}

	public function navbar_landpage_template(){
		view()->render( 'parts/navbar-landpage' );
	}

	public function remove_front_dependency(){
		wp_dequeue_style('front');
		wp_enqueue_style('dashboard');
	}

	public function prepare_landpage(){
		remove_action( 'wcic_navbar_template', array( $this, 'navbar_default_template' ) );
		add_action( 'wcic_navbar_template', array( $this, 'navbar_landpage_template' ) );
	}

	public function register_script(){
		// scripts
		wp_register_script( 'wpicjs', $this->pathDist . '/js/test.js', array( 'jquery', 'bootstrap' ), false, true );
		wp_register_script( 'headroom', $this->pathDist . '/assets/vendor/headroom.js/dist/headroom.min.js', array( 'jquery', 'bootstrap' ), false, true );
		wp_register_script( 'datatable', $this->pathDist . '/assets/datatable/datatables.min.js', array( 'jquery', 'bootstrap' ), false, true );
		wp_register_script( 'select2', $this->pathDist . '/assets/js/select2.min.js', array( 'jquery', 'bootstrap' ), false, true );
		// styles
		wp_register_style( 'front', $this->pathDist . '/css/front.css', false, false, 'all' );
		wp_register_style( 'fontawesome-free', $this->pathDist . '/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css', false, false, 'all' );
		wp_register_style( 'prism', $this->pathDist . '/assets/vendor/prismjs/themes/prism.css', false, false, 'all' );
		wp_register_style( 'nucleo', $this->pathDist . '/assets/vendor/nucleo/css/nucleo.css', false, false, 'all' );
		wp_register_style( 'datatable', $this->pathDist . '/assets/datatable/datatables.min.css', false, false, 'all' );
		wp_register_style( 'select2', $this->pathDist . '/assets/css/select2.min.css', false, false, 'all' );

		wp_localize_script( 'wpicjs', 'WPIC', array(
			'admin_ajax_url' => admin_ajax_url( 'wp-ajax.php' ),
			'csrf_token' => csrf_token(),
			'base_url' => WP_SITE_URL,
			'current_url' => url()
		) );
	}

	public function wpic_fronts_enqueue(){
		//
		wp_enqueue_script('datatable');
		wp_enqueue_script('select2');
		wp_enqueue_script('wpicjs');
		// wp_enqueue_script('headroom');
		//
		wp_enqueue_style('datatable');
		wp_enqueue_style('select2');
		wp_enqueue_style('front');
		wp_enqueue_style('fontawesome-free');
		wp_enqueue_style('nucleo');
		wp_enqueue_style('prism');
	}

}