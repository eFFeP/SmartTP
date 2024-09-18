<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Inizio del log degli errori<br>";

try {
    // Verifica se il file di configurazione esiste
    if (!file_exists('configuration.php')) {
        throw new Exception("Il file configuration.php non esiste");
    }

    // Includi il file di configurazione
    require_once 'configuration.php';

    // Verifica se la classe JConfig esiste
    if (!class_exists('JConfig')) {
        throw new Exception("La classe JConfig non è stata trovata nel file di configurazione");
    }

    $config = new JConfig();

    // Stampa alcune informazioni di configurazione
    echo "Host del database: " . $config->host . "<br>";
    echo "Nome del database: " . $config->db . "<br>";
    echo "Utente del database: " . $config->user . "<br>";

    // Tenta di connettersi al database
    $dsn = "pgsql:host={$config->host};dbname={$config->db};port=5432";
    $pdo = new PDO($dsn, $config->user, $config->password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connessione al database riuscita<br>";

    // Includi il file principale di Joomla
    require_once 'index.php';
} catch (Exception $e) {
    echo "Si è verificato un errore: " . $e->getMessage() . "<br>";
    echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
}

echo "Fine del log degli errori";
?>
