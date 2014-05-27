<?php
	/**
	 *  @File			includes.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This file holds all the index includes
	 * 
	 * 	@changelog		
	 *	4/24/14			Wrote file			
	 */	
	 
	//	Including the application library
	include( $A[ 'D_LIB' ].'library.php' ) ;

	//	Including the application api
	include( $A[ 'D_API' ].'api.php' ) ;	
		
	//	Including the application configuration file
	include( $A[ 'D_INI' ].'config.php' ) ;
	
	//	Including mySql	configuration
	// 	include( $A[ 'D_INI' ].'mysql.php' ) ;
	
	//	Including ssl configuration
	// 	include( $A[ 'D_INI' ].'ssl.php' ) ;
	
?>
