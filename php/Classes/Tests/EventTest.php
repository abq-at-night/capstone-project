<?php
namespace AbqAtNight\CapstoneProject\Tests;
use AbqAtNight\CapstoneProject\{Admin, Event, EventTag, Tag};
// grab the class under scrutiny

require_once(dirname(__DIR__) . "/autoload.php");
// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the event class
 *
 * This is a complete PHPUnit test of the event class. It is complete because all mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see Event
 * @author Wyatt Salmons <wyattsalmons@gmail.com>
 **/
class EventTest extends AbqAtNightTest {

	/**
	 * Profile that created the Event; this is for foreign key relations
	 * @var Admin profile
	 **/
	protected $admin = null;

    /**
     * Tag that is related to the Event; this is for the testGetEventByTagId method
     * @var Tag profile
     **/
    protected $tag = null;

	/**
	 * valid event age requirement
	 * @var string $VALID_AGEREQUIREMENT
	 **/
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
	protected $VALID_EVENTENDTIME = null;

	/**
	 * valid event image url
	 * @var string $VALID_EVENTIMAGE
	 **/
	protected $VALID_EVENTIMAGE = "https://imagelocation.com";

	/**
	 * valid venue lat value
	 * @var float $VALID_EVENTLAT
	 **/
	protected $VALID_EVENTLAT = 35;

