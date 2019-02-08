<?php

namespace ...;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Deepdivedylan\DataDesign\ValidateDate;
use Deepdivedylan\DataDesign\ValidateUuid;
use http\Exception\BadQueryStringException;
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

/**
 * Accessor method for the admin ID
 *
 * @return Uuid value of the admin ID
 **/

public function getAdminId() : Uuid {
	return($this->adminId);
}

/**
 * Mutator method for the admin ID
 *
 * @param Uuid | string $newAdminId new value of the admin ID
 * @throws \RangeException if $newAdminId is not positive
 * @throws \TypeError if $newAdminId is not a Uuid or a string
 **/

public function setAdminId($newAdminId) : void {
	try {
		$uuid = self::validateUuid($newAdminId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	//Convert and store the admin ID
	$this->adminId = uuid;
}

/**
 * Accessor method for the admin e-mail
 *
 * @return string value of the admin e-mail
 **/

public function getAdminEmail(): string  {
	return($this->adminEmail);
}

/**
 * Mutator method for the admin e-mail
 *
 * @param string $newAdminEmail new value of the admin e-mail
 * @throws \InvalidArgumentException if $newAdminEmail is not a string
 * @throws \RangeException if $newAdminEmail is too long
 **/

public function setAdminEmail(string $newAdminEmail) : void {
	//Verify the e-mail address is accurate.
	$newAdminEmail = trim($newAdminEmail);
	$newAdminEmail = filter_var($newAdminEmail, FILTER_VALIDATE_EMAIL);
	if(empty($newAdminEmail) === true) {
		throw (new \InvalidArgumentException("The admin e-mail is not valid."));
	}
	//Verify the e-mail address will fit in the database.
	if(strlen($newAdminEmail) > 128) {
		throw (new \RangeException("The admin e-mail must be no longer than 128 characters."));
	}
	//Store the e-mail address.
	$this->adminEmail = $newAdminEmail;
	}

}