<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

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
	// Grab the mySQL connection.
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/atnight.ini");
	// Determine which HTTP method was used.
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];
	// Sanitize the input.
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	// Handle the GET request - if the id is present that EventTag is returned; otherwise all EventTags are returned.
	if($method === "GET") {
		// Set XSRF cookie.
		setXsrfCookie();
		// Get a specific eventTag or all eventTags and update reply
		if(empty($id) === false) {
			//********Should we also try getting Event Tags by eventTagTagId? If so, how would we add that?
			$reply->data = EventTag::getEventTagByEventTagEventId($pdo, $id);
		} else {
			$reply->data = EventTag::getEventTagByEventTagEventIdAndEventTagTagId($pdo)->toArray();
		}
	} else if($method === "DELETE") {

		//Enforce that the end user has an XSRF token.
		verifyXsrf();

		// Retrieve the EventTag to be deleted
		$eventTag = EventTag::getEventTagByEventTagEventId($pdo, $id);
		if($eventTag === null) {
			throw(new RuntimeException("The EventTag does not exist.", 404));
		}
		//*************Ask about this one.
		//Enforce the admin is signed in and only trying to edit their own eventTag.
		if(empty($_SESSION["admin"]) === true || $_SESSION["admin"]->getAdminId() !== $event->getEventAdminId()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this eventTag.", 403));
		}

		// Delete the eventTag.
		$eventTag->delete($pdo);
		// Update the reply.
		$reply->message = "EventTag deleted OK";
	}
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}


// Encode and return reply to the front-end caller.
header("Content-type: application/json");
echo json_encode($reply);
