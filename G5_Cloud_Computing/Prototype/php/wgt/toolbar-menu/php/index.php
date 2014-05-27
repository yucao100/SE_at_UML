<?php
	
	/**
	 * This file contains the widget class
	 */
	
	if ( !defined( 'toolbarMenu' ) )  {
		
		define( 'toolbarMenu' , TRUE ) ;  
		
		class toolbarMenu {
			
			public function __construct( ) {}
			
			/**
			 * startMenu() 
			 * 
			 * generates a title
			 * 
			 * @param 	title	creates the title to the menu
			 */
			public function startMenu( $title ) {
			
				echo 	'<li>' , $title , '<ul>' ; 
			
			}
		
			/**
			 * endMenu() 
			 * 
			 * terminates a menu
			 */
			public function endMenu( ) {
			
				echo 	'</ul></li>' ;
		
			}
			
			/**
			 * item()
			 * 
			 * This function generates a menu line item.
			 * 
			 * @param 	icon	the fully qualified address of the image or NULL
			 * @param	link	the onclick function param
			 * @param	title	the action title
			 * 
			 * changelog 
			 * 5/7/14		Modified to accept enum value as an onclick 
			 * 				or to generate an actual link if the value is 
			 * 				a string
			 */
			public function item( $enum , $title , $pos = array() )  {
					
					if ( $enum == NULL && $title == NULL ) {
						$this->divider() ;
						return ;
					}					
										
					$pos[ 'x' ] = -16 * $pos[ 'x' ] ;
					$pos[ 'y' ] = -16 * $pos[ 'y' ] ;
					
					
					echo 	'<li> 
								
								<a class="toolbar-menu" ';
						// 5/7/14
						if ( is_string( $enum ) ) 					 
							echo '	 onclick="window.location.replace(\'' , $enum  , '\');"' ;
						else	
							echo '	 onclick="toolbar_menu_item(\'' , $enum  , '\');"' ;

						echo'>
								
									<div class="toolbar-menu-image" style="background-position:' , $pos['x'] , 'px ' , $pos['y']  , 'px;">
										
									</div>
								
									<div class="toolbar-menu-title">' , $title , '</div>
								
								</a>
								
							</li>' ;
					
				}
			
			/**
			 * divider()
			 * 
			 * This function generates a menu divider line item.
			 */	
			public function divider( )  {
				
					echo '<li class="divider"></li>' ;
				}

		}
	}
	
	// create an instance of the widget
	
	$WGT[ 'OBJ' ] = new toolbarMenu ;
		
?>
