<?php
    /**
     *  @File           email.php
     *  @Authors        Jose Flores
     *                  jose.flores.152@gmail.com
     *  
     *  @Description    This file holds the email class cookie management functions
     * 
     *  @changelog      
     *  5/25/14         Created
     */

    //  DEFINE GUARD
    if ( !defined( 'class_email' ) )  {
        
        define( 'class_email' , TRUE ) ;
        
        //require $this->A[ 'D_LIB' ] .'PHPMailer/PHPMailerAutoload.php' ;
        /**
         *  email
         * 
         *  This is tha email class it interfaces with the PHPMailer class 
         * 	as a template 
         * 
         * 	$A		The application globals
         * 	$this->mail	A mail instance
         */
        class email {
		
			private $A ;
			private $mail ;
			/**
			 * 	__construct
			 * 
			 * 	@param	$A		The applciation globals
			 */
			public function __construct( $A ) {
				$this->A = $A ;
				
				//require("class.phpmailer.php");
				include($this->A[ 'D_LIB' ] .'PHPMailer/class.phpmailer.php');
				
				// Setup PHPMailer 
				$this->mail = new PHPMailer(); 
				
				$this->mail->IsSMTP(); 
				
				// Debug error messages
				//$this->mail->SMTPDebug  = 2;
				
				// This is the SMTP mail server 
				$this->mail->SMTPSecure = $A[ 'MAIL_SMTP_SEC' ] ;       // sets the prefix to the servier
				$this->mail->Host       = $A[ 'MAIL_SMTP_HOST' ] ;      // sets GMAIL as the SMTP server
				$this->mail->Port       = $A[ 'MAIL_SMTP_PORT' ] ;      // set the SMTP port for the GMAIL 
							
				// Remove these next 3 lines if you dont need SMTP authentication 
				$this->mail->SMTPAuth = true; 
				$this->mail->Username = $A[ 'MAIL_SMTP_USR' ] ;
				$this->mail->Password = $A[ 'MAIL_SMTP_PWD' ] ;
			}
			
			/**
			 * 	send
			 * 
			 * 	This function senda an email	
			 * 
			 * 	@param	$from
			 * 	@param	$to
			 * 	@param	$subj
			 * 	@param	$msg
			 */
			public function send( $from , $to , $subj , $msg ) {
							
				// Set who the email is coming from 
				$this->mail->SetFrom( $from[ 'EMAIL' ] , $from[ 'NAME' ] ); 
				
				// Set who the email is sending to 
				$this->mail->AddAddress( $to[ 'EMAIL' ] ); 
				
				// Set the subject 
				$this->mail->Subject = $subj ; 
				
				//Set the message 
				$this->mail->MsgHTML( $msg ) ; 
				//$this->mail->AltBody(strip_tags($message)); 
				
				// Send the email 
				if(	!$this->mail->Send() ) {  
					return $this->mail->ErrorInfo ; 
				}
				return 0 ;
			}
		}
	}
	
?>
