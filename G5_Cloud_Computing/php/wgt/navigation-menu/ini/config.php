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
	
	// Navigatiopn Menu links
	$WGT[ 'MENU' ] = array( array( $A[ 'W_ROOT' ] , 'Home' ) ,
							array( $A[ 'W_ROOT' ] . 'about' , 'About' ) ,
							array( $A[ 'W_ROOT' ] . 'contact' , 'Contact' ) ,
							array( $A[ 'W_ROOT' ] . 'profile' , 'Profile' ) ,
							array( $A[ 'W_ROOT' ] . 'register' , 'register/login' ) ) ;
	
?>
