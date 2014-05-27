<?php
	/**
	 *  @File			content.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This file holds the developer tools page
	 * 
	 * 	@changelog		
	 *	2/25/14			Generated template
	 */
	 
	//	Define guard prevents acces unless from the index.php file at 
	//	this level
	if ( !defined( 'CONTENT_GUARD' ) ) 
		header( 'Location: ./' ) ;
		
	// Content begin
	$WGT[ 'CONFIG' ] = array( 'portal-developer.php' ) ;
	include( $A[ 'D_WGT' ].'toolbar-menu/index.php' ) ;
?>
