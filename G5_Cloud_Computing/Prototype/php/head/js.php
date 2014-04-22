<?php
	/**
	 *  @File			js.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This holds the js includes
	 * 
	 * 	@changelog		
	 *	4/21/14			Restructured the file to match constants.js 
	 * 					creation
	 * 	2/20/14			Created the file
	 */
	 
	//	google code library sources 
	echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>' ;
	echo '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>' ;
	
	// application js files
	echo '<script src="' , $A['W_JS_LIB'] , 'library.js"></script>' ;
	
	// 	application constants
	echo '<script src="' , $A['W_JS'] , 'constants.js"></script>' ;
	
	//	onload initialization routine
	echo '<script src="' , $A['W_JS'] , 'onload.js"></script>' ;
?>
