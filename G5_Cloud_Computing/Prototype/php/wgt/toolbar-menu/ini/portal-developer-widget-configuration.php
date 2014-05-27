<?php

	/**
	 * This is the widgets configuration file
	 */
	 
	// Menu Configuration
	// $WGT[ 'MENU' ][ 'TTL' ][ $COL ] = Title' ;
	// $WGT[ 'MENU' ][ 'LNK' ][ $COL ] = array( array( 'IMG' , 'JS' , 'TITLE' ) ) ;
	
	if ( isset( $_GET[ 'wgt' ] ) ) {			
		$WGT[ 'MENU' ][ 'TTL' ][ $WGT[ 'COUNTER' ] ] = 'Configurations' ;
		$WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COUNTER' ] ] = array( ) ;

		
		//look up all widgets configurations
		$item = getDirectoryList( $A , $A[ 'D_WGT' ].$_GET[ 'wgt' ].'//ini' ) ;

		foreach( $item as $entryName ){
			if ( $entryName != 'config.php' && $entryName != 'paths.php' ) {
				$WGT[ 'tmp' ] = array( $A[ 'W_DEV' ] . 'phpWidget/?wgt='. $_GET[ 'wgt' ] . '&cfg=' . $entryName , $entryName , array( 'x' => 15 , 'y' => 7 ) ) ;
				array_push( $WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COUNTER' ] ] , $WGT[ 'tmp' ] ) ;
			}
		}
	}
	
	// next menu item
	$WGT[ 'COUNTER' ]++ ;
	
	
?>
