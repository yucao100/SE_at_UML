<?php
	/**
	 *  @File			library.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This is the application library, the configuration 
	 * 					file needs to be included before it is.
	 * 
	 * 	@changelog		
	 *	4/21/14			Created errorsOn from an existing if trigger to 
	 * 					accomodate the new configuration flow
	 * 	4/19/14			All existing API calls were added to apiCall
	 * 	4/18/14			All API supporting methods were added
	 * 	3/20/14			Function getDirectoryList was added	
	 */
    
    ////
    //  CONFIGURATION TRIGGERS
    ////
    
    /** 
     * 	errorsOn
     * 
     * 	Error reporting trigger
     * 
     * 	@param	$bool		This function turns on server php error 
     * 						reporting.
     */
    function errorsOn( $bool = false ) {
		
		// 	Turning errors on
		ini_set( 'display_errors' , 'On' ) ;
		
		// 	Setting the error format
		ini_set( 'error_prepend_string', '<div class="error">[ PHP ]' ) ;
		ini_set( 'error_append_string',  '</div>' );
		
		// 	Displaying all errors
		error_reporting( E_ALL ) ;	
	}
	errorsOn( $bool = true ) ;
	////
	//  FUNCTIONS
	////
	
	// API INTERFACE FUNCTIONS
	
	/**
	 * 	apiCall
	 * 
	 * 	This function is the API interface, it make the appropriate api 
	 * 	calls and generates results
	 * 
	 *  @param 	$A			The application configuration
	 * 	@param 	$function	The action to take
	 * 	@param	$parameters	The needed parameters
	 * 
	 * 	@return  $result	The result array
	 */
	function apiCall( $A , $function , $parameters ) {
		// 	Creating instance of the api
		$apiObj = new api( $A ) ;
		
		switch ( trim( $function ) ) { 

			/* 
			 * 	An example case
			 * 
			 * 	case 'publicMethhod' : 
			 *		return apiObject->publicMethhod( $parameters ) ;
			 */
								
			// 	This is a method to query existing API methods, though 
			//  they may not be enabled yet to the user
			case 'getMethodList' :
				return $apiObj->getMethodList( ) ;
											
			// 	This is a method to generate WGT via the API while maintaining
			// 	the API's JSON syntax
			case 'getWidget' :
				return $apiObj->getWidget( $parameters ) ;
				
			case 'registerMFA' :
				return $apiObj->registerMFA( $parameters ) ;
				
			case 'registerUser' :
				return $apiObj->registerUser( $parameters ) ;
				
			case 'activateMFA' :
				return $apiObj->activateMFA( $parameters ) ;
				
			case 'authenticateMFA' :
				return $apiObj->authenticateMFA( $parameters ) ;
				
			case 'authenticateUser' :
				return $apiObj->authenticateUser( $parameters ) ;
			
			default :
				// This is method not found
				return $apiObj->setReturn( 405 , null , null ) ;
		}
	}
	
	/**
	 * 	getWGT
	 * 
	 * 	This function generates a widget for returning via the API
	 * 
	 *  @param 	$A			The application configuration	
	 * 	@param	$name		The widget name
	 * 	@param	$parametrs	The API parameters, contains the widget 
	 * 						parametrs if not null
	 * 
	 * 	@return	$content	The requested WGT HTML
	 */
	function getWGT( $A, $parameters ) {
		
		// 	Start Generating WGT
		ob_start() ;
		
		// 	Pass WGT arguments	
		if ( isset( $parameters[ 1 ] ) && 
			 $parameters[ 1 ] != null ) 
				$WGT[ 'ARGV' ] = array_slice( $parameters , 1 ) ;

		// 	Include WGT		
		include( $A[ 'D_WGT' ].$parameters[ 0 ].'\\index.php' ) ;
		
		// 	Generate HTML
		$content = ob_get_clean() ;
		
		// 	Strip tabs spaces and newlines
		$content =  preg_replace("/\s+/", " ", $content)  ;
		
		// 	Return Generated WGT
		return $content ;
	}
	
	/**
	 * 	jsoinValid
	 * 
	 * 	This function checks to see if a given json string is valid for 
	 * 	use with the API
	 * 
	 *  @param 	$A			The application configuration
	 *  @param 	$json		The json string to check
	 * 
	 * 	@return true		Valid json
	 * 	@return false		Invalid json
	 */
	function jsonValid( $A , $json ) {
		
		// Try to parse json, and check for well formed json
		if ( $json === null &&
			 json_last_error() !== JSON_ERROR_NONE ) {
				 // badly formed json found
				return false ;
		}
		
		// Getting number of instructions
		$size = count( $json ) ;
			
		// Setting order array for checking, 0 is preprocessing
		$order = array( 0 ) ;
			
		// Iterating through instructions 
		for ( $i = 0 ; $i < $size ; ++$i ) {

			if ( !array_key_exists ( 'order' , $json[ $i ] ) ||
				 !array_key_exists ( 'call' , $json[ $i ] ) ||
				 !array_key_exists ( 'parameter' , $json[ $i ] ) ) 
					return false ;
			// Verifying reserved orders are not used 
			// 0 is used to be a signal before operation
			if ( intval( $json[ $i ][ 'order' ] ) <= 0 )
				return false ;
			
			// Check if order was already used
			if ( in_array( $json[ $i ][ 'order' ] , $order ) )
				return false ;
			
			// Add order to list
			array_push( $order , $json[ $i ][ 'order' ] ) ;
			
		}
					
		// Valid json found
		return true ;
	}
	
	/**
	 * 	processJson
	 * 
	 * 	This function processes a large json instruction set for the api
	 * 	If the sting is not valid JSON it will abort with a SYNTAX error.
	 * 	If there is an error during processing the api will abort processing. 
	 * 	It is the users responsibility to verify all instructions were completed.
	 * 
	 * 	This function guarantees that one reply with at least one result 
	 * 	will be returned especially in case of error.
	 * 
	 *  @param 	$A			The application configuration
	 * 	@param 	$json		The inputted json instruction set
	 * 
	 * 	@return	$result		The returned values
	 */	
	function processJson( $A , $json ){
		// prepping the json result array
		$result = array() ;
		
		if ( !is_array( $json ) )
			$json = json_decode( $json , true) ;
		
		// Check if JSON is Valid and meets API requirements
		if ( jsonValid( $A , $json ) ) {
			
			// 	Fixing non wrapper array
			if ( array_key_exists ( 'order' , $json ) )
				$json = array( $json ) ;
						
			usort( $json , 'compareNum' ) ;

			// iterating through instructions
			foreach ( $json as $i ) {

				// processing an instruction
				$str = processCall( $A , $i ) ;
				
				// pushing the $str
				array_push( $result , $str ) ;
				
				//comparing status code to failure			
				if ( $str[ 'code' ][ 0 ] < 200 ||
					 $str[ 'code' ][ 0 ] >= 300 ) {				
						return json_encode( $result ) ;
				}

			}
		}
		else {
			// Send JSON malformed message
			array_push( $result ,  processCall( $A , 
									array( 'order' => 0 , 
										  'call' => 'setReturn' , 
										  'parameter' => array( 400 , 'Is Bad Syntax.' , null ) ) ) ) ;
		}
		return json_encode( $result ) ;
				
	}

	/**
	 * 	processCall
	 * 
	 * 	This function calls the api methods and prepares their return 
	 * 	json string
	 * 
	 *  @param 	$A			The application configuration
	 * 	@param 	$tmp		A single api call json string
	 * 
	 * 	@param 	$json		The return $json string
	 */
	function processCall( $A , $tmp ) {

		// conduct api call 
		$result = apiCall( $A , $tmp['call'] , $tmp['parameter'] ) ;
		
		// generate json result				
		$json = array( "order" => $tmp['order'] , "code" => $result['code'] , "value" => $result['return'] ) ;
		
		// return json string
		return $json ; 
	}

	// 	COMPARISON FUNCTIONS 

	/**
	 * 	compareNum
	 * 
	 * 	This function is to be used in conjunction with php usort to sort 
	 * 	numerical values in ascending order
	 * 
	 *  @param 	$A			The application configuration
	 * 	@param 	$a 			A number to compare for ordering
	 * 	@param 	$b			A number to compare for ordering
	 * 
	 * 	@return -1			$b is larger
	 * 	@return  0 			$a and $b are equal
	 * 	@return  1			$a is larger
	 */
	function compareNum( $a , $b ) {
		
		// $a and $b do not exist
		if ( !isset( $a['order'] ) && 
			  !isset( $b['order'] ) ) 
			return 0 ;
		
		// $a does not exist hence $b is larger
		if ( !isset( $a['order'] ) ) 
			return -1 ;

		// $b does not exist hence $a is larger
		if ( !isset( $b['order'] ) )
			return 1 ;

		// $a and $b are equal
		if ( $a['order'] == $b['order'] )
			return 0 ;
		
		// determine which is larger
		return ( ( $a['order'] > $b['order'] ) ? 1 : -1 ) ;
		
	}
	
	//	GENERAL
	
	/**
	 * 	getPublicMethods
	 * 
	 * 	This function uses its out of scope position to get the public 
	 * 	methods of a class.
	 * 
	 *  @param 	$A			The application configuration
	 * 	@param	$className	The name of the class to query
	 * 
	 * 	@return				The alphabetically sorted array of public 
	 * 						methods
	 */
	function getPublicMethods( $A , $className ) {
		// 	Get list of methods
		$arr = get_class_methods( new $className( $A ) ) ;
		// Sort methods alphabetically
		sort( $arr ) ;
		// Return sorted list
		return $arr ;
	}
	
	/**
	 * 	getDirectoryList
	 * 
	 * 	This function generates an array of directory entries
	 * 
	 * 	@param 	$A			The application configuration
	 * 	@parama	$path		The path to get a Dir list
	 * 
	 * 	@return $arr		The Dir list
	 */
	function getDirectoryList( $A , $path ) {
		// The array to return 
		$arr = array() ;
		
		//	$A[ 'D_WGT' ]
		//getting the directory
		$myDirectory = opendir( $path ) ;
		
		// 	reading each entry
		while ( $entryName = readdir( $myDirectory ) ) 
			// ommiting 	current and previous dir
			if ( $entryName != '.' && $entryName != '..' ) 
				// adding entries to return array
				array_push( $arr , $entryName ) ;
		
		// returning results	
		return $arr ;
	}
	
	/**
	 * 	getCSVArray
	 * 
	 * 	This function breaks appart a string of CSV and creates a table 
	 * 	row from them.
	 * 
	 * 	@param	$arg		The argument string to break up
	 * 
	 * 	@return null		An empty array
	 * 	@retrun $ret		An array with all CSV elements
	 */
	function getCSVArray( $arg ) {
		// 	Check for arguments
		if ( isset( $arg ) ) {
			if ( !is_array( $arg ) && 
				 strpos( $arg ,',') == true ) 
					$out = explode( ',' , $arg ) ; 	
			else 
				$out = $arg ;
				
			// 	return the row
			return $out ;
		}
		// 	return an empty row
		return NULL ;
	}

	/**
	 *	getDevRow
	 * 
	 * 	This function takes a CSV input and turns it into a table row
	 * 
	 * 	@param	$title		The th element
	 * 	@param	$args 		the td element
	 * 
	 * 	@return null		No row
	 * 	@return 			The table row
	 */
	function getDevRow( $title , $args ) {
		$rtn = '' ;
		//	create the row
		if ( ( $out = getCSVArray( $args ) ) != null ) {
			 $rtn =  '<tr><th>'.$title.'</th><td>'. var_inspect( $out ) . '</td></tr>' ;
		}
		return $rtn ;
	}
	
	/**
	 * 	printDevHead
	 * 
	 * 	This function breaks appart a string of CSV and creates a table 
	 * 	row from them.
	 * 
	 * 	@param	$A
	 * 	@param	$argCSS		The CSS argument string
	 * 	@param	$argJS		The JS argument string
	 *  
	 * 	@return null		An empty row
	 * 	@retrun string		The created row
	 */
	function getDevHead( $A , $argCSS , $argJS ) {
		//	Load jQuery CSS  
		$ret = '<link href="'.$A[ 'W_CSS' ].'jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css">' ;
		//	Load application CSS
		$ret .= '<link href="'.$A[ 'W_CSS' ].'main.css" rel="stylesheet" type="text/css">' ;
		
		//	Load optional CSS
		$ret .= getDevHeadSrc( $A , 'CSS' , $argCSS ) ;
		
		//	Load jQuery
		$ret .= '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>' ;
		$ret .= '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>' ;
		
		//	Load optional JS
		$ret .= getDevHeadSrc( $A , 'JS' , $argJS ) ;
		
		//	Load the onload function
		$ret .= '<script src="'.$A['W_JS'].'onload.js"></script>' ;
		
		//	Return generated head
		return $ret ;
	}
	
	/**
	 * 	getDevHeadSrc
	 * 
	 * 	This function produces the head JS and css includes
	 * 
	 * 	@param	$A			The application configuration 
	 * 	@param	$type		The type of resource [ 'JS', 'CSS' ]
	 * 	@param	$args		The comma seperated arguments
	 * 
	 * 	@return	string		The generated string
	 */
	function getDevHeadSrc( $A , $type , $args ) {
		// 	Setting up a blank return
		$ret = '' ;
		
		// checking to make sure text got passed and not null
		if ( $args != NULL ) {
			//	Break up array
			$out = explode( ',' , $args ) ; 	
			// 	Include each JS file
			foreach ( $out as $i )
				//	Generating a JS include
				if ( $type == 'JS' )
					$ret .= '<script src="'.$A[ 'W_JS_LIB' ].$i.'"></script>' ;
				//	Generating a CSS include
				else if ( $type == 'CSS' )
					$ret .= '<link href="'.$A[ 'W_CSS' ].$i.'" rel="stylesheet" type="text/css">' ;
		} 
		// 	Returning the string
		return $ret ;
	}
	
	/**
	 * var_inspect
	 * 
	 */
	 function var_inspect( $var ) {
		ob_start() ;
		var_dump( $var );
		$result = ob_get_clean() ;
		return $result ;
	}

?>
