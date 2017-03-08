<?php
define( 'OBJECT', 'OBJECT' );
define( 'object', 'OBJECT' ); // Back compat.
define( 'OBJECT_K', 'OBJECT_K' );
define( 'ARRAY_A', 'ARRAY_A' );
define( 'ARRAY_N', 'ARRAY_N' );
class db{
	public $prefix = '';
	public $last_error = '';
	public $num_queries = 0;
	public $num_rows = 0;
	public $func_call = '';
	var $rows_affected = 0;
	public $insert_id = 0;
	var $last_query;
	var $last_result;
	protected $result;
	protected $dbuser;
	protected $dbpassword;
	protected $dbname;
	protected $dbhost;
	protected $dbh;
	public function __construct( $dbuser, $dbpassword, $dbname, $dbhost ) {
		$this->prefix = 'tbl_';
		$this->dbuser = $dbuser;
		$this->dbpassword = $dbpassword;
		$this->dbname = $dbname;
		$this->dbhost = $dbhost;
		if($this->db_connect()){
			if( !$this->check_connection()){
				$this->print_error();
				return false;
			}
		}else{
			die("Database connection failed: " . mysqli_connect_error());
			return false;
		}
	}
	public function __destruct() {
		return true;
	}
	public function print_error( $str = '' ) {
		$str = mysqli_error( $this->dbh );
		$str   = htmlspecialchars( $str, ENT_QUOTES );
		$query = htmlspecialchars( $this->last_query, ENT_QUOTES );
		printf(
			'<div id="error"><p class="wpdberror"><strong>%s</strong> [%s]<br /><code>%s</code></p></div>',
			__( 'database error:' ),
			$str,
			$query
		);
	}
	public function db_connect() {
		if($this->dbh = mysqli_connect( $this->dbhost, $this->dbuser, $this->dbpassword,$this->dbname)){		
			return true;	
		}
		return false;
	}
	public function check_connection() {
		if ( @mysqli_ping( $this->dbh ) ) {
			return true;
		}
		return false;
	}
	public function query( $query ) {
		$this->_do_query( $query );
		
		$this->last_error = mysqli_error( $this->dbh );
		if ( $this->last_error ) {
			$this->insert_id = 0;
			return false;
		}

		if ( preg_match( '/^\s*(create|alter|truncate|drop)\s/i', $query ) ) {
			$return_val = $this->result;
			
		} elseif ( preg_match( '/^\s*(insert|delete|update|replace)\s/i', $query ) ) {
			$this->rows_affected = mysqli_affected_rows( $this->dbh );
			// Take note of the insert_id
			if ( preg_match( '/^\s*(insert|replace)\s/i', $query ) ) {
				$this->insert_id = mysqli_insert_id( $this->dbh );
			}
			// Return number of rows affected
			$return_val = $this->rows_affected;
			
		} else {
			$this->last_result = array();
			$num_rows = 0;
			while ( $row = @mysqli_fetch_object( $this->result ) ) {
				$this->last_result[$num_rows] = $row;
				$num_rows++;
			}
			// Log number of rows the query returned
			// and return number of rows selected
			$this->num_rows = $num_rows;
			$return_val     = $num_rows;
		}
		return $return_val;
	}
	private function _do_query( $query ) {
		$this->last_query = $query;	
		$this->result = @mysqli_query( $this->dbh, $query );
		$this->num_queries++;
	}
	function _weak_escape( $string ) {
		if ( func_num_args() === 1 && function_exists( '_deprecated_function' ) )
			_deprecated_function( __METHOD__, '3.6', 'wpdb::prepare() or esc_sql()' );
		return addslashes( $string );
	}
	function _real_escape( $string ) {
		return mysqli_real_escape_string( $this->dbh, $string );		
		return addslashes( $string );
	}
	function _escape( $data ) {
		if ( is_array( $data ) ) {
			foreach ( $data as $k => $v ) {
				if ( is_array($v) )
					$data[$k] = $this->_escape( $v );
				else
					$data[$k] = $this->_real_escape( $v );
			}
		} else {
			$data = $this->_real_escape( $data );
		}

		return $data;
	}
	public function escape( $data ) {
		if ( func_num_args() === 1 && function_exists( '_deprecated_function' ) )
			_deprecated_function( __METHOD__, '3.6', 'wpdb::prepare() or esc_sql()' );
		if ( is_array( $data ) ) {
			foreach ( $data as $k => $v ) {
				if ( is_array( $v ) )
					$data[$k] = $this->escape( $v, 'recursive' );
				else
					$data[$k] = $this->_weak_escape( $v, 'internal' );
			}
		} else {
			$data = $this->_weak_escape( $data, 'internal' );
		}

		return $data;
	}
	public function escape_by_ref( &$string ) {
		if ( ! is_float( $string ) )
			$string = $this->_real_escape( $string );
	}
	public function insert( $table, $data, $format = null ) {
		return $this->_insert_replace_helper( $table, $data, $format, 'INSERT' );
	}
	public function replace( $table, $data, $format = null ) {
		return $this->_insert_replace_helper( $table, $data, $format, 'REPLACE' );
	}
	function _insert_replace_helper( $table, $data, $format = null, $type = 'INSERT' ) {
		$this->insert_id = 0;
		if ( ! in_array( strtoupper( $type ), array( 'REPLACE', 'INSERT' ) ) ) {
			return false;
		}
		$fields = $values = array();
		foreach ( $data as $field => $value ) {
			$fields[] = $field;
			$values[]  = maybe_serialize($value);
		}
		$fields  = '`' . implode( '`, `', $fields ) . '`';
		$values = '\'' . implode( '\', \'', $values ) .'\'';
		$sql = "$type INTO `$table` ($fields) VALUES ($values)";
		$this->check_current_query = false;
		return $this->query($sql);
	}
	public function update( $table, $data, $where, $format = null, $where_format = null ) {
		if ( ! is_array( $data ) || ! is_array( $where ) ) {
			return false;
		}

		$fields = $conditions = $values = array();
		foreach ( $data as $field => $value ) {
			if ( is_null( $value ) ) {
				$fields[] = "`$field` = NULL";
				continue;
			}
			$fields[] = "`$field` = '". maybe_serialize($value) ."' ";
		}
		foreach ( $where as $field => $value ) {
			if ( is_null( $value ) ) {
				$conditions[] = "`$field` IS NULL";
				continue;
			}
			$conditions[] = "`$field` = '". maybe_serialize($value) ."' ";
		}

		$fields = implode( ', ', $fields );
		$conditions = implode( ' AND ', $conditions );
		$sql = "UPDATE `$table` SET $fields WHERE $conditions";
		$this->check_current_query = false;
		return $this->query($sql);
	}
	public function delete( $table, $where, $where_format = null ) {
		
		if($table == null || $table == '')
			return false;
			
		if ( ! is_array( $where ) ) {
			return false;
		}

		$conditions = $values = array();

		foreach ( $where as $field => $value ) {
			if ( is_null( $value ) ) {
				$conditions[] = "`$field` IS NULL";
				continue;
			}

			$conditions[] = "`$field` = '". maybe_serialize($value) ."' ";
		}
		$conditions = implode( ' AND ', $conditions );
		$sql = "DELETE FROM `$table` WHERE $conditions";
		return $this->query($sql);
	}
	public function get_var( $query = null, $x = 0, $y = 0 ) {
		$this->func_call = "\$db->get_var(\"$query\", $x, $y)";
		if ( $query ) {
			$this->query( $query );
		}
		// Extract var out of cached results based x,y vals
		if ( !empty( $this->last_result[$y] ) ) {
			$values = array_values( get_object_vars( $this->last_result[$y] ) );
		}
		// If there is a value return it else return null
		return ( isset( $values[$x] ) && $values[$x] !== '' ) ? $values[$x] : null;
	}
	public function get_row( $query = null, $output = OBJECT, $y = 0 ) {
		$this->func_call = "\$db->get_row(\"$query\",$output,$y)";

		if ( $query ) {
			$this->query( $query );
		} else {
			return null;
		}
		
		if ( !isset( $this->last_result[$y] ) )
			return null;
		
		if ( $output == OBJECT ) {
			return $this->last_result[$y] ? $this->last_result[$y] : null;
		} elseif ( $output == ARRAY_A ) {
			return $this->last_result[$y] ? get_object_vars( $this->last_result[$y] ) : null;
		} elseif ( $output == ARRAY_N ) {
			return $this->last_result[$y] ? array_values( get_object_vars( $this->last_result[$y] ) ) : null;
		} elseif ( strtoupper( $output ) === OBJECT ) {
			// Back compat for OBJECT being previously case insensitive.
			return $this->last_result[$y] ? $this->last_result[$y] : null;
		} else {
			$this->print_error();
		}
	}
	public function get_col( $query = null , $x = 0 ) {		
		if ( $query ) {
			$this->query( $query );
		} else {
			return null;
		}
		
		$new_array = array();
		// Extract the column values
		for ( $i = 0, $j = count( $this->last_result ); $i < $j; $i++ ) {
			$new_array[$i] = $this->get_var( null, $x, $i );
		}
		return $new_array;
	}
	public function get_results( $query = null, $output = OBJECT ) {
		$this->func_call = "\$db->get_results(\"$query\", $output)";
		if ( $query ) {
			$this->query( $query );
		} else {
			return null;
		}

		$new_array = array();
		if ( $output == OBJECT ) {
			// Return an integer-keyed array of row objects
			return $this->last_result;
		} elseif ( $output == OBJECT_K ) {
			// Return an array of row objects with keys from column 1
			// (Duplicates are discarded)
			foreach ( $this->last_result as $row ) {
				$var_by_ref = get_object_vars( $row );
				$key = array_shift( $var_by_ref );
				if ( ! isset( $new_array[ $key ] ) )
					$new_array[ $key ] = $row;
			}
			return $new_array;
		} elseif ( $output == ARRAY_A || $output == ARRAY_N ) {
			// Return an integer-keyed array of...
			if ( $this->last_result ) {
				foreach ( (array) $this->last_result as $row ) {
					if ( $output == ARRAY_N ) {
						// ...integer-keyed row arrays
						$new_array[] = array_values( get_object_vars( $row ) );
					} else {
						// ...column name-keyed row arrays
						$new_array[] = get_object_vars( $row );
					}
				}
			}
			return $new_array;
		} elseif ( strtoupper( $output ) === OBJECT ) {
			// Back compat for OBJECT being previously case insensitive.
			return $this->last_result;
		}
		return null;
	}
}
