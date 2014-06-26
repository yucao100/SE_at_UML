<?php
	/**
	 *  @File			content.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This file holds the about page
	 * 
	 * 	@changelog		
	 *	6/4/14			created error page
	 */
	 
	//	Define guard prevents acces unless from the index.php file at 
	//	this level
	if ( !defined( 'CONTENT_GUARD' ) ) 
		header( 'Location: ./' ) ;
		
	// Content begin
	if ( isset( $_GET[ 'error' ] ) ) {
		echo 'ERROR:' , $_GET[ 'error' ] ;
	}
	else {
		echo 'ERROR' ;
	}

?>
