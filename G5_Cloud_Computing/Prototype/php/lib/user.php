<?php
    /**
     *  @File           user.php
     *  @Authors        Jose Flores
     *                  jose.flores.152@gmail.com
     *  
     *  @Description    This is the user class, it manages the user sessions
     * 
     *  @changelog      
     *  5/25/14			Session started
     *  5/24/14			manage() REMOVE, REGISTER finished  
     * 	4/28/14			Underlying methods written
     */
	
    //  DEFINE GUARD
    if ( !defined( 'class_user' ) )  {
        
        define( 'class_user' , TRUE ) ;
        
        /**
         *  user
         * 
         *  This is tha application security, It will be used to validate 
         *  all users
         * 
         * 	$A			The application globals
         * 	$user		The user information	
         * 	$token		A generated token
         * 	$epoch		a unix timestamp generating array that limits 
         * 				the life of a session
         * 	$debug		Wether to run with a debug callstack
         * 	$tab		the callstack indenter count for visualization
         */
        class user {
            
            // 	VARIABLES
 
            private $A ;		//	The Global Settings and Paths       
            private $user ;
            private $token ;      
            
            // How long sessions should be allowed to be active 
            //		W = week
            //		D = day
            //		H = hour
            //		M = minutes
            //		S = seconds
            private $epoch = array( 'W' => 0 , 'D' => 0 , 'H' => 0 , 'M' => 5 , 'S' => 0 ) ;
            
            private $debug = false ;
            private $tab = -1 ;
			//  CONSTRUCTOR
			
			/**
             *  __construct
             * 
             *  This function creates an instance of the user class
             * 
             *  @param  $A      The global configuration
             *  @param  $user   The user variable
             * 	@param $token	The current user token
             */ 
            public function __construct( $A , $user , $token = false ) {
             
                $this->callStack( '__construct' ) ;
                
                $this->A = $A ;
                
				if ( $token ) { 
					

				}
				else {
					$this->user = $user ;
				}
                // Calculate time from epoch array
				$t = $this->epoch ;
				$t[ 'W' ] *= 7 ;
				$t[ 'D' ] += $t[ 'W' ] ;
				$t[ 'D' ] *= 24 ;
				$t[ 'H' ] += $t[ 'D' ] ;
				$t[ 'H' ] *= 60 ;
				$t[ 'M' ] += $t[ 'H' ] ;
				$t[ 'M' ] *= 60 ;
				$t[ 'S' ] += $t[ 'M' ] ;
                $this->epoch[ 'T' ] = $t[ 'S' ] ;
                
                $this->callStack( null , true ) ;
            }
            
            //	DEBUG
            
            private function callStack( $str , $bool = false ) {
				if( $bool){
					--$this->tab ;
					return ;
				}
				else{
					++$this->tab ;
				}
				
				for ( $i = 0 ; $i < $this->tab ; ++$i ) 
					echo "  " ;
					
				if ( $this->debug )
					echo $str , '<br/>' ;
			}
            /**
             *  showFields
             *  
             *  This function does a vardump of the $this->user and 
             * 	$this->mysql variable to screen for debugging
             */
            public function showFields( ) {
            
               echo "<table>
						<tr>
							<td>user</td>
							<td>",var_dump( $this->user ),"</td>
						</tr>
					</table>" ;
             
                
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
            private function genSalt() {
             
                $this->callStack( 'genSalt' ) ;
                
                //  the size of the initialized vector
                $size = mcrypt_get_iv_size( MCRYPT_CAST_256 , MCRYPT_MODE_CFB ) ;
                
                // returning the salt
                $this->callStack( null , true ) ;
                return bin2hex( mcrypt_create_iv( $size, MCRYPT_RAND ) ) ;
            }
            /** 
             * 	This function returns the salt of a user
             * 
             * 	@return string		the salt value
             */
            private function getUserSalt( ) {
			
             	$this->callStack( 'getUserSalt' ) ;
             	//	Get user information from DB
				
				$result = $this->getUser() ;
				$row = $result->fetch_array( MYSQLI_ASSOC ) ;
				
				// return the salt
				$this->callStack( null , true ) ;
				return $row[ 'usr_pwd_salt' ] ;
				
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
			
                $this->callStack( 'hash' ) ;
                
                // limit to a list of secure algorithms
                switch( $this->A[ 'SEC' ][ 'HASH_ALG' ] ){
                    case 'sha256' : 
                    case 'sha512' : 
                       // generate the password hash
                       $this->callStack( null , true ) ;
                       return hash( $this->A[ 'SEC' ][ 'HASH_ALG' ] , $salt.$password ) ;
                    default :
                          // disallow the chosen algorithm, and return nothing
						$this->callStack( null , true ) ;
                        return null ;
                }   
            }
            
            //  USER METHODS
           
            /**
             * 	register
             * 
             *  This function registers a user into the user table 
             * 
             *  @param  $user       The user array
             *  
             * 	@return 0			Successful Registration
             * 
             *  @return	1			Already registered
             *  @return	2			Fields are malformed
             *  @return	3			Hash / salt error
             * 	@return 4			insertion error
             */ 
            private  function register() {
               
                $this->callStack( 'register' ) ;
                
                // Is user already registered
                if ( $this->isUser( ) ) {
					$this->callStack( null , true ) ;
                    return 1 ;
				}
                
                // VALIDATE INPUT
                if ( !$this->processFields() ) {
                    $this->callStack( null , true ) ;
                    return 2 ;
                }
                  
                // Get the password salt
                $this->user[ 'usr_pwd_salt' ] = $this->genSalt() ;
                
                //  Hash the password for storage
                $this->user[ 'usr_pwd_hash' ] = $this->hash( $this->user[ 'usr_pwd_salt' ] , $this->user[ 'usr_pwd_1' ] ) ;     

				if ( $this->user[ 'usr_pwd_salt' ] == null || 
					 $this->user[ 'usr_pwd_hash' ] == null ) {
						$this->callStack( null , true ) ;
						return 3 ;
				}
						
                // Update user table
                if ( !$this->setUser() ) {
					$this->callStack( null , true ) ;
                    return 4 ;
				}
				               
                // Succesfull registration
                $this->callStack( null , true ) ;
                return 0 ;
                
            }
            
            /**
             * 	authenticate
             * 
             * 	This Function authenticates a user.
             * 
             * 	@return	0		User is authenticated
             *  
             *  @return 1    	user was not found
             *  @return 2	   	password did not match
             */
            private function authenticate() {
                
                $this->callStack( 'logOnUser' ) ;
                
                // Validate User
                if ( !$this->isUser() ) {
					$this->callStack( null , true ) ;
                    return 1 ;
                }
                
                // Validate Password
                if ( !$this->isPassword( $this->user[ 'usr_pwd_1' ] ) ) {
                    $this->callStack( null , true ) ;
                    return 2 ;
				}
				
				// User is valid
				$this->callStack( null , true ) ;
				return 0 ; 
            }
			
            /**
             * 	removeUser
             * 
             * 	This function removes a user from the db, and destroys 
             * 	any sessions associated to them
             * 
             * 	@return true	the user artifacts were removed
             * 	@return false	something could not be removed
             */
            public function removeUser() {
            
                $this->callStack( 'removeUser' ) ;
            
             	//	Get user information from DB
				$table = 'csr_usr_account' ;
			
				$operators = array( '==' ) ;
                $keyPairs = array( 'usr_email' => $this->user[ 'usr_email' ] ) ;
                
                $DB = new mysql( $this->A ) ;
            			
				$row = $this->getUser() ;
						
				$operators = array( '==' ) ;
                $keyPairs = array( 'usr_email' => $row[ 'usr_email' ] ) ;

				$result = $DB->delete( $table , $keyPairs , $operators ) ;
				
				$this->callStack( null , true ) ;			
				return 0 ;
            }
            
            /**
             *  isUser
             * 
             *  This function checks to see if a a user is already 
             *  registered.
             * 
             *  @return true        email is already registered
             *  @return false       email is not registered
             */
            private function isUser() { 
			
				$this->callStack( 'isUser' ) ;
             	//	Get user information from DB
				$row = $this->getUser() ;
				
				// User was not found or matched
                if ( $row == null ||
					 $row[ 'usr_email' ] != $this->user[ 'usr_email' ] ){
						$this->callStack( null , true ) ;
						return false ;
				 }
				// user found	 
				$this->callStack( null , true ) ;
                return true ; 
            }           
            
            /**
             * 	setUser
             * 	
             * 	This function sets/ update the user in the mysql database
             * 
             * 	@return true 
             * 	@return false 
             */
            private function setUser() {
				
				$this->callStack( 'setUser' ) ;
			
				$user = array(   'usr_name_first'		=> $this->user[ 'usr_name_first' ] , 
							  'usr_name_middle'		=> $this->user[ 'usr_name_middle' ] , 
							  'usr_name_last' 		=> $this->user[ 'usr_name_last' ] , 
							  'usr_email' 			=> $this->user[ 'usr_email' ] , 
							  'usr_pwd_salt' 		=> $this->user[ 'usr_pwd_salt' ] ,
							  'usr_pwd_hash' 		=> $this->user[ 'usr_pwd_hash' ] ,
							  'usr_phone_country' 	=> $this->user[ 'usr_phone_country' ] , 
							  'usr_phone_area' 		=> $this->user[ 'usr_phone_area' ] , 
							  'usr_phone_number' 	=> $this->user[ 'usr_phone_number' ] , 
							  'usr_phone_ext' 		=> $this->user[ 'usr_phone_ext' ] , 
							  'usr_dob_epoch' 		=> $this->user[ 'usr_dob_epoch' ] ) ;
							  
				$table = 'csr_usr_account' ;
								  
				$DB = new mysql( $this->A ) ;
				$result = $DB->insert( $table , $user ) ;
				
				$this->callStack( null , true ) ;
				return $result ;
                
            }
            
            /** 
             * 	getUser
             * 
             * 	This function gets the user from the db
             * 
             * 	@return null	no user found to match 
             * 	@return array	user variable
             */
            private function getUser() {
            
                $this->callStack( 'getUser' ) ;
                
                $table = 'csr_usr_account' ;
                
                $operators = array( '==' ) ;
                $keyPairs  = array( 'usr_email' => $this->user[ 'usr_email' ] ) ;
                
                $DB = new mysql( $this->A ) ;
                $result = $DB->select( $table , $keyPairs , $operators ) ;
				$row = $result->fetch_array( MYSQLI_ASSOC ) ;
				$this->callStack( null , true ) ;
				return $row ;
            }
       
            //  PASSWORD METHODS
            
            /**
             * 	DONE
             * 
             * 	isPassword
             * 	
             * 	This function compares the hash of the user password to 
             * 	the newly salted and hashed parameter
             * 
             *	@param $password		The password to try
             * 
             * 	@return true			The passwords match
             * 	@return false			The passwords do not match	
             */
            private function isPassword( $password ) {
			
				$this->callStack( 'isPassword' ) ;
				
				//	Get user information from DB
				$row = $this->getUser() ;

				//	check password for match
				if ( $this->hash( $row[ 'usr_pwd_salt' ] , $this->user[ 'usr_pwd_1' ] ) != $row[ 'usr_pwd_hash' ] ){
					$this->callStack( null , true ) ;
					return false ;
				}
				
				// 	password matches
				$this->callStack( null , true ) ;	
				return true ;
				
            }
                  
            //  SESSION METHODS
            
            /**
             *  startSession
             * 
             *  This function starts a user session
             * 
             *  @return true        Session was started
             *  @return false       Session could not be started
             */     
            private function startSession() {
                
                $this->callStack( 'startSession' ) ;
                
                // 	Generate new connections and class instances
                $token = new token( $this->A ) ;
				$cookie = new cookie( $this->A ) ;
				$DB = new mysql( $this->A ) ;
				
				// Get current transaction time
				$currentTime = time() ;
				
				// 	Generate a unique token
				$tok = $token->manage( 'NEW' ) ;
				
                // 	Get registered user ID and other reistration details
                $row = $this->getUser() ;
				
				// check that user exists
				if ( $row == null ) {
					$this->callStack( null , true ) ;
					return 1 ;
				}
				
				//	terminate all other user sessions
				//	edit token valid values for token session
                $table = 'csr_usr_token' ;
                $keyPairs = array( 'tok_usr_id' => ( (string) ( $row[ 'id' ] ) ) )  ;
                $op = array( '==' ) ;
                $change = array( 'tok_valid' => '0' ) ;
                $result = $DB->update( $table , $keyPairs , $op , $change ) ;
                
				//	edit token valid values for token session
                /*$table = 'csr_usr_token' ;
                $keyPairs = array( 'tok_string' => $token ) ;
                $op = array( '==' ) ;
                $change = array( 'tok_valid' => 0 ) ;
                $result = $DB->update( $table , $keyPairs , $op , $change ) ;
                */	
                
				// Store token in cookie session
                if( $cookie->manage( 'SET' , array( 'name' => 'token' , 'value' => $tok ) ) != 0 ) {
					$this->callStack( null , true ) ;
					return 2 ;
				}
					
				if ( !( isset( $_SERVER[ 'REMOTE_ADDR' ] ) ) || 
					$_SERVER[ 'REMOTE_ADDR' ] == null ){
						$this->callStack( null , true ) ;
						return 3 ;
				}
				
				// 	generate data for storage
                $keyPairs = array( 'tok_usr_id' => $row[ 'id' ] , 'tok_usr_ip' => $_SERVER[ 'REMOTE_ADDR' ] , 'tok_epoch' => $currentTime , 'tok_string' => $tok, 'tok_valid' => true ) ;
                
                //	insert token values for server session
                $table = 'csr_usr_token' ;
                $result = $DB->insert( $table , $keyPairs ) ;
					
                //  Session Started
                $this->callStack( null , true ) ;
                return 0 ;
            }
            
            /**
             * 	endSession
             * 
             * 	This function terminsates a user session
             */
            private function endSession() {
				$this->callStack( 'endSession' ) ;
				
				$C = new cookie( $this->A ) ;
				$DB = new mysql( $this->A ) ;
				
				$token = $C->manage( 'GET' , array( 'name' => 'token' ) ) ;
				

                //	edit token valid values for token session
                $table = 'csr_usr_token' ;
                $keyPairs = array( 'tok_string' => $token ) ;
                $op = array( '==' ) ;
                $change = array( 'tok_valid' => 0 ) ;
                $result = $DB->update( $table , $keyPairs , $op , $change ) ;
                                
				$C->manage( 'DELETE' , array( 'name' => 'token' ) ) ;
				
				$this->callStack( null , true ) ;
			}

            /**
             * 	getSessionState
             * 
             * 	This function gets the session information
             * 
             * 	@return	null	the seesion is not real
             * 	@return string	the session information
             */
            private function getSessionInfo() {
				$this->callStack( 'getSessionInfo' ) ;
				
				//	Variables
				$DB = new mysql( $this->A ) ;
				$C  = new cookie( $this->A ) ;
				
				//	getting token details
				$table = 'csr_usr_token' ;
				$tokenString = $C->manage( 'GET' , array( 'name' => 'token' ) ) ;
				$keyPairs = array( 'tok_string' => $tokenString ) ;
				$operators = array( '==' ) ;
                $result = $DB->select( $table , $keyPairs , $operators ) ;
                // converting the query to an array
				$rowToken = $result->fetch_array( MYSQLI_ASSOC ) ;
				
				//	if token found
                if ( $rowToken == null ) {
					$this->callStack( null , true ) ;
					return null ;
				}
				
				//	getting user information from token details
				$table = 'csr_usr_account' ;
				$keyPairs = array( 'id' => $rowToken[ 'tok_usr_id' ] ) ;
				$operators = array( '==' ) ;
                $result = $DB->select( $table , $keyPairs , $operators ) ;
				// converting the query to an array
				$rowUser = $result->fetch_array( MYSQLI_ASSOC ) ;
				
				// if user found
				if ( $rowUser == null ) {
					$this->callStack( null , true ) ;
					return null ;
				}
				
				$this->isSessionValid( ) == 0 ? $tmp = 1 : $tmp = 0 ;
				//	generating information
				$result = array( 'id' 			=> $rowUser[ 'id' ] , 
								 'usr_email' 	=> $rowUser[ 'usr_email' ] , 
								 'tok_string' 	=> $rowToken[ 'tok_string' ] , 
								 'tok_usr_ip' 	=> $rowToken[ 'tok_usr_ip' ] , 
								 'tok_epoch' 	=> $rowToken[ 'tok_epoch' ] , 
								 'tok_valid' 	=> $rowToken[ 'tok_valid' ] ,
								 'session_active' 	=> $tmp ) ;
				
				$this->callStack( null , true ) ;		  
				return $result;
			}
            
            /**
             * 	isSessionValid
             * 
             * 	This function validates a session
             * 
             * 	@return	0		valid token
             * 	@return 1 		token not in database 
             * 	@return 2		usr is not registered
             * 	@return 3		invalid token
             */
            private function isSessionValid( ) {
				$this->callStack( 'isSessionValid' ) ;
				
				//	Variables
				$DB = new mysql( $this->A ) ;
				$C  = new cookie( $this->A ) ;
				
				// 	getting token information from database
				$table = 'csr_usr_token' ;
				$tokenString = $C->manage( 'GET' , array( 'name' => 'token' ) ) ;
				$keyPairs = array( 'tok_string' => $tokenString ) ;
				$operators = array( '==' ) ;
                $result = $DB->select( $table , $keyPairs , $operators ) ;
                // 	converting the query to an array
				$rowToken = $result->fetch_array( MYSQLI_ASSOC ) ;
				
				// if value was found
				if ( $rowToken == null ) {
					$this->callStack( null , true ) ;
					return 1 ;
				}
				
				//	getting user information from token details
				$table = 'csr_usr_account' ;
				$keyPairs = array( 'id' => $rowToken[ 'tok_usr_id' ] ) ;
				$operators = array( '==' ) ;
                $result = $DB->select( $table , $keyPairs , $operators ) ;
				// converting the query to an array
				$rowUser = $result->fetch_array( MYSQLI_ASSOC ) ;
				
				$this->tokenUser = $rowUser ;
				
				//	if user found
				if ( $rowUser == null ) {
					$this->callStack( null , true ) ;
					return 2 ;
				}
				
				//	validating fields
				if ( $rowToken[ 'tok_valid' ] == 1 &&
					 $rowToken[ 'tok_epoch' ] > time() - $this->epoch[ 'T' ] &&
					 $rowToken[ 'tok_usr_ip' ] == $_SERVER[ 'REMOTE_ADDR' ] ) {
						//valid token
						$this->callStack( null , true ) ;				 
						return 0 ;
				}
				
				//	invalid token
				$this->callStack( null , true ) ;
				return 3 ;
					
			}
                         
            // 	FIELD METHODS
            
            /**
             *  validateFormat
             * 
             *  This function holds regex validation strings and other 
             *  validation statements for predetermined variable
             *  situations such as phone numbers, email addresses etc.
             * 
             *  @param  $type       The string refex to be used
             *  @param  $string     The string to compare
             * 
             *  @return true        The string validates witht he regex
             *  @return false       The type was not an option or the regex 
             *                      did not validate
             */ 
            private function validateField( $type , $string ) {
              
                $this->callStack( 'validateField' ) ;
                // Valid Regex Switch
                switch( $type ) {
                    
                    //  EMAIL
                    case 'EMAIL' :
                        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/' ; 
                        break ;
                    
                    //  STRINGS
                    case 'STRING' : 
                    case 'NAME' :
						$this->callStack( null , true ) ;
                        return true ;
                        break ;
                    
                    // PHONE NUMBERS    
                    case 'P_C' :
                        $regex = '/^\d{1,3}$/' ;
                        break ;
                        
                    case 'P_A' :
                        $regex = '/^\d{3}$/' ;
                        break ;
                        
                    case 'P_N' :
                        $regex = '/^\d{7}$/' ;
                        break ;
                    
                    case 'P_E' :
                        $regex = '/^\d{0,4}$/' ;
                        break ;
                    
                    // PASSWORDS    
                    case 'PWD' :
                        $regex = '/^(?=[^\d_].*?\d)\w(\w|[!@#$%]){7,20}/' ;
                        break ;
                        
                    //  DATES
                    case 'DATE' : 
                        // YYYY-MM-DD
                        $regex = '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/' ;
                        break ;
                    case 'EPOCH' :
                        if ( time() > $string ) {
							$this->callStack( null , true ) ;
                            return true ;
                        }
                
                    default :
                        // not a valid regex option
                        $this->callStack( null , true ) ;
                        return false ;
                }
                
                // Run the preg_match() function on regex against the string
                if ( preg_match( $regex , $string ) ) {
					$this->callStack( null , true ) ;
                    return true ;
				}

                // regex not matched ;
                $this->callStack( null , true ) ;
                return false ;
            }
            /**
             *  cleanField
             * 
             *  This function sanitizes in put and standardizes the
             *  format it will be stored in to the database.
             * 
             *  @param  $type       The type of input that will be 
             *                      sanitized
             *  @param  $string     The string to sanitize
             * 
             *  @return string      The sanitized string        
             */
            private	function cleanField( $type , $string ) {
                
                $this->callStack( 'cleanField' ) ;
                // remove all extra whitespace
                $string = trim( $string ) ;
                
                // Valid Regex Switch
                switch( $type ) {
                    
                    case 'DATE' : 
                        // Get unix usr_dob_epoch value of date in format YYYY-MM-DD
                        $this->callStack( null , true ) ;
                        return strtotime( $string ) ;
                        
                    case 'P_C' :
                    case 'P_A' :
                    case 'P_N' :
                    case 'P_E' :
                        //  Remove non digits
                        $regex = '/[^0-9]*/';
                        $this->callStack( null , true ) ;
                        return preg_replace( $regex , '' , $string ) ;
                        
                    case 'PWD' :
                        //  Keep password intact
                        $this->callStack( null , true ) ;
                        return $string ;

                    case 'EMAIL' :
                    case 'NAME' :
                    default :
                        // Make all lowercase
                        $this->callStack( null , true ) ;
                        return strtolower( $string ) ;
                }
        
            }
            /**
             *  processFields
             *  
             *  This function processes input, performs sanitation and 
             *  validates
             * 
             *  @return true        Good Input
             *  @return false       Bad Input
             */
            private	function processFields() {
                
                $this->callStack( 'processFields' ) ;
               
                // STANDARDIZING INPUT
                $this->user[ 'usr_email'  ] 		= $this->cleanField( 'EMAIL' , $this->user[ 'usr_email'  ] ) ;
                $this->user[ 'usr_name_first' ] 	= $this->cleanField( 'NAME'  , $this->user[ 'usr_name_first' ] ) ;
                $this->user[ 'usr_name_middle' ] 	= $this->cleanField( 'NAME'  , $this->user[ 'usr_name_middle' ] ) ;
                $this->user[ 'usr_name_last' ] 		= $this->cleanField( 'NAME'  , $this->user[ 'usr_name_last' ] ) ;
                $this->user[ 'usr_phone_country' ] 	= $this->cleanField( 'P_C'   , $this->user[ 'usr_phone_country' ] ) ;
                $this->user[ 'usr_phone_area' ] 	= $this->cleanField( 'P_A'   , $this->user[ 'usr_phone_area' ] ) ;
                $this->user[ 'usr_phone_number' ] 	= $this->cleanField( 'P_N'   , $this->user[ 'usr_phone_number' ] ) ;
                $this->user[ 'usr_phone_ext' ] 		= $this->cleanField( 'P_E'   , $this->user[ 'usr_phone_ext' ] ) ;
                $this->user[ 'usr_pwd_1'    ] 		= $this->cleanField( 'PWD'   , $this->user[ 'usr_pwd_1' ] ) ;
                $this->user[ 'usr_pwd_2'  ] 		= $this->cleanField( 'PWD'   , $this->user[ 'usr_pwd_2' ] ) ;
                
                // Are fields valid 
                if ( !( $this->validateField( 'DATE'  , $this->user[ 'usr_dob' ] ) ) ) {
					$this->callStack( null , true ) ;
					return false ;
				}
                //  Generating the Unix timestamps of dates
                $this->user[ 'usr_dob_epoch' ] = $this->cleanField( 'DATE' , $this->user[ 'usr_dob' ] ) ;
                
                //  Continuing with non user inputed date field validation
                if ( !( $this->validateField( 'EMAIL' , $this->user[ 'usr_email' ] ) &&
                        $this->validateField( 'NAME'  , $this->user[ 'usr_name_first' ] ) &&
                        $this->validateField( 'NAME'  , $this->user[ 'usr_name_middle' ] ) &&
                        $this->validateField( 'NAME'  , $this->user[ 'usr_name_last' ] ) &&
                        $this->validateField( 'EPOCH' , $this->user[ 'usr_dob_epoch' ] ) &&
                        $this->validateField( 'P_C'   , $this->user[ 'usr_phone_country' ] ) &&
                        $this->validateField( 'P_A'   , $this->user[ 'usr_phone_area' ] ) &&
                        $this->validateField( 'P_N'   , $this->user[ 'usr_phone_number' ] ) &&
                        $this->validateField( 'P_E'   , $this->user[ 'usr_phone_ext' ] ) &&
                        $this->validateField( 'PWD'   , $this->user[ 'usr_pwd_1' ] ) &&
                        $this->validateField( 'PWD'   , $this->user[ 'usr_pwd_2' ] ) ) ) {
							
							$this->callStack( null , true ) ;
                            return false ;  
						}
                                        
                // Check if passwords match
                if ( $this->user[ 'usr_pwd_1' ] != $this->user[ 'usr_pwd_2' ] ){
					$this->callStack( null , true ) ;
                    return false ;
				}
                
                // Passes all input tests
                $this->callStack( null , true ) ;
                return true ;
            }
            
            ////
            //  PUBLIC METHODS
            ////
            
           /**
			 * 	session
			 * 
			 * 	This function handles session states
			 * 
			 * 	@param	$state	START 	- start a new session
			 * 					STOP	- stop the session	
			 * 					RESET	- restsart the session
			 * 					STATUS	- get session state
			 * 					INFO	- get session information
			 * 	
			 * 	@return	int		success or failure of the operation
			 */
			public 	function session( $state ) {
				$this->callStack( 'session' ) ;
				switch ( $state ) {
					case 'START' :
						$tmp = $this->startSession() ; //done
						break ;

					case 'RESET' :
						$this->endSession() ;
						$tmp = $this->startSession() ;						
						break ;
					case 'STOP' :
						$tmp = $this->endSession() ;
						break ;
					case 'INFO' :
						$tmp = $this->getSessionInfo() ; //WIP
						break ;
						
					case 'STATE' :
					default:
						$tmp = $this->isSessionValid() ;
						break ;					
						
				}
				$this->callStack( null , true ) ;
				return $tmp ;
			}
			/**
			 * 	manage
			 * 
			 * 	This function contains all the user management options
			 * 
			 * 	@param	$action		REGISTER
			 * 						REMOVE
			 * 						
			 * 	@return	int			success or failure messages
			 */
			public 	function manage( $action , $P = null ) {
				$this->callStack( 'manage'  ) ;
				switch ( $action ) {
					case 'REGISTER' :
						$tmp = $this->register() ;
						break ; 
					
					case 'LOGIN' :
						$tmp = $this->authenticate() ;
						break ;
						
					case 'REMOVE' :
						$tmp =  $this->removeUser() ;
						break ;
					
					case 'SESSION' :
						if ( $P == null ) {
							$tmp = false ;
							break ;
						}
						$tmp =  $this->session( $P ) ;
						break ;
						
					default:
						$tmp = null ;
						break ;
				}
				
				$this->callStack( null , true ) ;
				return $tmp ;				
			}
			
        }
        
    }
    
   
    
    
?>
