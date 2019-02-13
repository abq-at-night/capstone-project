<?php
namespace DeepDive\AbqAtNight\Test;
use DeepDive\AbqAtNight\{Event};
// grab the class under scrutiny

require_once(dirname(__DIR__) . "/autoload.php");
// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * this is the the section for the tag in the ABQ at Night Capstone project
 *
 * @see Event
 * @author Wyatt Salmons <wyattsalmons@gmail.com>
 **/
class EventTest extends AbqAtNightTest {

	//******************************EVENTID-DO WE NEED? HOW TO FORMAT?***************************************************

	/**
	 * Profile that created the Tweet; this is for foreign key relations
	 * @var Admin profile
	 **/
	protected $admin = null;

	/**
	 * valid event age requirement
	 * @var string $VALID_AGEREQUIREMENT
	 */
	protected $VALID_EVENTAGEREQUIREMENT = "21 and over";

	/**
	 * valid description
	 * @var string $VALID_EVENTDESCRIPTION
	 **/
	protected $VALID_EVENTDESCRIPTION = "Some dudes playing fire.";

	/**
	 * valid end time
	 * @var \DateTime $VALID_EVENTENDTIME
	 **/
	protected $VALID_EVENTENDTIME = "2019-02-12 22:00:00";

	/**
	 * valid event image url
	 * @var string $VALID_EVENTIMAGE
	 */
	protected $VALID_EVENTIMAGE = "https://imagelocation.com";

	/**
	 * valid event ticket price
	 * @var string $VALID_EVENTPRICE
	 **/
	protected $VALID_EVENTPRICE = "$7 at the door";

	/**
	 * valid promoter website url
	 * @var string $VALID_PROMOTERWEBSITE
	 **/
	protected $VALID_EVENTPROMOTERWEBSITE = "https://somepromoterswebsite.com";

	/**
	 * valid start time
	 * @var \DateTime $VALID_EVENTSTARTTIME
	 **/
	protected $VALID_EVENTSTARTTIME = "2019-02-12 19:00:00";

	/**
	 * valid event title
	 * @var string $VALID_EVENTTITLE
	 **/
	protected $VALID_EVENTTITLE = "Dude and his Deck";

	/**
	 * alternate valid event title
	 * @var string $VALID_EVENTTITLE2
	 **/

	protected $VALID_EVENTTITLE2 = "Selena Gomez Christmas Spectacular";

	/**
	 * valid event venue
	 * @var string $VALID_EVENTVENUE
	 **/
	protected $VALID_EVENTVENUE = "The Launchpad";

	/**
	 * valid venue website url
	 * @var string $VALID_VENUEWEBSITE
	 **/
	protected $VALID_EVENTVENUEWEBSITE = "https://somepromoterswebsite.com";


