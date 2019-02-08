<?php
namespace Edu\Cnm\DataDesign\Test;
use Edu\Cnm\DataDesign\{Tag};

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
     * @parm
     * @throws \InvalidArgumentException if data types are not valid
     * @throws @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
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
        return($this->eventTagId);
    }
    /**
     * mutator method for event tag event id
     *
     * @param Uuid|string $newTagId new value of event tag event id
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
    public function setTagAdminId( $newEventTagTagId) : void {
        try {
            $uuid = self::validateUuid($newEventTagTagId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        // convert and store the tag admin id
        $this->tagAdminId = $uuid;
    }


    /**
     * accessor method for event tag tag id
     *
     * @return Uuid value of event tag tag id
     **/
    public function getTagType() : Uuid {
        return($this->eventTagTagId);
    }
    /**
     * mutator method for event tag tag id
     *
     * @param Uuid|string $newEventTagTagId new value of event tag event id
     * @throws \RangeException if $newEventTagTagId is not positive
     * @throws \TypeError if $newEventTagTagId is not a uuid or string
     **/
    public function setTagType( $newEventTagTagId) : void {
        try {
            $uuid = self::validateUuid($newEventTagTagId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        // convert and store the event tag tag id
        $this->eventTagTagId = $uuid;
    }


    /**
     * accessor method for event tag tag id
     *
     * @return Uuid value of event tag tag id
     **/
    public function getTagValue() : Uuid {
        return($this->eventTagTagId);
    }
    /**
     * mutator method for event tag tag id
     *
     * @param Uuid|string $newEventTagTagId new value of event tag event id
     * @throws \RangeException if $newEventTagTagId is not positive
     * @throws \TypeError if $newEventTagTagId is not a uuid or string
     **/
    public function setTagValue( $newEventTagTagId) : void {
        try {
            $uuid = self::validateUuid($newEventTagTagId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        // convert and store the event tag tag id
        $this->eventTagTagId = $uuid;
    }
}