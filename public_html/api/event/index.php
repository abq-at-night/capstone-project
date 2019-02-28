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
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);

	$eventTagTagId = filter_input(INPUT_GET, "eventTagTagId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventAdminId = filter_input(INPUT_GET, "eventAdminId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventTitle = filter_input(INPUT_GET, "eventTitle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
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

		} else if(empty($userLat) === false && empty($userLong) === false && empty($distance) === false) {
			$reply->data = Event::getEventByEventDistance($pdo, $userLong, $userLat, $distance)->toArray();

		} else {
			$reply->data = Event::getAllEvents($pdo)->toArray();
		}
	}