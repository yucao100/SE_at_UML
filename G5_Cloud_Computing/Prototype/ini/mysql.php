<?php
	/**
	 *  @File			mysql.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This is mysql configuration file.
	 * 
	 * 	@changelog		
	 *	4/23/14			Created file
	 */
	 
	//	Credential Storage
	$A[ 'M_CREDENTIALS' ] 	=	'C:\\mysql_credentials.php' ; 
	include( $A[ 'M_CREDENTIALS' ] ) ; 
	 
	// 	Initialization Database
	$A[ 'M_SQL' ]			=	$A[ 'D_INI' ].'init.sql' ;
	 
	//	Database Information
	$A[ 'M_DATABASE' ] 	=	'csr' ;
	 
?>
