<?php

	// Menu Configuration
	// $WGT[ 'MENU' ][ 'TTL' ][ $COL ] = Title' ;
	// $WGT[ 'MENU' ][ 'LNK' ][ $COL ] = array( array( 'IMG' , 'JS' , 'TITLE' ) ) ;
		
	
		
	$WGT[ 'MENU' ][ 'TTL' ][ $WGT[ 'COUNTER' ] ] = 'File' ;
	$WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COUNTER' ]++ ] = array( array( 0 		, 'New' 	, array( 'x' => 1 , 'y' => 8 ) ) ,
										  array( 1 		, 'Open' 	, array( 'x' => 1 , 'y' => 6 ) ) ,
										  array( 2 		, 'Close' 	, array( 'x' => 5 , 'y' => 8 ) ) ,
										  array( 11 	, 'Save' 	, array( 'x' => 6 , 'y' => 7 ) ) ,
										  array( NULL 	, NULL 	 	, NULL ) ,
										  array( 3 		, 'Exit' 	, array( 'x' => 10 , 'y' => 0 ) ) ) ;
	
	$WGT[ 'MENU' ][ 'TTL' ][ $WGT[ 'COUNTER' ] ] = 'Edit' ;
	$WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COUNTER' ]++ ] = array( array( 4 		, 'Undo' 	, array( 'x' => 0 , 'y' => 4 ) ) ) ;

	$WGT[ 'MENU' ][ 'TTL' ][ $WGT[ 'COUNTER' ] ] = 'Microsoft' ;
	$WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COUNTER' ]++ ] = array( array( 4 		, 'Undo' 	, array( 'x' => 0 , 'y' => 4 ) ) ) ;
	
	$WGT[ 'MENU' ][ 'TTL' ][ $WGT[ 'COUNTER' ] ] = 'Nokia' ;
	$WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COUNTER' ]++ ] = array( array( 4 		, 'Undo' 	, array( 'x' => 0 , 'y' => 4 ) ) ) ;
	
	$WGT[ 'MENU' ][ 'TTL' ][ $WGT[ 'COUNTER' ] ] = 'UML' ;
	$WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COUNTER' ]++ ] = array( array( 4 		, 'Undo' 	, array( 'x' => 0 , 'y' => 4 ) ) ) ;
	
	
	
?>
