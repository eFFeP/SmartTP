<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Diagnostica Joomla<br>";

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
    } else {
        echo "Errore: Classe JConfig non trovata.<br>";
    }
} else {
    echo "Errore: File di configurazione non trovato.<br>";
}

// Verifica la connessione al database
try {
    $dsn = "{$config->dbtype}:host={$config->host};dbname={$config->db}";
    $pdo = new PDO($dsn, $config->user, $config->password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connessione al database riuscita.<br>";
} catch (PDOException $e) {
    echo "Errore di connessione al database: " . $e->getMessage() . "<br>";
}

// Mostra le variabili d'ambiente
echo "<pre>";
print_r($_ENV);
echo "</pre>";

phpinfo();
?>
