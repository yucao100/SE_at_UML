<?php 
		echo '<div class="toolbar-menu">
	
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
