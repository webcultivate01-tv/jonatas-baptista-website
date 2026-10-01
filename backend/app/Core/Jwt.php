<?php

namespace App\Core;

use RuntimeException;

/**
 * Minimal, dependency-free JWT (HS256) implementation — no composer available
 * in this environment, so encode/decode is done by hand instead of pulling
 * in firebase/php-jwt.
 */
class Jwt
{
    public static function encode(array $payload, ?int $ttlSeconds = null): string
    {
        $secret = Env::get('JWT_SECRET');
        $ttl = $ttlSeconds ?? (int) Env::get('JWT_TTL', '3600');

        $header = ['typ' => 'JWT', 'alg' => 'HS256'];
        $payload['iat'] = time();
        $payload['exp'] = time() + $ttl;

        $segments = [
            self::base64UrlEncode(json_encode($header)),
            self::base64UrlEncode(json_encode($payload)),
        ];

        $signature = hash_hmac('sha256', implode('.', $segments), $secret, true);
        $segments[] = self::base64UrlEncode($signature);

        return implode('.', $segments);
    }

    /** Returns the decoded payload, or null if the token is missing, malformed, expired or has a bad signature. */
    public static function decode(?string $token): ?array
    {
        if (!$token || substr_count($token, '.') !== 2) {
            return null;
        }

        [$headerB64, $payloadB64, $signatureB64] = explode('.', $token);

        $secret = Env::get('JWT_SECRET');
        $expected = self::base64UrlEncode(hash_hmac(
            'sha256',
            "{$headerB64}.{$payloadB64}",
            $secret,
            true
        ));

        if (!hash_equals($expected, $signatureB64)) {
            return null;
        }

        $payload = json_decode(self::base64UrlDecode($payloadB64), true);
        if (!is_array($payload) || !isset($payload['exp']) || time() >= $payload['exp']) {
            return null;
        }

        return $payload;
    }

    private static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode(string $data): string
    {
        $padded = str_pad($data, strlen($data) % 4 === 0 ? strlen($data) : strlen($data) + (4 - strlen($data) % 4), '=');
        $decoded = base64_decode(strtr($padded, '-_', '+/'));
        if ($decoded === false) {
            throw new RuntimeException('Invalid base64url payload');
        }
        return $decoded;
    }
}
