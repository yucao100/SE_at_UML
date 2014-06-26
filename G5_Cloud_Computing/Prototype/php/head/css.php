<?php
	/**
	 *  @File			css.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This file holds the css includes
	 * 
	 * 	@changelog		
	 *	4/21/14			Restructured the file to match constants.js 
	 * 					creation
	 * 	2/20/14			Created the file
	 */
	
	//	Downloaded css files, place here first so that the main and 
	//	widget files can override 
	echo '<link href="' , $A['W_CSS'] , 'jquery-ui-1.10.4.custom.css" 	rel="stylesheet" type="text/css">' ;
	
	// 	The main css file this holds most styling elements to lend 
	//	consistency to the application
	echo '<link href="' , $A['W_CSS'] , 'main.css" 						rel="stylesheet" type="text/css">' ;
	
	//	Widget styles
	echo '<link href="' , $A['W_CSS'] , 'navigation-menu.css" 			rel="stylesheet" type="text/css">' ;
	echo '<link href="' , $A['W_CSS'] , 'profile-generator.css" 		rel="stylesheet" type="text/css">' ;
	echo '<link href="' , $A['W_CSS'] , 'toolbar-menu.css" 				rel="stylesheet" type="text/css">' ;
	echo '<link href="' , $A['W_CSS'] , 'toolbar-tabs.css" 				rel="stylesheet" type="text/css">' ;
	echo '<link href="' , $A['W_CSS'] , 'sec-registration.css" 			rel="stylesheet" type="text/css">' ;
	
?>
