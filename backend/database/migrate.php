<?php
/**
 * Creates the database and admins table if missing, and seeds/updates the
 * admin account from ADMIN_EMAIL / ADMIN_PASSWORD in backend/.env.
 * Run with: php backend/database/migrate.php
 */

require __DIR__ . '/../app/autoload.php';

use App\Core\Database;
use App\Core\Env;

Env::load(__DIR__ . '/../.env');

$dbName = Env::get('DB_NAME', 'jonatas_baptista_website');

echo "Connecting to MySQL server...\n";
$server = Database::serverConnection();

echo "Creating database `{$dbName}` if it doesn't exist...\n";
$server->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

$pdo = Database::connection();

echo "Creating `admins` table if it doesn't exist...\n";
$pdo->exec(<<<SQL
    CREATE TABLE IF NOT EXISTS admins (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL DEFAULT 'Administrator',
        email VARCHAR(150) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
SQL);

echo "Creating `categories` table if it doesn't exist...\n";
$pdo->exec(<<<SQL
    CREATE TABLE IF NOT EXISTS categories (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        slug VARCHAR(120) NOT NULL UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )
SQL);

$categoryCount = (int) $pdo->query('SELECT COUNT(*) FROM categories')->fetchColumn();
if ($categoryCount === 0) {
    echo "Seeding default categories from the blog page...\n";
    $insertCategory = $pdo->prepare('INSERT INTO categories (name, slug) VALUES (?, ?)');
    $defaultCategories = [
        'Investment Strategy' => 'investment-strategy',
        'Market Insights' => 'market-insights',
        'Property Analysis' => 'property-analysis',
        'Wealth Building' => 'wealth-building',
        'Decision-Making' => 'decision-making',
    ];
    foreach ($defaultCategories as $name => $slug) {
        $insertCategory->execute([$name, $slug]);
    }
}

echo "Creating `posts` table if it doesn't exist...\n";
$pdo->exec(<<<SQL
    CREATE TABLE IF NOT EXISTS posts (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        category_id INT UNSIGNED NOT NULL,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL UNIQUE,
        excerpt TEXT NOT NULL,
        body LONGTEXT NOT NULL,
        image_path VARCHAR(255) NOT NULL,
        tags VARCHAR(255) NULL,
        read_minutes TINYINT UNSIGNED NOT NULL DEFAULT 5,
        status ENUM('draft','published') NOT NULL DEFAULT 'published',
        published_at DATETIME NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES categories(id)
    )
SQL);

$postCount = (int) $pdo->query('SELECT COUNT(*) FROM posts')->fetchColumn();
if ($postCount === 0) {
    echo "Seeding existing blog articles into `posts`...\n";
    $findCategory = $pdo->prepare('SELECT id FROM categories WHERE slug = ? LIMIT 1');
    $insertPost = $pdo->prepare(
        'INSERT INTO posts (category_id, title, slug, excerpt, body, image_path, tags, read_minutes, status, published_at)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, \'published\', ?)'
    );

    $seedPosts = require __DIR__ . '/seed_posts.php';
    foreach ($seedPosts as $post) {
        $findCategory->execute([$post['category_slug']]);
        $categoryId = $findCategory->fetchColumn();
        if (!$categoryId) {
            continue;
        }
        $insertPost->execute([
            $categoryId,
            $post['title'],
            $post['slug'],
            $post['excerpt'],
            $post['body'],
            $post['image'],
            $post['tags'],
            $post['read_minutes'],
            $post['published_at'],
        ]);
    }
}

echo "Creating `hero_blog` table if it doesn't exist...\n";
$pdo->exec(<<<SQL
    CREATE TABLE IF NOT EXISTS hero_blog (
        id INT UNSIGNED PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        image_path VARCHAR(255) NOT NULL,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )
SQL);

$heroCount = (int) $pdo->query('SELECT COUNT(*) FROM hero_blog')->fetchColumn();
if ($heroCount === 0) {
    echo "Seeding hero section with the current blog page content...\n";
    $insertHero = $pdo->prepare('INSERT INTO hero_blog (id, title, description, image_path) VALUES (1, ?, ?, ?)');
    $insertHero->execute([
        'Ideas, Strategies & Real Lessons from the Field.',
        'Practical insights on client acquisition, sales, and business growth to help you attract better clients and build a more sustainable business.',
        '/image/blog-hero.png',
    ]);
}

$name = Env::get('ADMIN_NAME', 'Administrator');
$email = Env::get('ADMIN_EMAIL', 'admin@gmail.com');
$password = Env::get('ADMIN_PASSWORD', 'admin123');
$hash = password_hash($password, PASSWORD_BCRYPT);

$stmt = $pdo->prepare('SELECT id FROM admins WHERE email = ?');
$stmt->execute([$email]);
$existing = $stmt->fetch();

if ($existing) {
    $update = $pdo->prepare('UPDATE admins SET name = ?, password = ? WHERE email = ?');
    $update->execute([$name, $hash, $email]);
    echo "Updated existing admin: {$email}\n";
} else {
    $insert = $pdo->prepare('INSERT INTO admins (name, email, password) VALUES (?, ?, ?)');
    $insert->execute([$name, $email, $hash]);
    echo "Created admin: {$email}\n";
}

echo "Done.\n";
