<?php

require_once  dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use AbqAtNight\CapstoneProject\{
    Admin, Tag
};

/**
 * API for Tag Class
 *
 * @author Adrian Tsosie <atsosie11@cnm.edu>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
    //grab the mySql connection
    $secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/atnight.ini");
    $pdo = $secrets->getPdoObject();

    //determine which HTTP method was used
    $method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

    //sanitize input
    $tagId = filter_input(INPUT_GET, "tagId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $tagAdminId = filter_input(INPUT_GET, "tagAdminId",FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    //make sure the id is valid for methods that require it
    if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
        throw(new InvalidArgumentException("id cannot be empty or negative", 405));
    }

    if($method === "GET") {
        //set XSRF cookie
        setXsrfCookie();

        //get a specific tag based on arguments provided or all the tags and update reply
        if(empty($id) === false) {
            $reply->data = Tag::getTagByTagId($pdo, $id);

        } else if(empty($tagAdminId) === false) {
            $reply->data = Tag::getTagByTagType($pdo, $tagAdminId)->toArray();

        } else {
            $reply->data = Tag::getAllTags($pdo)->toArray();
        }
    }

    else if($method === "PUT" || $method === "POST") {

        //enforce the uer has a XSRF token
        verifyXsrf();

        // Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the
        // front end request which is, in this case, a JSON package.
        $requestContent = file_get_contents("php://input");

        // This Line Then decodes the JSON package and stores that result in $requestObject
        $requestObject = json_decode($requestContent);

        //make sure tag content is available (required field)
        if (empty($requestObject->tagId) === true) {
            throw(new \InvalidArgumentException ("No content for TagId.", 405));
        }

        if (empty($requestObject->tagAdminId) === true) {
            throw(new \InvalidArgumentException ("No content for TagAdminId.", 405));
        }

        if (empty($requestObject->tagType) === true) {
            throw(new \InvalidArgumentException ("No content for TagType.", 405));
        }

        if (empty($requestObject->tagValue) === true) {
            throw(new \InvalidArgumentException ("No content for TagValue.", 405));
        }

        //perform the actual put or post
        if ($method === "PUT") {

            //retrieve the tag to update
            $tag = Tag::getTagByTagId($pdo, $id);
            if ($tag === null) {
                throw(new RuntimeException("Tag does not exist", 404));
            }

            //enforce the user is signed in and only trying to edit their own tag
            if (empty($_SESSION["admin"]) === true || $_SESSION["admin"]->getAdminId()->toString !== $tag->getTagAdminId()->toString()) {
                throw(new \InvalidArgumentException("You are not allowed to edit this tag", 403));
            }

            // update all attributes
            $tag->setTagId($requestObject->tagId);
            $tag->setTagAdminId($requestObject->tagAdminId);
            $tag->setTagType($requestObject->tagType);
            $tag->setTagValue($requestObject->tagValue);

            // update reply
            $reply->message = "Tag updated OK";

        } else if($method === "POST") {

            // enforce the user is signed in
            if(empty($_SESSION["admin"]) === true) {
                throw(new \InvalidArgumentException("you must be logged in to post tag", 403));
            }

            // create new tag and insert into database
            $tag = new Tag(generateUuidV4(), $_SESSION["admin"]->getAdminId, $requestObject->tagType, $requestObject->tagValue);
            $tag->insert($pdo);

            // update reply
            $reply->message = "Tag Created OK";

        } else if ($method === "DELETE") {

            //enforce that the end user has a XSRF token.
            verifyXsrf();

            // retrieve the Tag to be deleted
            $tag = Tag::getTagByTagId($pdo, $id);
            if ($tag === null) {
                throw(new RuntimeException("Tag does not exist", 404));
            }

            //enforce the user is signed in and only trying to edit their own tag
            if (empty($_SESSION["admin"]) === true || $_SESSION["admin"]->getAdminId()->toString !== $tag->getTagAdminId()->toString()) {
                throw(new \InvalidArgumentException("You are not allowed to delete this tag", 403));
            }

            // delete tag
            $tag->delete($pdo);
            // update reply
            $reply->message = "Tag deleted OK";
        }
    }

// update the $reply->status $reply->message
    } catch(\Exception | \TypeError $exception) {
        $reply->status = $exception->getCode();
        $reply->message = $exception->getMessage();
    }

// encode and return reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);

// finally - JSON encodes the $reply object and sends it back to the front end.
