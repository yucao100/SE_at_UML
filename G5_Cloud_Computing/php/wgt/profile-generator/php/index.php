<?php

	/**
	 * This file contains the widget class
	 */
	 
	if ( !defined( 'profileGenerator' ) )  {
		
		define( 'profileGenerator' , TRUE ) ; 
	 
		class profileGenerator {
			
			public function __construct( ) {}
			
			public function profileStart() {}
		
			public function profileNameCardStart() {}
			public function profilePicture() {}
			public function profileInformation(){}
			public function profileNameCardEnd() {}
		
			public function profileRecordStart() {}
			public function profileRecordInput() {}
			public function profileRecord() {}
			public function profileRecordEnd(){}
		
			public function profileGraphsStart() {}	
			public function profileGraphs() {}
			public function profileGraphsEnd() {}
			
			public function profileEnd() {}
		}
	}
	
	// create an instance of the widget
	
	$WGT['OBJ'] = new profileGenerator ;
?>
