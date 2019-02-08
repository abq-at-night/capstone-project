<?php

namespace ...;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Deepdivedylan\DataDesign\ValidateDate;
use Deepdivedylan\DataDesign\ValidateUuid;
use Ramsey\Uuid\Uuid;

/**
 * Admin class for the ABQ at Night capstone project
 * This class will be used to instantiate new admin objects.
 *
 * @author Hunter Callaway <jcallaway3@cnm.edu>
 **/

class Admin implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;

	/**
	 * ID for this Admin. This is the primary key.
	 * @var Uuid\ $adminId
	 **/

	private $adminId;

	/**
	 * E-mail address for this Admin
	 * @var string $adminEmail
	 **/

	private $adminEmail;

	/**
	 * The hash for this Admin
	 * @var string $adminHash
	 **/

	private $adminHash;

	/**
	 * The password for this Admin
	 * @var string $adminPassword
	 **/

	private $adminPassword;

	/**
	 * The username for this Admin
	 * @var string $adminUsername
	 **/

	private $adminUsername;


}