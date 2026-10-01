<?php

use App\Controllers\AccountController;
use App\Controllers\AuthController;
use App\Controllers\CategoryController;
use App\Controllers\DashboardController;
use App\Controllers\HeroController;
use App\Controllers\PostController;
use App\Controllers\PublicApiController;
use App\Core\Env;
use App\Core\Router;

require __DIR__ . '/../app/autoload.php';

Env::load(__DIR__ . '/../.env');

$router = new Router();

$router->get('/admin', [AuthController::class, 'showLogin']);
$router->post('/admin/login', [AuthController::class, 'login']);
$router->post('/admin/logout', [AuthController::class, 'logout']);
$router->get('/admin/forgot-password', [AuthController::class, 'forgotPassword']);
$router->post('/admin/forgot-password', [AuthController::class, 'sendReset']);
$router->get('/admin/reset-password', [AuthController::class, 'showReset']);
$router->post('/admin/reset-password', [AuthController::class, 'resetPassword']);
$router->get('/admin/dashboard', [DashboardController::class, 'index']);
$router->get('/admin/account', [AccountController::class, 'index']);
$router->post('/admin/account/profile', [AccountController::class, 'updateProfile']);
$router->post('/admin/account/password', [AccountController::class, 'updatePassword']);
$router->get('/admin/categories',[CategoryController::class, 'index']);
$router->post('/admin/categories/store', [CategoryController::class, 'store']);
$router->post('/admin/categories/update', [CategoryController::class, 'update']);
$router->post('/admin/categories/delete', [CategoryController::class, 'delete']);
$router->get('/admin/hero-blog', [HeroController::class, 'index']);
$router->post('/admin/hero-blog/update', [HeroController::class, 'update']);
$router->get('/admin/posts', [PostController::class, 'index']);
$router->get('/admin/posts/create', [PostController::class, 'create']);
$router->post('/admin/posts/store', [PostController::class, 'store']);
$router->get('/admin/posts/edit', [PostController::class, 'edit']);
$router->post('/admin/posts/update', [PostController::class, 'update']);
$router->post('/admin/posts/delete', [PostController::class, 'delete']);

$router->get('/api/categories', [PublicApiController::class, 'categories']);
$router->get('/api/hero', [PublicApiController::class, 'hero']);
$router->get('/api/posts',[PublicApiController::class, 'posts']);
$router->get('/api/posts/show', [PublicApiController::class, 'showPost']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
