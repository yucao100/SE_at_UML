<?php 
	
	
	// Content begin
	if ( !isset( $_GET[ 'wgt' ] ) &&  
		 !isset( $_GET[ 'man' ] ) ) 
			header( 'Location: ./?man' ) ;
		
	////
	//	PARAMETER PARSING
	////
	
	$parameters = $WGT[ 'OBJ' ]->setParameters() ;
		
	echo $WGT[ 'OBJ' ]->getTitle() ;
						
	if ( isset( $_GET[ 'man' ] ) ) {
		
		echo $WGT[ 'OBJ' ]->getManual( $A ) ;

	}
	else if ( isset( $_GET[ 'wgt' ] ) ) {
		
		echo $WGT[ 'OBJ' ]->getStats( $A ,$parameters ) ;
		
	}
	
	// Destroying instance of the developer tool early before the index
	// file can to prevent polution of the next widget
	unset( $WGT ) ;
	
	// assigning discovered parameters
	$WGT = $parameters ;
	
	// calling experimental widget
	if ( isset( $_GET[ 'wgt' ] ) )
		include ( $A[ 'D_WGT' ].$_GET[ 'wgt' ].'/index.php' ) ;
	
	echo '</div>' ;
	
?>
