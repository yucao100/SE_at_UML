<?php

	/**
	 * This file contains the widget class
	 */
	
	if ( !defined( 'exampleWgt' ) )  {
		
		define( 'exampleWgt' , TRUE ) ;
		
		class exampleWgt {
			
			public function __construct( ) {
			
			}
			
		}
	}
	
	// create an instance of the widget
	
	$WGT['OBJ'] = new exampleWgt ;
?>
