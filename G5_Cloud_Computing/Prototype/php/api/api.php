<?php

	if ( !defined( 'api' ) )  {
		
		define( 'api' , TRUE ) ;
		
		class api {
			
			public function __construct( ) {}
			
			// MYSQL FUNCTIONS
			 
			private function mysqlAdd( $database , $table , $field , $value ) {}
					
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
			
			private function commentAdd() {}
					
			private function commentDrop() {}
			
			private function commentEdit() {}
			
			private function commentGet() {}
			
			
		}
	
	}
?>
