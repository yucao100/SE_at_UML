<?php 	
	/**
	 *  @File			page.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This is the application template
	 * 
	 * 	@changelog		
	 *	2/25/14			Created Template
	 */
		
	echo '<html>
	
			<head>' ;
				
				include( $A[ 'D_HEAD' ].'index.php' ) ;
				
	echo 	'</head>
	
			 <body>

				<div id="page">
				
					<div class="header">
					
						<div class="navigation">
						
							<div class="logo">
							
								<a href="' , $A[ 'W_ROOT' ] , '" >
									
									<img src="' , $A[ 'W_IMG' ] , '/logo/logo.png"/>
									
								</a>
								
							</div>';
							
								include( $A[ 'D_WGT' ].'navigation-menu/index.php' ) ;
							
					echo 	'
					
						</div>
					</div>
				
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
