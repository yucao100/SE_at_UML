<?php
	/**
	 *  @File			content.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This file holds the registration/ login page
	 * 
	 * 	@changelog		
	 * 	3/20/14			Added dummy registration form for presentation
	 *	2/25/14			Generated template
	 */
	 
	//	Define guard prevents acces unless from the index.php file at 
	//	this level
	if ( !defined( 'CONTENT_GUARD' ) ) 
		header( 'Location: ./' ) ;
		
	// Content begin
	include( $A[ 'D_WGT' ].'sec-Registration/index.php' ) ;
							
	
?>
