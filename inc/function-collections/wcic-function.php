<?php

function WCIC(){
    return \App\lib\wcic_load_class::init();
}

function view(){
	return new App\lib\wcic_load_view();
}

function get_image_directory(){
	return untrailingslashit( WCIC()->get_path( 'resource', true ) . 'img/' );
}

function get_dist_directory(){
	return untrailingslashit( WCIC()->get_path( 'dist', true ) );
}

function is_admin(){
	global $wp_current_page;
	if ( isset( $wp_current_page->admin_page ) && true === $wp_current_page->admin_page ) {
		return true;
	}
	return false;
}

function is_user_page(){
	global $wp_current_page;
	if ( isset( $wp_current_page->user_page ) && true === $wp_current_page->user_page ) {
		return true;
	}
	return false;
}

function add_dashboard_page( $page_id, $menu_title, $capability, $menu_slug, $function = '', $iconcode = '' ) {
	global $wpmenu;
	if ( current_user_can( $capability ) && ! empty( $page_id ) && ! empty( $function ) ) {
		/**
		* add action when content dashboard while rendered
		*/
 		add_action( 'render-' . $page_id .'-content', $function );

		if ( empty( $iconcode ) ) {
			$icon_code = 'ni ni-shop ';
		}
		if ( empty( $wpmenu ) ) {
			$wpmenu = array();
		}
		$wpmenu = array_merge( $wpmenu, array( $page_id, $menu_title, $capability, $menu_slug, $iconcode ) );
	}
}

function add_sub_page_dashboard( $page_id, $menu_title, $capability, $menu_slug, $function = '', $parent = '', $position = 0 ){
	global $wpchildmenu;
	if ( current_user_can( $capability ) && ! empty( $page_id ) && ! empty( $function ) ) {
		/**
		* add action when content dashboard while rendered
		*/
 		add_action( 'render-child.' . $page_id .'-content', $function );

		if ( empty( $wpchildmenu ) ) {
			$wpchildmenu = array();
		}

		$wpchildmenu = array_merge( $wpchildmenu, array( $page_id, $menu_title, $capability, $menu_slug, $parent, $position ) );
	}
}

function wpic_get_menus_dashboard(){
	global $wpmenu, $wpchildmenu, $wp_menus_dashboard;
	if ( isset( $wp_menus_dashboard ) && ! empty( $wp_menus_dashboard ) ) {
		return $wp_menus_dashboard;
	}
	if ( ! isset( $wpmenu ) || ! is_array( $wpmenu ) || empty( $wpmenu ) ) {
		// unset after menu has non a value
		unset( $wpmenu );
		unset( $wpchildmenu );
		return array();
	}
	// filter, clean and push master keys on $wpmenu
	$parent_master_keys = array( 'page_id', 'menu_title', 'capability', 'menu_slug', 'iconcode' );
	$wpmenu = wpic_array_combines( $parent_master_keys, $wpmenu );
	wpic_remove_duplicate_array_by( 'page_id', $wpmenu );
	wpic_remove_duplicate_array_by( 'menu_slug', $wpmenu );
	// set menus dashboard from current global menus
	$wp_menus_dashboard = $wpmenu;
	// filter, clean and push master keys on $wpchildmenu
	// check if that has a value
	if ( isset($wpchildmenu) && ! empty($wpchildmenu) && is_array($wpchildmenu) ) {
		$child_master_keys 	= array( 'page_id', 'menu_title', 'capability', 'menu_slug', 'parent', 'position' );
		$wpchildmenu = wpic_array_combines( $child_master_keys, $wpchildmenu );
		wpic_remove_duplicate_array_by( 'page_id', $wpchildmenu );
		wpic_remove_duplicate_array_by( 'menu_slug', $wpchildmenu );
		foreach ( $wpchildmenu as $key => $childmenu ) {
			$key_parent = array_search( $childmenu['parent'], array_column($wpmenu, 'page_id') );
			if ( $key_parent > -1 ) {
				$wp_menus_dashboard[$key_parent]['child'][] = $childmenu;
			}
		}
	}
	// unset after all menu has a registered
	unset( $wpmenu );
	unset( $wpchildmenu );

	// return global $wp_menus
	return $wp_menus_dashboard;
}

function wpic_get_dashboards(){
	// todo action merge wpmenu with childmenu
	$wpmenu = array(
		array(
			'page' 	=> 'dashboard',
			'slug' 	=> '/dashboard',
			'title' => __( 'Dashboard', 'wpic' ),
			'children' => array(
				array(
					'page' => 'isal',
					'slug' 	=> '/isal',
					'title' => __( 'Isal', 'wpic' )
				)
			)
		),
		array(
			'page' 	=> 'example',
			'slug' 	=> '/example',
			'title' => __( 'Example', 'wpic' ),
			'children' => array(
				array(
					'page' => 'isal',
					'slug' 	=> '/isal',
					'title' => __( 'Xisal', 'wpic' )
				)
			)
		)
	);
	$menu = apply_filters( 'wp_add_dashboard_menu', $wpmenu );
	return $menu;
}

