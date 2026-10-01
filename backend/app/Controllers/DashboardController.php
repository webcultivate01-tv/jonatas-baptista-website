<?php

namespace App\Controllers;

use App\Core\AuthMiddleware;
use App\Core\Database;
use App\Core\Response;

class DashboardController
{
    public function index(): void
    {
        $user = AuthMiddleware::requireAuth();
        $pdo = Database::connection();

        $totals = $pdo->query(
            "SELECT COUNT(*) AS total,
                    COALESCE(SUM(status = 'published'), 0) AS published,
                    COALESCE(SUM(status = 'draft'), 0) AS drafts
             FROM posts"
        )->fetch();

        $stats = [
            'posts' => (int) $totals['total'],
            'published' => (int) $totals['published'],
            'drafts' => (int) $totals['drafts'],
            'categories' => (int) $pdo->query('SELECT COUNT(*) FROM categories')->fetchColumn(),
        ];

        // Posts per category (includes categories with zero posts).
        $categoryBreakdown = $pdo->query(
            'SELECT categories.name, COUNT(posts.id) AS total
             FROM categories
             LEFT JOIN posts ON posts.category_id = categories.id
             GROUP BY categories.id, categories.name
             ORDER BY total DESC, categories.name ASC'
        )->fetchAll();

        // Posts created per month for the last 6 months.
        $monthlyRows = $pdo->query(
            "SELECT DATE_FORMAT(created_at, '%Y-%m') AS ym, COUNT(*) AS total
             FROM posts
             WHERE created_at >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 5 MONTH)
             GROUP BY ym"
        )->fetchAll(\PDO::FETCH_KEY_PAIR);

        $monthly = [];
        for ($i = 5; $i >= 0; $i--) {
            $ts = strtotime("first day of -$i month");
            $monthly[] = [
                'label' => date('M', $ts),
                'total' => (int) ($monthlyRows[date('Y-m', $ts)] ?? 0),
            ];
        }

        $recentPosts = $pdo->query(
            'SELECT posts.id, posts.title, posts.status, posts.created_at, categories.name AS category_name
             FROM posts
             INNER JOIN categories ON categories.id = posts.category_id
             ORDER BY posts.created_at DESC
             LIMIT 5'
        )->fetchAll();

        Response::view('dashboard/index', [
            'user' => $user,
            'stats' => $stats,
            'categoryBreakdown' => $categoryBreakdown,
            'monthly' => $monthly,
            'recentPosts' => $recentPosts,
        ]);
    }
}
