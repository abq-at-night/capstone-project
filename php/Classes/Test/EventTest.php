<?php
namespace Edu\Cnm\DataDesign\Test;
use Edu\Cnm\DataDesign\{Event};

//Grab the Admin class.
require_once(dirname(__DIR__) . "/autoload.php");

//Grab the UUID generator.
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Event class
 *
 * This is a complete PHPUnit test of the Event class. It is complete because all mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Event
 * @author Wyatt Salmons <wyattsalmons@gmail.com>
 *
 **/
class Event implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;

	/**
	 * id for Event; this is the primary key
	 * @var Uuid $eventId
	 **/
	private $eventId;

	/**
	 * id of the Admin that created this event; this is a foreign key
	 * @var Uuid $eventAdminId
	 **/
	private $eventAdminId;

	/**
	 * age requirement reported for this event
	 * @var string $eventAgeRequirement
	 **/
	private $eventAgeRequirement;

	/**
	 * date of this event in a php datetime object
	 * @var datetime $eventDate
	 **/
	private $eventDate;

	/**
	 * description of the event
	 * @var string $eventDescription
	 **/
	private $eventDescription;

	/**
	 * time the event ends
	 * @var datetime $eventEndTime
	 **/
	private $eventEndTime;

	/**
	 * event poster image Id
	 * @var Uuid $eventImage
	 **/
	private $eventImage;

	/**
	 * price of the event
	 * @var string $eventPrice
	 **/
	private $eventPrice;

	/**
	 * website url of promoter
	 * @var string $eventPromoterWebsite
	 **/
	private $eventPromoterWebsite;

	/**
	 * time the event starts
	 * @var string $eventStartTime
	 **/
	private $eventStartTime;

	/**
	 * title of the event
	 * @var string $eventTitle
	 **/
	private $eventTitle;

	/**
	 * venue the event is held at
	 * @var string $eventVenue
	 **/
	private $eventVenue;

	/**
	 * url of the venue hosting the event
	 * @var string $eventVenueWebsite
	 **/
	private $eventVenueWebsite;
}