function wp_get_current_user() {
	global $wpauth, $current_user;

	if ( ! $wpauth instanceof \Delight\Auth\Auth ) {
		return $wpauth;
	}

	wp_set_current_auth( $wpauth );

	if ( ! empty( $current_user ) ) {
		if ( $current_user instanceof WP_User ) {
			return $current_user;
		}

		// Upgrade stdClass to WP_User
		if ( is_object( $current_user ) && isset( $current_user->id ) ) {
			$cur_id       = $current_user->id;
			$current_user = null;
			wp_set_current_user( $cur_id );
			return $current_user;
		}

		// $current_user has a junk value. Force to WP_User with ID 0.
		$current_user = null;
		wp_set_current_user( 0 );
		return $current_user;
	}

	if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
		wp_set_current_user( 0 );
		return $current_user;
	}

	/**
	 * Filters the current user.
	 *
	 * The default filters use this to determine the current user from the
	 * request's cookies, if available.
	 *
	 * Returning a value of false will effectively short-circuit setting
	 * the current user.
	 *
	 * @since 3.9.0
	 *
	 * @param int|bool $user_id User ID if one has been determined, false otherwise.
	 */
	$user_id = apply_filters( 'determine_current_user', false );
	if ( ! $user_id ) {
		wp_set_current_user( 0 );
		return $current_user;
	}

	return $current_user;
}

//
// User option functions.
//

/**
 * Get the current user's ID
 *
 * @since MU (3.0.0)
 *
 * @return int The current user's ID, or 0 if no user is logged in.
 */
function get_current_user_id() {
	if ( ! function_exists( 'wp_get_current_user' ) ) {
		return 0;
	}
	$user = wp_get_current_user();
	return ( isset( $user->ID ) ? (int) $user->ID : 0 );
}

function wp_set_current_auth(\Delight\Auth\Auth $auth){
	global $current_user;
	if ( ! $auth->isLoggedIn() ) {
		$current_user = null;
	} else if ( ! $current_user instanceof WP_User ){
		$id = $auth->getUserId();
		$username = $auth->getUsername();
		$current_user = new \WP_User( $id, $username );
	}
}

/**
 * Changes the current user by ID or name.
 *
 * Set $id to null and specify a name if you do not know a user's ID.
 *
 * Some WordPress functionality is based on the current user and not based on
 * the signed in user. Therefore, it opens the ability to edit and perform
 * actions on users who aren't signed in.
 *
 * @since 2.0.3
 * @global WP_User $current_user The current user object which holds the user data.
 *
 * @param int    $id   User ID
 * @param string $name User's username
 * @return WP_User Current user User object
 */
function wp_set_current_user( $id, $name = '' ) {
	global $current_user;

	// If `$id` matches the current user, there is nothing to do.
	if ( isset( $current_user )
	&& ( $current_user instanceof WP_User )
	&& ( $id == $current_user->id )
	&& ( null !== $id )
	) {
		return $current_user;
	}

	$current_user = new WP_User( $id, $name );
	/**
	 * Fires after the current user is set.
	 *
	 * @since 2.0.1
	 */
	do_action( 'set_current_user' );

	return $current_user;
}

function current_user_can( $capability, ...$args ) {
    $current_user = wp_get_current_user();

    if ( empty( $current_user ) ) {
        return false;
    }

    return $current_user->has_cap( $capability, ...$args );
}

 function wpic_array_combines($arr1, $arr2) {
	$count1 = count($arr1);
	$count2 = count($arr2);
	$numofloops = $count2/$count1;

	$i = 0;
	while($i < $numofloops){
		$arr3 = array_slice($arr2, $count1*$i, $count1);
		$arr4[] = array_combine($arr1,$arr3);
		$i++;
	}

	return $arr4;
}

function wpic_remove_duplicate_array_by( $selector = 'id', &$data = '' ){
	$_data = array();
	foreach ($data as $v) {
	if (isset($_data[$v[$selector]])) {
		// found duplicate
		continue;
	}
		// remember unique item
		$_data[$v[$selector]] = $v;
	}
	// if you need a zero-based array
	// otherwise work with $_data
	$data = array_values($_data);
}

function get_wpauth(){
	global $wpauth;
	if ( $wpauth instanceof \Delight\Auth\Auth ) {
		return $wpauth;
	}
	return null;
}

function is_user_logged_in(){
	global $wpauth;

	if ( ! $wpauth instanceof \Delight\Auth\Auth ) {
		return false;
	}

	if ( ! $wpauth->isLoggedIn() ) {
		return false;
	}

	return $wpauth->check();
}

function admin_ajax_url( $path ){
	$url = WCIC()->get_path('admin-ajax', true);
	if ( $path && is_string($path) ) {
		$url .= ltrim( $path, '/' );
	}
	return $url;
}

function redirect_by_role(string $role){
	$redirect = '';
	switch ( $role ) {
		case 'admin':
			$redirect = WCIC()->get_path('', true).'wp-admin/';
			break;
		case 'author':
			$redirect = WCIC()->get_path('', true).'wp-user/';
			break;
	}
	return $redirect;
}

function canManageUser(\Delight\Auth\Auth $auth) {
    return $auth->hasRole(\Delight\Auth\Role::AUTHOR);
}

function wp_token_verifier(string $token){
	if ( empty($token) ) {
		throw new \Exception('Invalid CSRF-token.');
	}
	$wpcsrf = App\wcic_init_hooks::wpcsrf();
	if ( $wpcsrf->getTokenProvider()->validate((string)$token) === false) {
        throw new \Exception('Invalid CSRF-token.');
    }
}
