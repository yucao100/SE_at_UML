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
		
		
	$WGT[ 'MENU' ][ 'TTL' ][ 0 ] = 'File' ;
	$WGT[ 'MENU' ][ 'LNK' ][ 0 ] = array( array( 0 		, 'New' 	, array( 'x' => 1 , 'y' => 8 ) ) ,
										  array( 1 		, 'Open' 	, array( 'x' => 1 , 'y' => 6 ) ) ,
										  array( 2 		, 'Close' 	, array( 'x' => 5 , 'y' => 8 ) ) ,
										  array( 11 	, 'Save' 	, array( 'x' => 6 , 'y' => 7 ) ) ,
										  array( 11 	, 'Mom' 	, array( 'x' => 6 , 'y' => 7 ) ) ,
										  array( NULL 	, NULL 	 	, NULL ) ,
										  array( 3 		, 'Exit' 	, array( 'x' => 10 , 'y' => 0 ) ) ) ;
	
	$WGT[ 'MENU' ][ 'TTL' ][ 1 ] = 'Edit' ;
	$WGT[ 'MENU' ][ 'LNK' ][ 1 ] = array( array( 4 		, 'Undo' 	, array( 'x' => 0 , 'y' => 4 ) ) ) ;
	
	
	$WGT[ 'MENU' ][ 'TTL' ][ 2 ] = 'View' ;
	$WGT[ 'MENU' ][ 'LNK' ][ 2 ] = array( array( 5 		, 'Graphs' 	, array( 'x' => 13 , 'y' => 8 ) ) ) ;
	
	$WGT[ 'MENU' ][ 'TTL' ][ 3 ] = 'Tools' ;
	$WGT[ 'MENU' ][ 'LNK' ][ 3 ] = array( array( 6 		, 'Settings', array( 'x' => 12 , 'y' => 7 ) ) ) ;
	
	$WGT[ 'MENU' ][ 'TTL' ][ 4 ] = 'Devices' ;
	$WGT[ 'MENU' ][ 'LNK' ][ 4 ] = array( array( 7 		, 'Android' , array( 'x' => 15 , 'y' => 14 ) ) ,
										  array( 8 		, 'Kinect' 	, array( 'x' => 15 , 'y' => 14 ) ) ) ;
	
	$WGT[ 'MENU' ][ 'TTL' ][ 5 ] = 'Help' ;
	$WGT[ 'MENU' ][ 'LNK' ][ 5 ] = array( array( 10 	, 'Help' 	, array( 'x' => 3 , 'y' => 9 ) ) ,
										  array( NULL 	, NULL 	 	, NULL ) ,
										  array( 9 		, 'About' 	, array( 'x' => 1 , 'y' => 9 ) ) ) ;
	
?>
