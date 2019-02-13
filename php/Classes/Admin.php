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

class Admin implements \JsonSerializable {
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
	 * The username for this Admin
	 * @var string $adminUsername
	 **/


	private $adminUsername;

	/**
	 * Constructor for this Admin
	 *
	 * @param string \ Uuid $newAdminId ID of this Admin or null if a new Admin
	 * @param string $newAdminEmail e-mail address for this Admin
	 * @param string $newAdminHash hash for this Admin
	 * @param string $newAdminUsername username for this Admin
	 * @throws \InvalidArgumentException if the data types are not valid
	 * @throws \RangeException if the values are out of bounds (i.e. not the exact length or too long)
	 * @throws \TypeError if the data types violate type hints
	 * @throws \Exception if any other exception occurs
	 **/

	public function __construct($newAdminId, $newAdminEmail, $newAdminHash, $newAdminUsername) {
		try {
			$this->setAdminId($newAdminId);
			$this->setAdminEmail($newAdminEmail);
			$this->setAdminHash($newAdminHash);
			$this->setAdminUsername($newAdminUsername);
		}
			//Determine which exception type was thrown.
		catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception){
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

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
			throw (new \InvalidArgumentException("The hash is empty or not a string."));
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
	 * Inserts this Admin into MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL-related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function insert(\PDO $pdo) : void {
		// Create the query template.
		$query = "INSERT INTO admin(adminId, adminEmail, adminHash, adminUsername) VALUES(:adminId, :adminEmail, :adminHash, :adminUsername)";
		$statement = $pdo->prepare($query);

		// Bind the member variables to the place holders in the template.
		$parameters = ["adminId" => $this->adminId->getBytes(), "adminEmail" => $this->adminEmail, "adminHash" => $this->adminHash, "adminUsername" => $this->adminUsername];
		$statement->execute($parameters);
	}

	/**
	 * Deletes this Admin from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL-related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function delete(\PDO $pdo) : void {

		// Create query template.
		$query = "DELETE FROM admin WHERE adminId = : adminId";
		$statement = $pdo->prepare($query);

		// Bind the member variables to the place holder in the template
		$parameters = ["adminId" => $this->adminId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * Updates this Admin in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function update(\PDO $pdo) : void {

		// Create query template
		$query = "UPDATE admin SET adminId = :adminId, adminEmail = :adminEmail, adminHash = :adminHash, adminUsername = :adminUsername WHERE adminId = :adminId";
		$statement = $pdo->prepare($query);

		$parameters = ["adminId" => $this->adminId->getBytes(), "adminEmail" => $this->adminEmail, "adminHash" => $this->adminHash, "adminUsername" => $this->adminUsername];
		$statement->execute($parameters);
	}
	/**
	 * Gets Admin by adminId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $adminId admin id to search for
	 * @return Admin|null Admin found or null if not found
	 * @throws \PDOException when mySQL-related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/

	public static function getAdminByAdminId(\PDO $pdo, $adminId) : ?Admin {
		//Sanitize the adminId before searching
		try {
			$adminId = self::validateUuid($adminId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		//Create the query template.
		$query = "SELECT adminId, adminEmail, adminHash, adminUsername FROM admin WHERE adminId = :adminId";
		$statement = $pdo->prepare($query);

		//Bind the adminId to the place-holder in the template.
		$parameters = ["adminId" => $adminId->getBytes()];
		$statement->execute($parameters);

		//Grab the admin from MySQL
		try {
			$admin = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$admin = new Admin($row["adminId"], $row["adminEmail"], $row["adminHash"], $row["adminUsername"]); }
			} catch (\Exception $exception) {
				//If the row couldn't be converted, re-throw it.
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		return($admin);
	}

	/**
	 * Get Admin by adminEmail
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $adminEmail  admin e-mail to search for
	 * @return \SplFixedArray SplFixedArray of Admins found or null if not found
	 * @throws \PDOException when MySQL-related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/

	public static function getAdminByAdminEmail(\PDO $pdo, $adminEmail) : ?Admin {
		//Sanitize the adminEmail before searching
		try {
			$adminEmail = self::validateUuid($adminEmail);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		//Create the query template.
		$query = "SELECT adminId, adminEmail, adminHash, adminUsername FROM admin WHERE adminEmail = :adminEmail";
		$statement = $pdo->prepare($query);


		//Bind the adminId to the place-holder in the template.
		$parameters = ["adminEmail" => $adminEmail];
		$statement->execute($parameters);

		//Grab the admin from MySQL
		try {
			$admin = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$admin = new Admin($row["adminId"], $row["adminEmail"], $row["adminHash"], $row["adminUsername"]); }
		} catch (\Exception $exception) {
			//If the row couldn't be converted, re-throw it.
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($admin);
	}

	/**
	 * Formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);
		unset($fields["adminHash"]);
		unset($fields["adminEmail"]);
		return($fields);
	}

}