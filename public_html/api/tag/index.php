<?php

require_once  dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use AbqAtNight\CapstoneProject\{
    Tag
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
    $reply = new \Secrets("etc/apache2/capstone-mysql/at-night.ini");
    $pdo = $secrets->getPdoObjet();

    //determine which HTTP method was used
    $method = $_SERVER{"HTTP_X_HTTP_METHOD"} ?? $_SERVER["REQUEST_METHOD"];

    //sanitize input
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);

    $tagId = filter_input(INPUT_GET, "tagId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $tagAdminId = filter_input(INPUT_GET, "tagAdminId",FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $tagType = filter_input(INPUT_GET, "tagType", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $tagValue = filter_input(INPUT_GET, "tagValue", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    //make sure the id is valid for methods that require it
    if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
        throw(new InvalidArgumentException("id cannot be empty or negative", 405));

    ]

    if($method === "GET") {
        //set XSRF cookie
        setXsrfCookie();

        //get a specific tag based on arguments provided or all the tags and update reply
        if(empty($id) === false) {
            $reply->data = Tag::getTagByTagId($pdo, $id);
        } else if(empty($tagId) === false) {
            $reply->data = Tag::getTagByTagTaype($pdo, $tagId)->toArray();
        } else if(empty($tagAdminId) === false) {
            $reply->data = Tag::getAllTags($pdo, $tagAdminId)->toArray();
        }
    }
    }
}
