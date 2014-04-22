<?php
	/**
	 *  @File			localLib.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This file holds the root finding function.
	 * 
	 * 	@changelog		
	 *	4/20/14			getRoot was added
	 */

	//	Define guard prevents acces unless from the index.php file at 
	//	this level
	if ( !defined( 'CONTENT_GUARD' ) ) 
		header( 'Location: ./' ) ;
	
	/**
	 * 	getRoot
	 * 
	 * 	This functioin resolves the root paths, it counts backwards until 
	 * 	the directories do not match. This function works because there 
	 * 	are no other virtual directories besides the root.
	 */
	function getRoot( $dir ) {
		$server = $_SERVER['SERVER_NAME'].$_SERVER[ 'REQUEST_URI' ] ;
		
		// generate an array of web directory folders
		// remove any variables
		$server = explode( '?' , $_SERVER['SERVER_NAME'].$_SERVER[ 'REQUEST_URI' ] );

		// remove the filename if present
		$server = explode( 'index.php' , $server[ 0 ] );

		// break up
		$server =  array_filter( explode( '/' , $server[ 0 ] ) ) ;

		// generate an array of system directory folders
		$dir = explode( '\\' , $dir  ) ;

		//get sizes of arrays
		$s = count( $server ) ;
		$d = count( $dir ) ;
	
		//	travers arrays in reverse
		for( $i = 0 ; $i < $d ; ++$i ) {
			// check for directory mismatch
			if ( $server[ $s - $i ] != $dir[ $d - $i ] ) {
				
				// generate root paths
				$root[ 'W_ROOT' ] = 'http://' ;
				for ( $j = 0 ; $j <= ( $s - $i ) ; ++$j ) 
					$root[ 'W_ROOT' ] .= $server[$j] . '/' ;
				
				for ( $j = 0 ; $j <= ( ( $d - $i ) - 1 ) ; ++$j ) 
					$root[ 'D_ROOT' ] .= $dir[$j] . '\\' ;

				// return root paths
				return $root ;
			}
		}
	}
?>
