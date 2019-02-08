<?php
namespace Deepdivedylan\DataDesign;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Class that posts an event
 *
 * @author Wyatt Salmons <wyattsalmons@gmail.com>
 **/

class event implements \JsonSerializable {
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
	 * @param string $newEventAgeRequirement string contains age event requirement.
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
			$this->setEventAgeRequirement($newEventAgeRequirement);
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

		// convert and store the event id
		$this->eventId = $uuid;
	}

	/**
	 * accessor method for eventAdminId
	 *
	 * @return Uuid value of eventAdminId
	 **/
	public function getEventAdminId() : Uuid {
		return($this->eventAdminId);
	}

	/**
	 * mutator method for eventAdminId
	 *
	 * @param Uuid|string $newEventAdminId new value of adminEventid
	 * @throws \RangeException if $newAdminEvent is not positive
	 * @throws \TypeError if $newTweetId is not a uuid or string
	 **/
	public function setEventAdminId( $newEventAdminId) : void {
		try {
			$uuid = self::validateUuid($newEventAdminId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the eventAdminId
		$this->eventAdminId = $uuid;
	}

	/**
	 *accessor method for event age requirement
	 *
	 * @return string value of age requirement
	 */
	public function getEventAgeRequirement() : string {
		return($this->eventAgeRequirement);
	}
	/**
	 * mutator method for event age requirement
	 *
	 * @param string $newEventAgeRequirement new value of event age requirement
	 * @throws \InvalidArgumentException if $eventAgeRequirement is not a string or insecure
	 * @throws \RangeException if $eventAgeRequirement is > 128 characters
	 * @throws \TypeError if $eventAgeRequirement is not a string
	 */
	public function setEventAgeRequirement(string $newEventAgeRequirement) : void {
		// verify event age requirement is secure
		$newEventAgeRequirement = trim($newEventAgeRequirement);
		$newEventAgeRequirement = filter_var($newEventAgeRequirement, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newEventAgeRequirement) === true) {
			throw(new \InvalidArgumentException("event age requirement content is not secure"));
		}
		//verify the content will fit into the database
		if(strlen($newEventAgeRequirement) > 255) {
			throw(new \RangeException("url content too large"));
		}
		// convert and store the event age requirement
		$this->eventAgeRequirement = $newEventAgeRequirement;
	}



}