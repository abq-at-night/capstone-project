<?php

namespace DeepDive\AbqAtNight\Test;

use DeepDive\AbqAtNight\{Admin};

//Grab the Admin class.
require_once(dirname(__DIR__) . "/autoload.php");

//Grab the UUID generator.
require_once(dirname(__DIR__, 1) . "/ValidateUuid.php");

/**
 * Full PHPUnit test for the Admin class
 *
 * This is a complete PHPUnit test of the Tweet class. It is complete because all mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Admin
 * @author Hunter Callaway <jcallaway3@cnm.edu>
 *
 **/

class AdminTest extends AbqAtNightTest {

	/**
	 * Valid e-mail address for the admin
	 * @var $VALID_ADMIN_EMAIL
	 **/

	protected $VALID_ADMIN_EMAIL = "abqatnightadmin@gmail.com";

	/**
	 * Valid hash for the admin
	 * @var $VALID_ADMIN_HASH
	 **/

	protected $VALID_ADMIN_HASH;

	/**
	 * Valid username for the admin
	 * @var $VALID_ADMIN_USERNAME
	 **/

	protected $VALID_ADMIN_USERNAME = "abqatnightadmin";

	/**
	 * Updated valid username for the admin
	 * @var $VALID_ADMIN_USERNAME2
	 **/

	protected $VALID_ADMIN_USERNAME2 = "newabqatnightadmin";

	/**
	 * This method needs work.
	 **/
	public final function setUp() : void {
		parent::setUp();
		$password = "abc123";
		$this->VALID_ADMIN_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
	}

	/**
	 * Test inserting a valid Admin and verify the MySQL data matches
	 **/
	public function testInsertValidAdmin() : void {
		//Count the number of rows and save it for later.
		$rowsTotal = $this->getConnection()->getRowCount("admin");

		//Create a new Admin and insert it into MySQL.
		$adminId = generateUuidV4();
		$admin = new Admin($adminId, $this -> VALID_ADMIN_EMAIL, $this -> VALID_ADMIN_HASH, $this -> VALID_ADMIN_USERNAME);
		$admin->insert($this->getPDO());

		//Grab the data from MySQL and verify the fields meet our expectations.
		$pdoAdmin = Admin::getAdminByAdminId($this->getPDO(), $admin->getAdminId());
		$this->assertEquals($rowsTotal + 1, $this -> getConnection() -> getRowCount("admin"));
		$this->assertEquals($pdoAdmin -> getAdminId(), $adminId);
		$this->assertEquals($pdoAdmin -> getAdminEmail(), $this -> VALID_ADMIN_EMAIL);
		$this->assertEquals($pdoAdmin -> getAdminHash(), $this -> VALID_ADMIN_HASH);
		$this->assertEquals($pdoAdmin -> getAdminUsername(), $this -> VALID_ADMIN_USERNAME);
	}

	/**
	 * Test inserting a valid Admin, editing it, and then updating it.
	 **/

	public function testUpdateValidAdmin() : void {
		//Count the number of rows and save it for later.
		$rowsTotal = $this->getConnection()->getRowCount("admin");

		//Create a new Admin and insert it into MySQL.
		$adminId = generateUuidV4();
		$admin = new Admin($adminId, $this -> VALID_ADMIN_EMAIL, $this -> VALID_ADMIN_HASH, $this -> VALID_ADMIN_USERNAME);
		$admin->insert($this->getPDO());

		//Edit the Admin and update it in MySQL.
		$admin->setAdminUsername($this->VALID_ADMIN_USERNAME2);
		$admin->update($this->getPDO());

		//Grab the data from MySQL and verify the fields meet our expectations.
		$pdoAdmin = Admin::getAdminByAdminId($this->getPDO(), $admin->getAdminId());
		$this->assertEquals($rowsTotal + 1, $this -> getConnection() -> getRowCount("admin"));
		$this->assertEquals($pdoAdmin -> getAdminId(), $adminId);
		$this->assertEquals($pdoAdmin -> getAdminEmail(), $this -> VALID_ADMIN_EMAIL);
		$this->assertEquals($pdoAdmin -> getAdminHash(), $this -> password_hash($this ->VALID_ADMIN_PASSWORD, PASSWORD_DEFAULT));
		$this->assertEquals($pdoAdmin -> getAdminPassword(), $this -> VALID_ADMIN_PASSWORD);
		$this->assertEquals($pdoAdmin -> getAdminUsername(), $this -> VALID_ADMIN_USERNAME2);
	}

