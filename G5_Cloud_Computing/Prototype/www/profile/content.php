<?php
	// Content Define Guard
	if ( !defined( 'CONTENT_GUARD' ) ) 
		header( 'Location: ./' ) ;
		
	// Content begin
			include( $A[ 'D_WGT' ].'toolbar-menu/index.php' ) ;
						
				echo 	'<div class="profile">' ;
						
							include( $A[ 'D_WGT' ].'toolbar-tabs/index.php' ) ;
							
							
						
							//include( $A[ 'CONTENT' ] ) ;
				echo 	'</div>' ;
?>
