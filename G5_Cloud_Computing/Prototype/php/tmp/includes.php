<?php
	/**
	 *  @File			includes.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This file holds all the index includes
	 * 
	 * 	@changelog		
	 * 	6/4/14			Added mysql, cookie, token, user ; enabled mysql 
	 * 					ini
	 *	4/24/14			Wrote file			
	 */	
	
	// 	Including external classes
	// 	PHPMailer - Used and required by the email class
	
	// 	Including the application Classes
	include( $A[ 'D_LIB' ] . 'mysql.php'  ) ;
	include( $A[ 'D_LIB' ] . 'cookie.php'  ) ;
	include( $A[ 'D_LIB' ] . 'token.php'  ) ;
	include( $A[ 'D_LIB' ] . 'user.php'  ) ;
	include( $A[ 'D_LIB' ] . 'authentication.php'  ) ;
	include( $A[ 'D_LIB' ] . 'email.php'  ) ;
	include( $A[ 'D_LIB' ] . 'mfa.php'  ) ;	

	//	Including the application library
	include( $A[ 'D_LIB' ] . 'library.php' ) ;
		
	//	Including the application api
	include( $A[ 'D_API' ] . 'api.php' ) ;	
		
	//	Including developer configuration file
	include( $A[ 'D_INI' ] . 'dev.php' ) ;
	
	//	Including mySql	configuration
	include( $A[ 'D_INI' ] . 'mysql.php' ) ;
	
	//	Including sec configuration
	include( $A[ 'D_INI' ] . 'sec.php' ) ;
	
	//	Including ssl configuration
	include( $A[ 'D_INI' ] . 'ssl.php' ) ;
	
	//	Including email configuration
	include( $A[ 'D_INI' ] . 'email.php' ) ;
	

	
	$A[ 'AUTH' ] = new authentication( $A ) ;
	
?>
