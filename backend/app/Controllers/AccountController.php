<?php

namespace App\Controllers;

use App\Core\AuthMiddleware;
use App\Core\Response;
use App\Models\AdminModel;

class AccountController
{
    public function index(): void
    {
        $user = AuthMiddleware::requireAuth();
        $admin = AdminModel::findById((int) $user['sub']);
        if (!$admin) {
            Response::redirect('/admin');
        }

        Response::view('account/index', [
            'user' => $user,
            'admin' => $admin,
            'error' => $_GET['error'] ?? null,
            'success' => $_GET['success'] ?? null,
        ]);
    }

    public function updateProfile(): void
    {
        $user = AuthMiddleware::requireAuth();
        $id = (int) $user['sub'];

        $name = trim($_POST['name'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));

        if ($name === '' || mb_strlen($name) > 100) {
            Response::redirect('/admin/account?error=name_invalid');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) {
            Response::redirect('/admin/account?error=email_invalid');
        }
        if (AdminModel::emailTaken($email, $id)) {
            Response::redirect('/admin/account?error=email_taken');
        }

        AdminModel::updateProfile($id, $name, $email);
        AuthMiddleware::startSession(['id' => $id, 'name' => $name, 'email' => $email]);

        Response::redirect('/admin/account?success=profile');
    }

    /**
     * The admin is already authenticated via the session cookie, so the current
     * password is intentionally not required — they can set a new one even if
     * they have forgotten the old one.
     */
    public function updatePassword(): void
    {
        $user = AuthMiddleware::requireAuth();

        $password = (string) ($_POST['password'] ?? '');
        $confirm = (string) ($_POST['confirm_password'] ?? '');

        if (strlen($password) < 8) {
            Response::redirect('/admin/account?error=password_short');
        }
        if ($password !== $confirm) {
            Response::redirect('/admin/account?error=password_mismatch');
        }

        AdminModel::updatePassword((int) $user['sub'], password_hash($password, PASSWORD_BCRYPT));

        Response::redirect('/admin/account?success=password');
    }
}
