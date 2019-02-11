<?php
namespace DeepDive\AbqAtNight\Test;
use DeepDive\AbqAtNight\{Tag};
//Grab the Admin class.
require_once(dirname(__DIR__) . "/autoload.php");

//Grab the UUID generator.
require_once(dirname(__DIR__, 1) . "/Classes/ValidateUuid.php");

/**
* Full PHPUnit test for the Admin class
*
* This is a complete PHPUnit test of the Tweet class. It is complete because all mySQL/PDO enabled methods
* are tested for both invalid and valid inputs.
*
* @see Tag
* @author Adrian Tsosie <atsosie11@cnm.edu>
*
**/
class TagTest extends AbqAtNightTest {
    /**
     * valid id for Tag Id; this is the primary key
     * @var Tag tag
     **/
    protected $tag;

    /**
     * valid id for Tag Id; this is the primary key
     * @var $Valid_tag
     **/
    protected $VALID_TAG_ID;

    /**
     * valid admin id for the tag
     * @var $VALID_TAG_ADMIN_ID
     */
    protected $VALID_TAG_ADMIN_ID;

    /**
     * valid input type for tag
     * @var $VALID_TAG_TYPE
     **/
    protected $VALID_TAG_TYPE;

    /**
     * valid input value for tag
     * @var string $VALID__TAG_VALUE
     **/
    protected $VALID__TAG_VALUE;


    public final function setUp()  : void {
        // run the default setUp() method first
        parent::setUp();
        $password = "abc123";
        $this->VALID_TAG_ID = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);


        // create and insert a Profile to own the test Tweet
        $this->profile = new Profile(generateUuidV4(), null,"@handle", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "test@phpunit.de",$this->VALID_PROFILE_HASH, "+12125551212");
        $this->profile->insert($this->getPDO());

        // calculate the date (just use the time the unit test was setup...)
        $this->VALID_TWEETDATE = new \DateTime();

        //format the sunrise date to use for testing
        $this->VALID_SUNRISEDATE = new \DateTime();
        $this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

        //format the sunset date to use for testing
        $this->VALID_SUNSETDATE = new\DateTime();
        $this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));



    }

    /**
     * test inserting a valid Tweet and verify that the actual mySQL data matches
     **/
    public function testInsertValidTweet() : void {
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
     * test inserting a Tweet, editing it, and then updating it
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

    /**
     * test inserting a Tweet and regrabbing it from mySQL
     **/
    public function testGetValidTweetByTweetProfileId() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("tweet");

        // create a new Tweet and insert to into mySQL
        $tweetId = generateUuidV4();
        $tweet = new Tweet($tweetId, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
        $tweet->insert($this->getPDO());

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
