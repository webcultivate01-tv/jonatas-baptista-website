<?php

namespace App\Controllers;

use App\Core\Response;
use App\Models\CategoryModel;
use App\Models\HeroModel;
use App\Models\PostModel;

class PublicApiController
{
    public function categories(): void
    {
        header('Access-Control-Allow-Origin: *');

        $categories = array_map(
            fn (array $c) => ['name' => $c['name'], 'slug' => $c['slug']],
            CategoryModel::all()
        );

        Response::json($categories);
    }

    public function hero(): void
    {
        header('Access-Control-Allow-Origin: *');

        $hero = HeroModel::get();
        if ($hero === null) {
            Response::json(['error' => 'not_found'], 404);
        }

        Response::json([
            'title' => $hero['title'],
            'description' => $hero['description'],
            'image' => $hero['image_path'],
        ]);
    }

    public function posts(): void
    {
        header('Access-Control-Allow-Origin: *');

        $posts = array_map([$this, 'toPublicListItem'], PostModel::allPublished());

        Response::json($posts);
    }

    public function showPost(): void
    {
        header('Access-Control-Allow-Origin: *');

        $slug = trim($_GET['slug'] ?? '');
        $post = $slug !== '' ? PostModel::findBySlug($slug) : null;

        if ($post === null || $post['status'] !== 'published') {
            Response::json(['error' => 'not_found'], 404);
        }

        $data = $this->toPublicListItem($post);
        $data['body'] = $post['body'];

        Response::json($data);
    }

    private function toPublicListItem(array $post): array
    {
        return [
            'slug' => $post['slug'],
            'title' => $post['title'],
            'excerpt' => $post['excerpt'],
            'image' => $post['image_path'],
            'category_name' => $post['category_name'],
            'category_slug' => $post['category_slug'],
            'category_id' => (int) $post['category_id'],
            'tags' => $post['tags'] ? array_map('trim', explode(',', $post['tags'])) : [],
            'read_minutes' => (int) $post['read_minutes'],
            'published_at' => date('F j, Y', strtotime($post['published_at'])),
        ];
    }
}
