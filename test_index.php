<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Test PHP funzionante<br>";

// Test connessione al database PostgreSQL
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$db = getenv('DB_NAME');
$port = getenv('DB_PORT') ?: 5432;

echo "Tentativo di connessione al database PostgreSQL...<br>";

$dsn = "pgsql:host=$host;port=$port;dbname=$db;user=$user;password=$password";

try {
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connessione al database PostgreSQL riuscita!";
} catch (PDOException $e) {
    die("Connessione fallita: " . $e->getMessage());
}

phpinfo();
?>
