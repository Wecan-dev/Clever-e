<?php
	if(!class_exists("APPSDBQueryBuilder")) {
		class APPSDBQueryBuilder {
			private $select = "*";
			private $where = "";
			private $from = "";
			private $join = "";
			private $order_by = "";
			private $limit = "";
			private $qb_set = array();
			private $qb_isescape = array();
			
			/**
			 * ESCAPE character
			 *
			 * @var    string
			 */
			protected $_like_escape_chr = '!';
			
			public function Reset() {
				$this->select      = "*";
				$this->where       = "";
				$this->from        = "";
				$this->join        = "";
				$this->order_by    = "";
				$this->limit       = "";
				$this->qb_set      = array();
				$this->qb_isescape = array();
			}
			
			public function select( $select = '*', $escape = true ) {
				$this->select = $select;
			}
			
			function getSettedProperties() {
				return $this->qb_set;
			}
			
			public function where( $key, $value = NULL, $escape = true, $type = "AND" ) {
				
				if ( ! is_array( $key ) ) {
					$key = array( $key => $value );
				}
				
				foreach ( $key as $k => $v ) {
					$k = ( $escape ) ? $this->escape_key( $k ) : $k;
					if ( $v !== NULL ) {
						if ( $escape == true ) {
							$v = ' ' . $this->escape( $v );
						}
						
						if ( ! $this->_has_operator( $k ) ) {
							$k .= ' = ';
						}
					} elseif ( ! $this->_has_operator( $k ) ) {
						// value appears not to have been set, assign the test to IS NULL
						$k .= ' IS NULL';
					} elseif ( preg_match( '/\s*(!?=|<>|IS(?:\s+NOT)?)\s*$/i', $k, $match, PREG_OFFSET_CAPTURE ) ) {
						$k = substr( $k, 0, $match[0][1] ) . ( $match[1][0] === '=' ? ' IS NULL' : ' IS NOT NULL' );
					}
					
					$this->where .= ( ! empty( $this->where ) ? " $type " : "" ) . " " . $k . $v;
					
				}
				
				
			}
			
			public function set( $key, $value = '', $escape = true ) {
				$key = $this->_object_to_array( $key );
				if ( ! is_array( $key ) ) {
					$key = array( $key => $value );
				}
				foreach ( $key as $k => $v ) {
					$this->qb_set[ $this->escape_key( $k ) ]      = $v;
					$this->qb_isescape[ $this->escape_key( $k ) ] = $escape;
				}
				
				return $this;
			}
			
			public function like( $field, $match = '', $side = 'both', $escape = true ) {
				
				return $this->_like( $field, $match, 'AND ', $side, '', $escape );
			}
			
			protected function _like( $field, $match = '', $type = 'AND ', $side = 'both', $not = '', $escape = NULL ) {
				$field = ( $escape ) ? $this->escape_key( $field ) : $field;
				if ( $side === 'none' ) {
					$like_statement = "{$field} {$not} LIKE '{$match}'";
				} elseif ( $side === 'before' ) {
					$like_statement = "{$field} {$not} LIKE '%{$match}'";
				} elseif ( $side === 'after' ) {
					$like_statement = "{$field} {$not} LIKE '{$match}%'";
				} else {
					$like_statement = "{$field} {$not} LIKE '%{$match}%'";
				}
				$this->where( $like_statement, "", false );
			}
			
			public function limit( $value, $offset = 0 ) {
				$value = preg_replace( "/[^0-9]/", "", $value );
				if ( empty( $value ) ) {
					return;
				}
				if ( $offset && $offset > 0 ) {
					$this->limit = " LIMIT $offset , $value ";
				} else {
					$this->limit = " LIMIT $value ";
				}
			}
			
			public function FROM( $table ) {
				$this->from = $table;
			}
			
			public function order_by( $orderby, $direction = '', $escape = true ) {
				$orderby = ( $escape ? $this->escape_key( $orderby, " ," ) : $orderby );
				$comma   = ! empty( $this->order_by ) ? "," : "";
				if ( $direction == '' && is_string( $orderby ) ) {
					$this->order_by .= "{$comma} {$orderby}";
				} else {
					$direction = $this->escape_key( strtoupper( $direction ) );
					if ( in_array( $direction, array( "ASC", "DESC" ) ) ) {
						$this->order_by .= "{$comma} {$orderby} {$direction}";
					}
					
				}
				
			}
			
			/**
			 * Object to Array
			 *
			 * Takes an object as input and converts the class variables to array key/vals
			 *
			 * @param    object
			 *
			 * @return    array
			 */
			protected function _object_to_array( $object ) {
				if ( ! is_object( $object ) ) {
					return $object;
				}
				
				$array = array();
				foreach ( get_object_vars( $object ) as $key => $val ) {
					// There are some built in keys we need to ignore for this conversion
					if ( ! is_object( $val ) && ! is_array( $val ) ) {
						$array[ $key ] = $val;
					}
				}
				
				return $array;
			}
			
			/**
			 * Tests whether the string has an SQL operator
			 *
			 * @param    string
			 *
			 * @return    bool
			 */
			protected function _has_operator( $str ) {
				return (bool) preg_match( '/(<|>|!|=|\sIS NULL|\sIS NOT NULL|\sEXISTS|\sBETWEEN|\sLIKE|\sIN\s*\(|\s)/i', trim( $str ) );
			}
			
			
			/**
			 * "Smart" Escape String
			 *
			 * Escapes data based on type
			 * Sets boolean and null types
			 *
			 * @param    string
			 *
			 * @return    mixed
			 */
			public function escape( $str ) {
				if ( is_array( $str ) ) {
					$str = array_map( array( &$this, 'escape' ), $str );
					
					return $str;
				} elseif ( is_string( $str ) OR ( is_object( $str ) && method_exists( $str, '__toString' ) ) ) {
					return "'" . $this->escape_str( $str ) . "'";
				} elseif ( is_bool( $str ) ) {
					return ( $str === false ) ? 0 : 1;
				} elseif ( $str === NULL ) {
					return 'NULL';
				}
				
				return $str;
			}
			
			/**
			 * Escape String
			 *
			 * @param    string|string[] $str Input string
			 * @param    bool $like Whether or not the string will be used in a LIKE condition
			 *
			 * @return    string
			 */
			public function escape_str( $str ) {
				if ( is_array( $str ) ) {
					foreach ( $str as $key => $val ) {
						$str[ $key ] = $this->escape_str( $val );
					}
					
					return $str;
				}
				
				$str = $this->_escape_str( $str );
				
				return $str;
			}
			
			/**
			 * Platform-dependant string escape
			 *
			 * @param    string
			 *
			 * @return    string
			 */
			protected function _escape_str( $str ) {
				return str_replace( "'", "''", $this->remove_invisible_characters( $str ) );
			}
			
			/**
			 * Remove Invisible Characters
			 *
			 * This prevents sandwiching null characters
			 * between ascii characters, like Java\0script.
			 *
			 * @param    string
			 * @param    bool
			 *
			 * @return    string
			 */
			function remove_invisible_characters( $str, $url_encoded = true ) {
				$non_displayables = array();
				
				// every control character except newline (dec 10),
				// carriage return (dec 13) and horizontal tab (dec 09)
				if ( $url_encoded ) {
					$non_displayables[] = '/%0[0-8bcef]/';    // url encoded 00-08, 11, 12, 14, 15
					$non_displayables[] = '/%1[0-9a-f]/';    // url encoded 16-31
				}
				
				$non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';    // 00-08, 11, 12, 14-31, 127
				
				do {
					$str = preg_replace( $non_displayables, '', $str, - 1, $count );
				} while ( $count );
				
				return $str;
			}
			
			public function join( $table, $cond, $type = '', $escape = true ) {
				if ( $type !== '' ) {
					$type = strtoupper( trim( $type ) );
					
					if ( ! in_array( $type, array(
						'LEFT',
						'RIGHT',
						'OUTER',
						'INNER',
						'LEFT OUTER',
						'RIGHT OUTER'
					), true ) ) {
						$type = '';
					} else {
						$type .= ' ';
					}
				}
				$this->join .= " {$type} JOIN " . $table . " ON $cond ";
				
			}
			
			public function getSelectQuery( $table = '', $limit = NULL, $offset = NULL ) {
				if ( ! empty( $limit ) ) {
					$this->limit( $limit, $offset );
				}
				if ( ! empty( $table ) ) {
					$this->FROM( $table );
				}
				if ( ! empty( $this->where ) ) {
					$this->where = " WHERE " . $this->where;
				}
				if ( ! empty( $this->order_by ) ) {
					$this->order_by = " ORDER BY " . $this->order_by;
				}
				$this->select = rtrim( $this->select, ', ' );
				
				$query = "SELECT {$this->select} FROM {$this->from} {$this->join} {$this->where} {$this->order_by} {$this->limit}";
				$this->Reset();
				
				return $query;
			}
			
			public function getUpdateQuery( $table = '', $Nolimit = false ) {
				if ( ! $Nolimit ) {
					$this->limit( 1, 0 );
				} else {
					$this->limit = "";
				}
				if ( ! empty( $table ) ) {
					$this->FROM( $table );
				}
				if ( ! empty( $this->where ) ) {
					$this->where = " WHERE " . $this->where;
				}
				if ( ! empty( $this->order_by ) ) {
					$this->order_by = " ORDER BY " . $this->order_by;
				}
				$kevvaluestr = "";
				foreach ( $this->qb_set as $key => $value ) {
					if ( $this->qb_isescape[ $key ] ) {
						$value = $this->escape( $value );
					}
					$kevvaluestr .= "{$key}={$value},";
					
				}
				$kevvaluestr = rtrim( $kevvaluestr, ',' );
				$query       = "UPDATE {$this->from} SET {$kevvaluestr} {$this->where} {$this->limit}";
				$this->Reset();
				
				return $query;
			}
			
			public function getDeleteQuery( $table = '', $Nolimit = false ) {
				if ( ! $Nolimit ) {
					$this->limit( 1, 0 );
				} else {
					$this->limit = "";
				}
				if ( ! empty( $table ) ) {
					$this->FROM( $table );
				}
				if ( ! empty( $this->where ) ) {
					$this->where = " WHERE " . $this->where;
				}
				if ( ! empty( $this->order_by ) ) {
					$this->order_by = " ORDER BY " . $this->order_by;
				}
				$kevvaluestr = "";
				foreach ( $this->qb_set as $key => $value ) {
					if ( $this->qb_isescape[ $key ] ) {
						$value = $this->escape( $value );
					}
					$kevvaluestr .= "{$key}={$value},";
					
				}
				$kevvaluestr = rtrim( $kevvaluestr, ',' );
				$query       = "DELETE FROM {$this->from} {$this->where} {$this->limit}";
				
				$this->Reset();
				
				return $query;
			}
			
			private function escape_key( $str, $allowedchar = "" ) {
				return preg_replace( "/[^a-z0-9._{$allowedchar}]/i", "", $str );
			}
			
		}
	}