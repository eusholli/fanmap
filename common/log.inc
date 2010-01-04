<?php

// custom handler
function log($type, $msg, $file, $line)
{
	// log all errors
	error_log("$msg (error type $type)", 3, "/var/log/apache2/php.log");
	
	// if fatal error, die()
	if ($type == E_USER_ERROR)
	{
		die($msg);
	}
}

?>
