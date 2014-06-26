<?php
	/**
     *  @File           mfa.php
     *  @Authors        Jose Flores
     *                  jose.flores.152@gmail.com
     *  
     *  @Description    This file holds the mfa class, it manages the mfa devices
     * 
     *  @changelog      
     *  6/24/14			This class was written
     * 					__construct
     * 					register
     * 					createPin
     * 					activateMFA
     * 					Manage
     * 					
     */
	
    //  DEFINE GUARD
    if ( !defined( 'class_mfa' ) )  {
        
        define( 'class_mfa' , TRUE ) ;

		
		/**
		 * 	mfa
		 * 
		 * 	This is the mfa class
		 * 
		 * 	$A			Holds the Application globals
		 * 	$param		Holds the Device information
		 * 	$pin		Holds a system generated pin value
		 */
		class mfa {
			
			private $A ;
			private $param ;
			private $pin ;
			
			/**
			 * 	__construct
			 * 
			 * @param $A
			 * @param $param[]		The paramaters expected by this class in 
			 * 						an array
			 * 		
			 * 	REGISTER
			 * 		USR_PHONE -	Phone number
			 * 		USR_EMAIL -	usr email
			 * 		USR_SALT - 	device generated salt
			 * 		USR_PEPPER - device generated pepper
			 * 		USR_TIMESTAMP -	device generated timestamp	
			 * 
			 * 			or
			 * 
			 *  ACTIVATE
			 * 	CLEAN
			 * 		USR_PHONE -	Phone number
			 * 		USR_PIN -	Phone pin			
			 * 
			 * 			or 
			 * 
			 *  AUTHENTICATE
			 * 		USR_PHONE -	Phone number
			 * 		USR_TOKEN -	Minute Token
			 * 		
			 */
			public function __construct( $A , $param ){
				
				// application variables
				$this->A = $A ;
				// Store all parameters in paramas array
				$this->param = $param ;
				
			}
			
			/**
			 * 	register
			 * 
			 * 	This function registers an MFA device but does not activate 
			 * 	it
			 * 
			 * 	@return array 	mfa was registered an are returning salt 
			 * 					and pepper
			 * 	@return 1		user is not registered 
			 * 	@return 2 		device is in use
			 */ 
			private function register( ){
							
				$this->pin = $this->createPin() ;
				
				$DB = new mysql( $this->A ) ;
				
				// Check that user is registered
				
				$table = 'csr_usr_account' ;
                $operators = array( '==' ) ;
                $keyPairs  = array( 'usr_email' => $this->param[ 'USR_EMAIL' ] ) ;

                $result = $DB->select( $table , $keyPairs , $operators ) ;
				$row_cnt = $result->num_rows ;

				if ( $row_cnt == 0 ) { 
					return 1 ;
				}
				// get associative array from mysqli result
				$row = $result->fetch_assoc() ;
				
				$owner = $row[ 'id' ] ;
				
				// check that phone is not registered
				
				$table = 'csr_mfa_account' ;
				$keyPairs = array( 'mfa_device_id' => $this->param[ 'USR_PHONE' ] ) ;
				$operators = array( '==' ) ;
				
				$result = $DB->select( $table , $keyPairs , $operators ) ;
				$row_cnt = $result->num_rows ;
				
				if ( $row_cnt != 0 ) { 
					return 2 ;
				}
				
				$tk = new token() ;
				$this->param[ 'USR_SALT' ] = $tk->genSalt() ;
				$this->param[ 'USR_PEPPER' ] = $tk->genSalt() ;
				
				// Register Device
				$table = 'csr_mfa_account' ;
				$keyPairs = array(  'mfa_device_id' 	=> $this->param[ 'USR_PHONE' ] ,
									'mfa_device_date' 	=> $this->param[ 'USR_TIMESTAMP' ] ,
									'mfa_device_pin' 	=> $this->pin , 
									'mfa_device_salt' 	=> $this->param[ 'USR_SALT' ] , 
									'mfa_device_pepper' => $this->param[ 'USR_PEPPER' ] , 
									'mfa_device_owner_id'  => $owner ,
									'mfa_device_attempt'=> 0 ,
									'mfa_device_active' => 0 ) ;
				
				$DB->insert(  $table , $keyPairs ) ;
				$this->emailPin() ;
				return array( 'salt' => $this->param[ 'USR_SALT' ] , 'pepper' => $this->param[ 'USR_PEPPER' ] ) ; 

			}

			/**
			 *	createPin 
			 * 
			 * 	return a random 6 digit pin 
			 */
			private function createPin( ) {
				return mt_rand( 100000 , 999999 ) ;
			}
			
			/**
			 * 	authenticate
			 * 
			 * 	this function authenticates an mfa device, it has a testmode
			 * 	built in to allow for viewing of the mfa tokens as they are 
			 * 	generated. This mode can be used to compare results live to 
			 * 	that of transmitting software during developement.
			 * 
			 * 	@return				testing
			 * 	@return  	0 		authenticated	
			 * 	@return 	1		Device is not registered
			 * 	@return		2		Device is banned
			 * 	@return		3		Failure to authenticate
			 */ 	
			private function authenticate( ) {
				// Variables
				$precision = 15 ;
				$testLength = 30 ;
				$error = -1 ;
				$encryption = 'sha256' ;
				$testMode = false ; 
				$DB = new mysql( $this->A ) ;
				
				// get device info
				$table = 'csr_mfa_account' ;
                $operators = array( '==' ) ;
                $keyPairs  = array( 'mfa_device_id' => $this->param[ 'USR_PHONE' ] ) ;
                $result = $DB->select( $table , $keyPairs , $operators ) ;
				
				// Check if the device has been registered
				$row_cnt = $result->num_rows ;
				if ( $row_cnt == 0 ) { 
					return 1 ;
				}
				
				// get associative array from mysqli result
				$row = $result->fetch_assoc() ;
				
				//store token owner
				$owner = $row['mfa_device_owner_id'] ;
				
				// Check if the device has passed the ban limit 5 attempts
				if ( $row[ 'mfa_device_attempt' ] >= 5 ) {
					//ban device
					return 2 ;
				}
				
				// generate hash from formula
				$token = $this->shortToken( $row[ 'mfa_device_date' ] , 
													   $row[ 'mfa_device_salt' ] , 
													   $row[ 'mfa_device_pin' ] , 
													   $row[ 'mfa_device_pepper' ] , 
													   $precision , 
													   0 , 
													   $encryption ) ;
				
				// test mfa generation in cygwin
				if( $testMode ) {
					//This displays a loop of tokens so that the can be verified during development					
					for ( $i = 0 ; $i < 30 ; ++$i ) {
						//generate a token
						echo $this->shortToken( $row[ 'mfa_device_date' ] , 
														   $row[ 'mfa_device_salt' ] , 
														   $row[ 'mfa_device_pin' ]  , 
														   $row[ 'mfa_device_pepper' ] , 
														   $precision , 
														   0 , 
														   $encryption ) , "\n" ;
						// token every one second
						sleep( 1 ) ;
					}
					// exit test
					return ;
				
				}
				
				// compare to token
				for( $i = 0 ; $i >= $error ; ++$i ){
					
					// Generating token from database components
					$shortToken = $this->shortToken( $row[ 'mfa_device_date' ] , 
													   $row[ 'mfa_device_salt' ] , 
													   $row[ 'mfa_device_pin' ]  , 
													   $row[ 'mfa_device_pepper' ] , 
													   $precision , 
													   $i , 
													   $encryption ) ;
					
					// Matched tokens found
					if ( $token == $shortToken ) {
						// device attempts reset
						$newKeyPairs = array( 'mfa_device_attempt' => 0 ) ;
						$DB->update( $table , $keyPairs , $operators , $newKeyPairs ) ;
						//device has authenticated
						define( CURRENT_USER_ID , $owner ) ;
						return 0 ;
						
					}
			
				}
			
				// Increment the failed communication attempts after 5 consecutive failures the device is banned
				$table = 'csr_mfa_account' ;
				$keyPairs = array(  'mfa_device_id' => $this->param[ 'USR_PHONE' ] ) ;
				$operators = array( '==' ) ;
				$newKeyPairs = array( 'mfa_device_attempt' => ++$row[ 'mfa_device_attempt' ] ) ;
				$DB->update( $table , $keyPairs , $operators , $newKeyPairs ) ;
				
				// return denial
				return 3 ;
			
			}

			/**
			 * 	shortToken
			 * 
			 * 	this function generates a short lived token for a device
			 * 
			 * 	@param 	$mfa_device_date 	The device registration timestamp
			 * 	@param	$mfa_device_salt 	The salt to use
			 * 	@param	$mfa_device_pin 	The pin number
			 *  @param	$mfa_device_pepper	The pepper to use
			 * 	@param	$precision 			The interval a token is alive for
			 * 	@param	$i 					The number of precisions to go back
			 * 	@param	$encryption			The encryption method to use
			 * 								sha256 is available to android 
			 * 								devices
			 * 
			 * 	@return string				The generated token
			 */
			private function shortToken( $mfa_device_date , 
										 $mfa_device_salt , 
										 $mfa_device_pin , 
										 $mfa_device_pepper, 
										 $precision , 
										 $i , 
										 $encryption ) {
				/* 
				 * the line 				 
				 * (int) ( ( time() + ( $i * $precision ) ) / $precision ) . 
				 * calculates the current time and allows for increments in 
				 * periods incase there is a delay in transmission
				 * 
				 * Sender must use $i of 0 
				 * precision must match the reciever
				 * encryption must also match reciever : sha256
				 */
				return hash( $encryption , 
							 $mfa_device_salt . 
							 $mfa_device_date . 
							 (int) ( ( time() + ( $i * $precision ) ) / $precision ) . 
							 $mfa_device_pin . 
							 $mfa_device_pepper ) ;
			}
			
			/**
			 * 	emailPin
			 * 
			 * 	@return true	Email was sent with pin
			 * 	@return string	Error message
			 */
			private function emailPin( $to ) {
				$from = array( 'EMAIL' => 'msgs@csr.cs.uml.edu' , 
							   'NAME' => 'Messages' ) ; 
				$subj = 'Pin confirmation' ;
				$msg = 'Please enter pin into device: ' . $this->pin ;
				
				$email = new email( $A ) ;
				
				return $email->send( $from , array( 'EMAIL' => $to ) , $subj , $msg ) ;	
			}
			
			/**
			 * 	clean
			 * 
			 * 	This function removes an mfa device from the system from 
			 * 	a device that still has access to its pin.
			 * 
			 * 	@return	true		devices deleted
			 * 	@return false 		device could not be deleted
			 */
			 private function clean(){
					$DB = new mysql( $this->A ) ;
					
					// remove the following device
					$table = 'csr_mfa_account' ;
					$keyPairs = array ( 'mfa_device_id' => $this->param[ 'USR_PHONE'] ,
										'mfa_device_pin' => $this->param[ 'USR_PIN'] ) ;		
					$operators = array( '==' , '==' ) ;
					
					// delete matching devices
					$result = $DB->delete( $table , $keyPairs , $operators ) ;
				 
					// check if devices were deleted
					if ( $result == null )
						return false ;
					
					// matching devices were deleted	
					return true ;
			 }
			 
			/**
			 * 	activateMFA
			 * 
			 * 	This function completes the email verification process and 
			 * 	activates an mfa device
			 * 
			 * 	@return	0		device was activated
			 * 	@return 1 		user was not registered
			 * 	@return 2		device was banned
			 * 	@return 3		device was not activated
			 */
			 private function activateMFA( ) {
				
				//	create a new mysql instance
				$DB = new mysql( $this->A ) ;
				
				// check if user is registered
				$table = 'csr_mfa_account' ;
				$keyPairs = array(  'mfa_device_id' => $this->param[ 'USR_PHONE' ] ,
									'mfa_device_active' => 0 ) ;
				$operators = array( '==' , '==' ) ;
				$result = $DB->select( $table , $keyPairs , $operators ) ;
				
				// user does not exist
				$row_cnt = $result->num_rows ;
				if ( $row_cnt == 0 ) {
					return 1 ;
				}
				
				// 	get associative array
				$row = $result->fetch_assoc() ;
				
				//	verify mfa device is still within attempt limit
				if ( $row[ 'mfa_device_attempt' ] >= 5 ) {
					return 2 ;
				}
				
				//	verify the pin matches what was sent
				if ( $row[ 'mfa_device_pin' ] == $this->param[ 'USR_PIN' ] ) {
					// activate device and reset counter
					$newKeyPairs =  array( 'mfa_device_active' => 1 ,
										   'mfa_device_attempt' => 0 ) ;
										
					$DB->update( $table , $keyPairs , $operators , $newKeyPairs ) ;
					return 0 ;
				}
				
				//	add a device attempt
				$newKeyPairs = array( 'mfa_device_attempt' => ++$row[ 'mfa_device_attempt' ] ) ;
				$DB->update( $table , $keyPairs , $operators , $newKeyPairs ) ;
				
				// deny activation
				return 3 ;
			 }
			 
			/**
			 * 	manage
			 * 
			 * 	This function contains all the MFA management options
			 * 
			 * 	@param	$action		REGISTER
			 * 						ACTIVATE
			 * 						
			 * 	@return	int			success or failure messages
			 */
			public 	function manage( $action , $P = null ) {
				
				switch ( $action ) {
					case 'REGISTER' :
						$tmp = $this->register() ;
						break ; 
					
					case 'ACTIVATE' :
						$tmp = $this->activateMFA() ;
						break ;
						
					case 'AUTHENTICATE' :
						$tmp = $this->authenticate() ;
						break ;
						
					case 'CLEAN' :
						$tmp = $this->clean() ;
						break ;					
						
					default:
						$tmp = null ;
						break ;
				}
				
				return $tmp ;				
			}
		}

	}

?>
