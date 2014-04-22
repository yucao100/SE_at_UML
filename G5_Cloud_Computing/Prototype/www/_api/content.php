<?php
	/**
	 *  @File			content.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This file holds the ajax processing catch
	 * 
	 * 	@changelog		
	 *	4/20/14			Moved the catch to content file of that _api
	 */
	 
	//	Define guard prevents acces unless from the index.php file at 
	//	this level
	if ( !defined( 'CONTENT_GUARD' ) ) 
		header( 'Location: ./' ) ;
		
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
	 * 		  "values":[
	 * 				"value5",
	 * 				"value6"
	 * 		  ]
	 * 		}
	 * ]
	 * 
	 */	
	 
	header( 'Content-Type: application/json' ) ;

	//  JSON API Processing
	if ( isset( $_POST[ 'JSON' ] ) ){
		echo processJson( $A , $_POST[ 'JSON' ] ) ;
	}
	
	//  JSON API Processing
	else if ( isset( $_GET[ 'JSON' ] ) ) {
		echo processJson( $A , $_GET[ 'JSON' ] ) ;
	}
	
?>