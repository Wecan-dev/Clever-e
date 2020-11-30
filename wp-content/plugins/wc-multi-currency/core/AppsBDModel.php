<?php
APBD_LoadCore('APPSBDQueryBuilder');
	if(!class_exists("AppsBDModel")) {
		class AppsBDModel {
			protected $validations;
			protected $setProperties;
			protected $likesFields;
			protected $setOption;
			protected $updateWhereExtraField;
			protected $updateWhereExtraFieldOption = array();
			protected $tableName;
			protected $tableShortForm = "";
			protected $primaryKey;
			protected $uniqueKey;
			protected $multiKey;
			protected $autoIncField;
			protected $MySqlError;
			public $settedPropertyforLog = "";
			protected $htmlInputField = array();
			protected $isWhereSet = false;
			protected $isValidationRule = false;
			private static $quries = array();
			private $group_by = NULL;
			private $avoidCustomCheck = false;
			protected $checkCache = false;
			protected $cacheTime = 300; //5 minitue
			protected $kernelObject = NULL;
			protected $app_base_name = "";
			/**
			 * @var ObjectJoin[];
			 */
			protected $joinObjects = array();
			/**
			 * @var wpdb
			 */
			protected $db;
			/**
			 * @var APPSDBQueryBuilder
			 */
			private $queryBuilder;
			
			
			function __construct() {
				global $wpdb;
				$this->db =& $wpdb;
				
				$this->queryBuilder                = new APPSDBQueryBuilder();
				$this->tableShortForm              = "";
				$this->setProperties               = array();
				$this->setOption                   = array();
				$this->updateWhereExtraField       = array();
				$this->updateWhereExtraFieldOption = array();
				$this->uniqueKey                   = array();
				$this->multiKey                    = array();
				$this->autoIncField                = array();
				$this->likesFields                 = array();
			}
			
			function _e( $string, $parameter = NULL, $_ = NULL ) {
				$args = func_get_args();
				echo call_user_func_array( [ $this, "__" ], $args );
			}
			
			function settedPropertyforLog() {
				return $this->settedPropertyforLog;
			}
			
			function _ee( $string, $parameter = NULL, $_ = NULL ) {
				$args = func_get_args();
				foreach ( $args as &$arg ) {
					if ( is_string( $arg ) ) {
						$arg = $this->__( $arg );
					}
				}
				echo call_user_func_array( [ $this, "__" ], $args );
			}
			
			function ___( $string, $parameter = NULL, $_ = NULL ) {
				$args = func_get_args();
				foreach ( $args as &$arg ) {
					if ( is_string( $arg ) ) {
						$arg = $this->__( $arg );
					}
				}
				
				return call_user_func_array( [ $this, "__" ], $args );
			}
			
			function __( $string, $parameter = NULL, $_ = NULL ) {
				$args    = func_get_args();
				$args[0] = APBD_Lan__( $args[0], $this->app_base_name );
				if ( count( $args ) > 1 ) {
					$msg = call_user_func_array( "sprintf", $args );
				} else {
					$msg = $args[0];
				}
				
				return $msg;
			}
			
			function CheckCache( $setValue = true, $cacheTime = 0 ) {
				/*$is_cache=$this->config->item("custom_cache");
		if($is_cache){
			$this->checkCache=$setValue;
			if($cacheTime>0){
				$this->cacheTime=60*$cacheTime;
			}
		}
		//not supported by wp*/
			}
			
			function getTextByKey( $property, $isTag = true, $key = NULL ) {
				if ( $isTag ) {
					$data = $this->GetPropertyOptionsTag( $property );
				} else {
					$data = $this->GetPropertyOptions( $property );
				}
				if ( ! empty( $key ) || property_exists( $this, $property ) ) {
					if ( empty( $key ) ) {
						$key = $this->$property;
					}
					
					return ! empty( $data[ $key ] ) ? $data[ $key ] : $key;
				} else {
					return "Undefined Property";
				}
			}
			
			function AddWarning( $message, $parameter = NULL, $_ = NULL ) {
				$args    = func_get_args();
				$message = call_user_func_array( [ $this, "___" ], $args );
				APBD_AddWarning( $message );
			}
			
			function AddError( $message, $parameter = NULL, $_ = NULL ) {
				$args    = func_get_args();
				$message = call_user_func_array( [ $this, "___" ], $args );
				APBD_AddError( $message );
			}
			
			function AddInfo( $message, $parameter = NULL, $_ = NULL ) {
				$args    = func_get_args();
				$message = call_user_func_array( [ $this, "__" ], $args );
				APBD_AddInfo( $message );
			}
			
			static function GetTotalQueriesForLog() {
				$response = "";
				if ( ! empty( self::$quries ) ) {
					foreach ( self::$quries as $qur ) {
						$qur      = str_replace( "\n", "", $qur );
						$response .= ( $qur ) . ";\n";
					}
				}
				
				return $response;
			}
			
			static function GetTotalQueriesCountStr() {
				$total = count( self::$quries );
				
				return "Total quries(s) = $total";
			}
			
			function setTableShortName( $name ) {
				$this->tableShortForm = $name;
			}
			
			static function CreateDBTable() {
				return;
			}
			
			function DropDBTable() {
				return;
			}
			
			/**
			 * check the table name and othething
			 * @return boolean
			 */
			protected function CheckBasicCheck() {
				if ( empty ( $this->tableName ) ) {
					APBD_add_model_errors_code( "E002" );
					
					return false;
				}
				
				return true;
			}
			
			protected function doFieldValueFilter( $name, &$postvalue, $isXsClean ) {
			
			}
			
			function GetPostValue( $name, $default = "", $isXsClean = true ) {
				
				$objdata = $this->$name;
				if ( ! empty ( $this->$name ) || ( is_string( $objdata ) && $objdata . "_-A" === "0_-A" ) ) {
					$default = $this->$name;
				}
				$postvalue = ! empty( $_POST[ $name ] ) ? sanitize_text_field($_POST[ $name ]): $default;
				$this->doFieldValueFilter( $name, $postvalue, $isXsClean );
				
				return ! empty( $postvalue ) ? $postvalue : $default;
			}
			
			function insert_id() {
				return $this->db->insert_id;
			}
			
			function getDBError() {
				return $this->db->last_error;
			}
			
			protected function SetCustomModelWhereProperties() {
				return;
			}
			
			function AddGroupBy( $key ) {
				$this->group_by = $key;
			}
			
			function AddLike( $likefld, $likeValue, $likeside = "both" ) {
				if ( property_exists( $this, $likefld ) ) {
					$std                 = new stdClass();
					$std->field          = $likefld;
					$std->value          = $likeValue;
					$std->likeside       = $likeside;
					$this->likesFields[] = $std;
				}
			}
			
			function AvoidCustomModelWhereProperties( $isAvoid = true ) {
				$this->avoidCustomCheck = $isAvoid;
			}
			
			public function GetPropertyRawOptions( $property, $isWithSelect = false ) {
				if ( $isWithSelect ) {
					return array( "" => "Select" );
				}
				
				return array();
			}
			
			public function GetPropertyOptions( $property, $isWithSelect = false ) {
				$returnobj = $this->GetPropertyRawOptions( $property, $isWithSelect );
				foreach ( $returnobj as &$v ) {
					$v = $this->__( $v );
				}
				
				return $returnobj;
			}
			
			public function GetPropertyOptionsIcon( $property ) {
				
				return array();
			}
			
			public function GetPropertyOptionsColor( $property ) {
				
				return array();
			}
			
			public function GetPropertyOptionsTag( $property, $tag = 'span', $class_prefix = 'text-', $class_postfix = '', $default = '' ) {
				$properties = $this->GetPropertyOptions( $property );
				if ( count( $properties ) > 0 ) {
					$colors = $this->GetPropertyOptionsColor( $property );
					$icons  = $this->GetPropertyOptionsIcon( $property );
					foreach ( $properties as $key => &$value ) {
						$color = ! empty( $colors[ $key ] ) ? $colors[ $key ] : $default;
						$icon  = ! empty( $icons[ $key ] ) ? '<i class="' . $icons[ $key ] . '"></i>' : "";
						$value = "<{$tag} class=\"{$class_prefix}{$color}{$class_postfix}\">{$icon} {$value}</{$tag}>";
					}
				}
				
				return $properties;
			}
			
			public function SetDBJoinWhereCondition( $db, $clear_properties = true, $isSelectDb = true ) {
				$this->SetDBSelectWhereProperties( [], $clear_properties, $isSelectDb, $db );
			}
			
			/**
			 * @param unknown $extraParam
			 * @param string $isSelectDb
			 *
			 * @return boolean
			 */
			protected function SetDBSelectWhereProperties( $extraParam = array(), $clear_properties = true, $isSelectDb = true, $db = NULL ) {
				if ( ! $this->avoidCustomCheck ) {
					$this->SetCustomModelWhereProperties();
				}
				$alreadyadded = array();
				$tbname       = $this->GetTableName() . ".";
				$this->setCustomParamData();
				if ( empty( $db ) ) {
					if ( $isSelectDb ) {
						$db = $this->GetSelectDB();
					} else {
						$db = $this->GetUpdateDB();
					}
				}
				if ( empty ( $this->tableName ) ) {
					return false;
				}
				
				//primary key query
				$primaryKey = $this->primaryKey;
				if ( ! empty( $primaryKey ) && isset( $this->setProperties[ $primaryKey ] ) ) {
					if ( ! empty ( $this->setOption [ $primaryKey ] ) ) {
						$db->where( "(" . $tbname . $primaryKey . " " . $this->$primaryKey . ")", "", false );
					} else {
						$db->where( $tbname . $primaryKey, $this->$primaryKey );
					}
					$alreadyadded[]   = $primaryKey;
					$this->isWhereSet = true;
				}
				$generalKeys = array();
				// Unique Index key query
				if ( count( $this->uniqueKey ) > 0 ) {
					if ( is_array( $this->uniqueKey[0] ) ) {
						$selectedKey = "";
						foreach ( $this->uniqueKey as $pos => $uk ) {
							$generalKeys = array_merge( $generalKeys, $uk );
							$isOk        = true;
							foreach ( $uk as $fld ) {
								if ( ! isset( $this->setProperties[ $fld ] ) ) {
									$isOk = false;
									break;
								}
								
							}
							if ( $isOk ) {
								$selectedKey = $pos;
							}
						}
						if ( $selectedKey != "" ) {
							foreach ( $this->uniqueKey[ $selectedKey ] as $uk ) {
								if ( ! in_array( $uk, $alreadyadded ) && isset( $this->setProperties[ $uk ] ) ) {
									if ( ! empty ( $this->setOption [ $uk ] ) ) {
										$db->where( "(" . $tbname . $uk . " " . $this->$uk . ")", "", false );
									} else {
										$db->where( $tbname . $uk, $this->$uk );
									}
									$alreadyadded[]   = $uk;
									$this->isWhereSet = true;
								}
							}
						}
					} else {
						//for backword compatibility
						foreach ( $this->uniqueKey as $uk ) {
							if ( ! in_array( $uk, $alreadyadded ) && isset( $this->setProperties[ $uk ] ) ) {
								if ( ! empty ( $this->setOption [ $uk ] ) ) {
									$db->where( "(" . $tbname . $uk . " " . $this->$uk . ")", "", false );
								} else {
									$db->where( $tbname . $uk, $this->$uk );
								}
								$alreadyadded[]   = $uk;
								$this->isWhereSet = true;
							}
						}
					}
				}
				
				// Other's key query
				if ( count( $this->multiKey ) > 0 ) {
					if ( is_array( $this->multiKey[0] ) ) {
						$selectedKey = "";
						foreach ( $this->multiKey as $pos => $uk ) {
							$generalKeys = array_merge( $generalKeys, $uk );
							$isOk        = true;
							foreach ( $uk as $fld ) {
								if ( ! isset( $this->setProperties[ $fld ] ) ) {
									$isOk = false;
									break;
								}
								
							}
							if ( $isOk ) {
								$selectedKey = $pos;
							}
						}
						if ( $selectedKey != "" ) {
							foreach ( $this->multiKey[ $selectedKey ] as $uk ) {
								if ( ! in_array( $uk, $alreadyadded ) && isset( $this->setProperties[ $uk ] ) ) {
									if ( ! empty ( $this->setOption [ $uk ] ) ) {
										$db->where( "(" . $tbname . $uk . $this->setProperties[ $uk ] . ")", "", false );
									} else {
										$db->where( $tbname . $uk, $this->setProperties[ $uk ] );
									}
									$alreadyadded[]   = $uk;
									$this->isWhereSet = true;
								}
							}
						}
					} else {
						//for backword compatibility
						foreach ( $this->multiKey as $uk ) {
							if ( ! in_array( $uk, $alreadyadded ) && isset( $this->setProperties[ $uk ] ) ) {
								if ( ! empty ( $this->setOption [ $uk ] ) ) {
									$db->where( "(" . $tbname . $uk . $this->setProperties[ $uk ] . ")", "", false );
								} else {
									$db->where( $tbname . $uk, $this->setProperties[ $uk ] );
								}
								$alreadyadded[]   = $uk;
								$this->isWhereSet = true;
							}
						}
					}
				}
				
				//for GeneralKeys
				foreach ( $generalKeys as $uk ) {
					if ( ! in_array( $uk, $alreadyadded ) ) {
						if ( isset( $this->setProperties[ $uk ] ) ) {
							if ( ! empty ( $this->setOption [ $uk ] ) ) {
								$db->where( "(" . $tbname . $uk . " " . $this->$uk . ")", "", false );
							} else {
								$db->where( $tbname . $uk, $this->$uk );
							}
							$alreadyadded[]   = $uk;
							$this->isWhereSet = true;
						}
					}
				}
				
				foreach ( $this->setProperties as $key => $value ) {
					if ( property_exists( $this, $key ) && ! in_array( $key, $alreadyadded ) ) {
						if ( ! empty ( $this->setOption [ $key ] ) ) {
							$db->where( "(" . $tbname . $key . " " . $this->$key . ")", "", false );
						} else {
							$db->where( $tbname . $key, $this->$key );
						}
						$alreadyadded[] = $key;
					}
				}
				if ( is_array( $extraParam ) ) {
					foreach ( $extraParam as $key => $value ) {
						if ( property_exists( $this, $key ) && ! in_array( $key, $alreadyadded ) ) {
							if ( ! empty ( $this->setOption [ $key ] ) ) {
								$db->where( "(" . $tbname . $key . " " . $value . ")", "", false );
							} else {
								$db->where( $tbname . $key, $value );
							}
							$alreadyadded[] = $key;
						}
					}
				}
				//like properties
				if ( count( $this->likesFields ) > 0 ) {
					foreach ( $this->likesFields as $likefld ) {
						$db->like( $likefld->field, $likefld->value, $likefld->likeside );
					}
				}
				if ( ! empty( $this->group_by ) ) {
					$db->group_by( $this->group_by );
				}
				if ( $clear_properties ) {
					$this->ResetSetForInsetUpdate();
				}
				
				return true;
			}
			
			
			/**
			 * @param CI_DB_query_builder $dbobj
			 * @param unknown $extraParam
			 * @param string $clear_properties
			 *
			 * @return boolean
			 */
			function SetDBSelectJoinProperties( $db, $extraParam = array(), $clear_properties = true ) {
				$alreadyadded = array();
				$tbname       = $this->GetTableName() . ".";
				
				if ( empty ( $this->tableName ) ) {
					return false;
				}
				
				//primary key query
				$primaryKey = $this->primaryKey;
				if ( ! empty( $primaryKey ) && isset( $this->setProperties[ $primaryKey ] ) ) {
					if ( ! empty ( $this->setOption [ $primaryKey ] ) ) {
						$db->where( $tbname . $primaryKey . $this->$primaryKey, "", false );
					} else {
						$db->where( $tbname . $primaryKey, $this->$primaryKey );
					}
					$alreadyadded[]   = $primaryKey;
					$this->isWhereSet = true;
				}
				
				// Other's key query
				foreach ( $this->uniqueKey as $fk ) {
					foreach ( $fk as $uk ) {
						if ( isset( $this->setProperties[ $uk ] ) ) {
							if ( ! empty ( $this->setOption [ $uk ] ) ) {
								$db->where( $tbname . $uk . $this->$uk, "", false );
							} else {
								$db->where( $tbname . $uk, $this->$uk );
							}
							$alreadyadded[]   = $uk;
							$this->isWhereSet = true;
						}
					}
				}
				// Other's key query
				foreach ( $this->multiKey as $uk ) {
					if ( isset( $this->setProperties[ $uk ] ) ) {
						if ( ! empty ( $this->setOption [ $uk ] ) ) {
							$db->where( $tbname . $uk . $this->setProperties[ $uk ], "", false );
						} else {
							$db->where( $tbname . $uk, $this->setProperties[ $uk ] );
						}
						$alreadyadded[]   = $uk;
						$this->isWhereSet = true;
					}
				}
				foreach ( $this->setProperties as $key => $value ) {
					if ( property_exists( $this, $key ) && ! in_array( $key, $alreadyadded ) ) {
						if ( ! empty ( $this->setOption [ $key ] ) ) {
							$db->where( $tbname . $key . $this->$key, "", false );
						} else {
							$db->where( $tbname . $key, $this->$key );
						}
						$alreadyadded[] = $key;
					}
				}
				foreach ( $extraParam as $key => $value ) {
					if ( property_exists( $this, $key ) && ! in_array( $key, $alreadyadded ) ) {
						if ( ! empty ( $this->setOption [ $key ] ) ) {
							$db->where( $tbname . $key . $value, "", false );
						} else {
							$db->where( $tbname . $key, $value );
						}
						$alreadyadded[] = $key;
					}
				}
				if ( $clear_properties ) {
					$this->setProperties = array();
					$this->setOption     = array();
				}
				
				return true;
			}
			
			function Join( $join_obj, $join_obj_property, $main_obj_property, $type = "", $as = "" ) {
				if ( ! empty( $as ) ) {
					$join_obj->setTableShortName( $as );
				}
				$joinobj                    = new ObjectJoin();
				$joinobj->join_obj          = $join_obj;
				$joinobj->join_obj_property = $join_obj_property;
				$joinobj->main_obj_property = $main_obj_property;
				$joinobj->type              = $type;
				$this->joinObjects[]        = $joinobj;
			}
			
			protected function SetJoinProperties( $clear_properties = true ) {
				if ( count( $this->joinObjects ) > 0 ) {
					foreach ( $this->joinObjects as $jn ) {
						//$jn=new ObjectJoin();
						$thistblstrproperty = $this->getTableNameForJoinProperty( $jn->main_obj_property );
						if ( property_exists( $jn->join_obj, $jn->join_obj_property ) && ! empty( $thistblstrproperty ) ) {
							$tablestr = $jn->join_obj->GetTableName( false );
							$shorttbl = $jn->join_obj->GetTableName();
							$this->GetSelectDB()->join( $tablestr, " $shorttbl.$jn->join_obj_property=$thistblstrproperty", $jn->type );
							$jn->join_obj->SetDBSelectJoinProperties( $this->GetSelectDB(), [], $clear_properties );
						}
					}
				}
			}
			
			protected function SetJoinWhereConditions( $clear_properties = true, $isSelectDb = true ) {
				if ( count( $this->joinObjects ) > 0 ) {
					foreach ( $this->joinObjects as $jn ) {
						//$jn=new ObjectJoin();
						//$jn->join_obj=new self();
						$jn->join_obj->SetDBJoinWhereCondition( $this->GetSelectDB(), $clear_properties, $isSelectDb );
					}
				}
			}
			
			private function getTableNameForJoinProperty( $propertyName ) {
				if ( strpos( $propertyName, "." ) !== false ) {
					return $propertyName;
				}
				if ( property_exists( $this, $propertyName ) ) {
					return $this->GetTableName() . ".$propertyName";
				} else {
					if ( count( $this->joinObjects ) > 0 ) {
						foreach ( $this->joinObjects as $jn ) {
							if ( property_exists( $jn->join_obj, $propertyName ) ) {
								return $jn->join_obj->GetTableName() . ".$propertyName";
							}
						}
					}
				}
				
				return "";
			}
			
			protected function SetDBUpdateWhereProperties( $extraParam = array(), $isCheckWherePropetrySetOrNot = true, $clear_properties = false ) {
				if ( ! $this->CheckBasicCheck() ) {
					return false;
				}
				if ( count( $this->updateWhereExtraField ) == 0 ) {
					return false;
				}
				$alreadyadded = array();
				//primary key query
				$primaryKey = $this->primaryKey;
				if ( ! empty( $primaryKey ) && isset( $this->updateWhereExtraField[ $primaryKey ] ) ) {
					if ( in_array( $primaryKey, $this->updateWhereExtraFieldOption ) ) {
						$this->GetUpdateDB()->where( "(" . $primaryKey . $this->updateWhereExtraField[ $primaryKey ] . ")", "", false );
					} else {
						$this->GetUpdateDB()->where( $primaryKey, $this->updateWhereExtraField[ $primaryKey ] );
					}
					$alreadyadded[] = $primaryKey;
				}
				
				
				$generalKeys = array();
				// Unique Index key query
				if ( count( $this->uniqueKey ) > 0 ) {
					if ( is_array( $this->uniqueKey[0] ) ) {
						$selectedKey = "";
						foreach ( $this->uniqueKey as $pos => $uk ) {
							$generalKeys = array_merge( $generalKeys, $uk );
							$isOk        = true;
							foreach ( $uk as $fld ) {
								if ( ! isset( $this->updateWhereExtraField[ $fld ] ) ) {
									$isOk = false;
									break;
								}
								
							}
							if ( $isOk ) {
								$selectedKey = $pos;
							}
						}
						if ( $selectedKey != "" ) {
							foreach ( $this->uniqueKey[ $selectedKey ] as $uk ) {
								if ( isset( $this->updateWhereExtraField[ $uk ] ) && ! in_array( $uk, $alreadyadded ) ) {
									if ( in_array( $uk, $this->updateWhereExtraFieldOption ) ) {
										$this->GetUpdateDB()->where( "(" . $uk . $this->updateWhereExtraField[ $uk ] . ")", "", false );
									} else {
										$this->GetUpdateDB()->where( $uk, $this->updateWhereExtraField[ $uk ] );
									}
									$alreadyadded[] = $uk;
								}
							}
						}
					} else {
						//for backword compatibility
						// Other's key query
						foreach ( $this->uniqueKey as $uk ) {
							if ( isset( $this->updateWhereExtraField[ $uk ] ) && ! in_array( $uk, $alreadyadded ) ) {
								if ( in_array( $uk, $this->updateWhereExtraFieldOption ) ) {
									$this->GetUpdateDB()->where( "(" . $uk . $this->updateWhereExtraField[ $uk ] . ")", "", false );
								} else {
									$this->GetUpdateDB()->where( $uk, $this->updateWhereExtraField[ $uk ] );
								}
								$alreadyadded[] = $uk;
							}
							
						}
					}
				}
				
				// Other's Multikey query
				
				// Other's key query
				if ( count( $this->multiKey ) > 0 ) {
					if ( is_array( $this->multiKey[0] ) ) {
						$selectedKey = "";
						foreach ( $this->multiKey as $pos => $uk ) {
							$generalKeys = array_merge( $generalKeys, $uk );
							$isOk        = true;
							foreach ( $uk as $fld ) {
								if ( ! isset( $this->updateWhereExtraField[ $fld ] ) ) {
									$isOk = false;
									break;
								}
								
							}
							if ( $isOk ) {
								$selectedKey = $pos;
							}
						}
						if ( $selectedKey != "" ) {
							foreach ( $this->multiKey[ $selectedKey ] as $uk ) {
								if ( isset( $this->updateWhereExtraField[ $uk ] ) && ! in_array( $uk, $alreadyadded ) ) {
									if ( in_array( $uk, $this->updateWhereExtraFieldOption ) ) {
										$this->GetUpdateDB()->where( "(" . $uk . $this->updateWhereExtraField[ $uk ] . ")", "", false );
									} else {
										$this->GetUpdateDB()->where( $uk, $this->updateWhereExtraField[ $uk ] );
									}
									$alreadyadded[] = $uk;
								}
							}
						}
					} else {
						//for backword compatibility
						foreach ( $this->multiKey as $uk ) {
							if ( isset( $this->updateWhereExtraField[ $uk ] ) && ! in_array( $uk, $alreadyadded ) ) {
								if ( in_array( $uk, $this->updateWhereExtraFieldOption ) ) {
									$this->GetUpdateDB()->where( "(" . $uk . $this->updateWhereExtraField[ $uk ] . ")", "", false );
								} else {
									$this->GetUpdateDB()->where( $uk, $this->updateWhereExtraField[ $uk ] );
								}
								$alreadyadded[] = $uk;
							}
						}
					}
				}
				//for GeneralKeys
				foreach ( $generalKeys as $uk ) {
					if ( ! in_array( $uk, $alreadyadded ) ) {
						if ( isset( $this->updateWhereExtraField[ $uk ] ) ) {
							if ( in_array( $uk, $this->updateWhereExtraFieldOption ) ) {
								$this->GetUpdateDB()->where( "(" . $uk . $this->updateWhereExtraField[ $uk ] . ")", "", false );
							} else {
								$this->GetUpdateDB()->where( $uk, $this->updateWhereExtraField[ $uk ] );
							}
							$alreadyadded[]   = $uk;
							$this->isWhereSet = true;
						}
					}
				}
				
				
				foreach ( $this->updateWhereExtraField as $key => $value ) {
					if ( property_exists( $this, $key ) && ! in_array( $key, $alreadyadded ) ) {
						if ( in_array( $key, $this->updateWhereExtraFieldOption ) ) {
							$this->GetUpdateDB()->where( "(" . $key . $this->updateWhereExtraField[ $key ] . ")", "", false );
						} else {
							$this->GetUpdateDB()->where( $key, $this->updateWhereExtraField[ $key ] );
						}
						$alreadyadded[] = $key;
					}
				}
				
				foreach ( $extraParam as $key => $value ) {
					if ( property_exists( $this, $key ) && ! in_array( $key, $alreadyadded ) ) {
						$this->GetUpdateDB()->where( $key, $value );
						$alreadyadded[] = $key;
					}
				}
				if ( $isCheckWherePropetrySetOrNot ) {
					if ( count( $alreadyadded ) == 0 ) {
						APBD_add_model_errors_code( "E004" );
						
						return false;
					}
				}
				if ( $clear_properties ) {
					$this->updateWhereExtraField       = array();
					$this->updateWhereExtraFieldOption = array();
				}
				
				return true;
			}
			
			/**
			 * @param String $properties
			 * Comma separated
			 */
			function UnsetAllExcepts( $properties ) {
				$properties = explode( ",", $properties );
				$properties = array_map( "trim", $properties );
				foreach ( $this->setProperties as $key => $value ) {
					if ( ! in_array( $key, $properties ) ) {
						$this->UnsetPrperty( $key );
					}
				}
				
				return count( $this->setProperties ) > 0;
			}
			
			function UnsetAllUpdateProperty() {
				$this->updateWhereExtraField       = array();
				$this->updateWhereExtraFieldOption = array();
			}
			
			function SetDBPropertyForInsertOrUpdate( $isForUpdate = false ) {
				if ( ! $this->CheckBasicCheck() ) {
					return false;
				}
				if ( ! $isForUpdate ) {
					$primaryKey = $this->primaryKey;
					if ( ! empty( $primaryKey ) && ! isset( $this->setProperties[ $primaryKey ] ) && ! in_array( $primaryKey, $this->autoIncField ) ) {
						APBD_add_model_errors_code( "E002" );
						
						return false;
					}
				}
				$primaryKey = $this->primaryKey;
				foreach ( $this->setProperties as $key => $value ) {
					if ( $isForUpdate && $primaryKey == $key ) {
						continue;
					}
					if ( ! empty ( $this->setOption [ $key ] ) ) {
						$this->GetUpdateDB()->set( $key, $this->$key, false );
					} else {
						$this->GetUpdateDB()->set( $key, $this->$key );
					}
				}
				$this->ResetSetForInsetUpdate();
				
				return true;
			}
			
			/**
			 * @param string $likefld
			 * @param string $likeValue
			 * @param string $likeside
			 * @param bool $isSelectDb
			 */
			function SetDBLike( $likefld, $likeValue, $likeside = "after", $isSelectDb = true ) {
				$db = $isSelectDb ? $this->GetSelectDB() : $this->GetUpdateDB();
				//set like
				if ( ! empty ( $likefld ) ) {
					if ( property_exists( $this, $likefld ) ) {
						$db->like( $likefld, $likeValue, $likeside );
					} else {
						if ( count( $this->joinObjects ) > 0 ) {
							foreach ( $this->joinObjects as $jn ) {
								//$jn=new ObjectJoin();
								$thistblstrproperty = $this->getTableNameForJoinProperty( $likefld );
								if ( property_exists( $jn->join_obj, $likefld ) && ! empty( $thistblstrproperty ) ) {
									$likefld = $thistblstrproperty;
									$db->like( $likefld, $likeValue, $likeside );
									break;
								}
							}
						}
					}
				}
			}
			
			/**
			 * @param string|array $order_by
			 * @param string $order
			 * @param bool $isSelectDb
			 */
			function SetDBOrder( $order_by, $order = "", $isSelectDb = true ) {
				$db = $isSelectDb ? $this->GetSelectDB() : $this->GetUpdateDB();
				//SetOrder
				
				if ( ! empty ( $order_by ) && is_string( $order_by ) && property_exists( $this, $order_by ) ) {
					$db->order_by( $order_by, $order );
				} elseif ( ! empty( $order_by ) && is_string( $order_by ) && property_exists( $this, $order_by ) && empty( $order ) ) {
					$db->order_by( $order_by );
				} elseif ( is_array( $order_by ) ) {
					$forder = "";
					foreach ( $order_by as $op => $ov ) {
						$forder .= "$op $ov ,";
					}
					$forder = rtrim( $forder, ',' );
					$db->order_by( $forder );
				}
			}
			
			/**
			 * @param number $limit
			 * @param number $limitStart
			 * @param bool $isSelectDb
			 */
			function SetDBLimit( $limit, $limitStart = 0, $isSelectDb = true ) {
				$db = $isSelectDb ? $this->GetSelectDB() : $this->GetUpdateDB();
				$db->limit( $limit, $limitStart );
			}
			
			/**
			 * @param string $select
			 * @param bool $isSelectDb
			 */
			function SetDBSelect( $select = "", $isSelectDb = true ) {
				$db     = $isSelectDb ? $this->GetSelectDB() : $this->GetUpdateDB();
				$dbname = $this->GetTableName();
				if ( empty ( $select ) ) {
					$select = $dbname . ".* ";
				} else {
					$select = explode( ",", $select );
					foreach ( $select as $key => &$se ) {
						$se = trim( $se );
						if ( strpos( $se, "." ) !== false ) {
							continue;
						}
						if ( $se == "*" ) {
							$se = $dbname . ".* ";
						} elseif ( property_exists( $this, $se ) ) {
							$se = "$dbname.$se ";
						} else {
							if ( count( $this->joinObjects ) > 0 ) {
								foreach ( $this->joinObjects as $jn ) {
									if ( property_exists( $jn->join_obj, $se ) ) {
										$se = $jn->join_obj->GetTableName() . ".$se";
									}
								}
							} else {
								unset( $select[ $key ] );
							}
						}
					}
					$select = implode( ", ", $select );
				}
				$db->select( $select );
			}
			
			
			/**
			 * @param bool $isOnlyTableName
			 *
			 * @return string
			 */
			function GetTableName( $isOnlyTableName = true ) {
				if ( ! empty( $this->tableShortForm ) ) {
					if ( $isOnlyTableName ) {
						return $this->tableShortForm;
					} else {
						return $this->db->prefix . $this->tableName . " as " . $this->tableShortForm;
					}
				}
				
				return $this->db->prefix . $this->tableName;
			}
			
			protected function BindObject( $obj ) {
				if ( ! empty( $obj ) && ( is_object( $obj ) || is_array( $obj ) ) ) {
					foreach ( $obj as $key => $value ) {
						if ( in_array( $key, $this->htmlInputField ) ) {
							$value = stripcslashes( $value );
						}
						$this->$key = $value;
					}
				}
			}
			
			function SetValidation() {
				$this->validations = array();
			}
			
			public function IsValidForm( $isNew = true, $addError = true ) {
				
				$isOk     = true;
				$required = array();
				if ( empty( $this->validations ) ) {
					$this->SetValidation();
				}
				foreach ( $this->validations as $key => $value ) {
					if ( $isNew || ( isset( $this->setProperties [ $key ] ) && empty( $this->setOption [ $key ] ) ) ) {
						if ( ! isset( $value["Rule"] ) ) {
							continue;
						}
						$rules        = explode( "|", $value["Rule"] );
						$bracketValue = [];
						if ( is_array( $rules ) ) {
							foreach ( $rules as &$rule ) {
								$rule     = trim( $rule );
								$rule     = strtolower( $rule );
								$rulename = preg_replace( "/[^a-z_]/", "", $rule );
								$lg       = (int) preg_replace( "/[^0-9]/", "", $rule );
								if ( ! empty( $rulename ) && $lg > 0 ) {
									$bracketValue[ $rulename ] = $lg;
								}
								$rule = $rulename;
								
							}
							if ( in_array( "required", $rules ) ) {
								if ( empty ( $this->$key ) && trim( $this->$key ) . "_-_" === "_-_" ) {
									$isOk = false;
									array_push( $required, $value["Text"] );
									continue;
								}
							}
							
							if ( ! empty( $this->$key ) && in_array( "xss_clean", $rules ) ) {
								$this->$key = strip_tags( $this->$key );
							}
							if ( in_array( "lowercase", $rules ) ) {
								$this->$key = strtolower( $this->$key );
							}
							if ( ! empty( $this->$key ) && in_array( "digit", $rules ) ) {
								if ( ! ctype_digit( $this->$key ) ) {
									$isOk = false;
									$this->AddError( "%s should be digit", $value["Text"] );
								}
							}
							if ( ! empty( $this->$key ) && in_array( "numeric", $rules ) ) {
								if ( ! is_numeric( $this->$key ) ) {
									$isOk = false;
									$this->AddError( "%s should be numeric", $value["Text"] );
								}
							}
							if ( ! empty( $this->$key ) && in_array( "max_length", $rules ) && isset( $bracketValue['max_length'] ) ) {
								if ( strlen( $this->$key ) > (int) $bracketValue['max_length'] ) {
									$isOk = false;
									$bv   = (int) $bracketValue['max_length'];
									$this->AddError( " %s should be less then %s", $value["Text"], $bv );
								}
							}
							
							if ( in_array( "email", $rules ) ) {
								if ( ! empty( $this->$key ) && ! preg_match( "/^[A-Z0-9._]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/i", $this->$key ) ) {
									$isOk = false;
									$this->AddError( "%s should be a valid email address", $value["Text"] );
								}
							}
							if ( ! empty( $this->$key ) && in_array( "hexcode", $rules ) ) {
								if ( ! ctype_xdigit( $this->$key ) ) {
									$isOk = false;
									$this->AddError( $value["Text"] . " should be hexadecimal" );
								}
							}
							
						}
					}
					
				}
				
				if ( count( $required ) > 0 ) {
					if ( count( $required ) > 1 ) {
						$this->AddError( " %s are required", implode( ", ", $required ) );
					} else {
						$this->AddError( " %s is required", implode( ", ", $required ) );
					}
				}
				
				return $isOk;
			}
			
			function Save() {
				if ( ! $this->IsValidForm( true ) ) {
					return false;
				}
				if ( ! $this->SetDBPropertyForInsertOrUpdate() ) {
					return false;
				}
				$insertarray = $this->GetUpdateDB()->getSettedProperties();
				if ( $this->db->insert( $this->db->prefix . $this->tableName, $insertarray ) ) {
					$auto_inserted  = $this->db->insert_id;
					self::$quries[] = $this->db->last_query;
					if ( is_array( $this->autoIncField ) && count( $this->autoIncField ) > 0 ) {
						foreach ( $this->autoIncField as $fld ) {
							if ( property_exists( $this, $fld ) ) {
								$this->$fld = $auto_inserted;
							}
						}
					}
					$this->ResetSetForInsetUpdate();
					
					return true;
				} else {
					//$this->db->print_error();
					self::$quries[] = $this->db->last_query;
					APBD_AddQueryError( $this->db->last_query );
					if ( ! empty( $this->db->last_error ) ) {
						APBD_AddQueryError( $this->db->last_error );
					}
				}
				
				return false;
			}
			
			/**
			 * @param string $select
			 *
			 * @return boolean
			 */
			function Select( $select = "", $addFieldError = false ) {
				if ( ! $this->CheckBasicCheck() ) {
					return false;
				}
				if ( ! $this->IsValidForm( false, $addFieldError ) ) {
					return false;
				}
				if ( ! $this->SetDBSelectWhereProperties( array(), true, true ) ) {
					return false;
				}
				$this->SetDBSelect( $select, true );
				$this->SetJoinProperties();
				$query          = $this->queryBuilder->getSelectQuery( $this->GetTableName( false ) );
				self::$quries[] = $query;
				$result         = $this->db->get_row( $query );
				if ( $result ) {
					$this->BindObject( $result );
					$this->setProperties = array();
					$this->setOption     = array();
					
					return true;
				} else {
					return false;
				}
			}
			
			/**
			 *
			 * @param string $select
			 * @param string $orderBy
			 * @param string $order
			 * @param string $limit
			 * @param string $limitStart
			 * @param string $likefld
			 * @param string $like
			 * @param Array $ExtraLike
			 *
			 * @return static []
			 */
			function SelectAll( $select = "", $orderBy = "", $order = "", $limit = "", $limitStart = "", $likefld = "", $likeValue = "", $extraParam = array(), $likeside = "after", $isEscap = true, $is_data_only = false ) {
				if ( ! $this->CheckBasicCheck() ) {
					return false;
				}
				if ( ! $this->IsValidForm( false, false ) ) {
					return false;
				}
				if ( ! $this->SetDBSelectWhereProperties( $extraParam, true, true ) ) {
					return false;
				}
				
				$this->SetDBLike( $likefld, $likeValue, $likeside, true );
				
				//SetOrder
				$this->SetDBOrder( $orderBy, $order, true );
				$this->SetDBLimit( $limit, $limitStart );
				$this->SetDBSelect( $select, true );
				$this->SetJoinProperties();
				$this->SetJoinWhereConditions( false, true );
				$query          = $this->queryBuilder->getSelectQuery( $this->GetTableName( false ) );
				self::$quries[] = $query;
				$result         = $this->db->get_results( $query );
				if ( $result ) {
					return $result;
				} else {
					return array();
				}
			}
			
			/**
			 *
			 * @param string $select
			 * @param string $orderBy
			 * @param string $order
			 * @param string $limit
			 * @param string $limitStart
			 * @param string $likefld
			 * @param string $like
			 * @param Array $ExtraLike
			 *
			 * @return static []
			 */
			function SelectAllGridData( $select = "", $orderBy = "", $order = "", $limit = "", $limitStart = "", $likefld = "", $likeValue = "", $extraParam = array(), $likeside = "after", $isEscap = true ) {
				return $this->SelectAll( $select, $orderBy, $order, $limit, $limitStart, $likefld, $likeValue, $extraParam, $likeside, $isEscap, true );
			}
			
			function SelectAllWithIdentity( $unique_field, $select = "", $orderBy = "", $order = "", $limit = "", $limitStart = "", $likefld = "", $likeValue = "", $extraParam = array(), $likeside = "after", $isEscap = true ) {
				$result = $this->SelectAll( $select, $orderBy, $order, $limit, $limitStart, $likefld, $likeValue, $extraParam, $likeside, $isEscap );
				if ( count( $result ) > 0 ) {
					$newrsult = array();
					foreach ( $result as $obj ) {
						if ( ! empty( $obj->$unique_field ) ) {
							$newrsult[ $obj->$unique_field ] = $obj;
						}
					}
					
					return $newrsult;
				}
				
				return $result;
			}
			
			function SelectAllWithKeyValueWithStar( $key, $value, $isStarAdd = true, $orderBy = "", $order = "", $limit = "", $limitStart = "", $likefld = "", $likeValue = "", $extraParam = array(), $likeside = "after", $isEscap = true ) {
				$results    = $this->SelectAll( $key . "," . $value, $orderBy, $order, $limit, $limitStart, $likefld, $likeValue, $extraParam, $likeside, $isEscap );
				$returndata = array();
				if ( $isStarAdd ) {
					$returndata['*'] = "All";
				}
				foreach ( $results as $data ) {
					if ( ! empty( $data->$key ) ) {
						$returndata[ $data->$key ] = $data->$value;
					}
				}
				
				return $returndata;
			}
			
			function SelectAllWithKeyValue( $key, $value, $orderBy = "", $order = "", $limit = "", $limitStart = "", $likefld = "", $likeValue = "", $extraParam = array(), $likeside = "after", $isEscap = true ) {
				return $this->SelectAllWithKeyValueWithStar( $key, $value, false, $orderBy, $order, $limit, $limitStart, $likefld, $likeValue, $extraParam, $likeside, $isEscap );
			}
			
			function SelectAllWithArrayKeys( $key, $orderBy = "", $order = "", $limit = "", $limitStart = "", $likefld = "", $likeValue = "", $extraParam = array(), $likeside = "after", $isEscap = true ) {
				$results    = $this->SelectAll( $key, $orderBy, $order, $limit, $limitStart, $likefld, $likeValue, $extraParam, $likeside, $isEscap );
				$returndata = array();
				foreach ( $results as $data ) {
					if ( ! empty( $data->$key ) ) {
						$returndata[] = $data->$key;
					}
				}
				
				return $returndata;
			}
			
			
			/**
			 * @param String $property
			 * @param unknown $value
			 * @param unknown $extraparam
			 * @param string $isCache
			 * @param number $cacheTime
			 *
			 * @return static []:
			 */
			static function FindAllBy( $property, $value, $extraparam = array(), $order_by = '', $order = 'ASC', $limit = "", $limitStart = "", $isCache = false, $cacheTime = 0 ) {
				$n = new static();
				$n->checkCache( $isCache, $cacheTime );
				if ( property_exists( $n, $property ) ) {
					$n->$property( $value );
					if ( is_array( $extraparam ) ) {
						foreach ( $extraparam as $key => $value ) {
							if ( property_exists( $n, $key ) ) {
								$n->$key( $value );
							}
						}
					}
					
					return $n->SelectAll( '', $order_by, $order, $limit, $limitStart );
				}
				
				return array();
			}
			
			/**
			 * @param $findByProperty
			 * @param $findByvalue
			 * @param $key
			 * @param $value
			 * @param array $extraparam
			 * @param bool $isCache
			 * @param int $cacheTime
			 *
			 * @return static []
			 */
			static function FindAllByKeyValue( $findByProperty, $findByvalue, $key, $value, $extraparam = array(), $isCache = false, $cacheTime = 0 ) {
				$n = new static();
				$n->checkCache( $isCache, $cacheTime );
				if ( property_exists( $n, $findByProperty ) ) {
					$n->$findByProperty( $findByvalue );
					
					return $n->SelectAllWithKeyValue( $key, $value, "", "", "", "", "", "", $extraparam );
				}
				
				return array();
			}
			
			/**
			 * @param $findByProperty
			 * @param $findByvalue
			 * @param $identity_fld
			 * @param array $extraparam
			 * @param bool $isCache
			 * @param int $cacheTime
			 *
			 * @return static []
			 */
			static function FindAllByIdentiry( $findByProperty, $findByvalue, $identity_fld, $extraparam = array(), $isCache = false, $cacheTime = 0 ) {
				$n = new static();
				$n->checkCache( $isCache, $cacheTime );
				if ( property_exists( $n, $findByProperty ) ) {
					$n->$findByProperty( $findByvalue );
					
					return $n->SelectAllWithIdentity( $identity_fld, "", "", "", "", "", "", $extraparam );
				}
				
				return array();
			}
			
			function getPropertiesArray( $skipped = "" ) {
				$skipped    = explode( ",", $skipped );
				$return     = array();
				$reflection = new ReflectionObject( $this );
				$properties = $reflection->getProperties( ReflectionProperty::IS_PUBLIC );
				$skipped[]  = "settedPropertyforLog";
				foreach ( $properties as $property ) {
					if ( in_array( $property->getName(), $skipped ) ) {
						continue;
					}
					$return[ $property->getName() ] = $property->getValue( $this );
				}
				
				return $return;
			}
			
			static function FetchCountAll( $likefld = "", $likeValue = "", $extraParam = array(), $likeside = "after", $isCache = false, $cacheTime = 0 ) {
				$s = new static();
				$s->checkCache( $isCache, $cacheTime );
				
				return $s->CountALL( $likefld, $likeValue, $extraParam, $likeside );
			}
			
			static function FetchAllKeyValue( $key, $value, $isStarAdd = false, $orderBy = "", $order = "", $limit = "", $limitStart = "", $likefld = "", $likeValue = "", $extraParam = array(), $likeside = "after", $isEscap = true, $isCache = false, $cacheTime = 0 ) {
				$s = new static();
				$s->checkCache( $isCache, $cacheTime );
				$results    = $s->SelectAll( $key . "," . $value, $orderBy, $order, $limit, $limitStart, $likefld, $likeValue, $extraParam, $likeside, $isEscap );
				$returndata = array();
				if ( $isStarAdd ) {
					$returndata['*'] = "All";
				}
				foreach ( $results as $data ) {
					if ( ! empty( $data->$key ) ) {
						$returndata[ $data->$key ] = ! empty( $data->$value ) ? $data->$value : "Undefined $value";
					}
				}
				
				return $returndata;
			}
			
			function SelectAllWithIdentityWithSelectPropertyOnly( $unique_field, $select = "", $orderBy = "", $order = "", $limit = "", $limitStart = "", $likefld = "", $likeValue = "", $extraParam = array(), $likeside = "after", $isEscap = true ) {
				$result = $this->SelectAll( $select, $orderBy, $order, $limit, $limitStart, $likefld, $likeValue, $extraParam, $likeside, $isEscap, true );
				if ( count( $result ) > 0 ) {
					$newrsult = array();
					foreach ( $result as $obj ) {
						if ( ! empty( $obj->$unique_field ) ) {
							$newrsult[ $obj->$unique_field ] = $obj;
						}
					}
					
					return $newrsult;
				}
				
				return $result;
			}
			
			
			/**
			 * @param strin $fieldName | db field name
			 * @param string $default | default value
			 *
			 * @return string
			 */
			function GetNewIncId( $fieldName, $default ) {
				$query  = "SELECT max($fieldName) as lastS from " . $this->db->prefix . $this->tableName;
				$result = $this->db->get_row( $query );
				if ( $result ) {
					if ( ! empty ( $result->lastS ) ) {
						$a = $result->lastS;
						$a ++;
						
						return $a;
					}
				}
				
				return "$default";
			}
			
			function SelectQuery( $sql, $isArray = false ) {
				if ( $isArray ) {
					$output = ARRAY_A;
				} else {
					$output = OBJECT;
				}
				self::$quries[] = $sql;
				$result         = $this->db->get_results( $sql, $output );
				if ( $result ) {
					return $result;
				} else {
					return array();
				}
			}
			
			function IsExists( $property, $value, $otherParam = array() ) {
				if ( property_exists( $this, $property ) ) {
					$this->GetSelectDB()->where( $property, $value );
					foreach ( $otherParam as $key => $pvalue ) {
						$this->GetSelectDB()->where( $key, $pvalue );
					}
					$this->GetSelectDB()->select( "COUNT(*) AS total" );
					$query  = $this->queryBuilder->getSelectQuery( $this->GetTableName( false ) );
					$result = $this->db->get_row( $query );
					
					if ( ! empty( $result->total ) ) {
						return $result->total > 0;
					}
				}
				
				return false;
			}
			
			/**
			 * @return APPSDBQueryBuilder
			 */
			public function GetSelectDB() {
				return $this->queryBuilder;
			}
			
			
			/**
			 * @return APPSDBQueryBuilder
			 */
			public function GetUpdateDB() {
				return $this->queryBuilder;
			}
			
			function __call( $func, $args ) {
				if ( isset ( $args [0] ) ) {
					$value = $this->$func;
					
					// echo $func."=>".$value."==".$args[0];
					if ( $value != $args [0] || ( $args [0] == '' && $value == NULL ) ) {
						
						if ( property_exists( $this, $func ) ) {
							if ( isset ( $args [1] ) ) {
								$this->setOption [ $func ] = $args [1];
							}
							$this->setProperties [ $func ] = $args [0];
						}
						if ( ! empty( $args [1] ) ) {
							$this->$func = $args [0];
						} else {
							$this->$func = trim( $args [0] );
						}
					}
				} else {
					// echo $func;
				}
			}
			
			public static function __callStatic( $func, $args ) {
				if ( static::startsWith( $func, "FindBy" ) ) {
					$funcl    = strtolower( $func );
					$property = str_replace( "findby", "", $funcl );
					
					return static::FindBy( $property, $args[0] );
				}
				
			}
			
			/**
			 * @param string $select
			 * @param string $orderBy
			 * @param string $order
			 * @param string $limit
			 * @param string $limitStart
			 * @param string $likefld
			 * @param string $likeValue
			 * @param unknown $extraParam
			 * @param string $likeside
			 * @param string $isEscap
			 *
			 * @return Ambigous <Ambigous, boolean, multitype:>
			 */
			static function FetchAll( $select = "", $orderBy = "", $order = "", $limit = "", $limitStart = "", $likefld = "", $likeValue = "", $extraParam = array(), $likeside = "after", $isEscap = true ) {
				$s = new static();
				
				return $s->SelectAll( $select, $orderBy, $order, $limit, $limitStart, $likefld, $likeValue, $extraParam, $likeside, $isEscap );
			}
			
			function PostValue( $index, $default = NULL ) {
				return APBD_PostValue( $index, $default );
			}
			
			function GetValue( $index, $default = NULL ) {
				return APBD_GetValue( $index, $default );
			}
			
			
			/**
			 * @param unknown $property
			 * @param unknown $value
			 *
			 * @return static
			 */
			static function FindBy( $property, $value, $extraparam = array() ) {
				$n = new static();
				if ( property_exists( $n, $property ) ) {
					$n->$property( $value );
					if ( is_array( $extraparam ) ) {
						foreach ( $extraparam as $key => $value ) {
							if ( property_exists( $n, $key ) ) {
								$n->$key( $value );
							}
						}
					}
					if ( $n->Select() ) {
						return $n;
					}
				}
				
				return NULL;
			}
			
			function CountALL( $likefld = "", $likeValue = "", $extraParam = array(), $likeside = "after" ) {
				if ( empty ( $this->tableName ) ) {
					return false;
				}
				$this->GetSelectDB()->select( "count(*) as total", false );
				if ( ! $this->SetDBSelectWhereProperties( $extraParam, false, true ) ) {
					return false;
				}
				//set like
				$this->SetDBLike( $likefld, $likeValue, $likeside, true );
				//SetOrder
				$this->SetJoinProperties( false );
				$this->SetJoinWhereConditions( false, true );
				$query  = $this->queryBuilder->getSelectQuery( $this->GetTableName( false ) );
				$result = $this->db->get_row( $query );
				if ( $result && ! empty( $result->total ) ) {
					return $result->total;
				}
				
				return 0;
				
			}
			
			function ResetSetForInsetUpdate() {
				$this->settedPropertyforLog = "";
				foreach ( $this->setProperties as $key => $value ) {
					if ( isset ( $this->htmlInputField [ $key ] ) ) {
						continue;
					}
					if ( ! empty ( $this->settedPropertyforLog ) ) {
						$this->settedPropertyforLog .= ", ";
					}
					$this->settedPropertyforLog .= $key . "=" . $value;
				}
				$this->setProperties = array();
				$this->setOption     = array();
			}
			
			function SetFromArray( &$dataarray, $isNew = false ) {
				foreach ( $dataarray as $key => $value ) {
					if ( property_exists( $this, $key ) ) {
						$isHtml   = in_array( $key, $this->htmlInputField );
						$NewValue = $value;
						$oldValue = $this->PostValue( "old_" . $key );
						if ( $oldValue != NULL ) {
							if ( $oldValue == $NewValue ) {
								$this->$key = $NewValue;
							} else {
								$this->$key ( $NewValue );
								// $this->SetValidationRule ( $key );
							}
						} else {
							if ( $NewValue !== $oldValue ) {
								$this->$key ( $NewValue );
							} else {
								$this->$key = $NewValue;
							}
						}
					}
				}
				
				return $this->IsValidForm( $isNew );
			}
			
			function SetFromArrayWithOldData( &$dataarray, &$oldDataArray ) {
				foreach ( $dataarray as $key => $value ) {
					if ( property_exists( $this, $key ) ) {
						$isHtml   = in_array( $key, $this->htmlInputField );
						$NewValue = $value;
						$oldValue = isset( $oldDataArray[ $key ] ) ? $oldDataArray[ $key ] : NULL;
						if ( $oldValue != NULL ) {
							if ( $oldValue == $NewValue ) {
								$this->$key = $NewValue;
							} else {
								$this->$key ( $NewValue );
								// $this->SetValidationRule ( $key );
							}
						} else {
							if ( $NewValue !== $oldValue ) {
								$this->$key ( $NewValue );
							} else {
								$this->$key = $NewValue;
							}
						}
					}
				}
				
				return $this->IsValidForm( false );
			}
			
			function SetFromPostData( $isNew = false ) {
				return $this->SetFromArray( $_POST, $isNew );
			}
			
			function SetWhereUpdate( $property, $value, $isNotXSSClean = false ) {
				$this->updateWhereExtraField [ $property ] = $value;
				if ( $isNotXSSClean ) {
					$this->updateWhereExtraFieldOption[] = $property;
				}
			}
			
			function IsSetDataForSaveUpdate( $isShowMsg = false ) {
				$re = count( $this->setProperties ) > 0;
				if ( ! $re && $isShowMsg ) {
					APBD_AddWarning( "No change for update" );
				}
				
				return $re;
			}
			
			function IsSetPrperty( $property ) {
				return isset ( $this->setProperties [ $property ] );
			}
			
			function UnsetPrperty( $property ) {
				if ( isset ( $this->setProperties [ $property ] ) ) {
					unset ( $this->setProperties [ $property ] );
				}
				if ( isset ( $this->setOption [ $property ] ) ) {
					unset ( $this->setOption [ $property ] );
				}
			}
			
			function IsHTMLProperty( $property = "" ) {
				if ( in_array( $property, $this->htmlInputField ) ) {
					return true;
				}
				
				return false;
			}
			
			
			function Update( $notLimit = false, $isShowMsg = true, $dontProcessIdWhereNotset = true ) {
				if ( $this->IsSetDataForSaveUpdate() && count( $this->updateWhereExtraField ) > 0 ) {
					if ( ! $this->IsValidForm( false ) ) {
						return false;
					}
					//set update propertry for update
					if ( ! $this->SetDBPropertyForInsertOrUpdate( true ) ) {
						return false;
					}
					
					//set where condition propertry for update
					if ( ! $this->SetDBUpdateWhereProperties( array(), $dontProcessIdWhereNotset ) ) {
						return false;
					}
					$query          = $this->GetUpdateDB()->getUpdateQuery( $this->db->prefix . $this->tableName, $notLimit );
					self::$quries[] = $query;
					$uresult        = $this->db->query( $query );
					if ( $uresult !== false && $uresult > 0 ) {
						$this->ResetSetForInsetUpdate();
						$this->UnsetAllUpdateProperty();
						
						return true;
					} elseif ( $uresult !== false ) {
						APBD_AddQueryError( $query );
					}
				} else {
					if ( $isShowMsg && ! $this->IsSetDataForSaveUpdate() ) {
						$this->AddWarning( "No data found for update" );
					} elseif ( count( $this->updateWhereExtraField ) == 0 ) {
						$this->AddError( "E004" );
					}
					
				}
				
				
				//$wpdb->update( $table, $data, $where, $format = null, $where_format = null )
				
				
				return false;
			}
			
			function Delete( $notLimit = false, $isShowMsg = true, $dontProcessIdWhereNotset = true ) {
				if ( count( $this->updateWhereExtraField ) > 0 ) {
					if ( ! $this->IsValidForm( false ) ) {
						return false;
					}
					//set update propertry for update
					if ( ! $this->SetDBPropertyForInsertOrUpdate( true ) ) {
						return false;
					}
					
					//set where condition propertry for update
					if ( ! $this->SetDBUpdateWhereProperties( array(), $dontProcessIdWhereNotset ) ) {
						return false;
					}
					$query          = $this->GetUpdateDB()->getDeleteQuery( $this->db->prefix . $this->tableName, $notLimit );
					self::$quries[] = $query;
					$uresult        = $this->db->query( $query );
					if ( $uresult !== false && $uresult > 0 ) {
						$this->ResetSetForInsetUpdate();
						$this->UnsetAllUpdateProperty();
						
						return true;
					} elseif ( $uresult !== false ) {
						APBD_AddQueryError( $this->db->last_error );
					}
				} else {
					if ( $isShowMsg && ! $this->IsSetDataForSaveUpdate() ) {
						APBD_AddError( "No data found for update" );
					} elseif ( count( $this->updateWhereExtraField ) == 0 ) {
						APBD_add_model_errors_code( "E004" );
					}
					
				}
				
				return false;
			}
			
			protected static function DeleteByKeyValue( $key, $value, $noLimit = false, $extraParam = [] ) {
				$thisobj = new static();
				if ( ! property_exists( $thisobj, $key ) ) {
					return false;
				}
				$thisobj->SetWhereUpdate( $key, $value );
				if ( is_array( $extraParam ) && count( $extraParam ) > 0 ) {
					foreach ( $extraParam as $ekey => $item ) {
						if ( property_exists( $thisobj, $ekey ) ) {
							$thisobj->SetWhereUpdate( $ekey, $item );
						}
					}
				}
				
				return $thisobj->Delete( $noLimit );
			}
			
			function GetAffectedRows( $isSelectDB = false ) {
				return $this->db->rows_affected;
			}
			
			function force_set_pk_for_update( $isClean = true ) {
				$pk = $this->primaryKey;
				if ( ! empty( $this->$pk ) ) {
					if ( ! $isClean ) {
						$this->GetUpdateDB()->set( $pk . $this->$pk, false );
					} else {
						$this->GetUpdateDB()->set( $pk, $this->$pk );
					}
				}
			}
			
			static function GetTotalQueries() {
				ob_start();
				?>
                <div class="row">
                    <div class="panel panel-info">
                        <div class="panel-heading">Queries</div>
                        <div class="panel-body">
									<pre>
										<?php
											
											foreach ( self::$quries as $qur ) {
												$qur = str_replace( "\n", "", $qur );
												print_r( $qur );
											}
										
										?>
									</pre>
                        </div>
                    </div>
                </div>
				<?php
				return ob_get_clean();
			}
			
			static function GetDBFields() {
				$thisobj   = new static();
				$tableName = $thisobj->db->prefix . $thisobj->tableName;
				$fields    = $thisobj->db->get_results( "SHOW COLUMNS FROM {$tableName}" );
				//SMPrint($fields);
				$returnField = [];
				foreach ( $fields as $fld ) {
					$returnField[ $fld->Field ] = $fld;
				}
				
				return $returnField;
			}
			
			static function DBColumnAddOrModify( $columnName, $type, $length, $default = '', $nullstatus = 'NOT NULL', $after = '', $comment = '', $char_set = '' ) {
				$thisObj   = new static();
				$tableName = $thisObj->db->prefix . $thisObj->tableName;
				if ( empty( $tableName ) ) {
					return;
				}
				if ( $default == '' ) {
					$default = "''";
				}
				if ( ! empty( $char_set ) ) {
					$char_set = " CHARACTER SET {$char_set}";
				}
				if ( ! empty( $after ) ) {
					$after = " AFTER {$after}";
				}
				$fields = static::GetDBFields();
				//GPrint($fields);
				if ( isset( $fields[ $columnName ] ) ) {
					$queryType = "MODIFY";
				} else {
					$queryType = "ADD";
				}
				if ( strtolower( $type ) == "text" ) {
					$query = "ALTER TABLE `{$tableName}` {$queryType} COLUMN `{$columnName}`  {$type} $char_set {$nullstatus}  COMMENT '{$comment}' $after";
					
				} elseif ( strtolower( $type ) == "timestamp" ) {
					if ( $default == "''" ) {
						$default = "'0000-00-00 00:00:00'";
					}
					$query = "ALTER TABLE `{$tableName}` {$queryType} COLUMN `{$columnName}`  {$type} {$nullstatus} DEFAULT $default $after";
					
				} else {
					$query = "ALTER TABLE `{$tableName}` {$queryType} COLUMN `{$columnName}`  {$type}({$length}) $char_set {$nullstatus} DEFAULT {$default} COMMENT '{$comment}' $after";
				}
				///echo ($query) . "<br/>"; die;return;
				
				$thisObj->db->query( $query );
			}
			
			/**
			 * make sure you added wp table prefix with the table name;
			 *
			 * @param $query
			 *
			 * @return false|int
			 */
			static function DBDirectAlterQuery( $query ) {
				$thisObj = new static();
				
				return $thisObj->db->query( $query );
			}
			/*unchecked*/
		}
	}
	if(!class_exists("ObjectJoin")) {
		class ObjectJoin {
			const LEFT = "LEFT";
			const RIGHT = "RIGHT";
			const OUTER = "OUTER";
			const INNER = "INNER";
			public $join_obj_property;
			public $main_obj_property;
			/**
			 * @var AppsBDModel
			 */
			public $join_obj;
			public $type;
		}
	}