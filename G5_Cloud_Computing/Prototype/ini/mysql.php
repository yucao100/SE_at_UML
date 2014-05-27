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
	$A[ 'M_USR' ] 	= getenv( 'CSR_MYSQL_USR' ) ; 
    $A[ 'M_PWD' ] 	= getenv( 'CSR_MYSQL_PWD' ) ;
	 
	// 	Initialization Database
	$A[ 'M_SQL' ]	= $A[ 'D_INI' ].'init.sql' ;
	 
	//	Database Information
	$A[ 'M_DB' ] 	= 'csr' ;
    $A[ 'M_SERVER' ] = 'localhost' ;
	 
?>
