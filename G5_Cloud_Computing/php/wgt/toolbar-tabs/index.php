<?php
	/**
	 * This file setups the widget 
	 */
	
	////
	//  get the widget name
	////
	$WGT[ 'DIR' ] =  dirname(__FILE__) . '\\' ;
	
	////
	// Fetch Parameters
	////
	if ( isset( $WGT[ 'ARGV' ] ) ) {
		$WGT[ 'ARGC' ] = sizeof( $WGT[ 'ARGV' ] ) ;
	}
	else {
		$WGT[ 'ARGV' ] = NULL ;
		$WGT[ 'ARGC' ] = 0 ;
	}
	
	////
	// Set config default configuration if none
	////
	if ( !isset( $WGT[ 'CONFIG' ] ) ) {
		$WGT[ 'CONFIG' ] = 'config.php' ;
	}
	
	////
	// get the widget configuration
	////
	include( $WGT[ 'DIR' ] . 'ini\\' . $WGT[ 'CONFIG' ] ) ;
	
	////
	// get the widget object and create an instance
	////
	include( $WGT[ 'PHP' ] . 'index.php' ) ;
	
	////
	// execute the widget
	////
	include( $WGT[ 'BIN' ] . 'index.php' ) ;
	
	////
	// destroy the widget object
	////
	unset( $WGT ) ;
	
?>
