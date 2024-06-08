<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();

define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PASS","edgar");

define("SHA2_LONG",32);
define("ENCRYPT","AES-128-CBC");
?>