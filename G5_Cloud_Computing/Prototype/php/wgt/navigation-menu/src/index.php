<?php

	echo '<div class="navigation">
						
				<div class="logo">
							
					<a href="' , $A[ 'W_ROOT' ] , '" >
									
						<img src="' , $A[ 'W_IMG' ] , '/logo/logo.png"/>
									
					</a>
								
				</div>
			
				<div class="navigation-menu">
	
				<ul>';
		
					for( $WGT[ 'I' ] = 0 ; $WGT[ 'I' ] < sizeof( $WGT[ 'MENU' ] )  ; ++$WGT[ 'I' ] ) {
						echo '<li> <a href="' , $WGT[ 'MENU' ][ $WGT[ 'I' ] ][ 0 ] , '">' , $WGT[ 'MENU' ][ $WGT[ 'I' ] ][ 1 ] , '</a> </li>' ;
					}								
		
		echo	'</ul>
			
			</div>
			
		</div>' ;
	
?>
