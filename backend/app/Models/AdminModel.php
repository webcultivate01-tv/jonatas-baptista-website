<?php

namespace App\Models;

use App\Core\Database;

class AdminModel
{
    public static function findByEmail(string $email): ?array
    {
        $stmt = Database::connection()->prepare(
            'SELECT id, name, email, password FROM admins WHERE email = ? LIMIT 1'
        );
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        return $admin ?: null;
    }

    public static function findById(int $id): ?array
    {
        $stmt = Database::connection()->prepare(
            'SELECT id, name, email, password FROM admins WHERE id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        $admin = $stmt->fetch();

        return $admin ?: null;
    }

    public static function emailTaken(string $email, int $exceptId): bool
    {
        $stmt = Database::connection()->prepare(
            'SELECT 1 FROM admins WHERE email = ? AND id <> ? LIMIT 1'
        );
        $stmt->execute([$email, $exceptId]);

        return (bool) $stmt->fetchColumn();
    }

    public static function updateProfile(int $id, string $name, string $email): void
    {
        $stmt = Database::connection()->prepare(
            'UPDATE admins SET name = ?, email = ? WHERE id = ?'
        );
        $stmt->execute([$name, $email, $id]);
    }

    public static function updatePassword(int $id, string $passwordHash): void
    {
        $stmt = Database::connection()->prepare(
            'UPDATE admins SET password = ? WHERE id = ?'
        );
        $stmt->execute([$passwordHash, $id]);
    }
}
