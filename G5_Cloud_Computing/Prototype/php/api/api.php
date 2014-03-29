<?php

	if ( !defined( 'api' ) )  {
		
		define( 'api' , TRUE ) ;
		
		class api {
			
			public function __construct( ) {}
			
			// MYSQL FUNCTIONS
			
			/**
			 * name
			 * 
			 * about
			 * 
			 * @param var1 		definition 
			 * 
			 * @return	0
			 * @return	1		explain
			 * 
			 * @throws
			 */ 
			private function mysqlAdd( $database , $table , $field , $value ) {
			
				//  CHANGE LOG
				//	DATE	AUTHOR 		MOD
				/*	
				 * 
				 */
				 
				// 	VARIABLES
				/*  varOne
				 * 	CONST_ANTS 
				 */
				
				// 	CODE
				
				
			}
					
			private function mysqlDrop( $database , $table , $field ) {}
			
			private function mysqlEdit( $database , $table , $field , $value ) {}
			
			private function mysqlGet( $database , $table , $field ) {}
			
			private function mysqlAuthenticate( $database , $table , $userID , $password ) {}
			
			// USER FUNCTIONS
			
			private function userAdd() {}
					
			private function userDrop() {}
			
			private function userEdit() {}
			
			private function userGet() {}
			
			private function userLogin( $userID , $password ) {}
			
			private function userLogout( $userID ) {}
			
			// GRAPHING FUNCTIONS
			
			
			// COMMENT FUNCTIONS
			
			public function commentAdd( $user , $target , $comment ) {}
					
			public function commentDrop() {}
			
			public function commentEdit() {}
			
			public function commentGet() {}
			
			
		}
	
	}
?>