	/**
	 * valid venue lng value
	 * @var float $VALID_EVENTLNG
	 **/
	protected $VALID_EVENTLNG = -106;

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
	protected $VALID_EVENTSTARTTIME = null;

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
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);

        // create and insert a Admin to own the test Event
        $this->admin = new Admin(generateUuidV4(), "email@email.com",$hash, "testuser");
        $this->admin->insert($this->getPDO());

		// create and insert a Tag to own the test event
        $this->tag = new Tag(generateUuidV4(), $this->admin->getAdminId(), "Genre", "UK Garage");
        $this->tag->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_EVENTENDTIME = new \DateTime();
		$this->VALID_EVENTENDTIME->add(new \DateInterval("P10D"));
		$this->VALID_EVENTSTARTTIME = new \DateTime();
		$this->VALID_EVENTSTARTTIME->sub(new \DateInterval("P10D"));

		}

	/**
	 * test inserting a valid Event and verify that the actual mySQL data matches
	 **/
	public function testInsertValidEvent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert to into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->admin->getAdminId(), $this->VALID_EVENTAGEREQUIREMENT, $this->VALID_EVENTDESCRIPTION, $this->VALID_EVENTENDTIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTLAT, $this->VALID_EVENTLNG,$this->VALID_EVENTPRICE, $this->VALID_EVENTPROMOTERWEBSITE, $this->VALID_EVENTSTARTTIME, $this->VALID_EVENTTITLE, $this->VALID_EVENTVENUE, $this->VALID_EVENTVENUEWEBSITE);
		$event->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventAdminId(), $this->admin->getAdminId());
		$this->assertEquals($pdoEvent->getEventAgeRequirement(), $this->VALID_EVENTAGEREQUIREMENT);
		$this->assertEquals($pdoEvent->getEventDescription(), $this->VALID_EVENTDESCRIPTION);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndTime()->getTimestamp(), $this->VALID_EVENTENDTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventImage(), $this->VALID_EVENTIMAGE);
		$this->assertEquals($pdoEvent->getEventLat(), $this->VALID_EVENTLAT);
		$this->assertEquals($pdoEvent->getEventLng(), $this->VALID_EVENTLNG);
		$this->assertEquals($pdoEvent->getEventPrice(), $this->VALID_EVENTPRICE);
		$this->assertEquals($pdoEvent->getEventPromoterWebsite(), $this->VALID_EVENTPROMOTERWEBSITE);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventStartTime()->getTimestamp(), $this->VALID_EVENTSTARTTIME->getTimestamp());
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
		$event = new Event($eventId, $this->admin->getAdminId(), $this->VALID_EVENTAGEREQUIREMENT, $this->VALID_EVENTDESCRIPTION, $this->VALID_EVENTENDTIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTLAT, $this->VALID_EVENTLNG, $this->VALID_EVENTPRICE, $this->VALID_EVENTPROMOTERWEBSITE, $this->VALID_EVENTSTARTTIME, $this->VALID_EVENTTITLE, $this->VALID_EVENTVENUE, $this->VALID_EVENTVENUEWEBSITE);
		$event->insert($this->getPDO());

		// edit the Event and update it in mySQL
		$event->setEventTitle($this->VALID_EVENTTITLE2);
		$event->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventAdminId(), $this->admin->getAdminId());
		$this->assertEquals($pdoEvent->getEventAgeRequirement(), $this->VALID_EVENTAGEREQUIREMENT);
		$this->assertEquals($pdoEvent->getEventDescription(), $this->VALID_EVENTDESCRIPTION);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndTime()->getTimestamp(), $this->VALID_EVENTENDTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventImage(), $this->VALID_EVENTIMAGE);
		$this->assertEquals($pdoEvent->getEventLat(), $this->VALID_EVENTLAT);
		$this->assertEquals($pdoEvent->getEventLng(), $this->VALID_EVENTLNG);
		$this->assertEquals($pdoEvent->getEventPrice(), $this->VALID_EVENTPRICE);
		$this->assertEquals($pdoEvent->getEventPromoterWebsite(), $this->VALID_EVENTPROMOTERWEBSITE);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventStartTime()->getTimestamp(), $this->VALID_EVENTSTARTTIME->getTimestamp());
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
		$event = new Event($eventId, $this->admin->getAdminId(), $this->VALID_EVENTAGEREQUIREMENT, $this->VALID_EVENTDESCRIPTION, $this->VALID_EVENTENDTIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTLAT, $this->VALID_EVENTLNG, $this->VALID_EVENTPRICE, $this->VALID_EVENTPROMOTERWEBSITE, $this->VALID_EVENTSTARTTIME, $this->VALID_EVENTTITLE, $this->VALID_EVENTVENUE, $this->VALID_EVENTVENUEWEBSITE);
		$event->insert($this->getPDO());

		// delete the Event from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$event->delete($this->getPDO());

		// grab the data from mySQL and enforce the Event does not exist
		$pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertNull($pdoEvent);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("event"));
	}

	/**
	 * Test to get event by event id
	 **/
	public function testGetEventByEventId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert to into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->admin->getAdminId(), $this->VALID_EVENTAGEREQUIREMENT, $this->VALID_EVENTDESCRIPTION, $this->VALID_EVENTENDTIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTLAT, $this->VALID_EVENTLNG, $this->VALID_EVENTPRICE, $this->VALID_EVENTPROMOTERWEBSITE, $this->VALID_EVENTSTARTTIME, $this->VALID_EVENTTITLE, $this->VALID_EVENTVENUE, $this->VALID_EVENTVENUEWEBSITE);
		$event->insert($this->getPDO());

		//Grab the data from MySQL and verify the results match our expectations.
		$pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));


		//Grab the result from the array and validate it.

		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventAdminId(), $this->admin->getAdminId());
		$this->assertEquals($pdoEvent->getEventAgeRequirement(), $this->VALID_EVENTAGEREQUIREMENT);
		$this->assertEquals($pdoEvent->getEventDescription(), $this->VALID_EVENTDESCRIPTION);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndTime()->getTimestamp(), $this->VALID_EVENTENDTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventImage(), $this->VALID_EVENTIMAGE);
		$this->assertEquals($pdoEvent->getEventLat(), $this->VALID_EVENTLAT);
		$this->assertEquals($pdoEvent->getEventLng(), $this->VALID_EVENTLNG);
		$this->assertEquals($pdoEvent->getEventPrice(), $this->VALID_EVENTPRICE);
		$this->assertEquals($pdoEvent->getEventPromoterWebsite(), $this->VALID_EVENTPROMOTERWEBSITE);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventStartTime()->getTimestamp(), $this->VALID_EVENTSTARTTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventTitle(), $this->VALID_EVENTTITLE);
		$this->assertEquals($pdoEvent->getEventVenue(), $this->VALID_EVENTVENUE);
		$this->assertEquals($pdoEvent->getEventVenueWebsite(), $this->VALID_EVENTVENUEWEBSITE);
	}

	/**
	 * Test to get event by eventTagTagId
	 **/
	public function testGetEventByEventTagTagId() : void {
		//Count the number of rows and save it for later.
		$numRows = $this->getConnection()->getRowCount("event");

		//Create a new Event and insert it into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->admin->getAdminId(), $this->VALID_EVENTAGEREQUIREMENT, $this->VALID_EVENTDESCRIPTION, $this->VALID_EVENTENDTIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTLAT, $this->VALID_EVENTLNG, $this->VALID_EVENTPRICE, $this->VALID_EVENTPROMOTERWEBSITE, $this->VALID_EVENTSTARTTIME, $this->VALID_EVENTTITLE, $this->VALID_EVENTVENUE, $this->VALID_EVENTVENUEWEBSITE);
		$event->insert($this->getPDO());

		$eventTag = new EventTag($event->getEventId(), $this->tag->getTagId());
		$eventTag->insert($this->getPDO());

		//Grab the data from mySQL and enforce the fields match our expectations
		$pdoEvent= Event::getEventByEventTagTagId($this->getPDO(), $this->tag->getTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));

		//Grab the result from the object and validate it.
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventAdminId(), $this->admin->getAdminId());
		$this->assertEquals($pdoEvent->getEventAgeRequirement(), $this->VALID_EVENTAGEREQUIREMENT);
		$this->assertEquals($pdoEvent->getEventDescription(), $this->VALID_EVENTDESCRIPTION);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndTime()->getTimestamp(), $this->VALID_EVENTENDTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventImage(), $this->VALID_EVENTIMAGE);
		$this->assertEquals($pdoEvent->getEventLat(), $this->VALID_EVENTLAT);
		$this->assertEquals($pdoEvent->getEventLng(), $this->VALID_EVENTLNG);
		$this->assertEquals($pdoEvent->getEventPrice(), $this->VALID_EVENTPRICE);
		$this->assertEquals($pdoEvent->getEventPromoterWebsite(), $this->VALID_EVENTPROMOTERWEBSITE);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventStartTime()->getTimestamp(), $this->VALID_EVENTSTARTTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventTitle(), $this->VALID_EVENTTITLE);
		$this->assertEquals($pdoEvent->getEventVenue(), $this->VALID_EVENTVENUE);
		$this->assertEquals($pdoEvent->getEventVenueWebsite(), $this->VALID_EVENTVENUEWEBSITE);
	}


	/**
	 * test inserting a Event and regrabbing it from mySQL
	 **/
	public function testGetValidEventByEventAdminId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert to into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->admin->getAdminId(), $this->VALID_EVENTAGEREQUIREMENT, $this->VALID_EVENTDESCRIPTION, $this->VALID_EVENTENDTIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTLAT, $this->VALID_EVENTLNG, $this->VALID_EVENTPRICE, $this->VALID_EVENTPROMOTERWEBSITE, $this->VALID_EVENTSTARTTIME, $this->VALID_EVENTTITLE, $this->VALID_EVENTVENUE, $this->VALID_EVENTVENUEWEBSITE);
		$event->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Event::getEventByEventAdminId($this->getPDO(), $event->getEventAdminId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("AbqAtNight\\CapstoneProject\\Event", $results);

		// grab the result from the array and validate it
		$pdoEvent = $results[0];

		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventAdminId(), $this->admin->getAdminId());
		$this->assertEquals($pdoEvent->getEventAgeRequirement(), $this->VALID_EVENTAGEREQUIREMENT);
		$this->assertEquals($pdoEvent->getEventDescription(), $this->VALID_EVENTDESCRIPTION);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndTime()->getTimestamp(), $this->VALID_EVENTENDTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventImage(), $this->VALID_EVENTIMAGE);
		$this->assertEquals($pdoEvent->getEventLat(), $this->VALID_EVENTLAT);
		$this->assertEquals($pdoEvent->getEventLng(), $this->VALID_EVENTLNG);
		$this->assertEquals($pdoEvent->getEventPrice(), $this->VALID_EVENTPRICE);
		$this->assertEquals($pdoEvent->getEventPromoterWebsite(), $this->VALID_EVENTPROMOTERWEBSITE);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventStartTime()->getTimestamp(), $this->VALID_EVENTSTARTTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventTitle(), $this->VALID_EVENTTITLE);
		$this->assertEquals($pdoEvent->getEventVenue(), $this->VALID_EVENTVENUE);
		$this->assertEquals($pdoEvent->getEventVenueWebsite(), $this->VALID_EVENTVENUEWEBSITE);
	}

	/**
	 * test grabbing an Event by event title
	 **/
	public function testGetValidEventByEventTitle() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert to into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->admin->getAdminId(), $this->VALID_EVENTAGEREQUIREMENT, $this->VALID_EVENTDESCRIPTION, $this->VALID_EVENTENDTIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTLAT, $this->VALID_EVENTLNG, $this->VALID_EVENTPRICE, $this->VALID_EVENTPROMOTERWEBSITE, $this->VALID_EVENTSTARTTIME, $this->VALID_EVENTTITLE, $this->VALID_EVENTVENUE, $this->VALID_EVENTVENUEWEBSITE);
		$event->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Event::getEventByEventTitle($this->getPDO(), $event->getEventTitle());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("AbqAtNight\\CapstoneProject\\Event", $results);

		// grab the result from the array and validate it
		$pdoEvent = $results[0];
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventAdminId(), $this->admin->getAdminId());
		$this->assertEquals($pdoEvent->getEventAgeRequirement(), $this->VALID_EVENTAGEREQUIREMENT);
		$this->assertEquals($pdoEvent->getEventDescription(), $this->VALID_EVENTDESCRIPTION);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndTime()->getTimestamp(), $this->VALID_EVENTENDTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventImage(), $this->VALID_EVENTIMAGE);
		$this->assertEquals($pdoEvent->getEventLat(), $this->VALID_EVENTLAT);
		$this->assertEquals($pdoEvent->getEventLng(), $this->VALID_EVENTLNG);
		$this->assertEquals($pdoEvent->getEventPrice(), $this->VALID_EVENTPRICE);
		$this->assertEquals($pdoEvent->getEventPromoterWebsite(), $this->VALID_EVENTPROMOTERWEBSITE);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventStartTime()->getTimestamp(), $this->VALID_EVENTSTARTTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventTitle(), $this->VALID_EVENTTITLE);
		$this->assertEquals($pdoEvent->getEventVenue(), $this->VALID_EVENTVENUE);
		$this->assertEquals($pdoEvent->getEventVenueWebsite(), $this->VALID_EVENTVENUEWEBSITE);
	}

	/**
	 * Test getting events by distance
	 **/

	public function testGetEventByDistance() : void {
		//Count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		//Create a new Event object and insert it into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->admin->getAdminId(), $this->VALID_EVENTAGEREQUIREMENT, $this->VALID_EVENTDESCRIPTION, $this->VALID_EVENTENDTIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTLAT, $this->VALID_EVENTLNG, $this->VALID_EVENTPRICE, $this->VALID_EVENTPROMOTERWEBSITE, $this->VALID_EVENTSTARTTIME, $this->VALID_EVENTTITLE, $this->VALID_EVENTVENUE, $this->VALID_EVENTVENUEWEBSITE);
		$event->insert($this->getPDO());

		//Grab the data from mySQL and enforce the fields match our expectations.
		$eventLat = 35;
		$eventLng = -106;
		$results = Event::getEventByEventDistance($this->getPDO(), $eventLng, $eventLat, 100);
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);

		//Enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("AbqAtNight\\CapstoneProject\\Event", $results);

		//Grab the result from the array and validate it.
		$pdoEvent = $results[0];
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventAdminId(), $this->admin->getAdminId());
		$this->assertEquals($pdoEvent->getEventAgeRequirement(), $this->VALID_EVENTAGEREQUIREMENT);
		$this->assertEquals($pdoEvent->getEventDescription(), $this->VALID_EVENTDESCRIPTION);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndTime()->getTimestamp(), $this->VALID_EVENTENDTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventImage(), $this->VALID_EVENTIMAGE);
		$this->assertEquals($pdoEvent->getEventLat(), $this->VALID_EVENTLAT);
		$this->assertEquals($pdoEvent->getEventLng(), $this->VALID_EVENTLNG);
		$this->assertEquals($pdoEvent->getEventPrice(), $this->VALID_EVENTPRICE);
		$this->assertEquals($pdoEvent->getEventPromoterWebsite(), $this->VALID_EVENTPROMOTERWEBSITE);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventStartTime()->getTimestamp(), $this->VALID_EVENTSTARTTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventTitle(), $this->VALID_EVENTTITLE);
		$this->assertEquals($pdoEvent->getEventVenue(), $this->VALID_EVENTVENUE);
		$this->assertEquals($pdoEvent->getEventVenueWebsite(), $this->VALID_EVENTVENUEWEBSITE);
	}

	/**
	 * Test grabbing events by time
	 **/

	public function testGetEventByEventTime() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert to into mySQL
		$eventId = generateUuidV4();
		$eventEndTime = new \DateTime();
		$eventStartTime = new \DateTime();
		$event = new Event($eventId, $this->admin->getAdminId(), $this->VALID_EVENTAGEREQUIREMENT, $this->VALID_EVENTDESCRIPTION, $eventEndTime, $this->VALID_EVENTIMAGE, $this->VALID_EVENTLAT, $this->VALID_EVENTLNG, $this->VALID_EVENTPRICE, $this->VALID_EVENTPROMOTERWEBSITE, $eventStartTime, $this->VALID_EVENTTITLE, $this->VALID_EVENTVENUE, $this->VALID_EVENTVENUEWEBSITE);
		$event->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Event::getEventByEventTime($this->getPDO(), $this->VALID_EVENTENDTIME, $this->VALID_EVENTSTARTTIME);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("AbqAtNight\\CapstoneProject\\Event", $results);

		// grab the result from the array and validate it
		$pdoEvent = $results[0];
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventAdminId(), $this->admin->getAdminId());
		$this->assertEquals($pdoEvent->getEventAgeRequirement(), $this->VALID_EVENTAGEREQUIREMENT);
		$this->assertEquals($pdoEvent->getEventDescription(), $this->VALID_EVENTDESCRIPTION);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndTime()->getTimestamp(), $eventEndTime->getTimestamp());
		$this->assertEquals($pdoEvent->getEventImage(), $this->VALID_EVENTIMAGE);
		$this->assertEquals($pdoEvent->getEventLat(), $this->VALID_EVENTLAT);
		$this->assertEquals($pdoEvent->getEventLng(), $this->VALID_EVENTLNG);
		$this->assertEquals($pdoEvent->getEventPrice(), $this->VALID_EVENTPRICE);
		$this->assertEquals($pdoEvent->getEventPromoterWebsite(), $this->VALID_EVENTPROMOTERWEBSITE);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventStartTime()->getTimestamp(), $eventStartTime->getTimestamp());
		$this->assertEquals($pdoEvent->getEventTitle(), $this->VALID_EVENTTITLE);
		$this->assertEquals($pdoEvent->getEventVenue(), $this->VALID_EVENTVENUE);
		$this->assertEquals($pdoEvent->getEventVenueWebsite(), $this->VALID_EVENTVENUEWEBSITE);
	}
}