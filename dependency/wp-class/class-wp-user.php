<?php
use Models\Users;
/**
 * User API: WP_User class
 *
 * @package WordPress
 * @subpackage Users
 * @since 4.4.0
 * customize by isal.c
 */

/**
 * Core class used to implement the WP_User object.
 *
 * @since 2.0.0
 *
 * @property string $user_email
 * @property string $user_password
 * @property string $user_status
 * @property string $user_verivied
 * @property int    $user_level
 * @property string $display_name
 * @property string $spam
 * @property string $deleted
 * @property string $locale
 * @property string $rich_editing
 * @property string $syntax_highlighting
 */
class WP_User {
	/**
	 * User data container.
	 *
	 * @since 2.0.0
	 * @var object
	 */
	public $data;

	/**
	 * The user's ID.
	 *
	 * @since 2.1.0
	 * @var int
	 */
	public $ID = 0;

	/**
	 * The roles the user is part of.
	 *
	 * @since 2.0.0
	 * @var array
	 */
	public $roles = array();

	/**
	 * The filter context applied to user data fields.
	 *
	 * @since 2.9.0
	 * @var string
	 */
	public $filter = null;

	/**
	 * Constructor.
	 *
	 * Retrieves the userdata and passes it to WP_User::init().
	 *
	 * @since 2.0.0
	 *
	 * @param int|string|stdClass|WP_User $id User's ID, a WP_User object, or a user object from the DB.
	 * @param string $name Optional. User's username
	 */
	public function __construct( $id = 0, $name = '' ) {
		$user = Users::where( 'id', $id )->get()->toArray();
		$user = ! empty( $user ) ? current( $user ) : $user;
		$this->init( (object) $user );
	}

	/**
	 * Sets up object properties, including capabilities.
	 *
	 * @since  3.3.0
	 *
	 * @param object $data    User DB row object.
	 * @param int    $site_id Optional. The site ID to initialize for.
	 */
	public function init( $data ) {
		$this->data = $data;
		$this->ID   = (int) isset( $data->id ) ? $data->id : 0;
	}

	/**
	 * Magic method for accessing custom fields.
	 *
	 * @since 3.3.0
	 *
	 * @param string $key User meta key to retrieve.
	 * @return mixed Value of the given user meta key (if set). If `$key` is 'id', the user ID.
	 */
	public function __get( $key ) {
		if ( isset( $this->data->$key ) ) {
			$value = $this->data->$key;
		}
		return isset($value) ? $value : null;
	}


	/**
	 * Magic method for setting custom user fields.
	 *
	 * This method does not update custom fields in the database. It only stores
	 * the value on the WP_User instance.
	 *
	 * @since 3.3.0
	 *
	 * @param string $key   User meta key.
	 * @param mixed  $value User meta value.
	 */
	public function __set( $key, $value ) {
		$this->data->$key = $value;
	}

	/**
	 * Magic method for unsetting a certain custom field.
	 *
	 * @since 4.4.0
	 *
	 * @param string $key User meta key to unset.
	 */
	public function __unset( $key ) {
		if ( isset( $this->data->$key ) ) {
			unset( $this->data->$key );
		}
	}

	/**
	 * Makes private/protected methods readable for backward compatibility.
	 *
	 * @since 4.3.0
	 *
	 * @param string   $name      Method to call.
	 * @param array    $arguments Arguments to pass when calling.
	 * @return mixed|false Return value of the callback, false otherwise.
	 */
	public function __call( $name, $arguments ) {
		if ( '_init_caps' === $name ) {
			return call_user_func_array( array( $this, $name ), $arguments );
		}
		return false;
	}

	/**
	 * Determine whether a property or meta key is set
	 *
	 * Consults the users and usermeta tables.
	 *
	 * @since 3.3.0
	 *
	 * @param string $key Property
	 * @return bool
	 */
	public function has_prop( $key ) {
		return $this->__isset( $key );
	}

	/**
	 * Determine whether the user exists in the database.
	 *
	 * @since 3.4.0
	 *
	 * @return bool True if user exists in the database, false if not.
	 */
	public function exists() {
		return ! empty( $this->ID );
	}

	/**
	 * Retrieve the value of a property or meta key.
	 *
	 * Retrieves from the users and usermeta table.
	 *
	 * @since 3.3.0
	 *
	 * @param string $key Property
	 * @return mixed
	 */
	public function get( $key ) {
		return $this->__get( $key );
	}

	/**
	 * Return an array representation.
	 *
	 * @since 3.5.0
	 *
	 * @return array Array representation.
	 */
	public function to_array() {
		return get_object_vars( $this->data );
	}

	/**
	 * Retrieves all of the capabilities of the roles of the user, and merges them with individual user capabilities.
	 *
	 * All of the capabilities of the roles of the user are merged with the user's individual capabilities. This means
	 * that the user can be denied specific capabilities that their role might have, but the user is specifically denied.
	 *
	 * @since 2.0.0
	 *
	 * @return bool[] Array of key/value pairs where keys represent a capability name and boolean values
	 *                represent whether the user has that capability.
	 */
	public function get_role_caps() {

	}

	/**
	 * Remove role from user.
	 *
	 * @since 2.0.0
	 *
	 * @param string $role Role name.
	 */
	public function remove_role( $role ) {

	}

	/**
	 * Set the role of the user.
	 *
	 * This will remove the previous roles of the user and assign the user the
	 * new one. You can set the role to an empty string and it will remove all
	 * of the roles from the user.
	 *
	 * @since 2.0.0
	 *
	 * @param string $role Role name.
	 */
	public function set_role( $role ) {

	}

	public function has_cap( $cap ) {
		return true;
	}
}
