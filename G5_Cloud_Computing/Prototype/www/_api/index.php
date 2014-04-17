<?php
	////
	// 	INCLUDES
	////
	
	// 	Load Configuration File
	$basePath = dirname(__FILE__) ;
	include( $basePath."/../../ini/config.php" ) ;	
		
	// 	Load API
	require_once( $A[ 'D_API' ].'api.php' ) ; 	
	
	// 	Load Library Functions
	require_once( $A[ 'D_LIB' ].'library.php' ) ; 	
		
	
	////
	// 	AJAX BEGINS
	////
	
	/*
	 * Structuring information
	 * 		Processing Functions can be found in the Library
	 * 		API Actions are in the API
	 * 
	 * Reserved Orders
	 * 		[-INF , 0 ] 
	 * 
	 * For a list of available calls use LIST as the call value
	 * 
	 * Example JSON string 
	 * 
	 * [	
	 * 		{ "order":"1",
	 * 		  "call":"api_function_name",
	 * 		  "parameter":[
	 * 				"value5",
	 * 				"value6"
	 * 		  ]
	 * 		},
	 * 		{ "order":"2",
	 * 		  "call":"api_function_name",
	 * 		  "parameter":[
	 * 				"value5",
	 * 				"value6"
	 * 		  ]
	 * 		}
	 * ]
	 * 
	 */
	 

	
	// TO BE TURNED INTO A JSON REQUEST call WGT
	// if an ajax call from the website, temporary until it is converted 
	// to an api call
	if ( isset( $_POST[ 'ACTION' ] ) ) {
		switch ( $_POST[ 'ACTION' ] ) {
			case 'PROFILE' :	
				include( $A[ 'D_WGT' ].'profile-generator/index.php' ) ;
				return ;

			default : return ;
		}
	}
	
	 
	//  JSON API Processing
	if ( isset( $_POST[ 'JSON' ] ) ){
		echo processJson( $A , $_POST[ 'JSON' ] ) ;
	}
	
	//  JSON API Processing
	else if ( isset( $_GET[ 'JSON' ] ) ) {
		echo processJson( $A , $_GET[ 'JSON' ] ) ;
	}
	

?>
