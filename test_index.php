<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Test PHP funzionante<br>";

// Analizza la stringa di connessione PostgreSQL
$db_url = getenv('DB_HOST');
$url_parts = parse_url($db_url);

$host = $url_parts['host'];
$port = $url_parts['port'] ?? 5432;
$user = $url_parts['user'];
$password = $url_parts['pass'];
$dbname = ltrim($url_parts['path'], '/');

echo "Tentativo di connessione al database PostgreSQL...<br>";

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

try {
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connessione al database PostgreSQL riuscita!";
} catch (PDOException $e) {
    die("Connessione fallita: " . $e->getMessage());
}

phpinfo();
?>
