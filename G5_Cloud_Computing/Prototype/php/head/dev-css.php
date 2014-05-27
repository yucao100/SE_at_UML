<?php
	/**
	 *  @File			dev-css.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This file holds the css includes for developer mode
	 * 
	 * 	@changelog		
	 *	5/3/14			Created File
	 */
	
	//	Downloaded css files, place here first so that the main and 
	//	widget files can override 
	echo '<link href="' , $A['W_CSS'] 	, 'jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css">' ;
	echo '<link href="' , $A[ 'W_CSS' ] , 'dev-tools.css" 				rel="stylesheet" type="text/css">' ;
	echo '<link href="' , $A[ 'W_CSS' ] , 'navigation-menu.css" 		rel="stylesheet" type="text/css">' ;
	echo '<link href="' , $A[ 'W_CSS' ] , 'toolbar-menu.css" 			rel="stylesheet" type="text/css">' ;
	
	//	Load optional CSS
	if ( isset( $_GET[ 'css' ] ) )
		echo getDevHeadSrc( $A , 'CSS' , $_GET[ 'css' ] ) ;
	
	// 	The main css file this holds most styling elements to lend 
	//	consistency to the application
	echo '<link href="' , $A['W_CSS'] , 'main.css" 						rel="stylesheet" type="text/css">' ;
	
?>
