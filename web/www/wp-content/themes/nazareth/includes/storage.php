<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

// Get theme variable
if ( ! function_exists( 'nazareth_storage_get' ) ) {
	function nazareth_storage_get( $var_name, $default = '' ) {
		global $NAZARETH_STORAGE;
		return isset( $NAZARETH_STORAGE[ $var_name ] ) ? $NAZARETH_STORAGE[ $var_name ] : $default;
	}
}

// Set theme variable
if ( ! function_exists( 'nazareth_storage_set' ) ) {
	function nazareth_storage_set( $var_name, $value ) {
		global $NAZARETH_STORAGE;
		$NAZARETH_STORAGE[ $var_name ] = $value;
	}
}

// Check if theme variable is empty
if ( ! function_exists( 'nazareth_storage_empty' ) ) {
	function nazareth_storage_empty( $var_name, $key = '', $key2 = '' ) {
		global $NAZARETH_STORAGE;
		if ( ! empty( $key ) && ! empty( $key2 ) ) {
			return empty( $NAZARETH_STORAGE[ $var_name ][ $key ][ $key2 ] );
		} elseif ( ! empty( $key ) ) {
			return empty( $NAZARETH_STORAGE[ $var_name ][ $key ] );
		} else {
			return empty( $NAZARETH_STORAGE[ $var_name ] );
		}
	}
}

// Check if theme variable is set
if ( ! function_exists( 'nazareth_storage_isset' ) ) {
	function nazareth_storage_isset( $var_name, $key = '', $key2 = '' ) {
		global $NAZARETH_STORAGE;
		if ( ! empty( $key ) && ! empty( $key2 ) ) {
			return isset( $NAZARETH_STORAGE[ $var_name ][ $key ][ $key2 ] );
		} elseif ( ! empty( $key ) ) {
			return isset( $NAZARETH_STORAGE[ $var_name ][ $key ] );
		} else {
			return isset( $NAZARETH_STORAGE[ $var_name ] );
		}
	}
}

// Inc/Dec theme variable with specified value
if ( ! function_exists( 'nazareth_storage_inc' ) ) {
	function nazareth_storage_inc( $var_name, $value = 1 ) {
		global $NAZARETH_STORAGE;
		if ( empty( $NAZARETH_STORAGE[ $var_name ] ) ) {
			$NAZARETH_STORAGE[ $var_name ] = 0;
		}
		$NAZARETH_STORAGE[ $var_name ] += $value;
	}
}

// Concatenate theme variable with specified value
if ( ! function_exists( 'nazareth_storage_concat' ) ) {
	function nazareth_storage_concat( $var_name, $value ) {
		global $NAZARETH_STORAGE;
		if ( empty( $NAZARETH_STORAGE[ $var_name ] ) ) {
			$NAZARETH_STORAGE[ $var_name ] = '';
		}
		$NAZARETH_STORAGE[ $var_name ] .= $value;
	}
}

// Get array (one or two dim) element
if ( ! function_exists( 'nazareth_storage_get_array' ) ) {
	function nazareth_storage_get_array( $var_name, $key, $key2 = '', $default = '' ) {
		global $NAZARETH_STORAGE;
		if ( empty( $key2 ) ) {
			return ! empty( $var_name ) && ! empty( $key ) && isset( $NAZARETH_STORAGE[ $var_name ][ $key ] ) ? $NAZARETH_STORAGE[ $var_name ][ $key ] : $default;
		} else {
			return ! empty( $var_name ) && ! empty( $key ) && isset( $NAZARETH_STORAGE[ $var_name ][ $key ][ $key2 ] ) ? $NAZARETH_STORAGE[ $var_name ][ $key ][ $key2 ] : $default;
		}
	}
}

// Set array element
if ( ! function_exists( 'nazareth_storage_set_array' ) ) {
	function nazareth_storage_set_array( $var_name, $key, $value ) {
		global $NAZARETH_STORAGE;
		if ( ! isset( $NAZARETH_STORAGE[ $var_name ] ) ) {
			$NAZARETH_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			$NAZARETH_STORAGE[ $var_name ][] = $value;
		} else {
			$NAZARETH_STORAGE[ $var_name ][ $key ] = $value;
		}
	}
}

// Set two-dim array element
if ( ! function_exists( 'nazareth_storage_set_array2' ) ) {
	function nazareth_storage_set_array2( $var_name, $key, $key2, $value ) {
		global $NAZARETH_STORAGE;
		if ( ! isset( $NAZARETH_STORAGE[ $var_name ] ) ) {
			$NAZARETH_STORAGE[ $var_name ] = array();
		}
		if ( ! isset( $NAZARETH_STORAGE[ $var_name ][ $key ] ) ) {
			$NAZARETH_STORAGE[ $var_name ][ $key ] = array();
		}
		if ( '' === $key2 ) {
			$NAZARETH_STORAGE[ $var_name ][ $key ][] = $value;
		} else {
			$NAZARETH_STORAGE[ $var_name ][ $key ][ $key2 ] = $value;
		}
	}
}

// Merge array elements
if ( ! function_exists( 'nazareth_storage_merge_array' ) ) {
	function nazareth_storage_merge_array( $var_name, $key, $value ) {
		global $NAZARETH_STORAGE;
		if ( ! isset( $NAZARETH_STORAGE[ $var_name ] ) ) {
			$NAZARETH_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			$NAZARETH_STORAGE[ $var_name ] = array_merge( $NAZARETH_STORAGE[ $var_name ], $value );
		} else {
			$NAZARETH_STORAGE[ $var_name ][ $key ] = array_merge( $NAZARETH_STORAGE[ $var_name ][ $key ], $value );
		}
	}
}

