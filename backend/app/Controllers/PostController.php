<?php

namespace App\Controllers;

use App\Core\AuthMiddleware;
use App\Core\Response;
use App\Models\CategoryModel;
use App\Models\PostModel;

class PostController
{
    private const UPLOAD_DIR = __DIR__ . '/../../public/uploads';
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];
    private const MAX_FILE_SIZE = 5 * 1024 * 1024;

    public function index(): void
    {
        $user = AuthMiddleware::requireAuth();

        Response::view('post/index', [
            'user' => $user,
            'posts' => PostModel::allWithCategory(),
            'error' => $_GET['error'] ?? null,
            'success' => $_GET['success'] ?? null,
        ]);
    }

    public function create(): void
    {
        $user = AuthMiddleware::requireAuth();

        Response::view('post/form', [
            'user' => $user,
            'categories' => CategoryModel::all(),
            'post' => null,
            'error' => $_GET['error'] ?? null,
        ]);
    }

    public function store(): void
    {
        AuthMiddleware::requireAuth();

        $input = $this->readInput();
        if ($input['error'] !== null) {
            Response::redirect('/admin/posts/create?error=' . $input['error']);
        }

        $data = $input['data'];
        $categorySlug = CategoryModel::find($data['category_id'])['slug'];

        $imagePath = $this->handleUpload($categorySlug, $data['slug']);
        if ($imagePath === false) {
            Response::redirect('/admin/posts/create?error=image_invalid');
        }
        if ($imagePath === null) {
            Response::redirect('/admin/posts/create?error=image_required');
        }

        $data['image_path'] = $imagePath;

        PostModel::create($data);
        Response::redirect('/admin/posts?success=created');
    }

    public function edit(): void
    {
        $user = AuthMiddleware::requireAuth();

        $id = (int) ($_GET['id'] ?? 0);
        $post = $id > 0 ? PostModel::find($id) : null;
        if ($post === null) {
            Response::redirect('/admin/posts?error=not_found');
        }

        Response::view('post/form', [
            'user' => $user,
            'categories' => CategoryModel::all(),
            'post' => $post,
            'error' => $_GET['error'] ?? null,
        ]);
    }

    public function update(): void
    {
        AuthMiddleware::requireAuth();

        $id = (int) ($_POST['id'] ?? 0);
        $existing = $id > 0 ? PostModel::find($id) : null;
        if ($existing === null) {
            Response::redirect('/admin/posts?error=not_found');
        }

        $input = $this->readInput($id);
        if ($input['error'] !== null) {
            Response::redirect('/admin/posts/edit?id=' . $id . '&error=' . $input['error']);
        }

        $data = $input['data'];
        $categorySlug = CategoryModel::find($data['category_id'])['slug'];

        $imagePath = $this->handleUpload($categorySlug, $data['slug']);
        if ($imagePath === false) {
            Response::redirect('/admin/posts/edit?id=' . $id . '&error=image_invalid');
        }

        $data['image_path'] = $imagePath ?? $existing['image_path'];

        PostModel::update($id, $data);
        Response::redirect('/admin/posts?success=updated');
    }

    public function delete(): void
    {
        AuthMiddleware::requireAuth();

        $id = (int) ($_POST['id'] ?? 0);
        $post = $id > 0 ? PostModel::find($id) : null;
        if ($post === null) {
            Response::redirect('/admin/posts?error=not_found');
        }

        if (str_starts_with($post['image_path'], '/uploads/')) {
            $filePath = __DIR__ . '/../../public' . $post['image_path'];
            if (is_file($filePath)) {
                unlink($filePath);
                $postDir = dirname($filePath);
                if (is_dir($postDir) && count(scandir($postDir)) === 2) {
                    rmdir($postDir);
                }
            }
        }

        PostModel::delete($id);
        Response::redirect('/admin/posts?success=deleted');
    }

    /** Validates and normalizes the shared create/update form fields (everything except the image). */
    private function readInput(?int $excludeId = null): array
    {
        $title = trim($_POST['title'] ?? '');
        $categoryId = (int) ($_POST['category_id'] ?? 0);
        $body = trim($_POST['body'] ?? '');
        $tags = trim($_POST['tags'] ?? '');
        $readMinutes = (int) ($_POST['read_minutes'] ?? 0);
        $status = ($_POST['status'] ?? 'published') === 'draft' ? 'draft' : 'published';
        $publishedAt = trim($_POST['published_at'] ?? '');

        if ($title === '' || $body === '') {
            return ['error' => 'fields_required', 'data' => null];
        }

        $excerpt = self::makeExcerpt($body);
        if ($categoryId <= 0 || CategoryModel::find($categoryId) === null) {
            return ['error' => 'category_required', 'data' => null];
        }
        if ($readMinutes <= 0) {
            $readMinutes = 5;
        }
        if ($publishedAt === '') {
            $publishedAt = date('Y-m-d');
        }

        $slug = PostModel::slugify($title);
        if ($slug === '' || PostModel::slugExists($slug, $excludeId)) {
            return ['error' => 'duplicate', 'data' => null];
        }

        return [
            'error' => null,
            'data' => [
                'category_id' => $categoryId,
                'title' => $title,
                'slug' => $slug,
                'excerpt' => $excerpt,
                'body' => $body,
                'tags' => $tags !== '' ? $tags : null,
                'read_minutes' => $readMinutes,
                'status' => $status,
                'published_at' => $publishedAt . ' 09:00:00',
            ],
        ];
    }

    /** Derives the public listing excerpt from the post body since the admin form no longer collects one. */
    private static function makeExcerpt(string $body): string
    {
        $text = trim(preg_replace('/\s+/', ' ', strip_tags($body)) ?? '');
        if (mb_strlen($text) <= 160) {
            return $text;
        }

        return rtrim(mb_substr($text, 0, 160)) . '...';
    }

    /**
     * Handles the optional `image` file upload, storing it under uploads/<category-slug>/<post-slug>/.
     * Returns the stored relative path, null when no file was submitted, or false when the file was invalid.
     */
    private function handleUpload(string $categorySlug, string $postSlug)
    {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        if ($_FILES['image']['size'] > self::MAX_FILE_SIZE) {
            return false;
        }

        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            return false;
        }

        $postDir = self::UPLOAD_DIR . '/' . $categorySlug . '/' . $postSlug;
        if (!is_dir($postDir)) {
            mkdir($postDir, 0755, true);
        }

        $filename = bin2hex(random_bytes(8)) . '-' . time() . '.' . $extension;
        $destination = $postDir . '/' . $filename;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
            return false;
        }

        return '/uploads/' . $categorySlug . '/' . $postSlug . '/' . $filename;
    }
}
