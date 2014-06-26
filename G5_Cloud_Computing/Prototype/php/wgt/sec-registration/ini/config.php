<?php

	/**
	 * This is the widgets configuration file
	 */
	 
	// Initialize widget object
	
	$WGT[ 'OBJ' ] = NULL ;
	
	// Initial Counter
	$WGT[ 'COUNTER' ] = 0 ;
	
	$WGT[ 'FIELDS' ] = array( array( array( 'need' => true , 'type' => 'text' , 'size' => 25 , 'id' => 'usr_email'  , 	 		'value' => 'Email' ) ) ,
							  array( array( 'need' => true , 'type' => 'text' , 'size' => 25 , 'id' => 'usr_name_first' ,  		'value' => 'First Name' ) ) ,
							  array( array( 'need' => false , 'type' => 'text' , 'size' => 25 , 'id' => 'usr_name_middle' , 	 	'value' => 'Middle Name' ) ) ,
							  array( array( 'need' => true , 'type' => 'text' , 'size' => 25 , 'id' => 'usr_name_last' , 	 	'value' => 'Last Name' ) ) ,
							  array( array( 'need' => true , 'type' => 'password' , 'size' => 25 , 'id' => 'usr_pwd_1' , 		 	'value' => 'Password' ) ) ,
							  array( array( 'need' => true , 'type' => 'password' , 'size' => 25 , 'id' => 'usr_pwd_2' , 		 	'value' => 'Confirm Password' ) ) ,
							  array( array( 'need' => true , 'type' => 'calendar' , 'size' =>  0 , 'id' => 'usr_dob' , 		 		'value' => 'YYYY MM DD' ) ) ,
							  array( array( 'need' => true , 'type' => 'text' , 'size' =>  3 , 'id' => 'usr_phone_country' , 	'value' => 'Phone' ) ,
								     array( 'need' => true , 'type' => 'text' , 'size' =>  3 , 'id' => 'usr_phone_area' , 		'value' => ' ( ' ) ,
								     array( 'need' => true , 'type' => 'text' , 'size' =>  3 , 'id' => 'usr_phone_number_1' , 	'value' => ' ) ' ) ,
								     array( 'need' => true , 'type' => 'text' , 'size' =>  4 , 'id' => 'usr_phone_number_2' , 	'value' => ' - ' ) ,
								     array( 'need' => false , 'type' => 'text' , 'size' =>  4 , 'id' => 'usr_phone_ext' , 		'value' => 'EXT' ) ) ) ;
								  
?>
