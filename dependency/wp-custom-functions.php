<?php

include_once( 'wp-functions/wp-template.php' );
include_once( 'wp-functions/wp-general-template.php' );
include_once( 'wp-functions/wp-formating.php' );
include_once( 'wp-functions/wp-kses.php' );

/**
 * Get the filesystem directory path (with trailing slash) for the plugin __FILE__ passed in.
 *
 * @since 2.8.0
 *
 * @param string $file The filename of the plugin (__FILE__).
 * @return string the filesystem path of the directory that contains the plugin.
 */
function plugin_dir_path( $file ) {
	return trailingslashit( dirname( $file ) );
}

/**
 * Get the URL directory path (with trailing slash) for the plugin __FILE__ passed in.
 *
 * @since 2.8.0
 *
 * @param string $file The filename of the plugin (__FILE__).
 * @return string the URL path of the directory that contains the plugin.
 */
function plugin_dir_url( $file ) {
	return trailingslashit( plugins_url( '', $file ) );
}

/**
 * Whether to force SSL used for the Administration Screens.
 *
 * @since 2.6.0
 *
 * @staticvar bool $forced
 *
 * @param string|bool $force Optional. Whether to force SSL in admin screens. Default null.
 * @return bool True if forced, false if not forced.
 */
function force_ssl_admin( $force = null ) {
	static $forced = false;

	if ( ! is_null( $force ) ) {
		$old_forced = $forced;
		$forced     = $force;
		return $old_forced;
	}

	return $forced;
}

/**
 * Determines if SSL is used.
 *
 * @since 2.6.0
 * @since 4.6.0 Moved from functions.php to load.php.
 *
 * @return bool True if SSL, otherwise false.
 */
function is_ssl() {
	if ( isset( $_SERVER['HTTPS'] ) ) {
		if ( 'on' == strtolower( $_SERVER['HTTPS'] ) ) {
			return true;
		}

		if ( '1' == $_SERVER['HTTPS'] ) {
			return true;
		}
	} elseif ( isset( $_SERVER['SERVER_PORT'] ) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
		return true;
	}
	return false;
}

/**
 * Retrieves a modified URL query string.
 *
 * You can rebuild the URL and append query variables to the URL query by using this function.
 * There are two ways to use this function; either a single key and value, or an associative array.
 *
 * Using a single key and value:
 *
 *     add_query_arg( 'key', 'value', 'http://example.com' );
 *
 * Using an associative array:
 *
 *     add_query_arg( array(
 *         'key1' => 'value1',
 *         'key2' => 'value2',
 *     ), 'http://example.com' );
 *
 * Omitting the URL from either use results in the current URL being used
 * (the value of `$_SERVER['REQUEST_URI']`).
 *
 * Values are expected to be encoded appropriately with urlencode() or rawurlencode().
 *
 * Setting any query variable's value to boolean false removes the key (see remove_query_arg()).
 *
 * Important: The return value of add_query_arg() is not escaped by default. Output should be
 * late-escaped with esc_url() or similar to help prevent vulnerability to cross-site scripting
 * (XSS) attacks.
 *
 * @since 1.5.0
 *
 * @param string|array $key   Either a query variable key, or an associative array of query variables.
 * @param string       $value Optional. Either a query variable value, or a URL to act upon.
 * @param string       $url   Optional. A URL to act upon.
 * @return string New URL query string (unescaped).
 */
function add_query_arg() {
	$args = func_get_args();
	if ( is_array( $args[0] ) ) {
		if ( count( $args ) < 2 || false === $args[1] ) {
			$uri = $_SERVER['REQUEST_URI'];
		} else {
			$uri = $args[1];
		}
	} else {
		if ( count( $args ) < 3 || false === $args[2] ) {
			$uri = $_SERVER['REQUEST_URI'];
		} else {
			$uri = $args[2];
		}
	}

	if ( $frag = strstr( $uri, '#' ) ) {
		$uri = substr( $uri, 0, -strlen( $frag ) );
	} else {
		$frag = '';
	}

	if ( 0 === stripos( $uri, 'http://' ) ) {
		$protocol = 'http://';
		$uri      = substr( $uri, 7 );
	} elseif ( 0 === stripos( $uri, 'https://' ) ) {
		$protocol = 'https://';
		$uri      = substr( $uri, 8 );
	} else {
		$protocol = '';
	}

	if ( strpos( $uri, '?' ) !== false ) {
		list( $base, $query ) = explode( '?', $uri, 2 );
		$base                .= '?';
	} elseif ( $protocol || strpos( $uri, '=' ) === false ) {
		$base  = $uri . '?';
		$query = '';
	} else {
		$base  = '';
		$query = $uri;
	}

	wp_parse_str( $query, $qs );
	$qs = urlencode_deep( $qs ); // this re-URL-encodes things that were already in the query string
	if ( is_array( $args[0] ) ) {
		foreach ( $args[0] as $k => $v ) {
			$qs[ $k ] = $v;
		}
	} else {
		$qs[ $args[0] ] = $args[1];
	}

	foreach ( $qs as $k => $v ) {
		if ( $v === false ) {
			unset( $qs[ $k ] );
		}
	}

	$ret = build_query( $qs );
	$ret = trim( $ret, '?' );
	$ret = preg_replace( '#=(&|$)#', '$1', $ret );
	$ret = $protocol . $base . $ret . $frag;
	$ret = rtrim( $ret, '?' );
	return $ret;
}

