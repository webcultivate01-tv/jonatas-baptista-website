<?php

namespace App\Controllers;

use App\Core\AuthMiddleware;
use App\Core\Response;
use App\Models\CategoryModel;

class CategoryController
{
    public function index(): void
    {
        $user = AuthMiddleware::requireAuth();

        Response::view('category/index', [
            'user' => $user,
            'categories' => CategoryModel::all(),
            'error' => $_GET['error'] ?? null,
            'success' => $_GET['success'] ?? null,
        ]);
    }

    public function store(): void
    {
        AuthMiddleware::requireAuth();

        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            Response::redirect('/admin/categories?error=name_required');
        }

        $slug = CategoryModel::slugify($name);
        if ($slug === '' || CategoryModel::slugExists($slug)) {
            Response::redirect('/admin/categories?error=duplicate');
        }

        CategoryModel::create($name, $slug);
        Response::redirect('/admin/categories?success=created');
    }

    public function update(): void
    {
        AuthMiddleware::requireAuth();

        $id = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');

        if ($id <= 0 || CategoryModel::find($id) === null) {
            Response::redirect('/admin/categories?error=not_found');
        }
        if ($name === '') {
            Response::redirect('/admin/categories?error=name_required');
        }

        $slug = CategoryModel::slugify($name);
        if ($slug === '' || CategoryModel::slugExists($slug, $id)) {
            Response::redirect('/admin/categories?error=duplicate');
        }

        CategoryModel::update($id, $name, $slug);
        Response::redirect('/admin/categories?success=updated');
    }

    public function delete(): void
    {
        AuthMiddleware::requireAuth();

        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0 || CategoryModel::find($id) === null) {
            Response::redirect('/admin/categories?error=not_found');
        }

        if (CategoryModel::hasPosts($id)) {
            Response::redirect('/admin/categories?error=in_use');
        }

        CategoryModel::delete($id);
        Response::redirect('/admin/categories?success=deleted');
    }
}
