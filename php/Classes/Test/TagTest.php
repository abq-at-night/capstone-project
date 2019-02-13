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

    }
    /**
     * test inserting a valid Id and verify that the actual mySQL data matches
     **/
    public function testInsertValidTag() : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("tag");

        // create a new Tag and insert to into mySQL
        $tagId = generateUuidV4();
        $tag = new Tag($tagId, $this->VALID_TAG_ID, $this->VALID_TAG_ADMIN_ID, $this->VALID_TAG_TYPE, $this->VALID__TAG_VALUE);
        $tweet->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
        $this->assertEquals($pdoTag -> getTagId(), $this->VALID_TAG_ID);
        $this->assertEquals($pdoTag -> getTagAdminId(), $this->VALID_TAG_ADMIN_ID);
        $this->assertEquals($pdoTag -> getTagType(), $this->VALID_TAG_TYPE);
        $this->assertEquals($pdoTag -> getTagValue(), $this->VALID__TAG_VALUE);
    }

    /**
     * test inserting a Id, editing it, and then updating it
     **/
    public function testUpdateValidTag() : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("tag");

        // create a new Tag and insert to into mySQL
        $tagId = generateUuidV4();
        $tag = new Tag(
        $tag->insert($this->getPDO());

        // edit the Tag and update it in mySQL
        $tag->setValue($this->VALID__TAG_VALUE);
        $tag->update($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
        $this->assertEquals($pdoTag->getTagId(), $tagId);
        $this->assertEquals($pdoTag->getTagAdminId(), $this->VALID_TAG_ADMIN_ID);
        $this->assertEquals($pdoTag->getTagType(), $this->VALID_TAG_TYPE);
        //format the date too seconds since the beginning of time to avoid round off error
        $this->assertEquals($pdoTag->getTagValue(), $this->VALID__TAG_VALUE);
    }


    /**
     * test creating a Tag and then deleting it
     **/
    public function testDeleteValidTweet() : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("tag");

        // create a new Tag and insert to into mySQL
        $tagId = generateUuidV4();
        $tag = new Tag($tagId, $this->VALID_TAG_ID, $this->VALID_TAG_ADMIN_ID, $this->VALID_TAG_TYPE, $this->VALID__TAG_VALUE);
        $tag->insert($this->getPDO());

        // delete the Tag from mySQL
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
        $tag->delete($this->getPDO());

        // grab the data from mySQL and enforce the Tag does not exist
        $pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
        $this->assertNull($pdoTag);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("tag"));
    }

    /**
     * test inserting a Tag and regrabbing it from mySQL
     **/
    public function testGetValidTagByTagId() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("tag");

        // create a new Tag and insert to into mySQL
        $tagId = generateUuidV4();
        $tagId->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $results = Tag::getTagByTagId($this->getPDO(), $tweet->getTagId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
        $this->assertCount(1, $results);
        $this->assertContainsOnlyInstancesOf("DeepDive\\AbqAtNight\\php\\Classes\\Tag", $results);

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
    public function testGetValidTagByTagId() : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("tag");

        // create a new Tag and insert to into mySQL
        $tagId = generateUuidV4();
        $tag = new Tag($tagId, $this->VALID_TAG_ID, $this->VALID_TAG_ADMIN_ID, $this->VALID_TAG_TYPE, $this->VALID__TAG_VALUE););
        $tag->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $results = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
        $this->assertCount(1, $results);

        // enforce no other objects are bleeding into the test
        $this->assertContainsOnlyInstancesOf("DeepDive\\AbqAtNight\\php\\Classes\\Tag");

        // grab the result from the array and validate it
        $pdoTag = $results[0];
        $this->assertEquals($pdoTag->getTagId(), $tagId);
        $this->assertEquals($pdoTag->getTweetProfileId(), $this->profile->getProfileId());
        $this->assertEquals($pdoTag->getTagType(), $this->VALID_TAG_TYPE);
        //format the date too seconds since the beginning of time to avoid round off error
        $this->assertEquals($pdoTag->getTagValue(), $this->VALID__TAG_VALUE);
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
