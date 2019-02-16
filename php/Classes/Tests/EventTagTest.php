<?php
namespace AbqAtNight\CapstoneProject\Tests;
use AbqAtNight\CapstoneProject\{Admin, Event, Tag, EventTag};
//Grab the Admin class.
require_once(dirname(__DIR__) . "/autoload.php");

//Grab the UUID generator.
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Admin class
 *
 * This is a complete PHPUnit test of the Tag class. It is complete because all mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Event Tag
 * @author Adrian Tsosie <atsosie11@cnm.edu>
 *
 **/
class EventTagTest extends AbqAtNightTest {

    protected $admin = null;

    protected $event = null;

    protected $tag = null;

    protected $VALID_EVENT_TAG_EVENT_ID;

    protected $VALID_EVENT_TAG_TAG_ID;

    /**
     * set up for Event Tag
     **/
    public final function setUp(): void {
        // run the default setUp() method first
        parent::setUp();
		 $password = "abc123";
		 $hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);

        $this->admin = new Admin(generateUuidV4(), "email@email.com", $hash, "JoeAdmin");
        $this->admin->insert($this->getPDO());

        $date = new \DateTime("2019-04-19 16:20:00");
        $date2 = new \DateTime("2019-04-20 4:20:00");

        $this->event = new Event(generateUuidV4(), $this->admin->getAdminId() , "21 and over", "Put description here", $date2, "https://www.mysite.org", "TBA Location", "Price", "https://promoter.xyz", $date, "Tile of event", "Your mom's house", "https://www.venue.com");
        $this->event->insert($this->getPDO());

        $this->tag = new Tag(generateUuidV4(), $this->admin->getAdminId(), "Genre", "House");
        $this->tag->insert($this->getPDO());
    }

    /**
     * test inserting a valid Event tag and verify that the actual mySQL data matches
     **/
    public function testInsertValidEventTag(): void
    {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("eventTag");

        // create a new event tag and insert to into mySQL
        $eventTag = new EventTag($this->event->getEventId(), $this->tag->getTagId());
        $eventTag->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
		  $pdoEventTag = EventTag::getEventTagByEventId($this->getPDO(), $eventTag->getEventTagEventId());
        $pdoEventTag2 = EventTag::getEventTagByTagId($this->getPDO(), $eventTag->getEventTagTagId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventTag"));
        $this->assertEquals($pdoEventTag->getEventTagEventId(), $this->VALID_EVENT_TAG_EVENT_ID);
        $this->assertEquals($pdoEventTag2->getEventTagTagId(), $this->VALID_EVENT_TAG_TAG_ID);
    }
    /**
     * tests grabbing event tags by event id
     */
    public function testGetEventTagByEventId(): void
    {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("eventTag");

        // create a new Event Tag and insert to into mySQL
        $eventTag = new EventTag($this->event->getEventId(), $this->tag->getTagId());
        $eventTag->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoEventTag= EventTag::getEventTagByEventId($this->getPDO(), $eventTag->getEventTagEventId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventTag"));

        // grab the result from the array and validate it
        $this->assertEquals($pdoEventTag->getEventTagEventId(), $this->event->getEventId());
        $this->assertEquals($pdoEventTag->getEventTagTagId(), $this->tag->getTagId());
    }

    /**
     * tests grabbing event tags by tag id
     */
    public function testGetEventTagByTagId(): void
    {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("eventTag");

		  $eventTag = new EventTag($this->event->getEventId(), $this->tag->getTagId());
        $eventTag->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoEventTag = EventTag::getEventTagByTagId($this->getPDO(), $eventTag->getEventTagTagId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventTag"));

        // grab the result from the array and validate it
		  $this->assertEquals($pdoEventTag->getEventTagEventId(), $this->event->getEventId());
		  $this->assertEquals($pdoEventTag->getEventTagTagId(), $this->tag->getTagId());
    }

    /**
     * tests grabbing event tags by thr primary key
     */
    public function testGetEventTagByPrimaryKey(): void
    {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("eventTag");

		  $eventTag = new EventTag($this->event->getEventId(), $this->tag->getTagId());
        $eventTag->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoEventTag = EventTag::getEventTagByPrimaryKey($this->getPDO(), $eventTag->getEventTagEventId(), $eventTag->getEventTagTagId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventTag"));

        // grab the result from the array and validate it
        $this->assertEquals($pdoEventTag->getEventTagEventId(), $this->VALID_EVENT_TAG_EVENT_ID);
        $this->assertEquals($pdoEventTag->getEventTagTagId(), $this->VALID_EVENT_TAG_TAG_ID);
    }

}