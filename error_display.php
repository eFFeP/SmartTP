<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Diagnostica Joomla</h1>";

// Verifica se il file di configurazione esiste
if (file_exists('configuration.php')) {
    echo "File di configurazione trovato.<br>";
    
    // Carica la configurazione
    require_once 'configuration.php';
    
    // Verifica se la classe JConfig è definita
    if (class_exists('JConfig')) {
        echo "Classe JConfig trovata.<br>";
        
        $config = new JConfig();
        
        // Mostra alcune impostazioni (nascondi le informazioni sensibili)
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

// Tenta di caricare il file index.php di Joomla
try {
    ob_start();
    require_once 'index.php';
    ob_end_clean();
    echo "File index.php di Joomla caricato con successo.<br>";
} catch (Throwable $e) {
    echo "Errore durante il caricamento di index.php: " . $e->getMessage() . "<br>";
    echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
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
