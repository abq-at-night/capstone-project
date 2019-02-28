<?php

namespace AbqAtNight\CapstoneProject;
// load the profile class
require_once("/etc/apache2/capstone-mysql/Secrets.php");
use AbqAtNight\CapstoneProject\Admin;

require_once(dirname(__DIR__, 1) . "/Classes/Admin.php");

//use the constructor to create a new author
$secrets =  new \Secrets("/etc/apache2/capstone-mysql/cohort23/atnight.ini");
$pdo = $secrets->getPdoObject();
$password = "abc123";
$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
$admin = new Admin("0e3bf5bf-722a-41eb-b742-42450522ff0e", "jcallaway3@cnm.edu", $hash, "Hunter");
$admin->insert($pdo);
var_dump($admin);
$newAdmin = Admin::getAdminByAdminId($pdo, $admin->getAdminId());
var_dump($newAdmin);