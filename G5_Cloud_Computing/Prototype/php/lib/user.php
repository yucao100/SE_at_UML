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
	function errorsOn( $bool ) {
		
		// 	Turning errors on
		ini_set( 'display_errors' , 'On' ) ;
		
		// 	Setting the error format
		ini_set( 'error_prepend_string', '<div class="error">[ PHP ]' ) ;
		ini_set( 'error_append_string',  '</div>' );
		
		// 	Displaying all errors
		error_reporting( E_ALL ) ;	
	}
	errorsOn( true ) ;
    //  DEFINE GUARD
    if ( !defined( 'class_user' ) )  {
        
        define( 'class_user' , TRUE ) ;
        
        /**
         *  user
         * 
         *  This is tha application security, It will be used to validate 
         *  all users
         */
        class user {
            
            // 	VARIABLES
 
            private $A ;		//	The Global Settings and Paths       
                         
            private $debug = true ;
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
            public function __construct( $A , $user , $token ) {
             
                $this->callStack( '__construct' ) ;
                $this->A = $A ;
                $this->user = $user ;
                $this->token = $token ; 
                
            }
            
            //	DEBUG
            
            private function callStack( $str ) {
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
                       return hash( $this->A[ 'SEC' ][ 'HASH_ALG' ] , $salt.$password ) ;
                    default :
                          // disallow the chosen algorithm, and return nothing
                       
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
                if ( $this->isUser( ) )
                    return 1 ;
                
                // VALIDATE INPUT
                if ( !$this->processFields() ) 
                    return 2 ;
                  
                // Get the password salt
                $this->user[ 'usr_pwd_salt' ] = $this->genSalt() ;
                
                //  Hash the password for storage
                $this->user[ 'usr_pwd_hash' ] = $this->hash( $this->user[ 'usr_pwd_salt' ] , $this->user[ 'usr_pwd_1' ] ) ;     

				if ( $this->user[ 'usr_pwd_salt' ] == null || 
					 $this->user[ 'usr_pwd_hash' ] == null )
						return 3 ;
						
                // Update user table
                if ( !$this->setUser() ) 
                    return 4 ;
				               
                // Succesfull registration
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
                if ( !$this->isUser() ) 
                    return 1 ;
                
                // Validate Password
                if ( !$this->isPassword( $this->user[ 'usr_pwd_1' ] ) ) 
                    return 2 ;
				
				// User is valid
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
            			
				$result = $this->getUser() ;
				$row = $result->fetch_array( MYSQLI_ASSOC ) ;
						
				$operators = array( '==' ) ;
                $keyPairs = array( 'usr_email' => $row[ 'usr_email' ] ) ;

				$result = $DB->delete( $table , $keyPairs , $operators ) ;
				
				
				
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
				$result = $this->getUser() ;
				
				$row = $result->fetch_array( MYSQLI_ASSOC ) ;
				
				// User was not found or matched
                if ( $row == null ||
					 $row[ 'usr_email' ] != $this->user[ 'usr_email' ] )
					 return false ;
				// user found	 
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

				return $result ;
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
				$result = $this->getUser() ;
				$row = $result->fetch_array( MYSQLI_ASSOC ) ;

				//	check password for match
				if ( $this->hash( $row[ 'usr_pwd_salt' ] , $this->user[ 'usr_pwd_1' ] ) != $row[ 'usr_pwd_hash' ] )
					return false ;
				
				// 	password matches	
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
                
                
                
                
                
                
                
                if ( !$this->setToken() ) 
                    return false ;
                
                if ( !$this->insertSession() ) 
					return false ;
					
                //  Session Started
                return true ;
            }
            private function endSession() {}
            private function getSessionState() {}
            private function getSessionInfo() {}
            
                         
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
                        if ( time() > $string )
                            return true ;
                
                    default :
                        // not a valid regex option
                        return false ;
                }
                
                // Run the preg_match() function on regex against the string
                if ( preg_match( $regex , $string ) ) 
                    return true ;

                // regex not matched ;
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
                        return strtotime( $string ) ;
                        
                    case 'P_C' :
                    case 'P_A' :
                    case 'P_N' :
                    case 'P_E' :
                        //  Remove non digits
                        $regex = '/[^0-9]*/';
                        return preg_replace( $regex , '' , $string ) ;
                        
                    case 'PWD' :
                        //  Keep password intact
                        return $string ;

                    case 'EMAIL' :
                    case 'NAME' :
                    default :
                        // Make all lowercase
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
                if ( !( $this->validateField( 'DATE'  , $this->user[ 'usr_dob' ] ) ) )
					return false ;
                            
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
                        $this->validateField( 'PWD'   , $this->user[ 'usr_pwd_2' ] ) ) ) 
                            return false ;  
                                        
                // Check if passwords match
                if ( $this->user[ 'usr_pwd_1' ] != $this->user[ 'usr_pwd_2' ] )
                    return false ;
                
                // Passes all input tests
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
				
				switch ( $state ) {
					case 'START' :
						$this->startSession() ;
						return ;
					case 'RESET' :
						$this->endSession() ;
						$this->startSession() ;						
						return ;
					case 'STOP' :
						$this->endSession() ;
						return ;
					case 'INFO' :
						$this->getSessionInfo() ;
						return ;	
					case 'STATUS' :
					default:
						$this->getSessionStatus() ;
						return ;
				}
				
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
				
				switch ( $action ) {
					case 'REGISTER' :
						return $this->register() ;
												
					case 'REMOVE' :
						return $this->removeUser() ;
											
					default:
						return ;
				}				
			}
			
        }
        
    }
    
    
    
    include( 'mysql.php' ) ;
	include( 'cookie.php' ) ;
	include( 'token.php' ) ;
	
	
	
    //echo ini_set ( 'variables_order' , 'EGPCS' ) ;
	// SECURITY VALUE
    $A[ 'SEC' ][ 'HASH_ALG' ] = 'sha256' ;
    
    // MYSQL
    $A[ 'M_USR' ] 	= 'root' ; //$_E[ 'CSR_MYSQL_USR' ] ; 
    $A[ 'M_PWD' ] 	= 'Dsce18lse2k3' ; //$_E[ 'CSR_MYSQL_usr_pwd_1' ] ;

	//echo var_dump($_ENV);
	$A[ 'M_DB' ] 	= 'csr' ;
    $A[ 'M_SERVER' ] = 'localhost' ;

    // NEW USER
    $form = array(  'usr_email' => 'jose.flores.152@gmail.com' ,
                    'usr_name_first' => 'Jose' ,
                    'usr_name_middle' => 'Francisco' ,
                    'usr_name_last' => 'Flores' ,
                    'usr_dob' => '1984-12-18' ,
                    'usr_phone_country' => '1' ,
                    'usr_phone_area' => '508' ,
                    'usr_phone_number' => '2457496' ,
                    'usr_phone_ext' => '' ,
                    'usr_pwd_1' => 'Dsce18lse2k3$' ,
                    'usr_pwd_2' => 'Dsce18lse2k3$' ,
                    'usr_dob_epoch' => '' ) ;
    
    // INSTANCE        
    //$user = new user( $A , $form , null ) ;
	$cookie = new cookie( $A ) ;
	$token = new token( $A ) ;
    //echo $user->manage( 'REGISTER' ) , "\n" ;
    
    $P = array( 'name' => 'cookie' , 'value' => 'my Cookie' ) ;
    
    echo $token->manage( 'NEW' ) ;
    
    //echo $cookie->manage( 'SET' , $P ) ;
    //echo $cookie->manage( 'GET' , $P ) ;
    //echo $cookie->manage( 'DELETE' , $P ) ;
    
    
    //echo $user->manage( 'REMOVE' ) , "\n" ;
    
    //echo $user->authenticate() , "\n" ;
    
    // Start Session
    // End Session
    // remove
    // 
    
   
    
    
?>
