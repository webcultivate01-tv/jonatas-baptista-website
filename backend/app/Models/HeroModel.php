<?php

namespace App\Models;

use App\Core\Database;

class HeroModel
{
    /** The blog page has exactly one hero section, stored as row id 1. */
    public static function get(): ?array
    {
        $stmt = Database::connection()->query(
            'SELECT id, title, description, image_path, updated_at FROM hero_blog WHERE id = 1 LIMIT 1'
        );
        $hero = $stmt->fetch();

        return $hero ?: null;
    }

    public static function update(string $title, string $description, string $imagePath): void
    {
        $stmt = Database::connection()->prepare(
            'UPDATE hero_blog SET title = ?, description = ?, image_path = ? WHERE id = 1'
        );
        $stmt->execute([$title, $description, $imagePath]);
    }
}