	/**
	 * create dependent objects before running each test ***************THIS FUNCTION NEEDS HELP BADLY SEE COMMENTS******************************
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);

// **************************************************HELP WITH PROFILE PARAMETERS, CONFUSED WITH REQ' PARAMS. ***************************************************
		// create and insert a Profile to own the test Event
		$this->profile = new Profile(generateUuidV4(), null,"@handle", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "test@phpunit.de",$this->VALID_PROFILE_HASH, "+12125551212");
		$this->profile->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_EVENTENDTIME = new \DateTime();
		$this->VALID_EVENTSTARTTIME= new \DateTime();


		//***********************************************************DO WE NEED THIS "SUNRISE DATE"??*************************************************************
		//format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new\DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));

	}

	/**
	 * test inserting a valid Event and verify that the actual mySQL data matches
	 **/
	public function testInsertValidEvent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert to into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->admin->getAdminId(), $this->VALID_EVENTAGEREQUIREMENT, $this->VALID_EVENTDESCRIPTION, $this->VALID_EVENTENDTIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTPRICE, $this->VALID_EVENTPROMOTERWEBSITE, $this->VALID_EVENTSTARTTIME, $this->VALID_EVENTTITLE, $this->VALID_EVENTVENUE, $this->VALID_EVENTVENUEWEBSITE);
		$event->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
		$event->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventAdminId(), $this->Admin->getAdminId());
		$this->assertEquals($pdoEvent->getEventAgeRequirement(), $this->VALID_EVENTAGEREQUIREMENT);
		$this->assertEquals($pdoEvent->getEventDescription(), $this->VALID_EVENTDESCRIPTION);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndTime(), $this->VALID_EVENTENDTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventImage(), $this->VALID_EVENTIMAGE);
		$this->assertEquals($pdoEvent->getEventPrice(), $this->VALID_EVENTPRICE);
		$this->assertEquals($pdoEvent->getEventPromoterWebsite(), $this->VALID_EVENTPROMOTERWEBSITE);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventStartTime(), $this->VALID_EVENTSTARTTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventTitle(), $this->VALID_EVENTTITLE);
		$this->assertEquals($pdoEvent->getEventVenue(), $this->VALID_EVENTVENUE);
		$this->assertEquals($pdoEvent->getEventVenueWebsite(), $this->VALID_EVENTVENUEWEBSITE);
	}

	/**
	 * test inserting an Event, editing it, and then updating it
	 **/
	public function testUpdateValidEvent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert to into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->admin->getAdminId(), $this->VALID_EVENTAGEREQUIREMENT, $this->VALID_EVENTDESCRIPTION, $this->VALID_EVENTENDTIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTPRICE, $this->VALID_EVENTPROMOTERWEBSITE, $this->VALID_EVENTSTARTTIME, $this->VALID_EVENTTITLE, $this->VALID_EVENTVENUE, $this->VALID_EVENTVENUEWEBSITE);
		$event->insert($this->getPDO());

		// edit the Tweet and update it in mySQL
		$event->setEventTitle($this->VALID_EVENTTITLE2);
		$event->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
		$event->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventAdminId(), $this->Admin->getAdminId());
		$this->assertEquals($pdoEvent->getEventAgeRequirement(), $this->VALID_EVENTAGEREQUIREMENT);
		$this->assertEquals($pdoEvent->getEventDescription(), $this->VALID_EVENTDESCRIPTION);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndTime(), $this->VALID_EVENTENDTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventImage(), $this->VALID_EVENTIMAGE);
		$this->assertEquals($pdoEvent->getEventPrice(), $this->VALID_EVENTPRICE);
		$this->assertEquals($pdoEvent->getEventPromoterWebsite(), $this->VALID_EVENTPROMOTERWEBSITE);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventStartTime(), $this->VALID_EVENTSTARTTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventTitle(), $this->VALID_EVENTTITLE2);
		$this->assertEquals($pdoEvent->getEventVenue(), $this->VALID_EVENTVENUE);
		$this->assertEquals($pdoEvent->getEventVenueWebsite(), $this->VALID_EVENTVENUEWEBSITE);
	}


	/**
	 * test creating a Event and then deleting it
	 **/
	public function testDeleteValidEvent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert to into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->admin->getAdminId(), $this->VALID_EVENTAGEREQUIREMENT, $this->VALID_EVENTDESCRIPTION, $this->VALID_EVENTENDTIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTPRICE, $this->VALID_EVENTPROMOTERWEBSITE, $this->VALID_EVENTSTARTTIME, $this->VALID_EVENTTITLE, $this->VALID_EVENTVENUE, $this->VALID_EVENTVENUEWEBSITE);
		$event->insert($this->getPDO());

		// delete the Event from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$event->delete($this->getPDO());

		// grab the data from mySQL and enforce the Event does not exist
		$pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertNull($pdoEvent);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("event"));
	}


