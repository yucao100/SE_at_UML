<?php
	/**
	 *  @File			content.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This file holds the phpWidget tool
	 * 
	 * 	@changelog		
	 * 	4/20/14			Moved the functions found here to the library, 
	 * 					organized the file, and cleaned it up
	 * 	2/25/14			Wrote the widget tool
	 */	
	 
	//	Define guard prevents acces unless from the index.php file at 
	//	this level
	if ( !defined( 'CONTENT_GUARD' ) ) 
		header( 'Location: ./' ) ;
		
	// Content begin
	
	$WGT[ 'CONFIG' ] = array( 'portal-developer.php' , 'portal-developer-widget.php' , 'portal-developer-widget-configuration.php' ) ;
	include( $A[ 'D_WGT' ].'toolbar-menu/index.php' ) ;
	
	include( $A[ 'D_WGT' ].'dev-php-widget\\index.php' ) ;
?>
