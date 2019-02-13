<?php
namespace DeepDive\AbqAtNight;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 *  this is the the section for the tag class in the ABQ at Night Capstone project
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
     * @var string $tagType
     **/
    private $tagType;

    /**
     * tag that is identified by its value
     * @var string $tagValue
     **/
    private $tagValue;

    /**
     * constructor for this Tag
     *
     * @parm string \ Uuid $newTagId Id for the tag created. not null
     * @parm string \ Uuid $newTagAdminId Id for admin creating the tag
     * @parm string $newTagType The type of Tag with a string value
     * @parm string $newTagValue A tag with Value
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
     * @throws \TypeError if data types violate type hints
     * @throws \Exception if some other exception occurs
     * @Documentation https://php.net/manual/en/language.oop5.decon.php
     */
    public function __construct($newTagId, $newTagAdminId, $newTagType, $newTagValue) {
        try {
            $this->setTagId($newTagId);
            $this->setTagAdminId($newTagAdminId);
            $this->setTagType($newTagType);
            $this->setTagValue($newTagValue);
        }
            //Determine which exception type was thrown.
        catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }
    /**
     * Accessor method for tag id
     *
     * @return Uuid value of tag id
     **/
    public function getTagId() {
        return($this->tagId);
    }
    /**
     * Mutator method for tag id
     *
     * @param Uuid |string $newTagId new value of tag id
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
     * @return string value of tag type
     **/
    public function getTagType() : string {
        return($this->tagType);
    }
    /**
     * mutator method for tag type
     *
     * @param string $newTagType new value of tag type
     * @throws \RangeException if $newTagType is not positive
     * @throws \TypeError if $newTagType is not a uuid or string
     **/
    public function setTagType(string $newTagType) : void {
        $newTagType = trim($newTagType);
        $newTagType = filter_var($newTagType, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if(empty($newTagType) === true) {
            throw(new \InvalidArgumentException("tag content is empty or insecure"));
        }

        if(strlen($newTagType) > 140) {
            throw(new \RangeException("tag type is to long"));
        }

        $this->tagType = $newTagType;
    }


    /**
     * accessor method for tag value
     *
     * @return string value of tag value
     **/
    public function getTagValue() : string {
        return($this->tagValue);
    }
    /**
     * mutator method for tag value
     *
     * @param string $newTagValue new value of tag value
     * @throws \RangeException if $newTagValue is not positive
     * @throws \TypeError if $newTagValue is not a uuid or string
     **/
    public function setTagValue(string $newTagValue) : void {
        $newTagValue = trim($newTagValue);
        $newTagValue = filter_var($newTagValue, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if(empty($newTagValue) === true) {
            throw(new \InvalidArgumentException("tag content is empty or insecure"));
        }

        if(strlen($newTagValue) > 140) {
            throw(new \RangeException("tag value is to long"));
        }

        $this->tagValue = $newTagValue;
    }

    /**
     * inserts this Tag into mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function insert(\PDO $pdo) : void {

        // create query template
        $query = "INSERT INTO tag(tagId, tagAdminId, tagType, tagValue) VALUES(:tagId, :tagAdminId, :tagType, :tagValue)";
        $statement = $pdo->prepare($query);

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