<?php
    
    ////
    //  CONFIGURATION TRIGGERS
    ////
    
    /** 
     * 	Error reporting trigger
     */
    if ( $A[ 'ERRORS' ] ) {
		ini_set( 'display_errors' , 'On' ) ;
		error_reporting( E_ALL ) ;
		
	}
	
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
		//	List of public methods that are needed but are not part of API
		$blackList = array( '__construct' ) ;
		
		switch ( trim( $function ) ) { 

			/* 
			 * 	An example case
			 * 
			 * 	case 'publicMethhod' : 
			 *		$result = apiObject->publicMethhod( $parameters ) ;
			 *		break ;
			 */
			
			// 	This is a hardcoded success return used to signify that 
			// 	the interface is working
			case 'API' : 
				
				$result = array( 'code' => '200' , 
								 'return' => array( "OK" , 
													"API is available" ) ) ;
				break ;
			
			// 	This is a method to query existing API methods, though 
			//  they may not be enabled yet to the user
			case 'LIST' :
				$result = array( 'code' => '200' ,
								 'return' => array( "OK" ) );
				
				// 	Get all public methods from API
				$list = get_class_methods ( new api ) ;
				foreach ( $list as $item )
					// prevent deny values from pupulating
					if ( !in_array( $item , $blackList ) )
						array_push( $result['return'] , strtoupper( $item ) ) ;
				
				break ;
							
			// 	This is a method to notify the user of an error in their 
			//  API JSON syntax
			case '' :
			case 'SYNTAX' :
				$result = array( 'code' => '400' ,
								 'return' => array( "Bad Request" , 
													"The request cannot be fulfilled due to bad syntax." ) ) ;
				break ;
			
			// 	This is a method to generate WGT via the API while maintaining
			// 	the API's JSON syntax
			case 'WGT' :
				// Generating an available WGT
				switch ( trim( $parameters[ 0 ] ) ) {
					case 'PROFILE' :	
						// 	Including specified widget
						$result = array( 'code'  => '200' ,
										 'return' => array( "OK" , 
															getWGT( $A, 'profile-generator' , $parameters ) ) ) ;
						break ;
					// Missing WGT name
					case '' :
						$result = array( 'code' => '400' , 
										 'return' => array( "Bad Request" , 
															"The request cannot be fulfilled due to bad syntax." ) ) ;
						break ;
					// WGT not available
					default :
						$result = array( 'code' => '404' ,
										 'return' => array( "Resource Not Found" ,
															"The requested resource could not be found but may be available again in the future." ) ) ;
						break ;
				}
				break ;
				
			//	Method requested is not available
			default :
				// This is method not found
				$result = array( 'code' => '405' ,
								 'return' => array( "Method Not Allowed" , 
												    "A request was made using method that is not enabled by the API Interface, call LIST for existing API methods." ) ) ;
				break ;
		}
		
		// 	Returning result
		return $result ;
	}
	
	/**
	 * 	getWGT
	 * 
	 * 	This function generates a widget for returning via the API
	 * 
	 *  @param 	$A			The application configuration	
	 * 	@param	$name		The widget name
	 * 	@param	$parametrs	The API parameters, contains the widget 
	 * 						parametrs if greater than 1
	 * 
	 * 	@return	$content	The requested WGT HTML
	 */
	function getWGT( $A, $name , $parameters ) {
		
		// 	Start Generating WGT
		ob_start() ;
		
		// 	Pass WGT arguments
		if ( count( $parameters ) > 0 ) 
			$WGT[ 'ARGV' ] = array_slice( $parameters , 1 ) ;

		// 	Include WGT		
		include( $A[ 'D_WGT' ].$name.'/index.php' ) ;
		
		// 	Generate HTML
		$content = ob_get_clean() ;
		
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
		
		// If str is a blank string
		if( $json == '' ) 
			return false ;
		
		// Try to parse json, and check for well formed json
		if ( ( $obj = json_decode( $json , true ) ) === null && 
			 json_last_error() !== JSON_ERROR_NONE ) {
				 // badly formed json found
				return false ;
		}
		
		// Getting number of instructions
		$size = count( $obj ) ;
		
		// Setting order array for checking, 0 is preprocessing
		$order = array( '0' ) ;
			
		// Iterating through instructions 
		for ( $i = 0 ; $i < $size ; ++$i ) {
			// Verify all api structural requirements are met
			if ( !array_key_exists ( 'order' , $obj[ $i ] ) ||
				 !array_key_exists ( 'call' , $obj[ $i ] ) ||
				 !array_key_exists ( 'parameter' , $obj[ $i ] ) ) 
					return false ;
			// Verifying reserved orders are not used 
			// 0 is used to be a signal before operation
			if( intval( $obj[ $i ][ 'order' ] ) <= 0 )
				return false ;
			
			// Check if order was already used
			if ( in_array( $obj[ $i ][ 'order' ] , $order ) )
				return false ;
			
			// Add order to list
			array_push( $order , $obj[ $i ][ 'order' ] ) ;
			
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
	function processJson ( $A , $json ){
	
		// prepping the json result array
		//$result = '[' ;
		$result = array() ;
		
		// Check if JSON is Valid and meets API requirements
		if ( jsonValid( $A , $json ) ) {
			// decoding the json string
			$obj = json_decode( $json , true ) ;
					
			usort( $obj , 'compareNum' ) ;
			
			// finding the ammount of instructions
			$size = count( $obj ) ;
			
			// iterating through instructions
			for ( $i = 0 ; $i < $size ; ++$i ) {
				
				// processing an instruction
				$str = processCall( $A , $obj[ $i ] ) ;
				
				// appending to the result array
				//$result .= $str ;
				
				// pushing the $str
				array_push( $result , $str ) ;
				
				// retrieving status code
				// $objTmp = json_decode( $str , true ) ;
				
				//comparing status code to failure			
				//if ( $objTmp[ 'code' ] != '200' ) {
				if ( $str[ 'code' ] != '200' ) {				
					return json_encode( $result ) ; 
				}
				
				// if there is another item we need to insert ',' to seperate
				// for proper formed json
				//if ( $i + 1 < $size ) 
				//	$result .= ',' ;
			}
		}
		else {
			// Send JSON malformed message
			// $result .= processCall( $A , 
			array_push( $result ,  processCall( $A , 
									array( 'order' => '0' , 
										  'call' => 'SYNTAX' , 
										  'parameter' => 'NULL' ) ) ) ;
		}
			
		//return $result . ']' ; 
		
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
		// $result = array( 'code' => '200' , 'return' => array( 'OK' ) ) ;
		// generate json result				
		// $json = '{"order":"'.$tmp['order'].'","code":"'.$result['code'].'","values":['.$result['return'].']}' ;
		$json = array( "order" => $tmp['order'] , "code" => $result['code'] , "values" => $result['return'] ) ;
		
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
	 *  @param 	$A		The application configuration
	 * 	@param 	$a 		A number to compare for ordering
	 * 	@param 	$b		A number to compare for ordering
	 * 
	 * 	@return -1		$b is larger
	 * 	@return  0 		$a and $b are equal
	 * 	@return  1		$a is larger
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
 ?>
