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
	 * @var VALID_ADMIN_EMAIL
	 **/

	private $VALID_ADMIN_EMAIL = "abqatnightadmin@gmail.com";


	/**
	 * Valid password for the admin
	 * @var VALID_ADMIN_PASSWORD
	 **/

	private $VALID_ADMIN_PASSWORD = "myPassword123";

	/**
	 * Valid username for the admin
	 * @var VALID_ADMIN_USERNAME
	 **/

	private $VALID_ADMIN_USERNAME = "abqatnightadmin";

	public final function setUp() : void {
		parent::setUp();
	}

	/**
	 * Test inserting a valid Admin and verify the MySQL data matches
	 **/
	public function testInsertValidAdmin() : void {
		//Count the number of rows and save it for later.
		$rowsTotal = $this->getConnection()->getRowCount("admin");

		//Create a new Admin and insert it into SQL.
		$adminId = generateUuidV4();
		$admin = new Admin($adminId, $this -> VALID_ADMIN_EMAIL, $this -> password_hash($this->VALID_ADMIN_PASSWORD, PASSWORD_DEFAULT), $this -> VALID_ADMIN_PASSWORD, $this -> VALID_ADMIN_USERNAME);
		$admin->insert($this->getPDO());

		//Grab the data from MySQL and verify the fields meet our expectations.
		$pdoAdmin = Admin::getAdminByAdminId($this->getPDO(), $admin->getAdminId());
		$this->assertEquals($rowsTotal + 1, $this -> getConnection() -> getRowCount("admin"));
		$this->assertEquals($pdoAdmin -> getAdminId(), $adminId);
		$this->assertEquals($pdoAdmin -> getAdminEmail(), $this -> VALID_ADMIN_EMAIL);
		$this->assertEquals($pdoAdmin -> getAdminHash(), $this -> password_hash($this ->VALID_ADMIN_PASSWORD, PASSWORD_DEFAULT));
		$this->assertEquals($pdoAdmin -> getAdminPassword(), $this -> VALID_ADMIN_PASSWORD);
		$this->assertEquals($pdoAdmin -> getAdminUsername(), $this -> VALID_ADMIN_USERNAME);
	}

}