<?php

/**
 * Fire the wcic_head action.
 *
 * See {@see 'wcic_head'}.
 *
 * @since 1.2.0
 */
function wcic_head() {
	/**
	 * Prints scripts or data in the head tag on the front end.
	 *
	 * @since 1.5.0
	 */
	do_action( 'wcic_head' );
}

/**
 * Fire the wcici_footer action.
 *
 * See {@see 'wcici_footer'}.
 *
 * @since 1.5.1
 */
function wcic_footer() {
	/**
	 * Prints scripts or data before the closing body tag on the front end.
	 *
	 * @since 1.5.1
	 */
	do_action( 'wcic_footer' );
}