// Add array element after the key
if ( ! function_exists( 'nazareth_storage_set_array_after' ) ) {
	function nazareth_storage_set_array_after( $var_name, $after, $key, $value = '' ) {
		global $NAZARETH_STORAGE;
		if ( ! isset( $NAZARETH_STORAGE[ $var_name ] ) ) {
			$NAZARETH_STORAGE[ $var_name ] = array();
		}
		if ( is_array( $key ) ) {
			nazareth_array_insert_after( $NAZARETH_STORAGE[ $var_name ], $after, $key );
		} else {
			nazareth_array_insert_after( $NAZARETH_STORAGE[ $var_name ], $after, array( $key => $value ) );
		}
	}
}

// Add array element before the key
if ( ! function_exists( 'nazareth_storage_set_array_before' ) ) {
	function nazareth_storage_set_array_before( $var_name, $before, $key, $value = '' ) {
		global $NAZARETH_STORAGE;
		if ( ! isset( $NAZARETH_STORAGE[ $var_name ] ) ) {
			$NAZARETH_STORAGE[ $var_name ] = array();
		}
		if ( is_array( $key ) ) {
			nazareth_array_insert_before( $NAZARETH_STORAGE[ $var_name ], $before, $key );
		} else {
			nazareth_array_insert_before( $NAZARETH_STORAGE[ $var_name ], $before, array( $key => $value ) );
		}
	}
}

// Push element into array
if ( ! function_exists( 'nazareth_storage_push_array' ) ) {
	function nazareth_storage_push_array( $var_name, $key, $value ) {
		global $NAZARETH_STORAGE;
		if ( ! isset( $NAZARETH_STORAGE[ $var_name ] ) ) {
			$NAZARETH_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			array_push( $NAZARETH_STORAGE[ $var_name ], $value );
		} else {
			if ( ! isset( $NAZARETH_STORAGE[ $var_name ][ $key ] ) ) {
				$NAZARETH_STORAGE[ $var_name ][ $key ] = array();
			}
			array_push( $NAZARETH_STORAGE[ $var_name ][ $key ], $value );
		}
	}
}

// Pop element from array
if ( ! function_exists( 'nazareth_storage_pop_array' ) ) {
	function nazareth_storage_pop_array( $var_name, $key = '', $defa = '' ) {
		global $NAZARETH_STORAGE;
		$rez = $defa;
		if ( '' === $key ) {
			if ( isset( $NAZARETH_STORAGE[ $var_name ] ) && is_array( $NAZARETH_STORAGE[ $var_name ] ) && count( $NAZARETH_STORAGE[ $var_name ] ) > 0 ) {
				$rez = array_pop( $NAZARETH_STORAGE[ $var_name ] );
			}
		} else {
			if ( isset( $NAZARETH_STORAGE[ $var_name ][ $key ] ) && is_array( $NAZARETH_STORAGE[ $var_name ][ $key ] ) && count( $NAZARETH_STORAGE[ $var_name ][ $key ] ) > 0 ) {
				$rez = array_pop( $NAZARETH_STORAGE[ $var_name ][ $key ] );
			}
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if ( ! function_exists( 'nazareth_storage_inc_array' ) ) {
	function nazareth_storage_inc_array( $var_name, $key, $value = 1 ) {
		global $NAZARETH_STORAGE;
		if ( ! isset( $NAZARETH_STORAGE[ $var_name ] ) ) {
			$NAZARETH_STORAGE[ $var_name ] = array();
		}
		if ( empty( $NAZARETH_STORAGE[ $var_name ][ $key ] ) ) {
			$NAZARETH_STORAGE[ $var_name ][ $key ] = 0;
		}
		$NAZARETH_STORAGE[ $var_name ][ $key ] += $value;
	}
}

// Concatenate array element with specified value
if ( ! function_exists( 'nazareth_storage_concat_array' ) ) {
	function nazareth_storage_concat_array( $var_name, $key, $value ) {
		global $NAZARETH_STORAGE;
		if ( ! isset( $NAZARETH_STORAGE[ $var_name ] ) ) {
			$NAZARETH_STORAGE[ $var_name ] = array();
		}
		if ( empty( $NAZARETH_STORAGE[ $var_name ][ $key ] ) ) {
			$NAZARETH_STORAGE[ $var_name ][ $key ] = '';
		}
		$NAZARETH_STORAGE[ $var_name ][ $key ] .= $value;
	}
}

// Call object's method
if ( ! function_exists( 'nazareth_storage_call_obj_method' ) ) {
	function nazareth_storage_call_obj_method( $var_name, $method, $param = null ) {
		global $NAZARETH_STORAGE;
		if ( null === $param ) {
			return ! empty( $var_name ) && ! empty( $method ) && isset( $NAZARETH_STORAGE[ $var_name ] ) ? $NAZARETH_STORAGE[ $var_name ]->$method() : '';
		} else {
			return ! empty( $var_name ) && ! empty( $method ) && isset( $NAZARETH_STORAGE[ $var_name ] ) ? $NAZARETH_STORAGE[ $var_name ]->$method( $param ) : '';
		}
	}
}

// Get object's property
if ( ! function_exists( 'nazareth_storage_get_obj_property' ) ) {
	function nazareth_storage_get_obj_property( $var_name, $prop, $default = '' ) {
		global $NAZARETH_STORAGE;
		return ! empty( $var_name ) && ! empty( $prop ) && isset( $NAZARETH_STORAGE[ $var_name ]->$prop ) ? $NAZARETH_STORAGE[ $var_name ]->$prop : $default;
	}
}
