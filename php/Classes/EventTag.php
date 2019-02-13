<?php
namespace DeepDive\AbqAtNight;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * this is the the section for the event tag class in the ABQ at Night Capstone project
 *
 * @see Event Tag
 * @author Adrian Tsosie <atsosie11@cnm.com>
 *
 **/
class EventTag implements \JsonSerializable {
    use ValidateDate;
    use ValidateUuid;
    /**
     * Id for Event Tag Event Id; this is a foreign key
     * @var Uuid $eventTagEventId
     **/
    private $eventTagEventId;
    /**
     * Id of the Admin that created this event; this is a foreign key
     * @var Uuid $eventTagTagId
     **/
    private $eventTagTagId;

    /**
     * constructor for this Event Tag
     *
     * @param string \ Uuid $newEventTagEventId foreign key not null
     * @param string \ Uuid $newEventTagTagId
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
     * @throws \TypeError if data types violate type hints
     * @throws \Exception if some other exception occurs
     * @Documentation https://php.net/manual/en/language.oop5.decon.php
     */
    public function __construct($newEventTagEventId, $newEventTagTagId) {
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
     * inserts this Tag into mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function insert(\PDO $pdo) : void {

        // create query template
        $query = "INSERT INTO EventTag(eventTagEventId, eventTagTagId) VALUES(:eventTagEventId, :eventTagTagId)";
        $statement = $pdo->prepare($query);

        // bind the member variables to the place holders in the template
        $parameters = ["eventTagEventId" => $this->eventTagEventId->getBytes(), "eventTagTagId" => $this->eventTagTagId->getBytes()];
        $statement->execute($parameters);
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
