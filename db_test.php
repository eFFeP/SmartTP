<?php
$host = defined('_JENV_DB_HOST') ? constant('_JENV_DB_HOST') : 'localhost';
$user = defined('_JENV_DB_USER') ? constant('_JENV_DB_USER') : 'postgres';
$password = defined('_JENV_DB_PASSWORD') ? constant('_JENV_DB_PASSWORD') : 'tuapasswordlocale';
$dbname = defined('_JENV_DB_NAME') ? constant('_JENV_DB_NAME') : 'joomla_db';

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
if (!$conn) {
    echo "Errore di connessione al database.<br>";
    echo "Dettagli errore: " . pg_last_error();
} else {
    echo "Connessione al database riuscita.";
}
