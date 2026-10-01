<?php
/**
 * Router script for PHP's built-in dev server.
 * The public site is served as plain static files from the project root
 * ("/" resolves to the site's index.html via the server's own directory-index
 * handling). Only requests under /admin are routed through the PHP admin app.
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$isAdminRoute = $uri === '/admin' || strpos($uri, '/admin/') === 0;

if (!$isAdminRoute) {
    $staticFile = __DIR__ . '/..' . '/..' . $uri;
    if ($uri === '/' || is_file($staticFile)) {
        return false;
    }

    // Uploaded blog images live in backend/public/uploads, outside the site root.
    if (strpos($uri, '/uploads/') === 0 && strpos($uri, '..') === false) {
        $uploadFile = __DIR__ . $uri;
        if (is_file($uploadFile)) {
            $mimeTypes = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'];
            $ext = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
            if (isset($mimeTypes[$ext])) {
                header('Content-Type: ' . $mimeTypes[$ext]);
                header('Content-Length: ' . filesize($uploadFile));
                header('Access-Control-Allow-Origin: *');
                readfile($uploadFile);
                return true;
            }
        }
    }
}

require __DIR__ . '/index.php';