/**
 * Build URL query based on an associative and, or indexed array.
 *
 * This is a convenient function for easily building url queries. It sets the
 * separator to '&' and uses _http_build_query() function.
 *
 * @since 2.3.0
 *
 * @see _http_build_query() Used to build the query
 * @link https://secure.php.net/manual/en/function.http-build-query.php for more on what
 *       http_build_query() does.
 *
 * @param array $data URL-encode key/value pairs.
 * @return string URL-encoded string.
 */
function build_query( $data ) {
	return _http_build_query( $data, null, '&', '', false );
}

/**
 * From php.net (modified by Mark Jaquith to behave like the native PHP5 function).
 *
 * @since 3.2.0
 * @access private
 *
 * @see https://secure.php.net/manual/en/function.http-build-query.php
 *
 * @param array|object  $data       An array or object of data. Converted to array.
 * @param string        $prefix     Optional. Numeric index. If set, start parameter numbering with it.
 *                                  Default null.
 * @param string        $sep        Optional. Argument separator; defaults to 'arg_separator.output'.
 *                                  Default null.
 * @param string        $key        Optional. Used to prefix key name. Default empty.
 * @param bool          $urlencode  Optional. Whether to use urlencode() in the result. Default true.
 *
 * @return string The query string.
 */
function _http_build_query( $data, $prefix = null, $sep = null, $key = '', $urlencode = true ) {
	$ret = array();

	foreach ( (array) $data as $k => $v ) {
		if ( $urlencode ) {
			$k = urlencode( $k );
		}
		if ( is_int( $k ) && $prefix != null ) {
			$k = $prefix . $k;
		}
		if ( ! empty( $key ) ) {
			$k = $key . '%5B' . $k . '%5D';
		}
		if ( $v === null ) {
			continue;
		} elseif ( $v === false ) {
			$v = '0';
		}

		if ( is_array( $v ) || is_object( $v ) ) {
			array_push( $ret, _http_build_query( $v, '', $sep, $k, $urlencode ) );
		} elseif ( $urlencode ) {
			array_push( $ret, $k . '=' . urlencode( $v ) );
		} else {
			array_push( $ret, $k . '=' . $v );
		}
	}

	if ( null === $sep ) {
		$sep = ini_get( 'arg_separator.output' );
	}

	return implode( $sep, $ret );
}

/**
 * Retrieve a list of protocols to allow in HTML attributes.
 *
 * @since 3.3.0
 * @since 4.3.0 Added 'webcal' to the protocols array.
 * @since 4.7.0 Added 'urn' to the protocols array.
 *
 * @see wp_kses()
 * @see esc_url()
 *
 * @staticvar array $protocols
 *
 * @return string[] Array of allowed protocols. Defaults to an array containing 'http', 'https',
 *                  'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet',
 *                  'mms', 'rtsp', 'svn', 'tel', 'fax', 'xmpp', 'webcal', and 'urn'. This covers
 *                  all common link protocols, except for 'javascript' which should not be
 *                  allowed for untrusted users.
 */
function wp_allowed_protocols() {
	static $protocols = array();

	if ( empty( $protocols ) ) {
		$protocols = array( 'http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet', 'mms', 'rtsp', 'svn', 'tel', 'fax', 'xmpp', 'webcal', 'urn' );
	}

	if ( ! did_action( 'plugin_loaded' ) ) {
		/**
		 * Filters the list of protocols allowed in HTML attributes.
		 *
		 * @since 3.0.0
		 *
		 * @param array $protocols Array of allowed protocols e.g. 'http', 'ftp', 'tel', and more.
		 */
		$protocols = array_unique( (array) apply_filters( 'kses_allowed_protocols', $protocols ) );
	}

	return $protocols;
}