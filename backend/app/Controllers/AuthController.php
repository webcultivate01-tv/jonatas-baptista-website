<?php

namespace App\Controllers;

use App\Core\AuthMiddleware;
use App\Core\Jwt;
use App\Core\Response;
use App\Models\AdminModel;

class AuthController
{
    public function showLogin(): void
    {
        if (AuthMiddleware::check()) {
            Response::redirect('/admin/dashboard');
        }

        Response::view('auth/login', [
            'error' => $_GET['error'] ?? null,
            'reset' => $_GET['reset'] ?? null,
        ]);
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = (string) ($_POST['password'] ?? '');

        $admin = $email !== '' ? AdminModel::findByEmail($email) : null;

        if (!$admin || !password_verify($password, $admin['password'])) {
            Response::redirect('/admin?error=1');
        }

        AuthMiddleware::startSession($admin);

        Response::redirect('/admin/dashboard');
    }

    public function logout(): void
    {
        setcookie(AuthMiddleware::cookieName(), '', [
            'expires' => time() - 3600,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        Response::redirect('/admin');
    }

    public function forgotPassword(): void
    {
        Response::view('auth/forgot-password', [
            'error' => $_GET['error'] ?? null,
        ]);
    }

    public function sendReset(): void
    {
        $email = trim($_POST['email'] ?? '');
        $admin = $email !== '' ? AdminModel::findByEmail($email) : null;

        if (!$admin) {
            Response::redirect('/admin/forgot-password?error=1');
        }

        $token = Jwt::encode([
            'sub' => $admin['id'],
            'purpose' => 'password_reset',
        ], 600);

        Response::redirect('/admin/reset-password?token=' . urlencode($token));
    }

    public function showReset(): void
    {
        $token = $_GET['token'] ?? '';
        $payload = Jwt::decode($token);

        if (!$payload || ($payload['purpose'] ?? null) !== 'password_reset') {
            Response::view('auth/reset-password', [
                'invalid' => true,
                'error' => null,
                'token' => null,
            ]);
            return;
        }

        Response::view('auth/reset-password', [
            'invalid' => false,
            'error' => $_GET['error'] ?? null,
            'token' => $token,
        ]);
    }

    public function resetPassword(): void
    {
        $token = $_POST['token'] ?? '';
        $payload = Jwt::decode($token);

        if (!$payload || ($payload['purpose'] ?? null) !== 'password_reset') {
            Response::view('auth/reset-password', [
                'invalid' => true,
                'error' => null,
                'token' => null,
            ]);
            return;
        }

        $password = (string) ($_POST['password'] ?? '');
        $confirmPassword = (string) ($_POST['confirm_password'] ?? '');

        if ($password === '' || strlen($password) < 8 || $password !== $confirmPassword) {
            Response::redirect('/admin/reset-password?token=' . urlencode($token) . '&error=1');
        }

        $admin = AdminModel::findById((int) $payload['sub']);
        if (!$admin) {
            Response::view('auth/reset-password', [
                'invalid' => true,
                'error' => null,
                'token' => null,
            ]);
            return;
        }

        AdminModel::updatePassword($admin['id'], password_hash($password, PASSWORD_BCRYPT));

        Response::redirect('/admin?reset=1');
    }
}
