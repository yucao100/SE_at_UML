<?php 	
	/**
	 *  @File			page.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This is the application template
	 * 
	 * 	@changelog		
	 * 	5/7/14			added obstart for redirect
	 *	2/25/14			Created Template
	 */
	
	// to be able to redirect 
	ob_start() ;	
	
	echo '<html>
	
			<head>' ;
				
				include( $A[ 'D_HEAD' ].'index.php' ) ;
				
	echo 	'</head>
	
			 <body>

				<div id="page">
				
					<div class="header">';
					
							$WGT[ 'CONFIG' ] = 'main-navigation.php' ;
							include( $A[ 'D_WGT' ].'navigation-menu/index.php' ) ;
							
			echo 	'</div>
				
					<div class="main">' ;
					
				 include( $A[ 'CONTENT' ] ) ;
						
			echo 	'</div>
					
					<div class="footer">';
						
						$footer = 1 ;
						//include( $A[ 'D_LIB' ].'footer-menu.php' ) ;
						
			echo	'</div>
				
				</div>
				
			</body>
			
		</html>' ;
?>
