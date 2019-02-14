<?php
namespace AbqAtNight\CapstoneProject\Test;
use AbqAtNight\CapstoneProject\{Admin, Event, Tag, EventTag};
//Grab the Admin class.
require_once(dirname(__DIR__) . "/autoload.php");

//Grab the UUID generator.
require_once(dirname(__DIR__, 1) . "/ValidateUuid.php");

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

    protected $VALID_HASH;

    protected  $VALID_DATE = null;

    /**
     * set up for Event Tag
     **/
    public final function setUp(): void {
        // run the default setUp() method first
        parent::setUp();
        $password = "abc123";
        $this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost"=>384]);

        $this->admin = new Admin(generateUuidV4(), "email@email.com", $this->VALID_HASH, "JoeAdmin");
        $this->admin->insert($this->getPDO());

        $this->event = new Event(generateUuidV4(), $this->admin->getAdminId() , "21 and over", "Put description here", $this->VALID_DATE, "https://www.mysite.org", "TBA Location", "Price", "https://promoter.xyz", $this->VALID_DATE, "Tile of event", "Your mom's house", "https://www.venue.com");
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

        // create a new Tweet and insert to into mySQL
        $EventTagEventId = generateUuidV4();
        $EventTagTagId = generateUuidV4();
        $eventTag = new EventTag($EventTagEventId, $EventTagTagId);
        $eventTag->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoEventTag = EventTag::getEventTagByEventId($this->getPDO(), $eventTag->getEventTagEventId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventTag"));
        $this->assertEquals($pdoEventTag->getEventTagEventId(), $this->VALID_EVENT_TAG_EVENT_ID);
        $this->assertEquals($pdoEventTag->getEventTagTagId(), $this->VALID_EVENT_TAG_TAG_ID);
    }
    /**
     * tests grabbing event tags by event id
     */
    public function testGetEventTagByEventId(): void
    {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("eventTag");

        // create a new Tweet and insert to into mySQL
        $eventTagEventId = generateUuidV4();
        $eventTagTagId = generateUuidV4();
        $eventTag = new EventTag($eventTagEventId, $eventTagTagId);
        $eventTag->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $results = EventTag::getEventTagByEventId($this->getPDO(), $eventTag->getEventTagEventId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventTag"));
        $this->assertCount(1, $results);

        // enforce no other objects are bleeding into the test
        $this->assertContainsOnlyInstancesOf("AbqAtNight\\CapstoneProject\\php\\Classes\\Test\\EventTagTest", $results);

        // grab the result from the array and validate it
        $pdoEventTag = $results[0];
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

        $eventTagEventId = generateUuidV4();
        $eventTagTagId = generateUuidV4();
        $eventTag = new EventTag($eventTagEventId, $eventTagTagId);
        $eventTag->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $results = EventTag::getEventTagByTagId($this->getPDO(), $eventTag->getEventTagTagId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventTag"));
        $this->assertCount(1, $results);

        // enforce no other objects are bleeding into the test
        $this->assertContainsOnlyInstancesOf("AbqAtNight\\CapstoneProject\\php\\Classes\\Test\\EventTagTest", $results);

        // grab the result from the array and validate it
        $pdoEventTag = $results[0];
        $this->assertEquals($pdoEventTag->getEventTagEventId(), $this->VALID_EVENT_TAG_EVENT_ID);
        $this->assertEquals($pdoEventTag->getEventTagTagId(), $this->VALID_EVENT_TAG_TAG_ID);
    }

    /**
     * tests grabbing event tags by thr primary key
     */
    public function testGetEventTagByPrimaryKey(): void
    {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("eventTag");

        $eventTagEventId = generateUuidV4();
        $eventTagTagId = generateUuidV4();
        $eventTag = new EventTag($eventTagEventId, $eventTagTagId);
        $eventTag->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $results = EventTag::getEventTagByPrimaryKey($this->getPDO(), $eventTagEventId, $eventTagTagId);
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventTag"));
        $this->assertCount(1, $results);

        // enforce no other objects are bleeding into the test
        $this->assertContainsOnlyInstancesOf("AbqAtNight\\CapstoneProject\\php\\Classes\\Test\\EventTagTest", $results);

        // grab the result from the array and validate it
        $pdoEventTag = $results[0];
        $this->assertEquals($pdoEventTag->getEventTagEventId(), $this->VALID_EVENT_TAG_EVENT_ID);
        $this->assertEquals($pdoEventTag->getEventTagTagId(), $this->VALID_EVENT_TAG_TAG_ID);
    }

}