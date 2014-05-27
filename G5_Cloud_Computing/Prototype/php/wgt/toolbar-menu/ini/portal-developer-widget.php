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
				
	$WGT[ 'MENU' ][ 'TTL' ][ $WGT[ 'COUNTER' ] ] = 'Widgets' ;
	$WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COUNTER' ] ] = array( ) ;
	
	//look up all widgets
	$item = getDirectoryList( $A , $A[ 'D_WGT' ] ) ;
	foreach( $item as $entryName )
		array_push( $WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COUNTER' ] ] , array( $A[ 'W_DEV' ] . 'phpWidget/?wgt='. $entryName	, $entryName , array( 'x' => 12 , 'y' => 7 ) ) ) ;
	
	// next menu item
	$WGT[ 'COUNTER' ]++ ;
	
	
?>
