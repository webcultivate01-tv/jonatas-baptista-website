<?php

namespace App\Models;

use App\Core\Database;

class CategoryModel
{
    public static function all(): array
    {
        $stmt = Database::connection()->query(
            'SELECT id, name, slug, created_at, updated_at FROM categories ORDER BY name ASC'
        );

        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare(
            'SELECT id, name, slug, created_at, updated_at FROM categories WHERE id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        $category = $stmt->fetch();

        return $category ?: null;
    }

    public static function slugExists(string $slug, ?int $excludeId = null): bool
    {
        if ($excludeId !== null) {
            $stmt = Database::connection()->prepare(
                'SELECT id FROM categories WHERE slug = ? AND id != ? LIMIT 1'
            );
            $stmt->execute([$slug, $excludeId]);
        } else {
            $stmt = Database::connection()->prepare(
                'SELECT id FROM categories WHERE slug = ? LIMIT 1'
            );
            $stmt->execute([$slug]);
        }

        return (bool) $stmt->fetch();
    }

    public static function create(string $name, string $slug): void
    {
        $stmt = Database::connection()->prepare(
            'INSERT INTO categories (name, slug) VALUES (?, ?)'
        );
        $stmt->execute([$name, $slug]);
    }

    public static function update(int $id, string $name, string $slug): void
    {
        $stmt = Database::connection()->prepare(
            'UPDATE categories SET name = ?, slug = ? WHERE id = ?'
        );
        $stmt->execute([$name, $slug, $id]);
    }

    public static function delete(int $id): void
    {
        $stmt = Database::connection()->prepare('DELETE FROM categories WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function hasPosts(int $id): bool
    {
        $stmt = Database::connection()->prepare('SELECT 1 FROM posts WHERE category_id = ? LIMIT 1');
        $stmt->execute([$id]);

        return (bool) $stmt->fetch();
    }

    public static function slugify(string $name): string
    {
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug) ?? '';
        return trim($slug, '-');
    }
}
