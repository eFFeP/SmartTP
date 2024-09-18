<?php
if (getenv('_JENV_DB_HOST') !== false) {
    define('_JENV_DB_HOST', getenv('_JENV_DB_HOST'));
}
if (getenv('_JENV_DB_USER') !== false) {
    define('_JENV_DB_USER', getenv('_JENV_DB_USER'));
}
if (getenv('_JENV_DB_PASSWORD') !== false) {
    define('_JENV_DB_PASSWORD', getenv('_JENV_DB_PASSWORD'));
}
if (getenv('_JENV_DB_NAME') !== false) {
    define('_JENV_DB_NAME', getenv('_JENV_DB_NAME'));
}

/**
 * @package    Joomla.Site
 *
 * @copyright  (C) 2005 Open Source Matters, Inc. <https://www.joomla.org>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

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

// Run the application - All executable code should be triggered through this file
require_once dirname(__FILE__) . '/includes/app.php';
