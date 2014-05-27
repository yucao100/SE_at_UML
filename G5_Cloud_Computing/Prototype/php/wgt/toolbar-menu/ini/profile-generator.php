<?php
	// Menu Configuration
	// $WGT[ 'MENU' ][ 'TTL' ][ $COL ] = Title' ;
	// $WGT[ 'MENU' ][ 'LNK' ][ $COL ] = array( array( 'IMG' , 'JS' , 'TITLE' ) ) ;
		
		
	$WGT[ 'MENU' ][ 'TTL' ][ $WGT[ 'COUNTER' ] ] = 'File' ;
	$WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COUNTER' ]++ ] = array( array( 0 		, 'New' 	, array( 'x' => 1 , 'y' => 8 ) ) ,
										  array( 1 		, 'Open' 	, array( 'x' => 1 , 'y' => 6 ) ) ,
										  array( 2 		, 'Close' 	, array( 'x' => 5 , 'y' => 8 ) ) ,
										  array( 11 	, 'Save' 	, array( 'x' => 6 , 'y' => 7 ) ) ,
										  array( 11 	, 'Mom' 	, array( 'x' => 6 , 'y' => 7 ) ) ,
										  array( NULL 	, NULL 	 	, NULL ) ,
										  array( 3 		, 'Exit' 	, array( 'x' => 10 , 'y' => 0 ) ) ) ;
	
	$WGT[ 'MENU' ][ 'TTL' ][ $WGT[ 'COUNTER' ] ] = 'Edit' ;
	$WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COUNTER' ]++ ] = array( array( 4 		, 'Undo' 	, array( 'x' => 0 , 'y' => 4 ) ) ) ;
	
	
	$WGT[ 'MENU' ][ 'TTL' ][ $WGT[ 'COUNTER' ] ] = 'View' ;
	$WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COUNTER' ]++ ] = array( array( 5 		, 'Graphs' 	, array( 'x' => 13 , 'y' => 8 ) ) ) ;
	
	$WGT[ 'MENU' ][ 'TTL' ][ $WGT[ 'COUNTER' ] ] = 'Tools' ;
	$WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COUNTER' ]++ ] = array( array( 6 		, 'Settings', array( 'x' => 12 , 'y' => 7 ) ) ) ;
	
	$WGT[ 'MENU' ][ 'TTL' ][ $WGT[ 'COUNTER' ] ] = 'Devices' ;
	$WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COUNTER' ]++ ] = array( array( 7 		, 'Android' , array( 'x' => 15 , 'y' => 14 ) ) ,
										  array( 8 		, 'Kinect' 	, array( 'x' => 15 , 'y' => 14 ) ) ) ;
	
	$WGT[ 'MENU' ][ 'TTL' ][ $WGT[ 'COUNTER' ] ] = 'Help' ;
	$WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COUNTER' ]++ ] = array( array( 10 	, 'Help' 	, array( 'x' => 3 , 'y' => 9 ) ) ,
										  array( NULL 	, NULL 	 	, NULL ) ,
										  array( 9 		, 'About' 	, array( 'x' => 1 , 'y' => 9 ) ) ) ;
?>
