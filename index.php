<?php
// Abilita il reporting degli errori
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define the application's minimum supported PHP version as a constant so it can be referenced within the application.
define('JOOMLA_MINIMUM_PHP', '8.1.0');

if (version_compare(PHP_VERSION, JOOMLA_MINIMUM_PHP, '<')) {
    die(
        str_replace(
            '{{phpversion}}',
            JOOMLA_MINIMUM_PHP,
            file_get_contents(dirname(__FILE__) . '/includes/incompatible.html')
        )
    );
}

/**
 * Constant that is checked in included files to prevent direct access.
 * define() is used rather than "const" to not error for PHP 5.2 and lower
 */
define('_JEXEC', 1);

if (file_exists(__DIR__ . '/defines.php')) {
    include_once __DIR__ . '/defines.php';
}

if (!defined('_JDEFINES')) {
    define('JPATH_BASE', __DIR__);
    require_once JPATH_BASE . '/includes/defines.php';
}

require_once JPATH_BASE . '/includes/framework.php';

// Ensure the container is created
$container = \Joomla\CMS\Factory::getContainer();

// Manually register the session service provider
$container->registerServiceProvider(new \Joomla\CMS\Service\Provider\Session);

// Get the application
try {
    $app = $container->get(\Joomla\CMS\Application\SiteApplication::class);

    // Set the application as global app
    \Joomla\CMS\Factory::$application = $app;

    // Execute the application
    $app->execute();
} catch (\Throwable $e) {
    // Catch any errors and display them
    echo '<h1>An error occurred</h1>';
    echo '<p>Error message: ' . $e->getMessage() . '</p>';
    echo '<p>File: ' . $e->getFile() . '</p>';
    echo '<p>Line: ' . $e->getLine() . '</p>';
    echo '<h2>Stack trace:</h2>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
