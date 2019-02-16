<?php
namespace AbqAtNight\CapstoneProject\Tests;
use AbqAtNight\CapstoneProject\{Tag, Admin};
//Grab the Admin class.
require_once(dirname(__DIR__) . "/autoload.php");

//Grab the UUID generator.
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Tag class
 *
 * This is a complete PHPUnit test of the Tag class. It is complete because all mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Tag
 * @author Adrian Tsosie <atsosie11@cnm.edu>
 *
 **/
class TagTest extends AbqAtNightTest {
	/**
	 * Profile that created the Tag; this is for foreign key relations
	 * @var Admin profile
	 **/
	protected $admin = null;

	/**
	 * valid input type for tag
	 * @var $VALID_TAG_TYPE
	 **/
	protected $VALID_TAG_TYPE = "Genre";

	/**
	 * valid input value for tag
	 * @var string $VALID__TAG_VALUE
	 **/
	protected $VALID_TAG_VALUE = "Bro-step";


	public final function setUp(): void
	{
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);

		// create and insert a Admin to own the test Tag
		$this->admin = new Admin(generateUuidV4(), "email@email.com", $hash, "testuser");
		$this->admin->insert($this->getPDO());

	}

	/**
	 * test inserting a valid Id and verify that the actual mySQL data matches
	 **/
	public function testInsertValidTag(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");

		// create a new Tag and insert to into mySQL
		$tagId = generateUuidV4();
		$tag = new Tag($tagId, $this->admin->getAdminId(), $this->VALID_TAG_TYPE, $this->VALID_TAG_VALUE);
		$tag->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertEquals($pdoTag->getTagId(), $tagId);
		$this->assertEquals($pdoTag->getTagAdminId(), $this->admin->getAdminId());
		$this->assertEquals($pdoTag->getTagType(), $this->VALID_TAG_TYPE);
		$this->assertEquals($pdoTag->getTagValue(), $this->VALID_TAG_VALUE);
	}

	/**
	 * test inserting a Id, editing it, and then updating it
	 **/
	public function testUpdateValidTag(): void
	{
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");

		// create a new Tag and insert to into mySQL
		$tagId = generateUuidV4();
		$tag = new Tag($tagId, $this->admin->getAdminId(), $this->VALID_TAG_TYPE, $this->VALID_TAG_VALUE);
		$tag->insert($this->getPDO());

		// edit the Tag and update it in mySQL
		$tag->setTagValue($this->VALID_TAG_VALUE);
		$tag->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertEquals($pdoTag->getTagId(), $tagId);
		$this->assertEquals($pdoTag->getTagAdminId(), $this->admin->getAdminId());
		$this->assertEquals($pdoTag->getTagType(), $this->VALID_TAG_TYPE);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoTag->getTagValue(), $this->VALID_TAG_VALUE);
	}


	/**
	 * test creating a Tag and then deleting it
	 **/
	public function testDeleteValidTag(): void
	{
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");

		// create a new Tag and insert to into mySQL
		$tagId = generateUuidV4();
		$tag = new Tag($tagId, $this->admin->getAdminId(), $this->VALID_TAG_TYPE, $this->VALID_TAG_VALUE);
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
	 * test grabbing a Tag by tagId
	 **/
	public function testGetTagByTagId(): void
	{
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");

		// create a new Tag and insert to into mySQL
		$tagId = generateUuidV4();
		$tag = new Tag($tagId, $this->admin->getAdminId(), $this->VALID_TAG_TYPE, $this->VALID_TAG_VALUE);
		$tag->insert($this->getPDO());

		// grab the data from mySQL and verify the fields match our expectations
		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));

		// grab the result from the array and validate it
		$this->assertEquals($pdoTag->getTagId(), $tagId);
		$this->assertEquals($pdoTag->getTagAdminId(), $this->admin->getAdminId());
		$this->assertEquals($pdoTag->getTagType(), $this->VALID_TAG_TYPE);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoTag->getTagValue(), $this->VALID_TAG_VALUE);
	}

	/**
	 * test grabbing all Tags
	 **/
	public function testGetAllTags(): void
	{
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");

		// create a new Tag and insert to into mySQL
		$tagId = generateUuidV4();
		$tag = new Tag($tagId, $this->admin->getAdminId(), $this->VALID_TAG_TYPE, $this->VALID_TAG_VALUE);
		$tag->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tag::getAllTags($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("AbqAtNight\\CapstoneProject\\Tag", $results);

		// grab the result from the array and validate it
		$pdoTag = $results[0];
		$this->assertEquals($pdoTag->getTagId(), $tagId);
		$this->assertEquals($pdoTag->getTagAdminId(), $this->admin->getAdminId());
		$this->assertEquals($pdoTag->getTagType(), $this->VALID_TAG_TYPE);
		$this->assertEquals($pdoTag->getTagValue(), $this->VALID_TAG_VALUE);
	}
}
