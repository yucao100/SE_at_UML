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
	echo '<table>
			<tr>
				<td>user</td>
				<td><input type="text"/></td>
			</tr>
			<tr>	
				<td>password</td>
				<td><input type="password"/></td>
			</tr>
			</table>
			
		<button onclick="window.location=\'',$A['W_ROOT'], 'profile/\';">LogIn</button>
		<button>Register</button>' ;
?>
