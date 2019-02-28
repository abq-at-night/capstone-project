<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use AbqAtNight\CapstoneProject\{
	Event,
	// we only use the Admin class for testing purposes
	Admin
};


/**
 * api for the Event class
 *
 * @author {} <wyattsalmons@gmail.com>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/at-night.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	$eventTagTagId = filter_input(INPUT_GET, "eventTagTagId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventAdminId = filter_input(INPUT_GET, "eventAdminId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventTitle = filter_input(INPUT_GET, "eventTitle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	//TODO eventEnd and eventStart Time??
	$distance = filter_input(INPUT_GET, "distance", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$userLat = filter_input(INPUT_GET, "userLat", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$userLong = filter_input(INPUT_GET, "userLong", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);


	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific tweet based on arguments provided or all the tweets and update reply
		if(empty($id) === false) {
			$reply->data = Event::getEventByEventId($pdo, $id);

		} else if(empty($eventAdminId) === false) {
			$reply->data = Event::getEventByEventAdminId($pdo, $eventAdminId)->toArray();

		} else if(empty($eventTitle) === false) {
			$reply->data = Event::getEventByEventTitle($pdo, $eventTitle)->toArray();
//TODO is this right??
		} else if(empty($eventEndTime) === false && empty($eventStartTime) === false) {
			$reply->data = Event::getEventByEventTime($pdo, $eventEndTime, $eventStartTime)->toArray();

		} else if(empty($userLat) === false && empty($userLong) === false && empty($distance) === false) {
			$reply->data = Event::getEventByEventDistance($pdo, $userLong, $userLat, $distance)->toArray();
//TODO what do we do if we cant end in getAllEvents????
		} else {
			$reply->data = Event::getAllEvents($pdo)->toArray();
		}
	} else if($method === "PUT" || $method === "POST") {

		// enforce the user has a XSRF token
		verifyXsrf();

		//  Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestContent = file_get_contents("php://input");

		// This Line Then decodes the JSON package and stores that result in $requestObject
		$requestObject = json_decode($requestContent);
//TODO comb to see what is required...if not remove throw and return null.
		//make sure content is available (required field)
		if(empty($requestObject->eventAgeRequirment) === true) {
			throw(new \InvalidArgumentException ("No Content Found.", 405));
		}

		if(empty($requestObject->eventDescription) === true) {
			throw(new \InvalidArgumentException ("No Content Found.", 405));
		}

		if(empty($requestObject->eventEndTime) === true) {
			throw(new \InvalidArgumentException ("No Content Found.", 405));
		}

		if(empty($requestObject->eventImage) === true) {
			throw(new \InvalidArgumentException ("No Content Found.", 405));
		}

		if(empty($requestObject->eventLat) === true) {
			throw(new \InvalidArgumentException ("No Content Found.", 405));
		}

		if(empty($requestObject->eventLng) === true) {
			throw(new \InvalidArgumentException ("No Content Found.", 405));
		}

		if(empty($requestObject->eventPrice) === true) {
			throw(new \InvalidArgumentException ("No Content Found.", 405));
		}

		if(empty($requestObject->eventPromoterWebsite) === true) {
			throw(new \InvalidArgumentException ("No Content Found.", 405));
		}

		if(empty($requestObject->eventStartTime) === true) {
			throw(new \InvalidArgumentException ("No Content Found.", 405));
		}

		if(empty($requestObject->eventTitle) === true) {
			throw(new \InvalidArgumentException ("No Content Found.", 405));
		}

		if(empty($requestObject->eventVenue) === true) {
			throw(new \InvalidArgumentException ("No Content Found.", 405));
		}

		if(empty($requestObject->eventVenueWebsite) === true) {
			throw(new \InvalidArgumentException ("No Content Found.", 405));
		}
//TODO not sure if the times are handled right here...
		// make sure Event end date is accurate
		if(empty($requestObject->eventEndTime) === true) {
			$requestObject->eventEndTime = null;
		} else {
			// if the date exists, Angular's milliseconds since the beginning of time MUST be converted
			$eventEndTime = DateTime::createFromFormat("U.u", $requestObject->eventEndTime / 1000);
			if($eventEndTime === false) {
				throw(new RuntimeException("invalid event date", 400));
			}
			$requestObject->eventEndDate = $eventEndTime;
		}

		// make sure Event end date is accurate
		if(empty($requestObject->eventStartTime) === true) {
			$requestObject->eventStartTime = null;
		} else {
			// if the date exists, Angular's milliseconds since the beginning of time MUST be converted
			$eventStartTime = DateTime::createFromFormat("U.u", $requestObject->eventStartTime / 1000);
			if($eventStartTime === false) {
				throw(new RuntimeException("invalid event date", 400));
			}
			$requestObject->eventStartTime = $eventStartTime;
		}

		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the event to update
			$event = Event::getEventByEventId($pdo, $id);
			if($event === null) {
				throw(new RuntimeException("Event does not exist", 404));
			}

			//enforce the user is signed in and only trying to edit their own event
			if(empty($_SESSION["admin"]) === true || $_SESSION["admin"]->getAdminId()->toString() !== $event->getEventAdminId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this event", 403));
			}

			// update all attributes
			$event->setEventAgeRequirement($requestObject->eventAgeRequirement);
			$event->setEventDescription($requestObject->eventDescription);
			$event->setEventEndTime($requestObject->eventEndTime);
			$event->setEventImage($requestObject->eventImage);
			$event->setEventLat($requestObject->eventLat);
			$event->setEventLng($requestObject->eventLng);
			$event->setEventPrice($requestObject->eventPrice);
			$event->setEventPromoterWebsite($requestObject->eventPromoterWebsite);
			$event->setEventStartTime($requestObject->eventStartTime);
			$event->setEventTitle($requestObject->eventTitle);
			$event->setEventVenue($requestObject->eventVenue);
			$event->setEventVenueWebsite($requestObject->eventVenueWebsite);
			$event->update($pdo);

			// update reply
			$reply->message = "Event updated OK";

		} else if($method === "POST") {

			// enforce the admin is signed in
			if(empty($_SESSION["admin"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post events", 403));
			}
//TODO do we need the validateJwtHeader?
			validateJwtHeader();

			// create new event and insert into the database
			$event = new Event(generateUuidV4(), $_SESSION["admin"]->getAdminId,
				$requestObject->eventAgeRequirement,
				$requestObject->eventDescription,
				$requestObject->eventEndTime,
				$requestObject->eventImage,
				$requestObject->eventLat,
				$requestObject->eventLng,
				$requestObject->eventPrice,
				$requestObject->eventPromoterWebsite,
				$requestObject->eventStartTime,
				$requestObject->eventTitle,
				$requestObject->eventVenue,
				$requestObject->eventVenueWebsite);
			$event->insert($pdo);

			// update reply
			$reply->message = "Event created OK";
		}

	} else if($method === "DELETE") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the Tweet to be deleted
		$event = Event::getEventByEventId($pdo, $id);
		if($event === null) {
			throw(new RuntimeException("Event does not exist", 404));
		}
//TODO do we need the tostrings?
		//enforce the user is signed in and only trying to edit their own event
		if(empty($_SESSION["admin"]) === true || $_SESSION["admin"]->getAdminId()->toString !== $event->getEventAdminId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this event", 403));
		}

		// delete event
		$event->delete($pdo);
		// update reply
		$reply->message = "Event deleted OK";
	} else {
		throw(new \InvalidArgumentException("Invalid HTTP request"));
	}
}
// update the $reply->status $reply->message
catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

// encode and return reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);

// finally - JSON encodes the $reply object and sends it back to the front end.