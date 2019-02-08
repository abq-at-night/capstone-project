<?php
namespace Edu\Cnm\DataDesign\Test;
use Edu\Cnm\DataDesign\{eventTag};

//Grab the Admin class.
require_once(dirname(__DIR__) . "/autoload.php");

//Grab the UUID generator.
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

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
class EventTag implements \JsonSerializable
{
    use ValidateDate;
    use ValidateUuid;

    /**
     * id for Event Tag Event Id; this is the primary key
     * @var Uuid $eventId
     **/
    private $eventTagEventId;

    /**
     * id of the Admin that created this event; this is a foreign key
     * @var Uuid $eventAdminId
     **/
    private $eventTagTagId;
}