<?php
	/**
	 *  @File			index.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This file initializes the system
	 * 
	 * 	@changelog		
	 *	4/21/14			Modified order of requires_once statements to 
	 * 					allow for getRoot function
	 * 	2/25/14			wrote file			
	 */	

	// File Access Guard
	define( 'CONTENT_GUARD' , TRUE ) ;
	
	// Load the local library for path resoloution
	include( './localLib.php' ) ;
	
	// 	Resolve root paths
	$A = getRoot( __DIR__ ) ;
	
	//	Set content for index
	$A[ 'CONTENT' ] = 'content.php' ;
	
	// 	Including application navigation paths
	include( $A[ 'D_ROOT' ].'ini\\paths.php' ) ;
	
	//	Including the application library
	include( $A[ 'D_LIB' ].'library.php' ) ;

	//	Including the application api
	include( $A[ 'D_API' ].'api.php' ) ;	
		
	//	Including the application configuration file
	include( $A[ 'D_INI' ].'config.php' ) ;

	//	Error reporting true for on false for off
	//	This triggers error 500 failure for AJAX calls
	errorsOn( false ) ;
	
	//  Begin page processing
	include( $A[ 'D_TMP' ].'page.php' ) ; 
	
?>
