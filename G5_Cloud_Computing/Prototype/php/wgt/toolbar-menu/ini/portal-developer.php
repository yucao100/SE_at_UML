<?php

	/**
	 * This is the widgets configuration file
	 */
	 
	// Setup widget Paths

	$WGT[ 'SRC' ] =  $WGT[ 'DIR' ] . 'src\\' ;
	$WGT[ 'BIN' ] =  $WGT[ 'DIR' ] . 'bin\\' ;
	$WGT[ 'INI' ] =  $WGT[ 'DIR' ] . 'ini\\' ;
	$WGT[ 'PHP' ] =  $WGT[ 'DIR' ] . 'php\\' ;
	
	// Initialize widget object
	
	$WGT[ 'OBJ' ] = NULL ;
	
	// Menu Configuration
	// $WGT[ 'MENU' ][ 'TTL' ][ $COL ] = Title' ;
	// $WGT[ 'MENU' ][ 'LNK' ][ $COL ] = array( array( 'IMG' , 'JS' , 'TITLE' ) ) ;
				
	$WGT[ 'MENU' ][ 'TTL' ][ $WGT[ 'COUNTER' ] ] = 'Tools' ;
	$WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COUNTER' ] ] = array( array( $A[ 'W_DEV' ] . 'phpWidget/'	, 'phpWidget', array( 'x' => 11 , 'y' => 7 ) ) ,
														  array( NULL 	, NULL 	 	, NULL ) ,
														  array( $A[ 'W_DEV' ] . 'phpMyAdmin/'	, 'phpMyAdmin', array( 'x' => 11 , 'y' => 7 ) ) ) ;
	
	$WGT[ 'COUNTER' ]++ ;
	

	
?>
