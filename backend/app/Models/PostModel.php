<?php

namespace App\Models;

use App\Core\Database;

class PostModel
{
    private const SELECT_WITH_CATEGORY = <<<'SQL'
        SELECT posts.id, posts.title, posts.slug, posts.excerpt, posts.body,
               posts.image_path, posts.tags, posts.read_minutes, posts.status,
               posts.published_at, posts.created_at,
               categories.id AS category_id, categories.name AS category_name,
               categories.slug AS category_slug
        FROM posts
        INNER JOIN categories ON categories.id = posts.category_id
        SQL;

    public static function allWithCategory(): array
    {
        $stmt = Database::connection()->query(
            self::SELECT_WITH_CATEGORY . ' ORDER BY posts.created_at DESC'
        );

        return $stmt->fetchAll();
    }

    public static function allPublished(): array
    {
        $stmt = Database::connection()->query(
            self::SELECT_WITH_CATEGORY . " WHERE posts.status = 'published' ORDER BY posts.published_at DESC"
        );

        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare(
            self::SELECT_WITH_CATEGORY . ' WHERE posts.id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        $post = $stmt->fetch();

        return $post ?: null;
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = Database::connection()->prepare(
            self::SELECT_WITH_CATEGORY . ' WHERE posts.slug = ? LIMIT 1'
        );
        $stmt->execute([$slug]);
        $post = $stmt->fetch();

        return $post ?: null;
    }

    public static function slugExists(string $slug, ?int $excludeId = null): bool
    {
        if ($excludeId !== null) {
            $stmt = Database::connection()->prepare(
                'SELECT id FROM posts WHERE slug = ? AND id != ? LIMIT 1'
            );
            $stmt->execute([$slug, $excludeId]);
        } else {
            $stmt = Database::connection()->prepare(
                'SELECT id FROM posts WHERE slug = ? LIMIT 1'
            );
            $stmt->execute([$slug]);
        }

        return (bool) $stmt->fetch();
    }

    public static function create(array $data): void
    {
        $stmt = Database::connection()->prepare(
            'INSERT INTO posts (category_id, title, slug, excerpt, body, image_path, tags, read_minutes, status, published_at)
             VALUES (:category_id, :title, :slug, :excerpt, :body, :image_path, :tags, :read_minutes, :status, :published_at)'
        );
        $stmt->execute($data);
    }

    public static function update(int $id, array $data): void
    {
        $data['id'] = $id;
        $stmt = Database::connection()->prepare(
            'UPDATE posts SET category_id = :category_id, title = :title, slug = :slug, excerpt = :excerpt,
                body = :body, image_path = :image_path, tags = :tags, read_minutes = :read_minutes,
                status = :status, published_at = :published_at
             WHERE id = :id'
        );
        $stmt->execute($data);
    }

    public static function delete(int $id): void
    {
        $stmt = Database::connection()->prepare('DELETE FROM posts WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function slugify(string $name): string
    {
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug) ?? '';
        return trim($slug, '-');
    }
}
