<?php
	/**
	 *  @File			content.php
	 * 	@Authors		Jose Flores
	 * 					jose.flores.152@gmail.com
	 * 	
	 * 	@Description	This file holds the registration/ login page
	 * 
	 * 	@changelog		
	 * 	3/20/14			Added dummy registration form for presentation
	 *	2/25/14			Generated template
	 */
	 
	//	Define guard prevents acces unless from the index.php file at 
	//	this level
	if ( !defined( 'CONTENT_GUARD' ) ) 
		header( 'Location: ./' ) ;
		
	// Content begin
	$str = '<table class="form">' ;
				
					$str .= '<tr class="sec-registration-line">
						<td colspan="2"><h3> Login </h3> </td>
					</tr>' ;
					
					$str .= '<tr class="sec-registration-line">
								<td>Email</td>
								<td><input style="width:200px" type="text"/></td>
							</tr>' ;
							
					$str .= '<tr class="sec-registration-line">
								<td>Password</td>
								<td><input style="width:200px" type="password"/></td>
							</tr>' ;
							
					$str .= '<tr class="sec-registration-line">
								<td></td>
								<td><button>Login</button></td>
							</tr></table>' ;
					
	echo $str ;						
	
?>
