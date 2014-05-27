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
	if ( isset( $WGT[ 'ARGV' ] ) && !is_array( $WGT[ 'ARGV' ] ) ) {
			
		$WGT[ 'ARGV' ] = explode( ',' , $WGT[ 'ARGV' ]  ) ;
		$WGT[ 'ARGV' ] = $WGT[ 'ARGV' ] ;
		
	}
	else {
		$WGT[ 'ARGV' ] = NULL ;
	}
	
	$WGT[ 'ARGC' ] = sizeof( $WGT[ 'ARGV' ] ) ;
	
	////
	// Set config default configuration if none
	////
	
	// Check if config param exists and is an array
	if ( isset( $WGT[ 'CONFIG' ] ) && 
		!is_array( $WGT[ 'CONFIG' ] ) ) {
			// turn it into an array
			$WGT[ 'CONFIG' ] = array( $WGT[ 'CONFIG' ] ) ;
	}
	
	// if it doesnt exists add minimum reqs
	if ( !isset( $WGT[ 'CONFIG' ] ) ) {
		$WGT[ 'CONFIG' ] = array( 'paths.php' , 'config.php' ) ;
	}
	// if it does exist prepend minimum reqs
	else {
		array_unshift( $WGT[ 'CONFIG' ] , 'paths.php' , 'config.php' ) ;
	}
	
	
	////
	// get the widget configuration
	////
	foreach ( $WGT[ 'CONFIG' ] as $tmp )
		include( $WGT[ 'DIR' ] . 'ini\\' . $tmp ) ;

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
