<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve existing files directly
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// Route /students* requests to routes.php
if (preg_match('#^/(students|add-student|search)#', $uri)) {
    require __DIR__ . '/../app/routes.php';
} else {
    // Otherwise serve index.php
    require __DIR__ . '/index.php';
}
