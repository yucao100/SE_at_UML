<?php

	/**
	 * This file contains the widget class
	 */
	
	if ( !defined( 'secRegistration' ) )  {
		
		define( 'secRegistration' , TRUE ) ;
		
		class secRegistration {
			private $form ;
			private $name ;
			
			public function __construct(  ) {
			
			}
			
			public function getForm( $name , $form ) {
				$str = $this->startForm( $name ) ;
				$str.= $this->genForm( $form ) ;
				$str.= $this->endForm() ;
				return $str ;
			}
			public function startForm( $name ) {
				$str = '' ;
				$str .= '<form name="' . $name . '" id="' . $name . '" >' ;
				return $str ;
			}
			
			public function genForm( $form ) {
				$str = '' ;
				$str .= '<table class="form">' ;
				
					$str .= '<tr class="sec-registration-line">
						<td colspan="2"><h3> Register</h3> </td>
					</tr>' ;
					
					$str .= '<tr class="sec-registration-line">
								<td>Email</td>
								<td><input style="width:200px" type="text"/></td>
							</tr>' ;
					
					$str .= '<tr class="sec-registration-line">
								<td>First Name</td>
								<td><input style="width:200px" type="text"/></td>
							</tr>' ;
					
					$str .= '<tr class="sec-registration-line">
								<td>Middle Name</td>
								<td><input style="width:200px" type="text"/></td>
							</tr>' ;
					
					$str .= '<tr class="sec-registration-line">
								<td>Last Name</td>
								<td><input style="width:200px" type="text"/></td>
							</tr>' ;
					
					$str .= '<tr class="sec-registration-line">
								<td>Password</td>
								<td><input style="width:200px" type="password"/></td>
							</tr>' ;
					
					$str .= '<tr class="sec-registration-line">
								<td>Confirm Password</td>
								<td><input style="width:200px" type="password"/></td>
							</tr>' ;
					
					$str .= '<tr class="sec-registration-line">
								<td>Date Of Birth</td>
								<td>
									<input class="date" type="text"/>
									<input class="date" type="text"/>
									<input class="date" type="text"/>
								</td>
							</tr>' ;

					$str .= '<tr class="sec-registration-line">
								<td>Phone Number</td>
								<td>
									<input class="number" type="text"/>
									<input class="number" type="text"/>
									<input class="number" type="text"/>
									<input class="number" type="text"/>
									<input class="number" type="text"/>
								</td>
							</tr>' ;
					
					$str .= '<tr class="sec-registration-line">
								<td></td>
								<td><button>Register</button></td>
							</tr>' ;		
														
							
				$str .='</table>' ;
				return $str ;
			}
			
			
			
			public function endForm() {
				$str = '' ;
				$str .= '</form>' ;
				return $str ;
			}
		}
	}
	
	// create an instance of the widget
	
	$WGT['OBJ'] = new secRegistration() ;
