<?php

namespace App\Core;

class AuthMiddleware
{
    private const COOKIE_NAME = 'auth_token';

    public static function cookieName(): string
    {
        return self::COOKIE_NAME;
    }

    /** Returns the JWT payload for the current request's cookie, or null if not authenticated. */
    public static function user(): ?array
    {
        $token = $_COOKIE[self::COOKIE_NAME] ?? null;
        return Jwt::decode($token);
    }

    /** Issues a fresh JWT cookie for the given admin row (id, email, name). */
    public static function startSession(array $admin): void
    {
        $token = Jwt::encode([
            'sub' => $admin['id'],
            'email' => $admin['email'],
            'name' => $admin['name'],
        ]);

        setcookie(self::COOKIE_NAME, $token, [
            'expires' => time() + (int) (getenv('JWT_TTL') ?: 3600),
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax',
            'secure' => false,
        ]);
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function requireAuth(): array
    {
        $user = self::user();
        if ($user === null) {
            Response::redirect('/admin');
        }
        return $user;
    }
}
