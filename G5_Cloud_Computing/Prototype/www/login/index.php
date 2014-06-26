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
	
	////
	//	RESOLVE PATHS
	////
	
	// Load the local library for path resoloution
	include( './localLib.php' ) ;
	
	// 	Resolve root paths
	$A = getRoot( __DIR__ ) ;
	
	// 	Including application navigation paths
	include( $A[ 'D_ROOT' ].'ini\\paths.php' ) ;
	
	////
	//	INCLUDES
	////
	$A[ 'SECURE' ] = false ;	
	$A[ 'ACCESS' ] = array( 'ALL' ) ;
	include( $A[ 'D_TMP' ].'includes.php' ) ;

	////
	//	FUNCTION TRIGGERS	
	////

	//	Error reporting true for on false for off
	errorsOn( false ) ;

	////
	//	PAGE CALLING
	////
	
	//	Set content for index
	$A[ 'CONTENT' ] = 'content.php' ;
	
	//  Begin page processing
	include( $A[ 'D_TMP' ].'page.php' ) ; 
	
	
?>
