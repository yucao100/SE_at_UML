<?php
    /**
     *  @File           cookie.php
     *  @Authors        Jose Flores
     *                  jose.flores.152@gmail.com
     *  
     *  @Description    This class holds all the cookie management functions
     * 
     *  @changelog      
     *  5/25/14         Created
     */

    //  DEFINE GUARD
    if ( !defined( 'class_cookie' ) )  {
        
        define( 'class_cookie' , TRUE ) ;
        
        /**
         *  cookie
         * 
         *  This is tha cookie class it will be used to hold client side 
         * 	session information, such as an authentication token
         */
        class cookie {
            
            // 	VARIABLES
 
            private $A ;		//	The Global Settings and Paths       
             
            private $secure ; 
            private $expire ;
            private $path ;
            private $domain ;
            
            private $debug  = true ;
            
			//  CONSTRUCTOR
			
			/**
             *  __construct
             * 
             *  This function creates an instance of the user class
             * 
             *  @param  $A      	The global configuration
             *  @param  $secure 	Wether to use https or http
             * 	@param 	$expire		Cookie expiration date
             * 	@param 	$path		server path access
             * 	@param 	$domain		domain access
             */ 
            public	 function __construct( $A , 
										  $secure = false , 
										  $expire = null , 
										  $path = '/' , 
										  $domain = null ) {
				// Set up class environment
				$this->A      = $A ;		
				$this->secure = $secure ;	
				$this->expire = $expire ;	
				$this->path   = $path ;
				$this->domain = $domain ;
			}
			/**
			 * 	setCookie
			 * 
			 * 	This function sets a cookie 
			 * 
			 * 	@param	$C			an array of values including the 
			 * 						key => value pairs : name, value
			 * 
			 * 	@return true
			 * 	@return false
			 */
			private	function setCookie( $C ){
				//	validate variables
				if ( !( isset( $C[ 'name' ] ) && isset( $C[ 'value' ] ) ) )
					return 1 ;
				
				//	create the cookie	
				setcookie( $C[ 'name' ] , 	// the name of the cookie
						   $C[ 'value' ] , 	// the token value	
						   $this->expire , 	// the length of the cookie
						   $this->path , 	// the server path of the cookie
						   $this->domain , 	// the domain that the cookie is for
						   $this->secure ) ;// true for https 
				
				// Validate cookie was created
				//-> There is an error during validation, newly created 
				//   cookies will not be in the session variable yet and 
				//   therefore they cant be found
				
				//if ( $this->getCookie( $C ) == null ) 
				//	return 2 ;
					
				// return success
				return 0 ;
			}
			/**
			 * 	getCookie
			 * 
			 * 	This function returns the cookie
			 * 
			 * 	@param 	$C			an array of values including the 
			 * 						key => value pairs : name
			 * 
			 * 	@return string		the value of the cookie
			 * 	@return null		the cookie was not found
			 */ 
			private	function getCookie( $C ) {
				//validate parameters
				if ( !( isset( $C[ 'name' ] ) ) )
					return null ;

				// search for cookie
				if ( !isset( $_COOKIE[ $C[ 'name' ] ] ) ) 
					// not found
					return null ;

				// return success
				return $_COOKIE[ $C[ 'name' ] ] ;
			}
			/**
			 * 	delCookie
			 * 
			 * 	This function deletes a cookie by expiring it
			 * 
			 * 	@param	$C			an array of values including the 
			 * 						key => value pairs : name
			 * 
			 * 	@return true		cookie was deleted
			 * 	@return false		cookie was not deleted
			 */
			private	function delCookie( $C ) {
				
				// check if key is present
				if ( !( isset( $C[ 'name' ] ) ) )
					return false ;
				
				// expire cookie
				setcookie( $C[ 'name' ] , 	// the name of the cookie
						   null , 			// the token value	
						   time() - 1 , 	// the length of the cookie
						   $this->path , 	// the server path of the cookie
						   $this->domain , 	// the domain that the cookie is for
						   $this->secure ) ;// true for https 
				
				// check that cookie was expired
				if ( $this->getCookie( $C[ 'name' ] ) != null )
					return false ;
				
				// return success				
				return true ;
			}
			
			////
			//PUBLIC METHOD
			////
			
			/**
			 * 	manage
			 * 
			 * 	This function manages the cookies 
			 * 
			 * 	@param	$action		The action
			 * 						SET
			 * 						GET
			 * 						DELETE
			 * 	@param 	$C			The optional paramers
			 *
			 * 	@return true		succesfull completion
			 * 	@return false		failure
			 * 	@return null		invalid cookie
			 * 	@return string		The cookies value
			 */ 	
			public function manage( $action , $C = null ) {
				
				if ( $C == null ) 
					return false ;
				
				// switch of avalilable options
				switch( $action ) {
					case 'SET' : 
						return $this->setCookie( $C ) ;
					case 'DELETE' : 
						return $this->delCookie( $C ) ;
					case 'GET' : 
						return $this->getCookie( $C ) ;
					default : return null ;
				}
				
			}
           
		}
	}
?>
