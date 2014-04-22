<?php
	/**
	 *  @File			content.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This file holds the phpWidget tool
	 * 
	 * 	@changelog		
	 * 	4/20/14			Moved the functions found here to the library, 
	 * 					organized the file, and cleaned it up
	 * 	2/25/14			Wrote the widget tool
	 */	
	 
	//	Define guard prevents acces unless from the index.php file at 
	//	this level
	if ( !defined( 'CONTENT_GUARD' ) ) 
		header( 'Location: ./' ) ;
		
	// Content begin

	//echo 'test' ;
	////
	//	INCLUDES
	////
	
	// 	Include the configuration File
	//define('__ROOT__', 
	//echo dirname(dirname(__FILE__));//); 
	
	echo ';'.realpath(__DIR__) ;
	//require_once(__ROOT__.'/config.php'); 
	/*$A[ 'CURRENT' ] = __DIR__ ;
	require_once( '\\..\\ini\\config.php' ) ;
	require_once( '\\..\\php\\lib\\library.php' ) ;
	require_once( '\\..\\ini\\paths.php' ) ;
	*/
	//require_once( $path ) ;
	
	/*
	//	Force Errors
	$A_[ 'ERROR' ] = true ;
	
	// 	Set Content Variable
	$A[ 'CONTENT' ] = 'content.php' ;
	
	//	Include the library
	require_once( $A[ 'D_LIB' ] ) ;

		
	////
	//	PARAMETER PARSING
	////
	
	//	wgt name	
	if( isset( $_GET[ 'wgt' ] ) )  
		$WGT[ 'WGT' ] = $_GET[ 'wgt' ] ;
	else 
		$WGT[ 'WGT' ] = NULL ;
	
	//	css files to use	
	if( isset( $_GET[ 'css' ] ) )  
		$WGT[ 'CSS' ] = $_GET[ 'css' ] ;
	else 
		$WGT[ 'CSS' ] = NULL ;
	
	//	javascript file to use	
	if( isset( $_GET[ 'css' ] ) )  
		$WGT[ 'JS' ] = $_GET[ 'js' ] ;
	else 
		$WGT[ 'JS' ] = NULL ;
		
	// 	configuration file to use
	if( isset( $_GET[ 'cfg' ] ) )  
		$WGT[ 'CONFIG' ] = $_GET[ 'cfg' ] ;
	else 
		$WGT[ 'CONFIG' ] = NULL ;
	
	//	widget arguments
	if( isset( $_GET[ 'argv' ] ) ) 
		$WGT[ 'ARGV' ] = $_GET[ 'argv'] ;
	else 
		$WGT[ 'ARGV' ] = NULL ;
		
	
	
	/*
	echo '<html>
			<head>' ;
	
	printJS( $A , $WGT[ 'JS' ] ) ;
	printCSS( $A , $WGT[ 'CSS' ] ) ;
	
	echo '</head><body class="dev"><div class="tools"><br/>DEVELOPER TOOL: WGT <br/><br/><table class="wgt">' ;
						
	if ( isset( $_GET[ 'man' ] ) ) {
		
		echo '<tr>
					<th>Argument</th>
					<th>Mandatory</th>
					<th>description</th>
					<th>example</th></tr>
				<tr>
					<th>wgt</th>
					<td>TRUE</td>
					<td>The name of the widget to view</td>
					<td> ... /PHPwgt.php?wgt=toolbar-menu</td>
				 </tr>
				 <tr>
					<th>man</th>
					<td></td>
					<td>Brings up the manual</td>
					<td> ... /PHPwgt.php?man</td>
				 </tr>
				 <tr>
					<th>css</th>
					<td></td>
					<td>Sets optional css files to use, will take a comma separated list.</td>
					<td> ... /PHPwgt.php?wgt=toolbar-menu&css=toolbar-menu.css,main.css</td>
				 </tr>
				 <tr>
					<th>cfg</th>
					<td></td>
					<td>Sets an alternate configuration files to use,default is config.php found in the widget.</td>
					<td> ... /PHPwgt.php?wgt=toolbar-menu&cfg=config.php</td>
				 </tr>
				 <tr>
					<th>argv</th>
					<td></td>
					<td>Sets optional run time parametrs to use, widget must be set to use them. Will take a comma separated list.</td>
					<td> ... /PHPwgt.php?wgt=toolbar-menu&argv=1,2,3,4</td>
				 </tr>
			</table>LIST OF WIDGETS<br/>' ;
			
		$item = getDirectoryList( $A , $A[ 'D_WGT' ] ) ;
		foreach( $item as $entryName )
			echo $entryName , '<br/>' ;
				
		echo '<br/></div>' ;

	}
	else if ( isset( $_GET[ 'wgt' ] ) ) {
		
		$WGT[ 'WGT' ] 		=  printArray( 'WGT' , $_GET[ 'wgt' ] ) ;
		$WGT[ 'PATH' ] 		=  printArray( 'PATH' , $A[ 'D_WGT' ].$_GET[ 'wgt' ].'/index.php' ) ;
		$WGT[ 'CSS' ] 		=  printArray( 'CSS' , $WGT[ 'CSS' ] ) ;
		$WGT[ 'CONFIG' ] 	=  printArray( 'CFG' , $WGT[ 'CONFIG' ] ) ;
		$WGT[ 'ARGV' ] 		=  printArray( 'ARGV' , $WGT[ 'ARGV' ] ) ;
			
		echo 	'</table><br/></div>' ;
		
		include ( $A[ 'D_WGT' ].$_GET[ 'wgt' ].'/index.php' ) ;
		
	}
	
	else header( 'Location: '.$A[ 'W_ROOT' ].'_portal/developer/test/PHPwgt.php?man' ) ;
	
	echo '</body></html>' ;*/
?>
