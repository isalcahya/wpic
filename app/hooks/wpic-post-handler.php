<?php
/**
 *
 */
class WpicPostHandler {
	public function register(){

	}

	public function init(){
		add_action( 'wp_ajax_nopriv_wp_ajax_call', array( $this, 'wcic_post_handler_reg_page' ) );
	}

	public function wcic_post_handler_reg_page(){
		$csrf = input()->post('csrf_token', null);
	}
}