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

	private $VALID_ADMIN_EMAIL;

	/**
	 * Valid hash for the admin
	 * @var VALID_ADMIN_HASH
	 **/

	private $VALID_ADMIN_HASH;

	/**
	 * Valid password for the admin
	 * @var VALID_ADMIN_PASSWORD
	 **/

	private $VALID_ADMIN_PASSWORD;

	/**
	 * Valid username for the admin
	 * @var VALID_ADMIN_USERNAME
	 **/

	private $VALID_ADMIN_USERNAME;
}