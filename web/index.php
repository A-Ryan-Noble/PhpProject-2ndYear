<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Database.php';

use Itb\WebApplication;
use Itb\Database;

session_start();

$webApplication = new WebApplication();

$webApplication->run();

$db = new Database();

$connection = $db->getConnection();