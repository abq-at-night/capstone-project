<?php
namespace AbqAtNight\CapstoneProject;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Class that posts an event
 *
 * @author Wyatt Salmons <wyattsalmons@gmail.com>
 **/

class Event implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;

	/**
	 * id for event; this is the primary key
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
	 * event poster image url
	 * @var string $eventImage
	 **/
	private $eventImage;

	/**
	 * location for venue; this contains the location of the venue
	 * @var string $eventLocation
	 **/
	private $eventLocation;

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
	 * @var /Datetime $eventStartTime
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
	 * constructor for event
	 *
	 * @param string|Uuid $newEventId id of this event or null if a new event
	 * @param string|Uuid $newEventAdminId id of the Admin that sent this event
	 * @param string $newEventAgeRequirement string contains age event requirement.
	 * @param string $newEventDescription description of the event
	 * @param \DateTime|string $newEventEndTime time event ends
	 * @param string|Uuid $newEventImage Id of this event poster
	 * @param string $newEventLocation location of the venue
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
	public function __construct($newEventId, $newEventAdminId, string $newEventAgeRequirement, string $newEventDescription, $newEventEndTime, string $newEventImage, string $newEventLocation, string $newEventPrice, string $newEventPromoterWebsite, $newEventStartTime, string $newEventTitle, string $newEventVenue, string $newEventVenueWebsite) {
		try {
			$this->setEventId($newEventId);
			$this->setEventAdminId($newEventAdminId);
			$this->setEventAgeRequirement($newEventAgeRequirement);
			$this->setEventDescription($newEventDescription);
			$this->setEventEndTime($newEventEndTime);
			$this->setEventImage($newEventImage);
			$this->setEventLocation($newEventLocation);
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
	 * @throws \TypeError if $newEventAdminId is not a uuid or string
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
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
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
	public function getEventImage() : string {
		return($this->eventImage);
	}
	/**
	 * mutator method for event image
	 *
	 * @param string $newEventImage new value of event image host url
	 * @throws \InvalidArgumentException if $newEventImage is not a string or insecure
	 * @throws \RangeException if $newEventImage is > 256 characters
	 * @throws \TypeError if $eventPromoterWebsite is not a string
	 */
	public function setEventImage(string $newEventImage) : void {
		// verify event promoter url is secure
		$newEventImage = trim($newEventImage);
		$newEventImage = filter_var($newEventImage, FILTER_SANITIZE_URL);
		if(empty($newEventImage) === true) {
			throw(new \InvalidArgumentException("event image url is not secure"));
		}
		//verify the content will fit into the database
		if(strlen($newEventImage) > 256) {
			throw(new \RangeException("event image url too large"));
		}
		// convert and store the event promoter website
		$this->eventImage = $newEventImage;
	}

	/**
	 *accessor method for event location
	 *
	 * @return string value of event location
	 */
	public function getEventLocation() : string {
		return($this->eventLocation);
	}
	/**
	 * mutator method for event location
	 *
	 * @param string $newEventLocation new value of event location
	 * @throws \InvalidArgumentException if $eventDescription is not a string or insecure
	 * @throws \RangeException if $eventLocation is > 256 characters
	 * @throws \TypeError if $eventLocation is not a string
	 */
	public function setEventLocation(string $newEventLocation) : void {
		// verify event description is secure
		$newEventLocation = trim($newEventLocation);
		$newEventLocation = filter_var($newEventLocation, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newEventLocation) === true) {
			throw(new \InvalidArgumentException("event location content is not secure"));
		}
		//verify the content will fit into the database
		if(strlen($newEventLocation) > 256) {
			throw(new \RangeException("event location content too large"));
		}
		// convert and store the event age requirement
		$this->eventLocation = $newEventLocation;
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
		$newEventPromoterWebsite = filter_var($newEventPromoterWebsite, FILTER_SANITIZE_URL, FILTER_FLAG_NO_ENCODE_QUOTES);
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
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
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
		$newEventVenueWebsite = filter_var($newEventVenueWebsite, FILTER_SANITIZE_URL, FILTER_FLAG_NO_ENCODE_QUOTES);
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
	 * inserts this event into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// create query template. *********************************************************WARNINGS DUE TO NO TABLES YET AS OF 2/11/19
		$query = "INSERT INTO event(eventId,eventAdminId, eventAgeRequirement, eventDescription, eventEndTime, eventImage, eventLocation, eventPrice, eventPromoterWebsite, eventStartTime, eventTitle, eventVenue, eventVenueWebsite) VALUES(:eventId, :eventAdminId, :eventAgeRequirement, :eventDescription, :eventEndTime, :eventImage, :eventLocation, :eventPrice, :eventPromoterWebsite, :eventStartTime, :eventTitle, :eventVenue, :eventVenueWebsite)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedEndDate = $this->eventEndTime->format("Y-m-d H:i:s.u");
		$formattedStartDate = $this->eventStartTime->format("Y-m-d H:i:s.u");
		$parameters = [
			"eventId" => $this->eventId->getBytes(),
			"eventAdminId" => $this->eventAdminId->getBytes(),
			"eventAgeRequirement" => $this->eventAgeRequirement,
			"eventDescription" =>  $this->eventDescription,
			"eventEndTime" => $formattedEndDate,
			"eventImage" => $this->eventImage,
			"eventLocation" => $this->eventLocation,
			"eventPrice" =>  $this->eventPrice,
			"eventPromoterWebsite" =>  $this->eventPromoterWebsite,
			"eventStartTime" => $formattedStartDate,
			"eventTitle" =>  $this->eventTitle,
			"eventVenue" =>  $this->eventVenue,
			"eventVenueWebsite" =>  $this->eventVenueWebsite,
			];
		$statement->execute($parameters);
	}

	/**
	 * deletes this event from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// create query template
		$query = "DELETE FROM event WHERE eventId = :eventId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["eventId" => $this->eventId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this event in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE event SET eventAdminId = :eventAdminId, eventAgeRequirement = :eventAgeRequirement, eventDescription = :eventDescription, eventEndTime = :eventEndTime, eventImage = :eventImage, eventLocation = :eventLocation, eventPrice = :eventPrice, eventPromoterWebsite = :eventPromoterWebsite, eventStartTime = :eventStartTime, eventTitle = :eventTitle, eventVenue = :eventVenue, eventVenueWebsite = :eventVenueWebsite WHERE eventId = :eventId";
		$statement = $pdo->prepare($query);

		$formattedEndDate = $this->eventEndTime->format("Y-m-d H:i:s.u");
		$formattedStartDate = $this->eventStartTime->format("Y-m-d H:i:s.u");
		$parameters = [
			"eventId" => $this->eventId->getBytes(),
			"eventAdminId" => $this->eventAdminId->getBytes(),
			"eventAgeRequirement" => $this->eventAgeRequirement,
			"eventDescription" =>  $this->eventDescription,
			"eventEndTime" => $formattedEndDate,
			"eventImage" => $this->eventImage,
			"eventLocation" => $this->eventLocation,
			"eventPrice" =>  $this->eventPrice,
			"eventPromoterWebsite" =>  $this->eventPromoterWebsite,
			"eventStartTime" => $formattedStartDate,
			"eventTitle" =>  $this->eventTitle,
			"eventVenue" =>  $this->eventVenue,
			"eventVenueWebsite" =>  $this->eventVenueWebsite,
		];
		$statement->execute($parameters);
	}

	/**
	 * gets the event by eventId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $eventId event id to search for
	 * @return event|null event found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getEventByEventId(\PDO $pdo, $eventId) : ?Event {
		// sanitize the eventId before searching
		try {
			$eventId = self::validateUuid($eventId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT eventId, eventAdminId, eventAgeRequirement, eventDescription, eventEndTime, eventImage, eventLocation, eventPrice, eventPromoterWebsite, eventStartTime, eventTitle, eventVenue, eventVenueWebsite FROM event WHERE eventId = :eventId";
		$statement = $pdo->prepare($query);

		// bind the event id to the place holder in the template
		$parameters = ["eventId" => $eventId->getBytes()];
		$statement->execute($parameters);

		// grab the event from mySQL
		try {
			$event = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$event = new event($row["eventId"], $row["eventAdminId"], $row["eventAgeRequirement"], $row["eventDescription"], $row["eventEndTime"], $row["eventImage"], $row["eventLocation"], $row["eventPrice"], $row["eventPromoterWebsite"], $row["eventStartTime"], $row["eventTitle"], $row["eventVenue"], $row["eventVenueWebsite"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($event);
	}

	/**
	 * gets the event by admin id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $eventAdminId admin id to search by
	 * @return \SplFixedArray SplFixedArray of Events found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getEventByEventAdminId(\PDO $pdo, $eventAdminId) : \SplFixedArray {

		try {
			$eventAdminId = self::validateUuid($eventAdminId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT eventId, eventAdminId, eventAgeRequirement, eventDescription, eventEndTime, eventImage, eventLocation, eventPrice, eventPromoterWebsite, eventStartTime, eventTitle, eventVenue, eventVenueWebsite FROM event WHERE eventAdminId = :eventAdminId";
		$statement = $pdo->prepare($query);
		// bind the event admin id to the place holder in the template
		$parameters = ["eventAdminId" => $eventAdminId->getBytes()];
		$statement->execute($parameters);
		// build an array of event
		$events = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$event = new event($row["eventId"], $row["eventAdminId"], $row["eventAgeRequirement"], $row["eventDescription"], $row["eventEndTime"], $row["eventImage"], $row["eventLocation"], $row["eventPrice"], $row["eventPromoterWebsite"], $row["eventStartTime"], $row["eventTitle"], $row["eventVenue"], $row["eventVenueWebsite"]);
				$events[$events->key()] = $event;
				$events->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($events);
	}

	/**
	 * gets the event by title
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $eventTitle event content to search for
	 * @return \SplFixedArray SplFixedArray of events found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getEventByEventTitle(\PDO $pdo, string $eventTitle) : \SplFixedArray {
		// sanitize the description before searching
		$eventTitle = trim($eventTitle);
		$eventTitle = filter_var($eventTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($eventTitle) === true) {
			throw(new \PDOException("event title is invalid"));
		}

		// escape any mySQL wild cards
		$eventTitle = str_replace("_", "\\_", str_replace("%", "\\%", $eventTitle));

		// create query template
		$query = "SELECT eventId, eventAdminId, eventAgeRequirement, eventDescription, eventEndTime, eventImage, eventLocation, eventPrice, eventPromoterWebsite, eventStartTime, eventTitle, eventVenue, eventVenueWebsite FROM event WHERE eventTitle = :eventTitle";
		$statement = $pdo->prepare($query);

		// bind the event content to the place holder in the template
		$eventTitle = "%$eventTitle%";
		$parameters = ["eventTitle" => $eventTitle];
		$statement->execute($parameters);

		// build an array of events
		$events = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$event = new event($row["eventId"], $row["eventAdminId"], $row["eventAgeRequirement"], $row["eventDescription"], $row["eventEndTime"], $row["eventImage"], $row["eventLocation"], $row["eventPrice"], $row["eventPromoterWebsite"], $row["eventStartTime"], $row["eventTitle"], $row["eventVenue"], $row["eventVenueWebsite"]);
				$events[$events->key()] = $event;
				$events->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($events);
	}

	/**
	 * gets all Events
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Events found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllEvents(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT eventId, eventAdminId, eventAgeRequirement, eventDescription, eventEndTime, eventImage, eventLocation, eventPrice, eventPromoterWebsite, eventStartTime, eventTitle, eventVenue, eventVenueWebsite FROM event WHERE eventId = :eventId";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of events
		$events = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$event = new event($row["eventId"], $row["eventAdminId"], $row["eventAgeRequirement"], $row["eventDescription"], $row["eventEndTime"], $row["eventImage"], $row["eventLocation"], $row["eventPrice"], $row["eventPromoterWebsite"], $row["eventStartTime"], $row["eventTitle"], $row["eventVenue"], $row["eventVenueWebsite"]);
				$events[$events->key()] = $event;
				$events->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($events);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);
		//format the date so that the front end can consume it
		$fields["eventEndTime"] = round(floatval($this->eventEndTime->format("U.u")) * 1000);
		$fields["eventStartTime"] = round(floatval($this->eventStartTime->format("U.u")) * 1000);
		return($fields);
	}
}