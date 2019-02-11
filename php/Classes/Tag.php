<?php
namespace DeepDive\AbqAtNight;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Full PHPUnit test for the Tag class
 *
 * This is a complete PHPUnit test of the Tag class. It is complete because all mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Tag
 * @author Adrian Tsosie <atsosie11@cnm.com>
 *
 **/
class Tag implements \JsonSerializable {
    use ValidateDate;
    use ValidateUuid;

    /**
     * id for Tag Id; this is the primary key
     * @var Uuid $tagId
     **/
    private $tagId;

    /**
     * tag of the Admin Id that created this event; this is a foreign key
     * @var Uuid $tagAdminId
     **/
    private $tagAdminId;

    /**
     * tag that is identified by its type
     * @var Uuid $tagType
     **/
    private $tagType;

    /**
     * tag that is identified by its value
     * @var Uuid $tagValue
     **/
    private $tagValue;

    /**
     * constructor for this Event Tag
     *
     * @parm string|Uuid $newEventTagEVentId
     * @parm string|Uuid $newEvent TagId
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
     * @throws \TypeError if data types violate type hints
     * @throws \Exception if some other exception occurs
     * @Documentation https://php.net/manual/en/language.oop5.decon.php
     */
    public function _construct($newTagId, $newTagAdminId, $newTagType, $newTagValue) {
        try {
            $this->setTagId($newTagId);
            $this->setTagAdminId($newTagAdminId);
            $this->setTagType($newTagType);
            $this->setTagValue($newTagValue);
        }
        catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }
    /**
     * accessor method for tag id
     *
     * @return Uuid value of tag id
     **/
    public function getTagId() : Uuid {
        return($this->tagId);
    }
    /**
     * mutator method for tag id
     *
     * @param Uuid|string $newTagId new value of tag id
     * @throws \RangeException if $newTagId is not positive
     * @throws \TypeError if $newTagId is not a uuid or string
     **/
    public function setTagId($newTagId) : void {
        try {
            $uuid = self::validateUuid($newTagId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        // convert and store the tag id
        $this->tagId = $uuid;
    }


    /**
     * accessor method for tag admin id
     *
     * @return Uuid value of tag admin id
     **/
    public function getTagAdminId() : Uuid {
        return($this->tagAdminId);
    }
    /**
     * mutator method for tag admin Id
     *
     * @param Uuid|string $newTagAdminId new value of tag admin id
     * @throws \RangeException if $newTagAdminId is not positive
     * @throws \TypeError if $newTagAdminId is not a uuid or string
     **/
    public function setTagAdminId($newTagAdminId) : void {
        try {
            $uuid = self::validateUuid($newTagAdminId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        // convert and store the tag admin id
        $this->tagAdminId = $uuid;
    }


    /**
     * accessor method for tag type
     *
     * @return Uuid value of tag type
     **/
    public function getTagType() : Uuid {
        return($this->tagType);
    }
    /**
     * mutator method for tag type
     *
     * @param Uuid|string $newTagType new value of tag type
     * @throws \RangeException if $newTagType is not positive
     * @throws \TypeError if $newTagType is not a uuid or string
     **/
    public function setTagType($newTagType) : void {
        try {
            $uuid = self::validateUuid($newTagType);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        // convert and store the tag type
        $this->tagType = $uuid;
    }


    /**
     * accessor method for tag value
     *
     * @return Uuid value of tag value
     **/
    public function getTagValue() : Uuid {
        return($this->tagValue);
    }
    /**
     * mutator method for tag value
     *
     * @param Uuid|string $newTagValue new value of tag value
     * @throws \RangeException if $newTagValue is not positive
     * @throws \TypeError if $newTagValue is not a uuid or string
     **/
    public function setTagValue( $newTagValue) : void {
        try {
            $uuid = self::validateUuid($newTagValue);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        // convert and store the tag value
        $this->tagValue = $uuid;
    }

    /**
     * inserts this Tweet into mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function insert(\PDO $pdo) : void {

        // create query template
        $query = "INSERT INTO tag(tagId, tagAdminId, tagType, tagValue) VALUES(:tagId, :tagAdminId, :tagType, :tagValue)";
        $statement = $pdo->prepare($query);

        // bind the member variables to the place holders in the template
        $formattedDate = $this->tweetDate->format("Y-m-d H:i:s.u");
        $parameters = ["tagId" => $this->tagId->getBytes(), "tagAdminId" => $this->tagAdminId->getBytes(), "tagType" => $this->tagType, "tagValue" => $this->tagValue];
        $statement->execute($parameters);
    }
    /**
     * Formats the state variables for JSON serialization
     *
     * @return array resulting state variables to serialize
     **/
    public function jsonSerialize() : array {
        $fields = get_object_vars($this);

        $fields["tagId"] = $this->tagId->toString();

        return($fields);
    }
}