<?php
	/**
	 *  @File			dev-js.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	File holds external libraries for dev mode
	 * 
	 * 	@changelog		
	 *	5/3/14			Created file 
	 */
	 
	//	google code library sources 
	echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>' ;
	echo '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>' ;
			
	//	Load optional JS
	if ( isset( $_GET[ 'js' ] ) )
		echo getDevHeadSrc( $A , 'JS' , $_GET[ 'js' ] ) ;
	
	//	onload initialization routine
	echo '<script src="' , $A['W_JS'] , 'onload.js"></script>' ;
?>
