<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Test di connessione al database<br>";

$db_url = getenv('DB_HOST');
$db_user = getenv('DB_USER');
$db_password = getenv('DB_PASSWORD');
$db_name = getenv('DB_NAME');

echo "DB_HOST: " . $db_url . "<br>";
echo "DB_USER: " . $db_user . "<br>";
echo "DB_NAME: " . $db_name . "<br>";

$url_parts = parse_url($db_url);
$host = $url_parts['host'];
$port = $url_parts['port'] ?? 5432;

$dsn = "pgsql:host=$host;port=$port;dbname=$db_name;user=$db_user;password=$db_password";

try {
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connessione al database riuscita!";
} catch (PDOException $e) {
    echo "Errore di connessione: " . $e->getMessage();
}

// Mostra tutte le variabili d'ambiente (nascondendo i valori sensibili)
echo "<h2>Variabili d'ambiente:</h2>";
echo "<pre>";
foreach ($_ENV as $key => $value) {
    if (strpos(strtolower($key), 'password') !== false) {
        echo "$key: [NASCOSTO]\n";
    } else {
        echo "$key: $value\n";
    }
}
echo "</pre>";

// Mostra informazioni su PHP
phpinfo();
?>
