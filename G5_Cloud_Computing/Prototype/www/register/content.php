<?php
	// Content Define Guard
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
