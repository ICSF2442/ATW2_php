<?php
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Accept, X-Requested-With, remember-me");
header("Access-Control-Allow-Credentials: true");
require_once('autoloader.php');
AutoLoader::register();
if (session_status() !== PHP_SESSION_ACTIVE) session_start();


