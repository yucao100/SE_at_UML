<?php 
		echo '<div class="toolbar-menu" style="';
			
			if ( $WGT[ 'ARGC' ] > 0 ) 
				echo ' background:' , $WGT[ 'ARGV' ][ 0 ] , ';' ;
				
			if ( $WGT[ 'ARGC' ] > 1  ) 
				echo ' color:' , $WGT[ 'ARGV' ][ 1 ] , ';' ;
			
		echo '">
	
				<ul id="toolbar-menu-ul">' ;
					
		
		// For every menu topic
		for( $WGT[ 'COL' ] = 0 ; $WGT[ 'COL' ] < sizeof( $WGT[ 'MENU' ][ 'TTL' ] )  ; ++$WGT[ 'COL' ] ) {
			
			// Print Title
			$WGT[ 'OBJ' ]->startMenu( $WGT[ 'MENU' ][ 'TTL' ][ $WGT[ 'COL' ] ] ) ;
			
			
			for( $WGT[ 'ITEM' ] = 0 ; $WGT[ 'ITEM' ] < sizeof( $WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COL' ] ] ) ; ++$WGT[ 'ITEM' ] ) {
				// Action 
				$WGT[ 'OBJ' ]->item( 
					$WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COL' ] ][ $WGT[ 'ITEM' ] ][ 0 ] , 
					$WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COL' ] ][ $WGT[ 'ITEM' ] ][ 1 ] , 
					$WGT[ 'MENU' ][ 'LNK' ][ $WGT[ 'COL' ] ][ $WGT[ 'ITEM' ] ][ 2 ] ) ;
			}
			
			// End menu
			$WGT[ 'OBJ' ]->endMenu( ) ;
		}		
					
					
					
		echo 	'</ul>
	
			</div>' ;
	
?>
