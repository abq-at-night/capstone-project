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
class Tag implements \JsonSerializable
{
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
}