//**********************************************************************************WYATT START HERE************************************************************************************************************
	/**
	 * test inserting a Event and regrabbing it from mySQL
	 **/
	public function testGetValidEventByEventAdminId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert to into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->admin->getAdminId(), $this->VALID_EVENTAGEREQUIREMENT, $this->VALID_EVENTDESCRIPTION, $this->VALID_EVENTENDTIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTPRICE, $this->VALID_EVENTPROMOTERWEBSITE, $this->VALID_EVENTSTARTTIME, $this->VALID_EVENTTITLE, $this->VALID_EVENTVENUE, $this->VALID_EVENTVENUEWEBSITE);
		$event->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Event::getEventByEventAdminId($this->getPDO(), $event->getEventAdminId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("DeepDive\\AbqAtNight\\Event", $results);

		// grab the result from the array and validate it
		$pdoEvent = $results[0];

		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventAdminId(), $this->admin->getAdminId());
		$this->assertEquals($pdoEvent->getEventAgeRequirement(), $this->VALID_EVENTAGEREQUIREMENT);
		$this->assertEquals($pdoEvent->getEventDescription(), $this->VALID_EVENTDESCRIPTION);
		$this->assertEquals($pdoEvent->getEventImage(), $this->VALID_EVENTIMAGE);
		$this->assertEquals($pdoEvent->getEventPrice(), $this->VALID_EVENTPRICE);
		$this->assertEquals($pdoEvent->getEventPromoterWebsite(), $this->VALID_EVENTPROMOTERWEBSITE);
		$this->assertEquals($pdoEvent->getEventTitle(), $this->VALID_EVENTTITLE);
		$this->assertEquals($pdoEvent->getEventVenue(), $this->VALID_EVENTVENUE);
		$this->assertEquals($pdoEvent->getEventVenueWebsite(), $this->VALID_EVENTVENUEWEBSITE);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndTime()->getTimestamp(), $this->VALID_EVENTENDTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventStartDate()->getTimestamp(), $this->VALID_EVENTSTARTTIME->getTimestamp());
	}

	/**
	 * test grabbing an Event by event title
	 **/
	public function testGetValidEventByEventTitle() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert to into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->admin->getAdminId(), $this->VALID_EVENTAGEREQUIREMENT, $this->VALID_EVENTDESCRIPTION, $this->VALID_EVENTENDTIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTPRICE, $this->VALID_EVENTPROMOTERWEBSITE, $this->VALID_EVENTSTARTTIME, $this->VALID_EVENTTITLE, $this->VALID_EVENTVENUE, $this->VALID_EVENTVENUEWEBSITE);
		$event->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Event::getEventByEventTitle($this->getPDO(), $event->getEventTitle());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("DeepDive\\AbqAtNight\\Event", $results);

		// grab the result from the array and validate it
		$pdoEvent = $results[0];

		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventAdminId(), $this->admin->getAdminId());
		$this->assertEquals($pdoEvent->getEventAgeRequirement(), $this->VALID_EVENTAGEREQUIREMENT);
		$this->assertEquals($pdoEvent->getEventDescription(), $this->VALID_EVENTDESCRIPTION);
		$this->assertEquals($pdoEvent->getEventImage(), $this->VALID_EVENTIMAGE);
		$this->assertEquals($pdoEvent->getEventPrice(), $this->VALID_EVENTPRICE);
		$this->assertEquals($pdoEvent->getEventPromoterWebsite(), $this->VALID_EVENTPROMOTERWEBSITE);
		$this->assertEquals($pdoEvent->getEventTitle(), $this->VALID_EVENTTITLE);
		$this->assertEquals($pdoEvent->getEventVenue(), $this->VALID_EVENTVENUE);
		$this->assertEquals($pdoEvent->getEventVenueWebsite(), $this->VALID_EVENTVENUEWEBSITE);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndTime()->getTimestamp(), $this->VALID_EVENTENDTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventStartDate()->getTimestamp(), $this->VALID_EVENTSTARTTIME->getTimestamp());
	}

	/**
	 * test grabbing all Events
	 **/
	public function testGetAllValidEvents() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Tweet and insert to into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->admin->getAdminId(), $this->VALID_EVENTAGEREQUIREMENT, $this->VALID_EVENTDESCRIPTION, $this->VALID_EVENTENDTIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTPRICE, $this->VALID_EVENTPROMOTERWEBSITE, $this->VALID_EVENTSTARTTIME, $this->VALID_EVENTTITLE, $this->VALID_EVENTVENUE, $this->VALID_EVENTVENUEWEBSITE);
		$event->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Event::getAllEvents($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("DeepDive\\AbqAtNight\\Event", $results);

		// grab the result from the array and validate it
		$pdoEvent = $results[0];

		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventAdminId(), $this->admin->getAdminId());
		$this->assertEquals($pdoEvent->getEventAgeRequirement(), $this->VALID_EVENTAGEREQUIREMENT);
		$this->assertEquals($pdoEvent->getEventDescription(), $this->VALID_EVENTDESCRIPTION);
		$this->assertEquals($pdoEvent->getEventImage(), $this->VALID_EVENTIMAGE);
		$this->assertEquals($pdoEvent->getEventPrice(), $this->VALID_EVENTPRICE);
		$this->assertEquals($pdoEvent->getEventPromoterWebsite(), $this->VALID_EVENTPROMOTERWEBSITE);
		$this->assertEquals($pdoEvent->getEventTitle(), $this->VALID_EVENTTITLE);
		$this->assertEquals($pdoEvent->getEventVenue(), $this->VALID_EVENTVENUE);
		$this->assertEquals($pdoEvent->getEventVenueWebsite(), $this->VALID_EVENTVENUEWEBSITE);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndTime()->getTimestamp(), $this->VALID_EVENTENDTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventStartDate()->getTimestamp(), $this->VALID_EVENTSTARTTIME->getTimestamp());
	}
}