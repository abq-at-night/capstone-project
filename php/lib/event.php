<?php

namespace DeepDive\AbqAtNight;
// load the profile class

require_once(dirname(__DIR__, 1) . "/Classes/Event.php");

//use the constructor to create a new author
$test = new Event("e462fab1-e72d-4730-b9d8-3f7b43bd5ae7","570a137c-15e1-4c92-a657-e88e182eac2b", "21 and over", "Lorem ipsum dolor sit amet, consectetur adipiscing elit.", "2019-02-12 22:00:00", "bf5a4324-0f9b-41d9-966a-8f820a1c03cc", "7 at the door", "promowebsite.com", "2019-02-12 19:00:00", "New Show", "Venue", "venuewebsite.com");
var_dump($test);