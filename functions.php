<?php

function __autoload( $class ) {
	$class = strtolower( $class );
	#$path = "includes/classes/{$class}.php";
	$path = "{$class}.php";

	if( file_exists( $path ) ) {
		require_once( $path );
	} else if (file_exists( "${class}.cls.php" ) ) {
            require_once( "{$class}.cls.php" );
  } else {
		die( "<br />FUNCTIONS:: __autoload=> Class Not Found Error! - {$class}" );
	}
}

function redirect( $location ) {
	header( "Location: {$location}" );
}

function atomicErrors( $errNo, $errStr, $errFile, $errLine ) {
	echo "<br /><table class='error-table'>
	<tr>
	<td>
	<p class='error-header'>
	<strong>ERROR:</strong> {$errStr}
	</p>
	<p class='error-text'>
	Please try again, or contact us and tell us that an error occurred here::
	<strong>Error-line:</strong> {$errLine} of File: '{$errFile}'
	</p>";
	if( $errNo == E_USER_ERROR ) {
		echo "<p class='error-fatal'>
		This Error was <strong>FATAL</strong> so the program must terminate.
		</p>";
		echo "</td></tr></table>";
		exit;
	}
	echo "</td></tr></table>";
}

?>
