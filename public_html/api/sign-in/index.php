<?php

require_once  dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");



use AbqAtNight\CapstoneProject\Admin;

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
	$secrets =  new \Secrets("/etc/apache2/capstone-mysql/cohort23/atnight.ini");
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
			throw (new \InvalidArgumentException("A password must be entered.", 401));
		} else {
			$adminPassword = $requestObject->adminPassword;
		}
var_dump($requestObject);
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

		//Hash the password provided by the admin.
		$hash = hash_pbkdf2("sha512", $adminPassword, $admin->getAdminHash(), 262144);

		//Check if the password hash matches what is in mySQL.
		if($hash !== $admin->getAdminHash()) {
			throw (new \InvalidArgumentException("Invalid password.", 401));
		}

		//Grab the admin from the database and put it into a session.
		$admin = Admin::getAdminByAdminId($pdo, $admin->getAdminId());
		$_SESSION["admin"] = $admin;

		//Create the authorization payload.
		$authObject = (object)[
			"adminId" => $admin->getAdminId(),
			"adminUsername" => $admin->getAdminUsername()
		];

		//Create and set the JWT.
		setJwtAndAuthHeader("auth", $authObject);

		$reply->message = "Sign in was successful.";
	} else {
		throw (new \InvalidArgumentException("Invalid HTTP request!"));
	}
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

//Sets up the response header.
header("Content-type: application/json");

//JSON encode the $reply object and echo it back to the front end.
echo  json_encode($reply);
