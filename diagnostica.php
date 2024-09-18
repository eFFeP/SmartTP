<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Diagnostica Joomla<br>";

// Verifica il percorso corrente
echo "Percorso corrente: " . __DIR__ . "<br>";

// Verifica le variabili d'ambiente
echo "DB_HOST: " . (getenv('DB_HOST') ?: 'non impostato') . "<br>";
echo "DB_USER: " . (getenv('DB_USER') ?: 'non impostato') . "<br>";
echo "DB_PASSWORD: " . (getenv('DB_PASSWORD') ? 'impostato' : 'non impostato') . "<br>";
echo "DB_NAME: " . (getenv('DB_NAME') ?: 'non impostato') . "<br>";
echo "DB_PORT: " . (getenv('DB_PORT') ?: 'non impostato') . "<br>";

// Verifica se il file di configurazione esiste
if (file_exists('configuration.php')) {
    echo "File di configurazione trovato.<br>";
    
    // Carica la configurazione
    require_once 'configuration.php';
    
    // Verifica se la classe JConfig è definita
    if (class_exists('JConfig')) {
        echo "Classe JConfig trovata.<br>";
        
        // Crea un'istanza di JConfig
        $config = new JConfig();
        
        // Verifica alcune impostazioni
        echo "Debug: " . ($config->debug ? 'Attivo' : 'Inattivo') . "<br>";
        echo "Database type: " . $config->dbtype . "<br>";
        echo "Database host: " . $config->host . "<br>";
        echo "Database name: " . $config->db . "<br>";
        echo "Database user: " . $config->user . "<br>";
    } else {
        echo "Errore: Classe JConfig non trovata.<br>";
    }
} else {
    echo "Errore: File di configurazione non trovato.<br>";
}

// Verifica la connessione al database
if (isset($config)) {
    echo "Tentativo di connessione al database:<br>";
    echo "Host: " . $config->host . "<br>";
    echo "Database: " . $config->db . "<br>";
    echo "Utente: " . $config->user . "<br>";
    echo "DSN: {$config->dbtype}:host={$config->host};dbname={$config->db};port=" . getenv('DB_PORT') . "<br>";
    try {
        $dsn = "{$config->dbtype}:host={$config->host};dbname={$config->db};port=" . getenv('DB_PORT');
        $pdo = new PDO($dsn, $config->user, $config->password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connessione al database riuscita.<br>";
    } catch (PDOException $e) {
        echo "Errore di connessione al database: " . $e->getMessage() . "<br>";
    }
}

// Verifica se i file essenziali di Joomla esistono
$essential_files = ['includes/app.php', 'libraries/loader.php', 'libraries/src/Factory.php'];
foreach ($essential_files as $file) {
    if (file_exists($file)) {
        echo "File $file trovato.<br>";
    } else {
        echo "Errore: File $file non trovato.<br>";
    }
}

// Mostra le variabili d'ambiente
echo "<pre>";
print_r($_ENV);
echo "</pre>";

phpinfo();
?>
