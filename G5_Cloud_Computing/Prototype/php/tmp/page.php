<?php 	
	// require_once( $A[ 'D_API' ].'index.php') ;
	// require_once( $A[ 'D_LIB' ].'index.php') ;
	
	// $user = new session() ;
	
	// $user.init() ;
	// $user.validate()	; 
	
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
