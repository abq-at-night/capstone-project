<?php
require_once (dirname(__DIR__, 2) . "/vendor/autoload.php");
require_once ("/etc/apache2/capstone-mysql/Secrets.php");

/**
 * Function to get the latitude and longitude by the address
 *
 * @param string $address venue address
 * @throws \InvalidArgumentException if $address is not a string or is insecure
 * @return stdClass $reply
 **/

function getLatLongByAddress ($address) : \stdClass {
	if (empty($address) === true)  {
		throw(new \InvalidArgumentException("The address field is empty or insecure"));
	}
	$address = filter_var($address, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	$url = "https://maps.googleapis.com/maps/api/geocode/json";
	$secrets =  new \Secrets("/etc/apache2/capstone-mysql/cohort23/atnight.ini");
	$api = $secrets->getSecret("google");

	$json = file_get_contents($url . "?address=" . urlencode($address) . "&key=" . $api);
	$jsonObject = json_decode($json);
	$lat = $jsonObject->results[0]->geometry->location->lat;
	$long = $jsonObject->results[0]->geometry->location->lng;
	$reply = new stdClass();
	$reply->lat = $lat;
	$reply->long = $long;

	return $reply;
}