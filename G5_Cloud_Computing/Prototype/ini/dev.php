<?php
	/**
	 *  @File			dev.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This is the application dev configuration
	 *
	 * 
	 * 	@changelog		
	 *  6/25/2014		renamed file
	 * 	5/03/2014		Added developer mode
	 *	4/21/2014		Removed all path resolving and moved it to the 
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
