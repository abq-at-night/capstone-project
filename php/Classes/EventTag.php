<?php
namespace AbqAtNight\CapstoneProject;

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
    public function setEventTagTagId($newEventTagTagId) : void {
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
        $query = "INSERT INTO eventTag(eventTagEventId, eventTagTagId) VALUES(:eventTagEventId, :eventTagTagId)";
        $statement = $pdo->prepare($query);

        // bind the member variables to the place holders in the template
        $parameters = ["eventTagEventId" => $this->eventTagEventId->getBytes(), "eventTagTagId" => $this->eventTagTagId->getBytes()];
        $statement->execute($parameters);
    }

    /**
     * deletes the Event Tag from mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related error occur
     * @throws \TypeError if $pdo is not a PDO connection object
     */
    public function delete(\PDO $pdo) : void {

        // create query template
        $query = "DELETE FROM eventTag WHERE eventTagEventId = :eventTagEventId && eventTagTagId = :eventTagTagId";
        $statement = $pdo->prepare($query);

        //binds th variables to the place holder in the template
        $parameters = ["eventTagEventId" => $this->eventTagEventId->getBytes(), "eventTagTagId" => $this->eventTagTagId->getBytes()];
        $statement->execute($parameters);

    }

    /**
     * Gets Event Tag by Event Id
     *
     * @param \PDO $pdo PDO connection object
     * @param Uuid|string $eventTagEventId event tag to search for
     * @return EventTag | null EventTag found or null if not found
     * @throws \PDOException when mySQL-related errors occur
     * @throws \TypeError when a variable are not the correct data type
     **/

    public static function getEventTagByEventTagEventId(\PDO $pdo, $eventTagEventId) : ?EventTag {
        //Sanitize the adminId before searching
        try {
            $eventTagEventId = self::validateUuid($eventTagEventId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }

        //Create the query template.
        $query = "SELECT eventTagEventId, eventTagTagId FROM eventTag WHERE  eventTagEventId = :eventTagEventId";
        $statement = $pdo->prepare($query);

        //Bind the tagId to the place-holder in the template.
        $parameters = ["eventTagEventId" => $eventTagEventId->getBytes()];
        $statement->execute($parameters);

        //Grab the eventTag from MySQL
        try {
            $eventTag = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
                $eventTag = new EventTag($row["eventTagEventId"], $row["eventTagTagId"]); }
        } catch (\Exception $exception) {
            //If the row couldn't be converted, re-throw it.
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return($eventTag);
    }

    public static function getEventTagByEventTagTagId(\PDO $pdo, $eventTagTagId) : ?EventTag {
        //Sanitize the adminId before searching
        try {
            $eventTagTagId = self::validateUuid($eventTagTagId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }

        //Create the query template.
        $query = "SELECT eventTagEventId, eventTagTagId FROM eventTag WHERE  eventTagTagId = :eventTagTagId";
        $statement = $pdo->prepare($query);

        //Bind the tagId to the place-holder in the template.
        $parameters = ["eventTagTagId" => $eventTagTagId->getBytes()];
        $statement->execute($parameters);

        //Grab the eventTag from MySQL
        try {
            $eventTag = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
                $eventTag = new EventTag($row["eventTagEventId"], $row["eventTagTagId"]);
            }
        } catch (\Exception $exception) {
            //If the row couldn't be converted, re-throw it.
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return($eventTag);
    }

    public static function getEventTagByEventTagEventIDEventTagTagId(\PDO $pdo, $eventTagEventId, $eventTagTagId) : \SplFixedArray {
        //Create the query template.
        $query = "SELECT eventTagEventId, eventTagTagId FROM eventTag WHERE eventTagEventId = :eventTagEventId AND eventTagTagId = :eventTagTagId";
        $statement = $pdo->prepare($query);
			$parameters = ["eventTagEventId" => $eventTagEventId->getBytes(), "eventTagTagId" => $eventTagTagId->getBytes()];
        $statement->execute($parameters);

        //build an array of event tags
        $eventTags = new\SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !== false) {
            try {
                $eventTag = new EventTag($row["eventTagEventId"], $row["eventTagTagId"]);
                $eventTags[$eventTags->key()] = $eventTag;
                $eventTags->next();
            } catch(\Exception $exception) {
                //if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return ($eventTags);
    }


    /**
     * Formats the state variables for JSON serialization
     *
     * @return array resulting state variables to serialize
     **/
    public function jsonSerialize() : array {
        $fields = get_object_vars($this);

        return($fields);
    }
}
