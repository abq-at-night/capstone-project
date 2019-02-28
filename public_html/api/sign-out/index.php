<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

/**
 * API for signing out
 *
 * @author Hunter Callaway <jcallaway3@cnm.edu>
 **/
//Verify the XSRF challenge.
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//Prepare the default error message.
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//Grab the mySQL connection.
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/atnight.ini");
	//Determine which HTTP method was used.
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER)
}