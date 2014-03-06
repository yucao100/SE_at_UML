<?php

	echo '<div class="navigation-menu">
	
			<ul>';
	
				for( $WGT[ 'I' ] = 0 ; $WGT[ 'I' ] < sizeof( $WGT[ 'MENU' ] )  ; ++$WGT[ 'I' ] ) {
					echo '<li> <a href="' , $WGT[ 'MENU' ][ $WGT[ 'I' ] ][ 0 ] , '">' , $WGT[ 'MENU' ][ $WGT[ 'I' ] ][ 1 ] , '</a> </li>' ;
				}								
	
	echo	'</ul>
		
		</div>' ;
	
?>
