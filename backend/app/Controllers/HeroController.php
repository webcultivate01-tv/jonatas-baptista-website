<?php

namespace App\Controllers;

use App\Core\AuthMiddleware;
use App\Core\Response;
use App\Models\HeroModel;

class HeroController
{
    private const UPLOAD_DIR = __DIR__ . '/../../public/uploads/hero';
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];
    private const MAX_FILE_SIZE = 5 * 1024 * 1024;

    public function index(): void
    {
        $user = AuthMiddleware::requireAuth();

        Response::view('hero/index', [
            'user' => $user,
            'hero' => HeroModel::get(),
            'error' => $_GET['error'] ?? null,
            'success' => $_GET['success'] ?? null,
        ]);
    }

    public function update(): void
    {
        AuthMiddleware::requireAuth();

        $existing = HeroModel::get();
        if ($existing === null) {
            Response::redirect('/admin/hero-blog?error=not_found');
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $imageUrl = trim($_POST['image_url'] ?? '');

        if ($title === '' || $description === '') {
            Response::redirect('/admin/hero-blog?error=fields_required');
        }

        $uploaded = $this->handleUpload();
        if ($uploaded === false) {
            Response::redirect('/admin/hero-blog?error=image_invalid');
        }

        if ($uploaded !== null) {
            $imagePath = $uploaded;
        } elseif ($imageUrl === '') {
            $imagePath = $existing['image_path'];
        } elseif (preg_match('#^(https?://|/)[^\s]+$#i', $imageUrl)) {
            $imagePath = $imageUrl;
        } else {
            Response::redirect('/admin/hero-blog?error=url_invalid');
        }

        HeroModel::update($title, $description, $imagePath);
        Response::redirect('/admin/hero-blog?success=updated');
    }

    /** Returns the stored relative path, null when no file was submitted, or false when the file was invalid. */
    private function handleUpload()
    {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK || $_FILES['image']['size'] > self::MAX_FILE_SIZE) {
            return false;
        }

        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            return false;
        }

        if (!is_dir(self::UPLOAD_DIR)) {
            mkdir(self::UPLOAD_DIR, 0755, true);
        }

        $filename = bin2hex(random_bytes(8)) . '-' . time() . '.' . $extension;
        if (!move_uploaded_file($_FILES['image']['tmp_name'], self::UPLOAD_DIR . '/' . $filename)) {
            return false;
        }

        return '/uploads/hero/' . $filename;
    }
}
