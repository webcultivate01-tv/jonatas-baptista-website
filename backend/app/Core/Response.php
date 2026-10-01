<?php

namespace App\Core;

class Response
{
    public static function redirect(string $path): void
    {
        header("Location: {$path}");
        exit;
    }

    public static function view(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = __DIR__ . "/../Views/{$view}.php";
        require $viewFile;
    }

    public static function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