	/**
	 * Test creating an Admin and then deleting it.
	 **/

	public function testDeleteValidAdmin() : void {
		//Count the number of rows and save it for later.
		$rowsTotal = $this->getConnection()->getRowCount("admin");

		//Create a new Admin and insert it into MySQL.
		$adminId = generateUuidV4();
		$admin = new Admin($adminId, $this -> VALID_ADMIN_EMAIL, $this -> password_hash($this->VALID_ADMIN_PASSWORD, PASSWORD_DEFAULT), $this -> VALID_ADMIN_PASSWORD, $this -> VALID_ADMIN_USERNAME);
		$admin->insert($this->getPDO());

		//Delete the Admin from MySQL.
		$this->assertEquals($rowsTotal + 1, $this->getConnection()->getRowCount("admin"));
		$admin->delete($this->getPDO());

		//Grab the data from MySQL and verify the Admin does not exist.
		$pdoAdmin = Admin::getAdminByAdminId($this->getPDO(), $admin->getAdminId());
		$this->assertNull($pdoAdmin);
		$this->assertEquals($rowsTotal, $this->getConnection()->getRowCount("admin"));
	}

	public function testGetValidAdminByAdminId() : void {
		//Count the number of rows and save it for later.
		$rowsTotal = $this->getConnection()->getRowCount("admin");

		//Create a new Admin and insert it into MySQL.
		$adminId = generateUuidV4();
		$admin = new Admin($adminId, $this -> VALID_ADMIN_EMAIL, $this -> password_hash($this->VALID_ADMIN_PASSWORD, PASSWORD_DEFAULT), $this -> VALID_ADMIN_PASSWORD, $this -> VALID_ADMIN_USERNAME);
		$admin->insert($this->getPDO());

		//Grab the data from MySQL and verify the results match our expectations.
		$results = Admin::getAdminByAdminId($this->getPDO(), $admin->getAdminId());
		$this->assertEquals($rowsTotal + 1, $this->getConnection()->getRowCount("admin"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("DeepDive\\AbqAtNight\\php\\Classes\\Admin", $results);

		//Grab the result from the array and validate it.
		$pdoAdmin = $results[0];
		$this->assertEquals($pdoAdmin -> getAdminId(), $adminId);
		$this->assertEquals($pdoAdmin -> getAdminEmail(), $this -> VALID_ADMIN_EMAIL);
		$this->assertEquals($pdoAdmin -> getAdminHash(), $this -> password_hash($this ->VALID_ADMIN_PASSWORD, PASSWORD_DEFAULT));
		$this->assertEquals($pdoAdmin -> getAdminPassword(), $this -> VALID_ADMIN_PASSWORD);
		$this->assertEquals($pdoAdmin -> getAdminUsername(), $this -> VALID_ADMIN_USERNAME);
	}

	/**
	 * Test grabbing all Admins
	 **/

	public function testGetAllValidAdmins() : void {
		//Count the number of rows and save it for later.
		$rowsTotal = $this->getConnection()->getRowCount("admin");

		//Create a new Admin and insert it into MySQL.
		$adminId = generateUuidV4();
		$admin = new Admin($adminId, $this -> VALID_ADMIN_EMAIL, $this -> password_hash($this->VALID_ADMIN_PASSWORD, PASSWORD_DEFAULT), $this -> VALID_ADMIN_PASSWORD, $this -> VALID_ADMIN_USERNAME);
		$admin->insert($this->getPDO());

		//Grab the data from MySQL and verify the fields match our expectations.
		$results = Admin::getAllAdmins($this->getPDO());
		$this->assertEquals($rowsTotal + 1, $this->getConnection()->getRowCount("admin"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("DeepDive\\AbqAtNight\\php\\Classes\\Admin", $results);

		//Grab the result from the array and validate it.
		$pdoAdmin = $results[0];
		$this->assertEquals($pdoAdmin -> getAdminId(), $adminId);
		$this->assertEquals($pdoAdmin -> getAdminEmail(), $this -> VALID_ADMIN_EMAIL);
		$this->assertEquals($pdoAdmin -> getAdminHash(), $this -> password_hash($this ->VALID_ADMIN_PASSWORD, PASSWORD_DEFAULT));
		$this->assertEquals($pdoAdmin -> getAdminPassword(), $this -> VALID_ADMIN_PASSWORD);
		$this->assertEquals($pdoAdmin -> getAdminUsername(), $this -> VALID_ADMIN_USERNAME);
	}

}