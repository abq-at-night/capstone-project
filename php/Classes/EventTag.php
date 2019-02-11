<?php
namespace DeepDive\AbqAtNight;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Full PHPUnit test for the Event Tag class
 *
 * This is a complete PHPUnit test of the Event Tag class. It is complete because all mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Event Tag
 * @author Adrian Tsosie <atsosie11@cnm.com>
 *
 **/
class EventTag implements \JsonSerializable {
    use ValidateDate;
    use ValidateUuid;
    /**
     * id for Event Tag Event Id; this is a foreign key
     * @var Uuid $eventTagEventId
     **/
    private $eventTagEventId;
    /**
     * id of the Admin that created this event; this is a foreign key
     * @var Uuid $eventAdminId
     **/
    private $eventTagTagId;

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
    public function _construct($newEventTagEventId, $newEventTagTagId) {
        try {
            $this->setEventTagEventId($newEventTagEventId);
            $this->setEventTagTagId($newEventTagTagId);
        }
        catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }
    /**
     * accessor method for event tag event id
     *
     * @return Uuid value of event tag event id
     **/
    public function getEventTagEventId() : Uuid {
        return($this->eventTagEventId);
    }
    /**
     * mutator method for event tag event id
     *
     * @param Uuid|string $newEventTagEventId new value of event tag event id
     * @throws \RangeException if $newEventTagEventId is not positive
     * @throws \TypeError if $newEventTagEventId is not a uuid or string
     **/
    public function setEventTagEventId( $newEventTagEventId) : void {
        try {
            $uuid = self::validateUuid($newEventTagEventId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }

        // convert and store the event tag event id
        $this->eventTagEventId = $uuid;
    }
    /**
     * accessor method for event tag tag id
     *
     * @return Uuid value of event tag tag id
     **/
    public function getEventTagTagId() : Uuid {
        return($this->eventTagTagId);
    }
    /**
     * mutator method for event tag tag id
     *
     * @param Uuid|string $newEventTagTagId new value of event tag event id
     * @throws \RangeException if $newEventTagTagId is not positive
     * @throws \TypeError if $newEventTagTagId is not a uuid or string
     **/
    public function setEventTagTagId( $newEventTagTagId) : void {
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
     * Formats the state variables for JSON serialization
     *
     * @return array resulting state variables to serialize
     **/
    public function jsonSerialize() : array {
        $fields = get_object_vars($this);

        $fields["EventTagEventId"] = $this->eventTagEventId->toString();

        return($fields);
    }
}
