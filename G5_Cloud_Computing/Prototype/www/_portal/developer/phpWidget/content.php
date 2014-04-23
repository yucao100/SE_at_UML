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
	if ( !isset( $_GET[ 'wgt' ] ) &&  
		 !isset( $_GET[ 'man' ] ) ) 
			header( 'Location: ./?man' ) ;
		
	////
	//	PARAMETER PARSING
	////
	
	//	wgt name	
	if( isset( $_GET[ 'wgt' ] ) )  {
		$WGT[ 'WGT' ] = $_GET[ 'wgt' ] ;
		$WGT[ 'CSS' ] = $_GET[ 'wgt' ].'.css' ;
	}
	else {
		$WGT[ 'WGT' ] = NULL ;
		$WGT[ 'CSS' ] = NULL ;
	}
	
	//	css files to use	
	if( isset( $_GET[ 'css' ] ) )  
		$WGT[ 'CSS' ] = $_GET[ 'css' ] ;
		
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
		
	
	
	echo '<html>
			<head>' ;
	
	echo getDevHead( $A , $WGT[ 'CSS' ] , $WGT[ 'JS' ] ) ;
		
	echo '</head><body class="dev"><div class="tools"><p>DEVELOPER TOOL: WGT</p><table class="wgt">' ;
						
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
					<td> /?wgt=toolbar-menu</td>
				 </tr>
				 <tr>
					<th>man</th>
					<td></td>
					<td>Brings up the manual</td>
					<td> /?man</td>
				 </tr>
				 <tr>
					<th>css</th>
					<td></td>
					<td>Sets optional css files to use, will take a CSV list.</td>
					<td> /?wgt=toolbar-menu&css=toolbar-menu.css,main.css</td>
				 </tr>
				 <tr>
					<th>cfg</th>
					<td></td>
					<td>Sets an alternate configuration file to use,default is config.php found in the widget.</td>
					<td> /?wgt=toolbar-menu&cfg=config.php</td>
				 </tr>
				 <tr>
					<th>argv</th>
					<td></td>
					<td>Sets optional run time parametrs to use, widget must be set to use them. Will take a comma separated list.</td>
					<td> /?wgt=toolbar-menu&argv=1,2,3,4</td>
				 </tr>
				<tr>
					<th>List of Widgets</th>
					<td><ul>';
						$item = getDirectoryList( $A , $A[ 'D_WGT' ] ) ;
						foreach( $item as $entryName )
							echo '<li>' , $entryName , '</li>' ;
					
				echo '</ul></td>
					<td></td>
					<td></td>
				</tr>' ;

	}
	else if ( isset( $_GET[ 'wgt' ] ) ) {
		
		echo getDevRow( 'WGT' , $_GET[ 'wgt' ] ) ;
		echo getDevRow( 'PATH' , $A[ 'D_WGT' ].$_GET[ 'wgt' ].'\\index.php' ) ;
		echo getDevRow( 'CSS' , $WGT[ 'CSS' ] ) ;
		echo getDevRow( 'CFG' , $WGT[ 'CONFIG' ] ) ;
		echo getDevRow( 'ARGV' , $WGT[ 'ARGV' ] ) ;
		
	}
	
	echo '</table>' ;
	
	if ( isset( $_GET[ 'wgt' ] ) )
		include ( $A[ 'D_WGT' ].$_GET[ 'wgt' ].'/index.php' ) ;
		
	echo '</body></html>' ;
?>
