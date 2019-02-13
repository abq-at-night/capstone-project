<?php
namespace AbqAtNight\CapstoneProject;
use AbqAtNight\CapstoneProject\ {Tag};
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
 * @see Tag
 * @author Adrian Tsosie <atsosie11@cnm.edu>
 *
 **/
class EventTagTest extends AbqAtNightTest
{
    /**
     * valid Tag for event; this is the primary key
     * @var $EventTag tag
     **/
    protected $eventTag;

    /**
     * valid id for Tag Id; this is the primary key
     * @var $VALID_TAG_EVENT_ID
     **/
    protected $EVENT_TAG_EVENT_ID;

    /**
     * valid admin id for the tag
     * @var $VALID_TAG_ADMIN_ID
     */
    protected $EVENT_TAG_TAG_ID;


    public final function setUp(): void
    {
        // run the default setUp() method first
        parent::setUp();
        $password = "abc123";
        $this->VALID_TAG_ID = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);


        // create and insert a Profile to own the test Tweet
        $this->profile = new Profile(generateUuidV4(), null, "@handle", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "test@phpunit.de", $this->VALID_PROFILE_HASH, "+12125551212");
        $this->profile->insert($this->getPDO());

        // calculate the date (just use the time the unit test was setup...)
        $this->VALID_TWEETDATE = new \DateTime();

    }

    /**
     * test inserting a valid Tweet and verify that the actual mySQL data matches
     **/
    public function testInsertValidTweet(): void
    {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("tweet");

        // create a new Tweet and insert to into mySQL
        $tweetId = generateUuidV4();
        $tweet = new Tweet($tweetId, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
        $tweet->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoTweet = Tweet::getTweetByTweetId($this->getPDO(), $tweet->getTweetId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
        $this->assertEquals($pdoTweet->getTweetId(), $tweetId);
        $this->assertEquals($pdoTweet->getTweetProfileId(), $this->profile->getProfileId());
        $this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT);
        //format the date too seconds since the beginning of time to avoid round off error
        $this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
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
        $eventTag = new EventTag($eventTagEventId,, $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
        $eventTag->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $results = EventTag::getEventTagByEventId($this->getPDO(), $eventTag->getTweetContent());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventTag"));
        $this->assertCount(1, $results);

        // enforce no other objects are bleeding into the test
        $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\EventTag", $results);

        // grab the result from the array and validate it
        $pdoEventTag = $results[0];
        $this->assertEquals($pdoEventTag->getEventTagEventId(), $eventTagEventId);
        $this->assertEquals($pdoEventTag->getEventTagTagId(), $this->profile->getProfileId());
    }

    /**
     * tests grabbing event tags by tag id
     */
    public function testGetEventTagByTagId(): void
    {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("eventTag");

        // create a new Tweet and insert to into mySQL
        $eventTagEventId = generateUuidV4();
        $eventTag = new EventTag($eventTagEventId,, $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
        $eventTag->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $results = EventTag::getEventTagByEventId($this->getPDO(), $eventTag->getTweetContent());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventTag"));
        $this->assertCount(1, $results);

        // enforce no other objects are bleeding into the test
        $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\EventTag", $results);

        // grab the result from the array and validate it
        $pdoEventTag = $results[0];
        $this->assertEquals($pdoEventTag->getEventTagEventId(), $eventTagEventId);
        $this->assertEquals($pdoEventTag->getEventTagTagId(), $this->profile->getProfileId());
    }

}