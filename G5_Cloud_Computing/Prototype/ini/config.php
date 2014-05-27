<?php
	/**
	 *  @File			config.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This is the application library, the configuration 
	 * 					file needs to be included before it is.
	 * 
	 * 	@changelog		
	 *  5/3/2014		Added developer mode
	 *	4/21/14			Removed all path resolving and moved it to the 
	 * 					paths.php configuration file, the root paths are 
	 * 					now resolved in the index.php of the caller with 
	 * 					a call to localLib function getRoot.
	 * 	4/20/14 		Added the errors boolean
	 */
	 
	// Error reporting
	$A[ 'ERRORS' ] = true ;
	
	// Developer Mode
	$A[ 'DEV' ] = false ;

?>
