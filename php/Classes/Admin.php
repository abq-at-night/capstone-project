<?php

namespace DeepDive\AbqAtNight;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Admin class for the ABQ at Night capstone project
 * This class will be used to instantiate new admin objects.
 *
 * @author Hunter Callaway <jcallaway3@cnm.edu>
 **/

class Admin implements JsonSerializable {
	use ValidateDate;
	use ValidateUuid;

	/**
	 * ID for this Admin. This is the primary key.
	 * @var Uuid $adminId
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

	public function getAdminId() {
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
		$this->adminId = $uuid;
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

	/**
	 * Accessor method for the admin hash
	 *
	 * @return string value of the admin hash
	 */

	public function getAdminHash() : string {
		return($this->adminHash);
	}

	/**
	 * Mutator method for the admin hash
	 *
	 * @param string $newAdminHash new string value of the admin hash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is longer than 97 characters
	 **/

	public function setAdminHash(string $newAdminHash) : void {
		//Enforce that the hash is properly formatted.
		$newAdminHash = trim($newAdminHash);
		if(empty($newAdminHash) === $newAdminHash) {
			throw (new \InvalidArgumentException("The password hash is empty or not a string."));
		}
		//Ensure the hash is an Argon hash.
		$adminHashInfo = password_get_info($newAdminHash);
		if($adminHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("The hash is not an Argon hash."));
		}
		//Ensure the hash is exactly 97 characters long.
		if(strlen($newAdminHash) !== 97) {
			throw(new \RangeException("The hash must be exactly 97 characters long."));
		}
		//Store the hash.
		$this->adminHash = $newAdminHash;
	}

	/**
	 * Accessor method for the admin password
	 *
	 * @return string value of the admin password
	 **/

	public function getAdminPassword() : string {
		return($this->adminPassword);
	}

	/**
	 * Mutator method for the admin password
	 *
	 * @param string $newAdminPassword new string value for the admin password
	 * @throws \InvalidArgumentException if the password is empty
	 * @throws \RangeException if the password is longer than 97 characters
	 **/

	public function setAdminPassword($newAdminPassword) : void {
		//Ensure the password is correctly formatted.
		$newAdminPassword = trim($newAdminPassword);
		if(empty($newAdminPassword) === true) {
			throw(new \InvalidArgumentException("The password is not valid."));
		}
		if(strlen($newAdminPassword) > 97) {
			throw(new \RangeException("The password must be no longer than 97 characters"));
		}
		//Store the password.
		$this->adminPassword = $newAdminPassword;
	}

	/**
	 * Accessor method for the admin username
	 *
	 * @return string value of the admin username
	 **/

	public function getAdminUsername() {
		return($this->adminUsername);
	}

	/**
	 * Mutator method for the admin username
	 *
	 * @param string $newAdminUsername new string value for the admin username
	 * @throws \InvalidArgumentException if the username is empty
	 * @throws \RangeException if the username is longer than 32 characters
	 **/

	public function setAdminUsername($newAdminUsername) : void {
		//Ensure the username is not empty.
		if(empty($newAdminUsername) === true) {
			throw(new \InvalidArgumentException("The username is not valid."));
		}
		if(strlen($newAdminUsername) > 32) {
			throw(new \RangeException("The username must be no longer than 32 characters."));
		}
		//Store the username.
		$this->adminUsername = $newAdminUsername;
	}

	/**
	 * Constructor for this Admin
	 *
	 * @param string \ Uuid $newAdminId ID of this Admin or null if a new Admin
	 * @param string $newAdminEmail e-mail address for this Admin
	 * @param string $newAdminHash hash for this Admin
	 * @param string $newAdminPassword password for this Admin
	 * @param string $newAdminUsername username for this Admin
	 * @throws \InvalidArgumentException if the data types are not valid
	 * @throws \RangeException if the values are out of bounds (i.e. not the exact length or too long)
	 * @throws \TypeError if the data types violate type hints
	 * @throws \Exception if any other exception occurs
	 **/

	public function __construct($newAdminId, $newAdminEmail, $newAdminHash, $newAdminPassword, $newAdminUsername) {
		try {
			$this->setAdminId($newAdminId);
			$this->setAdminEmail($newAdminEmail);
			$this->setAdminHash($newAdminHash);
			$this->setAdminPassword($newAdminPassword);
			$this->setAdminUsername($newAdminUsername);
		}
		//Determine which exception type was thrown.
		catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception){
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
}