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
	//******************************HELP WITH EVENTID, EVENTADMINID, AND EVENTIMAGE. DO WE NEED? HOW TO FORMAT?***************************************************

	/**
	 * valid event age requirement
	 * @var string $VALID_AGEREQUIREMENT
	 */
	protected $VALID_AGEREQUIREMENT = "21 and over";

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
		$event = new Event($eventId, $this->admin->getAdminId(), $this->VALID_AGEREQUIREMENT, $this->VALID_EVENTDESCRIPTION, $this->VALID_EVENTENDTIME, $this->VALID_EVENTIMAGE, $this->VALID_EVENTPRICE, $this->VALID_EVENTPROMOTERWEBSITE, $this->VALID_EVENTSTARTTIME, $this->VALID_EVENTTITLE, $this->VALID_EVENTVENUE, $this->VALID_EVENTVENUEWEBSITE);
		$event->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
		$event->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventAdminId(), $this->Admin->getAdminId());
		$this->assertEquals($pdoEvent->getEventTitle(), $this->$VALID_EVENTTITLE);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndTime()->getTimestamp(), $this->$VALID_EVENTENDTIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventStartTime()->getTimestamp(), $this->$VALID_EVENTSTARTTIME->getTimestamp());
	}

	/**
	 * test inserting an event, editing it, and then updating it
	 **/
	public function testUpdateValidTweet() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tweet");

		// create a new Tweet and insert to into mySQL
		$tweetId = generateUuidV4();
		$tweet = new Tweet($tweetId, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->insert($this->getPDO());

		// edit the Tweet and update it in mySQL
		$tweet->setTweetContent($this->VALID_TWEETCONTENT2);
		$tweet->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTweet = Tweet::getTweetByTweetId($this->getPDO(), $tweet->getTweetId());
		$this->assertEquals($pdoTweet->getTweetId(), $tweetId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertEquals($pdoTweet->getTweetProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT2);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
	}


	/**
	 * test creating a Tweet and then deleting it
	 **/
	public function testDeleteValidTweet() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tweet");

		// create a new Tweet and insert to into mySQL
		$tweetId = generateUuidV4();
		$tweet = new Tweet($tweetId, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->insert($this->getPDO());

		// delete the Tweet from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$tweet->delete($this->getPDO());

		// grab the data from mySQL and enforce the Tweet does not exist
		$pdoTweet = Tweet::getTweetByTweetId($this->getPDO(), $tweet->getTweetId());
		$this->assertNull($pdoTweet);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("tweet"));
	}


//**********************************************************************************WYATT START HERE************************************************************************************************************
	/**
	 * test inserting a Event and regrabbing it from mySQL
	 **/
	public function testGetValidEventByEventAdminId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Tweet and insert to into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->Admin->getAdminId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$event->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tweet::getTweetByTweetProfileId($this->getPDO(), $tweet->getTweetProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Tweet", $results);

		// grab the result from the array and validate it
		$pdoTweet = $results[0];

		$this->assertEquals($pdoTweet->getTweetId(), $tweetId);
		$this->assertEquals($pdoTweet->getTweetProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
	}

	/**
	 * test grabbing a Tweet by tweet content
	 **/
	public function testGetValidTweetByTweetContent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tweet");

		// create a new Tweet and insert to into mySQL
		$tweetId = generateUuidV4();
		$tweet = new Tweet($tweetId, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tweet::getTweetByTweetContent($this->getPDO(), $tweet->getTweetContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Tweet", $results);

		// grab the result from the array and validate it
		$pdoTweet = $results[0];
		$this->assertEquals($pdoTweet->getTweetId(), $tweetId);
		$this->assertEquals($pdoTweet->getTweetProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
	}

	/**
	 * test grabbing all Tweets
	 **/
	public function testGetAllValidTweets() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tweet");

		// create a new Tweet and insert to into mySQL
		$tweetId = generateUuidV4();
		$tweet = new Tweet($tweetId, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tweet::getAllTweets($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Tweet", $results);

		// grab the result from the array and validate it
		$pdoTweet = $results[0];
		$this->assertEquals($pdoTweet->getTweetId(), $tweetId);
		$this->assertEquals($pdoTweet->getTweetProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
	}
}