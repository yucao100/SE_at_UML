<?php
	$basePath = dirname(__FILE__);
	require_once( $basePath."/../ini/config.php" );
	
	$A[ 'CONTENT' ] = 'content.php' ;
	
	require_once( $A[ 'D_TMP' ].'page.php') ;
?>
