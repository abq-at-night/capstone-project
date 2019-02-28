<?php

require_once  dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use AbqAtNight\CapstoneProject\{
	Admin
};

/**
 * API for app sign in, Admin class
 *
 * POST requests are supported.
 *
 * @author Hunter Callaway <jcallaway3@cnm.edu>
 **/

//Verify the session. If it's not active, start it.
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//Prepare an empty reply.
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {

	//Grab the mySQL connection.
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/atnight.ini");
	$pdo = $secrets->getPdoObject();

	//Determine which HTTP method was used.
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//If the method is POST, handle the sign-in logic.
	if($method === "POST") {

		//Make sure the XSRF Token is valid.
		verifyXsrf();

		//Process the request content and decode the json object into a PHP object.
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//Check for the password (required field).
		if(empty($requestObject->adminPassword) === true) {
			throw (\new \InvalidArgumentException("A password must be entered.", 401));
		} else {
			$adminPassword = $requestObject->adminPassword;
		}

		//Check for the email (required field).
		if(empty($requestObject->adminEmail) === true) {
			throw (new \InvalidArgumentException("An email address must be entered.", 401));
		} else {
			$adminEmail = filter_var($requestObject->adminEmail, FILTER_VALIDATE_EMAIL);
		}

		//Grab the admin from the database by the email address provided.
		$admin = Admin::getAdminByAdminEmail($pdo, $adminEmail);
		if(empty($admin) === true) {
			throw(new \InvalidArgumentException("Invalid Email", 401));
		}
	}
}
