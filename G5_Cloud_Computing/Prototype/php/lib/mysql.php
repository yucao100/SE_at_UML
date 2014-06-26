<?php
	
    /**
     *  @File           mysql.php
     *  @Authors        Jose Flores
     *                  jose.flores.152@gmail.com
     *  
     *  @Description    This file holds the mysql class which uses the 
     * 					mysqli PHP object to generate conections and 
     * 					perform querys from arrays.
     * 
     *  @changelog      
     *  5/20/14        Version 1 complete, INSERT, DELETE, SELECT are available
     */
     
	//  DEFINE GUARD
    if ( !defined( 'class_mysql' ) )  {
        
        define( 'class_mysql' , TRUE ) ;
		/**
		 *	mysql
		 * 
		 * 	This class handles mysql connections
		 * 
		 * 	concept was based off of a class found online
		 * 	http://alperguc.blogspot.com/2013/08/php-database-class-mysqli.html
		 * 	but then later modified.
		 * 
		 * 	$connection		a mysqli connection
		 */
		// My database Class called myDBC
		class mysql {
			
			//	VARIABLES
			private $connection  ; 	// 	mysqli object instance
			
			//	CONSTUCTOR
			 
			/**
			 * 	__construct
			 * 
			 * 	This function is the class constructor, it instantiates an 
			 * 	instance of the mysqli class and then checks for a valid 
			 * 	connection
			 */		
			public function __construct( $A ) {
				$this->connection = new mysqli( $A[ 'M_SERVER' ] , 
								  $A[ 'M_USR' ] ,  
								  $A[ 'M_PWD' ] , 
								  $A[ 'M_DB' ] ) ;
								  
				if ( $this->connection->connect_errno > 0 ) {
					die( 'Unable to connect to database [' . $this->connection->connect_error . ']' ) ;
				}
			}
			
			//	DESTRUCTOR
			
			/**
			 * 	__destructor 
			 * 
			 * 	This function kills the thread and closes the database 
			 * 	connection
			 * 
			 */
			public function __destruct() {
				//	determine thread id 
				$thread_id = $this->connection->thread_id ;

				//	Kill connection 
				$this->connection->kill( $thread_id ) ;
				
				// close database connection
				$this->connection->close() ;
			}
			
			//	METHODS
			
			/**
			 * 	insert
			 * 
			 * 	This function creates a mysql insert query from an array of 
			 * 	values and table location
			 * 
			 * 	@param	$table		table to performt he operation on
			 * 	@param	$keyPairs	The array of values
			 * 						array( key => pair )
			 * 
			 * 	@return				Mysqli return values
			 */
			public function insert( $table , $keyPairs ) {

				//VARIABLES
				$bool = false ;				// 	multiple $keyPair sentinel
				$column = $values = '';		//	initializing values

				//	Run through all the keyPairs
				foreach( $keyPairs as $key => $value ) {
					
					// 	check if a field is blank	
					if ( trim( $value ) != '' ) {
						// 	if the second string or beyond seperate with commas
						if ( $bool ) {
							$column .= ' , '  ;
							$values .= ' , '  ;
						}
						
						// 	append the keys and cleaned inputs to their strings
						$column .= '`'. $key .'`' ;
						$values .= '"' . $this->cleanString( $value ) . '"' ;
						
						// 	Set bool to true to signify that the commas can 
						//	start being generated
						$bool = true ;
					}
				}
				
				//	generate query
				$query = 'INSERT INTO `' . $table . '` ( ' .  $column . ' ) VALUES ( ' . $values . ' )' ;

				// perform query
				return $this->runQuery( $query ) ;
			}
			
			/**
			 * 	select
			 * 
			 * 	This function creates a mysql select query from an array of 
			 * 	values , operators and table location
			 * 
			 * 	@param	$table		table to performt he operation on
			 * 	@param	$keyPairs	The array of values
			 * 						array( key => pair )
			 * 	@param	$operators	The relationship betweent the key and value 
			 * 						ie wether they must be equal or not, 
			 * 						using php comparison operators for consistency
			 * 	@return				Mysqli return values
			 */
			public function select( $table , $keyPairs , $operators ) {
				
				//VARIABLES
				$i = 0 ;			//	operator incrementor
				$bool = false ;		//	first item sentinel
				$options = '';		// 	the WHERE options

				//	Run through all the keyPairs
				foreach( $keyPairs as $key => $val ) {
					
					// 	If the second string or beyond seperate with commas
					if ( $bool ) {
						$options .= ' AND '  ;
					}
					
					$options .= '`' . $key . '`' . 
						$this->getOperator( $operators[ $i++ ] ) . 
						'"' . $this->cleanString( $val ) . '"' ;
										
					// 	Set bool to true to signify that the commas can 
					//	start being generated
					$bool = true ;
					
				}

				// 	Generate Query
				$query = 'SELECT * FROM `' . $table ; 
				
				// 	If there where key pairs
				if ( $options != '' ) 
					$query .= '` WHERE ' . $options ;

				// 	Query mysql
				return $this->runQuery( $query ) ;
			}
			
			/**
			 * 	select
			 * 
			 * 	This function creates a mysql select query from an array of 
			 * 	values , operators and table location
			 * 
			 * 	@param	$table		table to performt he operation on
			 * 	@param	$keyPairs	The array of values
			 * 						array( key => pair )
			 * 	@param	$operators	The relationship betweent the key and value 
			 * 						ie wether they must be equal or not, 
			 * 						using php comparison operators for consistency
			 * 	@return				Mysqli return values
			 */
			public function update( $table , $keyPairs , $operators , $newKeyPairs ) {
				
				//VARIABLES
				$i = 0 ;			//	operator incrementor
				$bool = false ;		//	first item sentinel
				$options = $change = '';		// 	the WHERE options

				//	Run through all the keyPairs
				foreach( $keyPairs as $key => $val ) {
					
					// 	If the second string or beyond seperate with commas
					if ( $bool ) {
						$options .= ' AND '  ;
					}
					
					$options .= '`' . $key . '`' . 
						$this->getOperator( $operators[ $i++ ] ) . 
						'"' . /*$this->cleanString(*/ $val /*)*/ . '"' ;
										
					// 	Set bool to true to signify that the commas can 
					//	start being generated
					$bool = true ;
					
				}

				$bool = false ;
				foreach( $newKeyPairs as $key => $val ) {
					
					// 	If the second string or beyond seperate with commas
					if ( $bool ) {
						$change .= ' , '  ;
					}
					
					$change .= '`' . $key . '`=' . 
						'"' . /*$this->cleanString(*/ $val /*)*/ . '"' ;
										
					// 	Set bool to true to signify that the commas can 
					//	start being generated
					$bool = true ;
					
				}
				
				// 	Generate Query
				$query = 'UPDATE `' . $table .'`' ; 
				$query .= ' SET ' . $change ;
				
				// 	If there where key pairs
				if ( $options != '' ) 
					$query .= ' WHERE ' . $options ;

				// 	Query mysql
				return $this->runQuery( $query ) ;
			}
			
			/**
			 * 	delete
			 * 
			 * 	This function creates a mysql delete query from an array of 
			 * 	values, operators and table location
			 * 
			 * 	@param	$table		table to performt he operation on
			 * 	@param	$keyPairs	The array of values
			 * 						array( key => pair )
			 * 	@param	$operators	The relationship betweent the key and value 
			 * 						ie wether they must be equal or not, 
			 * 						using php comparison operators for consistency
			 * 	@return				Mysqli return values
			 */
			public function delete( $table , $keyPairs , $operators ) {
				
				//VARIABLES
				$i = 0 ;			//	operator incrementor
				$bool = false ;		//	first item sentinel
				$options = '';		// 	the WHERE options

				//	Run through all the keyPairs
				foreach( $keyPairs as $key => $val ) {
					
					// 	If the second string or beyond seperate with commas
					if ( $bool ) {
						$options .= ' AND '  ;
					}
					
					$options .= '`' . $key . '`' . 
						$this->getOperator( $operators[ $i++ ] ) . 
						'"' . $this->cleanString( $val ) . '"' ;
										
					// 	Set bool to true to signify that the commas can 
					//	start being generated
					$bool = true ;
					
				}

				// 	Generate Query
				$query = 'DELETE FROM `' . $table .'` WHERE ' . $options ;

				// 	Query mysql
				return $this->runQuery( $query ) ;
								
			}

			/**
			 * 	getOperator
			 * 
			 * 	This function guarantees that the operators for a WHERE mysql 
			 * 	clause are valid and that for ease of use are translated from 
			 * 	the php equivilents
			 *
			 * 	@param 	$operators 	the operator to verify/ convert
			 * 
			 * 	@return the mysql operator 
			 */
			private function getOperator( $operators ) {
				
				switch ( $operators ) {			
					case '==' 	: return '=' ;
					case '===' 	: return '===' ;	
					case '!=' 	: return '!=' ;
					case '!==' 	: return '!==' ;
					case '<' 	: return '<' ;
					case '>' 	: return '>' ;
					case '<=' 	: return '<=' ;
					case '>=' 	: return '>=' ;
					default 	: return false ;
				}
					
			}
			
			/**
			 * 	runQuery
			 * 
			 * 	This function runs a mysql query. 
			 * 
			 * 	@param $query 	the query to perform
			 * 
			 * 	@return the mysqli response
			 */
			private function runQuery( $query) {
				
				// run query or report error
				if ( !$result = $this->connection->query( $query ) ) {
					die( '[ SQL ] ' . $this->connection->error  ) ;
				}	
				// return result
				return $result ;	
			}
			 
			/**
			 * 	cleanString
			 * 	
			 * 	This function cleans the string so that it can be stored 
			 * 	safely in a mysql database
			 * 
			 * 	@param	$text 		the string to sanitize
			 * 
			 * 	@return string		the cleaned string
			 */ 
			private function cleanString( $text ) {
				// strip extra spaces on out sid and sanitize
				return $this->connection->real_escape_string( trim( $text ) ) ;
			}
			 
			/**
			 * 	getLastInsertID
			 * 
			 * 	This function gets the last insertion id
			 * 
			 * 	@return int		the last insert id
			 */
			private function getLastInsertID() {
				
				return $this->connection->insert_id ;
			}	 
		}	
	}	 
?>
