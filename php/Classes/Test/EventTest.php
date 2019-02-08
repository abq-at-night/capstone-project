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

	/**
	 * constructor for Event
	 *
	 * @param string|Uuid $newEventId id of this event or null if a new event
	 * @param string|Uuid $newEventAdminId id of the Admin that sent this Event
	 * @param string $newEventAgeRequirement string contains age event requirements.
	 * @param \DateTime|string $newEventDate date of the event
	 * @param string $newEventDescription description of the event
	 * @param \DateTime|string $newEventEndTime time event ends
	 * @param string|Uuid $newEventImage Id of this event poster
	 * @param string $newEventPrice price of the event
	 * @param string $newEventPromoterWebsite Url of the promoter website
	 * @param \DateTime|string $newEventStartTime time event starts
	 * @param string $newEventTitle title of the event
	 * @param string $newEventVenue name of venue hosting the event
	 * @param string $newEventVenueWebsite Url of the venue website
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

	public function __construct($newEventId, $newEventAdminId, string $newEventAgeRequirement, $newEventDate, string $newEventDescription, string $newEventEndTime, $newEventImage, string $newEventPrice, string $newEventPromoterWebsite, $newEventStartTime, string $newEventTitle, string $newEventVenue, string $newEventVenueWebsite) {
		try {
			$this->setEventId($newEventId);
			$this->setEventAdminId($newEventAdminId);
			$this->setEventAgeRequirements($newEventAgeRequirement);
			$this->setEventDate($newEventDate);
			$this->setEventDescription($newEventDescription);
			$this->setEventEndTime($newEventEndTime);
			$this->setEventImage($newEventImage);
			$this->setEventPrice($newEventPrice);
			$this->setEventPromoterWebsite($newEventPromoterWebsite);
			$this->setEventStartTime($newEventStartTime);
			$this->setEventTitle($newEventTitle);
			$this->setEventVenue($newEventVenue);
			$this->setEventVenueWebsite($newEventVenueWebsite);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for event id
	 *
	 * @return Uuid value of event id
	 **/
	public function getTweetId() : Uuid {
		return($this->eventId);
	}

	/**
	 * mutator method for event id
	 *
	 * @param Uuid|string $newEventId new value of event id
	 * @throws \RangeException if $newEventId is not positive
	 * @throws \TypeError if $newEventId is not a uuid or string
	 **/
	public function setEventId( $newEventId) : void {
		try {
			$uuid = self::validateUuid($newEventId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the tweet id
		$this->eventId = $uuid;
	}

}