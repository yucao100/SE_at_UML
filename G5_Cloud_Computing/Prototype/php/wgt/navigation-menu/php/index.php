<?php

	/**
	 * This file contains the widget class
	 */
	 
	 if ( !defined( 'navigationMenu' ) )  {
		 
		define( 'navigationMenu' , TRUE ) ;
		 
		class navigationMenu {
			
			public function __construct( ) {
			
			}
			
		}
	}
	
	// create an instance of the widget
	
	$WGT['OBJ'] = new navigationMenu ;
?>
