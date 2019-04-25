<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/var/www/secrets/Secrets.php");

use AbqAtNight\CapstoneProject\{
	Event, Tag, EventTag
};

/**
 * API for the EventTag class
 *
 * @author <jcallaway3@cnm.edu>
 **/

// Verify the session and start it if it is not active.
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// Prepare an empty reply.
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the mySql connection
	$secrets = new \Secrets("/var/www/secrets/atnight.ini");
	$pdo = $secrets->getPdoObject();

	// Determine which HTTP method was used.
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// Sanitize the input.
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//enforce the uer has a XSRF token
	verifyXsrf();

	// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the
	// front end request which is, in this case, a JSON package.
	$requestContent = file_get_contents("php://input");

	// This Line Then decodes the JSON package and stores that result in $requestObject
	$requestObject = json_decode($requestContent);

	//make sure tag content is available (required field)
	if(empty($requestObject->eventTagEventId) === true) {
		throw(new \InvalidArgumentException ("No content for eventTagEventId.", 405));
	}

	if(empty($requestObject->eventTagTagId) === true) {
		throw(new \InvalidArgumentException ("No content for eventTagTagId.", 405));
	}

// enforce the user is signed in
	if(empty($_SESSION["admin"]) === true) {
		throw(new \InvalidArgumentException("you must be logged in to post eventTag", 403));
	}

	// Handle the POST request
	if($method === "POST") {


		// Set JWT cookie.
		validateJwtHeader();

		// create new tag and insert into database
		$eventTag = new eventTag($requestObject->eventTagEventId, $requestObject->eventTagTagId);
		$eventTag->insert($pdo);

		// update reply
		$reply->message = "eventTag Created OK";

	} else if($method === "PUT") {

		//Enforce that the end user has an XSRF token.
		verifyXsrf();

		// Retrieve the EventTag to be deleted
		$eventTag = EventTag::getEventTagByEventTagEventIdAndEventTagTagId($pdo, $requestObject->eventTagEventId, $requestObject->eventTagTagId);
		if($eventTag === null) {
			throw(new RuntimeException("The EventTag does not exist.", 404));
		}

		//todo Ask about this one.
		//Enforce the admin is signed in and only trying to edit their own eventTag.
		if(empty($_SESSION["admin"]) === true) {
			throw(new \InvalidArgumentException("You are not allowed to delete this eventTag.", 403));
		}

		// Delete the eventTag.
		$eventTag->delete($pdo);
		// Update the reply.
		$reply->message = "EventTag deleted OK";
	} else {
		throw(new \InvalidArgumentException("Invalid HTTP request"));
	}

	// update the $reply->status $reply->message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

// Encode and return reply to the front-end caller.
header("Content-type: application/json");
echo json_encode($reply);

// finally - JSON encodes the $reply object and sends it back to the front end.