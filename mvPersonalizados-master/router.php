<?php
// Simple router for PHP built-in server
// If the requested file exists, let the server serve it directly.
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$file = __DIR__ . $uri;
if ($uri !== '/' && file_exists($file)) {
    return false;
}

// Otherwise, route the request to the front controller
require_once __DIR__ . '/index.php';

?>
