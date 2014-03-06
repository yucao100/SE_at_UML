<?php
	
	ini_set( 'display_errors' , 'on' ) ;
	ini_set( 'error_prepend_string', '<div class="error">[ PHP ]' ) ;
	ini_set( 'error_append_string',  '</div>' );
	
	require_once( 'D:/webapps/csr/ini/config.php' ) ;
	
	$A[ 'CONTENT' ] = 'content.php' ;
	
	$WGT[ 'WGT' ] 	=  NULL ;
	$WGT[ 'CSS' ] 	=  NULL ;
	$WGT[ 'CONFIG' ] = NULL ;
	$WGT[ 'ARGV' ] 	=  NULL ;
	
	if( isset( $_GET[ 'wgt' ] ) )  $WGT[ 'WGT' ] 	=  $_GET[ 'wgt' ] ;
	if( isset( $_GET[ 'css' ] ) )  $WGT[ 'CSS' ] 	=  $_GET[ 'css' ] ;
	if( isset( $_GET[ 'cfg' ] ) )  $WGT[ 'CONFIG' ] =  $_GET[ 'cfg' ] ;
	if( isset( $_GET[ 'argv' ] ) ) $WGT[ 'ARGV' ] 	=  $_GET[ 'argv' ] ;
		
	function printArray( $title , $arg ) {
		if ( isset( $arg ) ) {
			
			if ( strpos( $arg ,',') == true ) 
				$out = explode( ',' , $arg ) ; 	
			else 
				$out = $arg ;
		
			echo '<tr><th>' , $title , '</th><td>' , rtrim( print_r( $out ) , '1' ) , '</td></tr>' ;
			return $out ;
		}
		return NULL ;
	}
	
	function printJS($A) {
			echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>' ;
			echo '<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>' ;
			echo '<script src="' , $A['W_JS_LIB'] , 'onload.js"></script>' ;
		}
		
	function printCSS( $arg , $name , $A ) {
		if ( $arg != NULL ) {
			$out = explode( ',' , $arg ) ; 	
			
			foreach ( $out as $i )
				echo '<link href="' , $A[ 'W_CSS' ] , $i ,'" rel="stylesheet" type="text/css">' ;
		}
		else {
			echo '<link href="' , $A[ 'W_CSS' ] , 'main.css" rel="stylesheet" type="text/css">' ;
			echo '<link href="' , $A[ 'W_CSS' ] , $name ,'.css" rel="stylesheet" type="text/css">' ;
		}
		
		echo '<link href="' , $A[ 'W_CSS' ] ,'developer-tools.css" rel="stylesheet" type="text/css">' ;
		echo '<link href="' , $A[ 'W_CSS' ] ,'jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css">' ;
		
	}	
	
	
	echo '<html><head>' ;
	
	printJS($A) ;
	
	if ( isset( $_GET[ 'man' ] ) ) {
	
		printCSS( $WGT[ 'CSS' ] , 'developer-tools' , $A ) ;
		
		echo '</head><body class="dev"><div class="tools">
			<br/>DEVELOPER TOOL: WGT <br/><br/>
			<table class="wgt"">
				<tr><th>Argument</th><th>Mandatory</th><th>description</th><th>example</th></tr>
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
			</table>
			LIST OF WIDGETS<br/>' ;
			
		$myDirectory = opendir(  $A[ 'D_WGT' ] ) ;
		
		while ( $entryName = readdir( $myDirectory ) ) 
			if ( $entryName != '.' && $entryName != '..' ) 
				echo $entryName , '<br/>' ;
				
		echo '<br/></div>' ;
		
		
		

	}
	else if ( isset( $_GET[ 'wgt' ] ) ) {
		
		printCSS( $WGT[ 'CSS' ] , $_GET[ 'wgt' ] , $A ) ;

		echo '</head>
				<body class="dev">
					<div class="tools">
						<br/>DEVELOPER TOOL: WGT <br/><br/>
						<table class="wgt">';
		
							$WGT[ 'WGT' ] 		=  printArray( 'WGT' , $_GET[ 'wgt' ] ) ;
							$WGT[ 'PATH' ] 		=  printArray( 'PATH' , $A[ 'D_WGT' ].$_GET[ 'wgt' ].'/index.php' ) ;
							$WGT[ 'CSS' ] 		=  printArray( 'CSS' , $WGT[ 'CSS' ] ) ;
							$WGT[ 'CONFIG' ] 	=  printArray( 'CFG' , $WGT[ 'CONFIG' ] ) ;
							$WGT[ 'ARGV' ] 		=  printArray( 'ARGV' , $WGT[ 'ARGV' ] ) ;
			
				echo 	'</table>
						<br/>
					</div>' ;
		
		include ( $A[ 'D_WGT' ].$_GET[ 'wgt' ].'/index.php' ) ;
		
	}
	else header( 'Location: '.$A[ 'W_ROOT' ].'_portal/developer/test/PHPwgt.php?man' ) ;
	
	echo '</body>
	</html>' ;
?>
