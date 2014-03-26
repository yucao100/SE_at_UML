<?php

	/**
	 * This file contains the widget class
	 */
	
	if ( !defined( 'toolbarTabs' ) )  {
		
		define( 'toolbarTabs' , TRUE ) ;
		
		class toolbarTabs {
			
			public function __construct( ) {
			
			}
			
		}
	
	}
	
	// create an instance of the widget
	
	$WGT['OBJ'] = new toolbarTabs ;
?>
