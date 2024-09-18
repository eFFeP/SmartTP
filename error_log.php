<?php
ini_set('log_errors', 1);
ini_set('error_log', '/tmp/php-errors.log');
error_reporting(E_ALL);

// Redirect degli errori in un file di log
ini_set('display_errors', 0);

// Includi il file principale di Joomla
require_once 'index.php';
