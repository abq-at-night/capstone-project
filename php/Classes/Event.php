<?php
namespace DeepDive\AbqAtNight;

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
	 * description of the event
	 * @var string $eventDescription
	 **/
	private $eventDescription;

	/**
	 * time the event ends
	 * @var /Datetime $eventEndTime
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
	 * accessor method for event id
	 *
	 * @return Uuid value of event id
	 **/
	public function getEventId() : Uuid {
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
		if(strlen($newEventAgeRequirement) > 128) {
			throw(new \RangeException("event age requirement content too large"));
		}
		// convert and store the event age requirement
		$this->eventAgeRequirement = $newEventAgeRequirement;
	}

	/**
	 *accessor method for event description
	 *
	 * @return string value of event description
	 */
	public function getEventDescription() : string {
		return($this->eventDescription);
	}
	/**
	 * mutator method for event description
	 *
	 * @param string $newEventDescription new value of event description
	 * @throws \InvalidArgumentException if $eventDescription is not a string or insecure
	 * @throws \RangeException if $eventDescription is > 500 characters
	 * @throws \TypeError if $eventDescription is not a string
	 */
	public function setEventDescription(string $newEventDescription) : void {
		// verify event description is secure
		$newEventDescription = trim($newEventDescription);
		$newEventDescription = filter_var($newEventDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newEventDescription) === true) {
			throw(new \InvalidArgumentException("event description content is not secure"));
		}
		//verify the content will fit into the database
		if(strlen($newEventDescription) > 500) {
			throw(new \RangeException("event description content too large"));
		}
		// convert and store the event age requirement
		$this->eventDescription = $newEventDescription;
	}

	/**
	 * accessor method for event end datetime
	 *
	 * @return \DateTime value of event end datetime
	 **/
	public function getEventEndTime() : \DateTime {
		return($this->eventEndTime);
	}

	/**
	 * mutator method for event end datetime
	 *
	 * @param \DateTime|string $newEventEndTime event end date as a DateTime object or string
	 * @throws \InvalidArgumentException if $newEventEndTime is not a valid object or string
	 * @throws \RangeException if $newEventEndTime is a date that does not exist
	 * @throws \TypeError if $eventEndTime is not a /Datetime
	 **/
	public function setEventEndTime($newEventEndTime) : void {
		// store the end date using the ValidateDate trait
		try {
			$newEventEndTime = self::validateDateTime($newEventEndTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the event end time
		$this->eventEndTime = $newEventEndTime;
	}

	/**
	 * accessor method for event image
	 *
	 * @return Uuid value of event image
	 **/
	public function getEventImage() : Uuid {
		return($this->eventImage);
	}
	/**
	 * mutator method for event image
	 *
	 * @param Uuid|string $newEventImage new value of event id
	 * @throws \RangeException if $newEventImage is not positive
	 * @throws \TypeError if $newEventImage is not a uuid or string
	 **/
	public function setEventImage( $newEventImage) : void {
		try {
			$uuid = self::validateUuid($newEventImage);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the event image id
		$this->eventImage = $uuid;
	}

	/**
	 *accessor method for event price
	 *
	 * @return string value of event price
	 */
	public function getEventPrice() : string {
		return($this->eventPrice);
	}
	/**
	 * mutator method for event description
	 *
	 * @param string $newEventPrice new value of event description
	 * @throws \InvalidArgumentException if $eventPrice is not a string or insecure
	 * @throws \RangeException if $eventPrice is > 500 characters
	 * @throws \TypeError if $eventPrice is not a string
	 */
	public function setEventPrice(string $newEventPrice) : void {
		// verify event price is secure
		$newEventPrice = trim($newEventPrice);
		$newEventPrice = filter_var($newEventPrice, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newEventPrice) === true) {
			throw(new \InvalidArgumentException("event price content is not secure"));
		}
		//verify the content will fit into the database
		if(strlen($newEventPrice) > 32) {
			throw(new \RangeException("event price content too large"));
		}
		// convert and store the event price
		$this->eventPrice = $newEventPrice;
	}

	/**
	 *accessor method for event promoter website
	 *
	 * @return string value of event event promoter website
	 */
	public function getEventPromoterWebsite() : string {
		return($this->eventPromoterWebsite);
	}
	/**
	 * mutator method for event promoter website
	 *
	 * @param string $newEventPromoterWebsite new value of event promoter website
	 * @throws \InvalidArgumentException if $eventPromoterWebsite is not a string or insecure
	 * @throws \RangeException if $eventPromoterWebsite is > 256 characters
	 * @throws \TypeError if $eventPromoterWebsite is not a string
	 */
	public function setEventPromoterWebsite(string $newEventPromoterWebsite) : void {
		// verify event promoter url is secure
		$newEventPromoterWebsite = trim($newEventPromoterWebsite);
		$newEventPromoterWebsite = filter_var($newEventPromoterWebsite, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newEventPromoterWebsite) === true) {
			throw(new \InvalidArgumentException("event price content is not secure"));
		}
		//verify the content will fit into the database
		if(strlen($newEventPromoterWebsite) > 256) {
			throw(new \RangeException("event price content too large"));
		}
		// convert and store the event promoter website
		$this->eventPromoterWebsite = $newEventPromoterWebsite;
	}

	/**
	 * accessor method for event start datetime
	 *
	 * @return \DateTime value of event start datetime
	 **/
	public function getEventStartTime() : \DateTime {
		return($this->eventStartTime);
	}

	/**
	 * mutator method for event start datetime
	 *
	 * @param \DateTime|string $newEventStartTime event start date as a DateTime object or string
	 * @throws \InvalidArgumentException if $newEventStartTime is not a valid object or string
	 * @throws \RangeException if $newEventStartTime is a date that does not exist
	 * @throws \TypeError if $eventStartTime is not a /Datetime
	 **/
	public function setEventStartTime($newEventStartTime) : void {
		// store the end date using the ValidateDate trait
		try {
			$newEventStartTime = self::validateDateTime($newEventStartTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the event start time
		$this->eventStartTime = $newEventStartTime;
	}

	/**
	 *accessor method for event title
	 *
	 * @return string value of event event title
	 */
	public function getEventTitle() : string {
		return($this->eventTitle);
	}
	/**
	 * mutator method for event title
	 *
	 * @param string $newEventTitle new value of event title
	 * @throws \InvalidArgumentException if $eventTitle is not a string or insecure
	 * @throws \RangeException if $eventTitle is > 128 characters
	 * @throws \TypeError if $eventTitle is not a string
	 */
	public function setEventTitle(string $newEventTitle) : void {
		// verify event title is secure
		$newEventTitle = trim($newEventTitle);
		$newEventTitle = filter_var($newEventTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newEventTitle) === true) {
			throw(new \InvalidArgumentException("event price content is not secure"));
		}
		//verify the content will fit into the database
		if(strlen($newEventTitle) > 128) {
			throw(new \RangeException("event price content too large"));
		}
		// convert and store the event title
		$this->eventTitle = $newEventTitle;
	}

	/**
	 *accessor method for event venue
	 *
	 * @return string value of event venue
	 */
	public function getEventVenue() : string {
		return($this->eventVenue);
	}
	/**
	 * mutator method for event venue
	 *
	 * @param string $newEventVenue new value of event venue name
	 * @throws \InvalidArgumentException if $eventVenue is not a string or insecure
	 * @throws \RangeException if $eventVenue is > 128 characters
	 * @throws \TypeError if $eventVenue is not a string
	 */
	public function setEventVenue(string $newEventVenue) : void {
		// verify event venue name is secure
		$newEventVenue = trim($newEventVenue);
		$newEventVenue = filter_var($newEventVenue, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newEventVenue) === true) {
			throw(new \InvalidArgumentException("event price content is not secure"));
		}
		//verify the content will fit into the database
		if(strlen($newEventVenue) > 128) {
			throw(new \RangeException("event price content too large"));
		}
		// convert and store the event venue name
		$this->eventVenue = $newEventVenue;
	}

	/**
	 *accessor method for event venue website
	 *
	 * @return string value of event event venue website
	 */
	public function getEventVenueWebsite() : string {
		return($this->eventVenueWebsite);
	}
	/**
	 * mutator method for event venue website
	 *
	 * @param string $newEventVenueWebsite new value of event Venue website
	 * @throws \InvalidArgumentException if $eventVenueWebsite is not a string or insecure
	 * @throws \RangeException if $eventVenueWebsite is > 256 characters
	 * @throws \TypeError if $eventVenueWebsite is not a string
	 */
	public function setEventVenueWebsite(string $newEventVenueWebsite) : void {
		// verify event venue url is secure
		$newEventVenueWebsite = trim($newEventVenueWebsite);
		$newEventVenueWebsite = filter_var($newEventVenueWebsite, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newEventVenueWebsite) === true) {
			throw(new \InvalidArgumentException("event price content is not secure"));
		}
		//verify the content will fit into the database
		if(strlen($newEventVenueWebsite) > 256) {
			throw(new \RangeException("event price content too large"));
		}
		// convert and store the event venue website
		$this->eventVenueWebsite = $newEventVenueWebsite;
	}

	/**
	 * constructor for Event
	 *
	 * @param string|Uuid $newEventId id of this event or null if a new event
	 * @param string|Uuid $newEventAdminId id of the Admin that sent this Event
	 * @param string $newEventAgeRequirement string contains age event requirement.
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

	public function __construct($newEventId, $newEventAdminId, string $newEventAgeRequirement, string $newEventDescription, string $newEventEndTime, $newEventImage, string $newEventPrice, string $newEventPromoterWebsite, $newEventStartTime, string $newEventTitle, string $newEventVenue, string $newEventVenueWebsite) {
		try {
			$this->setEventId($newEventId);
			$this->setEventAdminId($newEventAdminId);
			$this->setEventAgeRequirement($newEventAgeRequirement);
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


}