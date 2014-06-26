<?php
	/**
	 *  @File			email.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This is the email configuration file.
	 * 
	 * 	@changelog		
	 *	6/25/14			Created file
	 */

	
	
	$A[ 'MAIL_SMTP_HOST' ] 	= 'smtp.gmail.com' ;			// Specify main and backup SMTP servers
	$A[ 'MAIL_SMTP_PORT' ]	= 587 ;
	$A[ 'MAIL_SMTP_SEC' ]   = 'tls' ;
	
	$A[ 'MAIL_SMTP_USR' ] 	= getenv( 'CSR_SMTP_USR' ) ;  	// SMTP username
	$A[ 'MAIL_SMTP_PWD' ] 	= getenv( 'CSR_SMTP_PWD' ) ;  	// SMTP password
		
?>
