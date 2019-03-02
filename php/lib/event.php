<?php

namespace AbqAtNight\CapstoneProject;
// load the profile class
require_once("/etc/apache2/capstone-mysql/Secrets.php");
use AbqAtNight\CapstoneProject\{Event, Admin};

require_once(dirname(__DIR__, 1) . "/Classes/Admin.php");
require_once(dirname(__DIR__, 1) . "/Classes/Event.php");

//use the constructor to create a new author
$secrets =  new \Secrets("/etc/apache2/capstone-mysql/cohort23/atnight.ini");
$pdo = $secrets->getPdoObject();

$event = new Event("2608d9a5-fe0f-4ed6-9574-0d9c3d016eca", "0e3bf5bf-722a-41eb-b742-42450522ff0e", "All ages", "Bringin' the rock.", "2019-03-31 02:00:00", "www.sweetpic.com", "35.084112", "-106.651193", "$25.00", "www.mypromotersite.com", "2019-03-30 21:00:00", "Rock ABQ presents Hinder and Trapt", "Sunshine Theater", "www.sunshinetheaterlive.com");
$event->insert($pdo);
var_dump($event);
$newEvent = Event::getEventByEventId($pdo, $event->getEventId());
var_dump($newEvent);