<?php
	/**
	 *  @File			index.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This file generates the head of the application 
	 * 					pages
	 * 
	 * 	@changelog		
	 * 	5/3/14			Added developer tool switch
	 * 	2/20/14			Created the file
	 */
	
	//	Includeing meta information 
	include( $A[ 'D_HEAD' ] . 'meta.php' ) ; 
		
	if ( $A[ 'DEV' ] ) {
		// 	Including styling information
		include( $A[ 'D_HEAD' ] . 'dev-css.php' ) ;
	
		// 	Including Scripting information
		include( $A[ 'D_HEAD' ] . 'dev-js.php' ) ;
		
	}  
	else {	
		// 	Including styling information
		include( $A[ 'D_HEAD' ] . 'css.php' ) ;
	
		// 	Including Scripting information
		include( $A[ 'D_HEAD' ] . 'js.php' ) ;
	}
	
	
	
?>
