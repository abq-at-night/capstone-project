<?php

namespace AbqAtNight\CapstoneProject;
// load the profile class
require_once("/etc/apache2/capstone-mysql/Secrets.php");
use AbqAtNight\CapstoneProject\Tag;

require_once(dirname(__DIR__, 1) . "/Classes/Tag.php");

//use the constructor to create a new author
$secrets =  new \Secrets("/etc/apache2/capstone-mysql/cohort23/atnight.ini");
$pdo = $secrets->getPdoObject();
$tag = new Tag("454ad45d-6443-4942-bbf3-b22b67e12461", "0e3bf5bf-722a-41eb-b742-42450522ff0e", "Genre", "House Music");
$tag->insert($pdo);
var_dump($tag);
$newTag = Tag::getTagByTagId($pdo, $tag->getTagId());
var_dump($newTag);