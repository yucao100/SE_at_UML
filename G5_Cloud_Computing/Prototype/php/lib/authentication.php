<?php
	/**
     *  @File           authenticate.php
     *  @Authors        Jose Flores
     *                  jose.flores.152@gmail.com
     *  
     *  @Description    This file holds the authenticate class, it 
     * 					manages website lauthentication
     * 
     *  @changelog      
     *  6/25/14			Compiled loose functions into a class
     * 					
     */
	
    //  DEFINE GUARD
    if ( !defined( 'class_authentication' ) )  {
        
        define( 'class_authentication' , TRUE ) ;

		
		/**
		 * 	authentication
		 * 
		 * 	This is the authentication class it handles user authentication
		 * 	to the web part of the website not the api, The api is intended 
		 * 	for MFA devices
		 * 
		 * 	$A			Holds the Application globals
		 */
		class authentication {

			private $A ;
			private $user ;
			
			/**
			 * 	__construct
			 * 	
			 * 	This function kicks off authentication
			 * 
			 * 	$A				The application Globals
			 * 	$bool_secure	Wether security is enabled for the 
			 * 					landing page and subsequent pages
			 */ 
			 public function __construct( $A ) {
				
				$this->A = $A ;
				
				// Security is not required
				if ( $A[ 'SECURE' ] ) {

					// Security required
					$this->user = new user( $A , null , true ) ;
					
					// perform authentication
					$id = $this->authenticate() ;				
					
					// Authenticate user
					define( 'CURRENT_USER_ID' , $id ) ;
				}

			 }
			 
			/**
			 * 	deauthenticate
			 * 
			 * 	This function terminates a session.
			 * 
			 * 	@param $A	the application variable
			 */                
			public function deauthenticate( ) {
				
				$this->user->manage( 'SESSION' , 'STOP' ) ;	
				
			}
			
			/**
			 * 	authenticate
			 * 
			 * 	This function authenticates a user or redirects them to a target 
			 * 	page 
			 * 
			 * 	@param	$A
			 * 	@param 	$secure
			 * 	@param	$target
			 * 	@param 	$form
			 *
			 * 	@return	
			 */
			public function authenticate( ) {
					
				// Redirect possibilities
				$login = 'Location: ' . $this->A[ 'W_ROOT' ].'login' ;
				
				$session =  $this->user->manage( 'SESSION' , 'INFO' ) ;
				
				// has session cookie
			
				if ( $session[ 'session_active' ] == 1 ) {
					 // has valid session token
					 				 
					 $DB = new mysql( $this->A ) ;
					 
					 $table = 'csr_usr_account' ;
					 $keyPairs = array( 'usr_email' => $session[ 'usr_email' ] ) ;
					 $operators = array( '==' ) ;
					 
					 $result = $DB->select( $table , $keyPairs , $operators ) ;	
					 
					 $row = $result->fetch_assoc() ;				 

					 return $row[ 'id' ] ;
					 
				}
				
				$this->deauthenticate( ) ;
				
				if ( $session[ 'session_active' ] == 2 ) {
					 // not registered
					 header( $registration ) ;
				}
							
				header( $login ) ;
			}
		}
	}

?>
