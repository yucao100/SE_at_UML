<?php
	/**
	 *  @File			content.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This file holds the about page
	 * 
	 * 	@changelog		
	 *	2/25/14			added iframe
	 */
	 
	//	Define guard prevents acces unless from the index.php file at 
	//	this level
	if ( !defined( 'CONTENT_GUARD' ) ) 
		header( 'Location: ./' ) ;
		
	// Content begin
	echo '<iframe src="https://sites.google.com/site/utcbmi/computational-sensing-csr/time-tracker-csr" style="width:100%; height:100%;"></iframe>' ;
?>
