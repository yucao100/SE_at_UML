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
	
	// Sub Id of the widget, prefixed to all fields for instance uniqueness
	$WGT[ 'id' ] = 'contact-form' ;
	
	// creates input text boxes with TITLE , id extension , hidden
	$WGT[ 'lines' ] =  array( array( 'Name' 	, 'name' 	, false) , 
							  array( 'Email' 	, 'email' 	, false) , 
							  array( 'Subject' 	, 'subject' , false) ) ;
							  
	
	
?>
