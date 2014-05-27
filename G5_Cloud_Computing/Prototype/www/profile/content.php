<?php
	/**
	 *  @File			content.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This file holds the profile page
	 * 
	 * 	@changelog		
	 * 	3/20/14			Added the toolbar tabs to the profile page
	 *	2/25/14			Generated template
	 */
	 
	//	Define guard prevents acces unless from the index.php file at 
	//	this level
	if ( !defined( 'CONTENT_GUARD' ) ) 
		header( 'Location: ./' ) ;
		
	// Content begin
	$WGT[ 'CONFIG' ] = 'profile-generator.php' ;
	include( $A[ 'D_WGT' ].'toolbar-menu/index.php' ) ;
				
	echo 	'<div class="profile">' ;
			
				include( $A[ 'D_WGT' ].'toolbar-tabs/index.php' ) ;

	echo 	'</div>' ;
?>
