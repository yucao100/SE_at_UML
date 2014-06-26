<?php
    /**
     *  @File           token.php
     *  @Authors        Jose Flores
     *                  jose.flores.152@gmail.com
     *  
     *  @Description    This class holds all the token management functions
     * 
     *  @changelog  
     *  5/27/14			Added isToken and getToken, integrated with 
     * 					management function    
     *  5/25/14         Created
     */

    //  DEFINE GUARD
    if ( !defined( 'class_token' ) )  {
        
        define( 'class_token' , TRUE ) ;
        
        /**
         *  token
         * 
         *  This is the token class it will be used to generate session 
         * 	tokens
         * 
         * 	$A		The application globals
         */
        class token {
            
            // 	VARIABLES
 
            private $A ;		//	The Global Settings and Paths       
                         
			//  CONSTRUCTOR
			
			/**
             *  __construct
             * 
             *  This function creates an instance of the token class
             * 
             *  @param  $A      	The global configuration
             */ 
            public	 function __construct( $A ) {
				// Set up class environment
				$this->A      = $A ;
			}
			
			
			//  ENCRYPTION METHODS
            
            /**
             *  genSalt
             *  
             *  This function generates a salt for encryption of passwords.
             * 
             *  Salt should be generated using a Cryptographically Secure 
             *  Pseudo-Random Number Generator (CSPRNG). CSPRNGs are very 
             *  different than ordinary pseudo-random number generators, 
             *  like the "C" language's rand() function. As the name suggests, 
             *  CSPRNGs are designed to be cryptographically secure, meaning 
             *  they provide a high level of randomness and are completely 
             *  unpredictable. We don't want our salts to be predictable, 
             *  so we must use a CSPRNG. 
             * 
             *  http://php.net/manual/en/function.mcrypt-create-iv.php
             * 
             *  @return salt        The salt to be used in encryption
             */
            public function genSalt() {
                             
                //  the size of the initialized vector
                $size = mcrypt_get_iv_size( MCRYPT_CAST_256 , MCRYPT_MODE_CFB ) ;
                
                // returning the salt
                return bin2hex( mcrypt_create_iv( $size, MCRYPT_RAND ) ) ;
            }
            /**
             *  hash
             *  
             *  This function generates the secure password hash to be
             *  stored in a database    
             * 
             *  @param  $salt
             * 
             *  @return $hash
             */
            private function hash( $salt , $password ) {
			
                // limit to a list of secure algorithms
                switch( $this->A[ 'SEC' ][ 'HASH_ALG' ] ){
                    case 'sha256' : 
                    case 'sha512' : 
                       // generate the password hash
                       return hash( $this->A[ 'SEC' ][ 'HASH_ALG' ] , $salt.$password ) ;
                    default :
                          // disallow the chosen algorithm, and return nothing
                       
                        return null ;
                }   
            }
            
            /**
             * 	getToken
             * 
             * 	This function returns a new unused token
             * 
             * 	@return	string		new token
             */
			private function getToken( ) {
				
				// This loop genereates a unique session key from two 
                // cryptographically secure random salts
                do {
					$s1 = $this->genSalt() ;
					$s2 = $this->genSalt() ;
					$token = $this->hash( $s1 , $s2 ) ;       
                
                } while ( $this->isToken( $token ) ) ;
                
				return $token ;
			}
			
			/**
			 * 	isToken
			 * 
			 * 	This function checks to see if the token has been used
			 * 
			 * 	@param	$token		The hash token to check
			 * 
			 * 	@return	true		The token is in use 
			 * 	@return false		The token is not in use 
			 */
			private function isToken( $token ) {
				
				// Setting up query
				$keyPairs = array( 'tok_string' => $token ) ;
				$operators = array( '==' );
				$table = 'csr_usr_token' ;

				// querying the token
				$DB = new mysql( $this->A ) ;
                $result = $DB->select( $table , $keyPairs , $operators ) ;

				// converting the query to an array
				$row = $result->fetch_array( MYSQLI_ASSOC ) ;
				
				// detecting if any value was returned
				if ( $row == null )
					return false ;

				// token was found
				return true ; 
				
			}
			
			////
			//PUBLIC METHOD
			////
			
			/**
			 * 	manage
			 * 
			 * 	This function manages the tokens 
			 * 
			 * 	@param	$action		The action
			 * 						NEW
			 * 	@param 	$C			The optional paramers
			 *
			 * 	@return null		invalid option
			 * 	@return string		The unique token value
			 */ 	
			public function manage( $action , $C = null ) {
				
				// switch of avalilable options
				switch( $action ) {
					case 'NEW' : 
						return $this->getToken( ) ;
					
					default : return null ;
				}
				
			}
           
		}
	}
?>
