<?php

require_once  dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use AbqAtNight\CapstoneProject\{
	Admin
};

/**
 * API for app sign in, Admin class
 *
 * POST requests are supported.
 *
 * @author Hunter Callaway <jcallaway3@cnm.edu>
 **/
