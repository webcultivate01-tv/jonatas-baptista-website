<?php
$activeNav = 'blog-management';
$pageTitle = 'Blog Management';
$pageSubtitle = 'Create and manage the articles shown on the public blog page.';

$errorMessages = [
    'not_found' => 'That post could not be found.',
];
$successMessages = [
    'created' => 'Post created successfully.',
    'updated' => 'Post updated successfully.',
    'deleted' => 'Post deleted successfully.',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow" />
  <title>Blog Management — Jonatas Baptista</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <?php require __DIR__ . '/../partials/admin-styles.php'; ?>
  <style>
    .card {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 1rem;
      padding: 1.75rem;
    }
    .card h2 {
      font-family: 'Playfair Display', serif;
      font-size: 1.15rem;
      font-weight: 700;
      color: var(--text-strong);
    }
    .card-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1.25rem;
      flex-wrap: wrap;
      gap: 0.75rem;
    }
    .banner {
      font-size: 0.88rem;
      padding: 0.75rem 1rem;
      border-radius: 0.6rem;
      margin-bottom: 1.5rem;
    }
    .banner-error {
      background: var(--danger-bg);
      border: 1px solid #f6c4c0;
      color: var(--danger);
    }
    .banner-success {
      background: #eafaf1;
      border: 1px solid #b7e9cd;
      color: #1e8449;
    }
    .btn {
      font-family: 'Outfit', sans-serif;
      font-size: 0.88rem;
      font-weight: 600;
      border: none;
      border-radius: 0.55rem;
      padding: 0.7rem 1.35rem;
      cursor: pointer;
      transition: background 0.15s, opacity 0.15s;
      white-space: nowrap;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }
    .btn-primary { background: var(--indigo); color: #fff; }
    .btn-primary:hover { background: #4338ca; }
    .btn-ghost {
      background: #fff;
      color: var(--text-mid);
      border: 1.5px solid var(--border);
      padding: 0.5rem 0.9rem;
      font-size: 0.82rem;
    }
    .btn-ghost:hover { border-color: var(--indigo); color: var(--indigo); }
    .btn-danger {
      background: #fff;
      color: var(--danger);
      border: 1.5px solid #f6c4c0;
      padding: 0.5rem 0.9rem;
      font-size: 0.82rem;
    }
    .btn-danger:hover { background: var(--danger-bg); }
    table { width: 100%; border-collapse: collapse; }
    thead th {
      text-align: left;
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: var(--text-soft);
      padding: 0 0.5rem 0.75rem;
      border-bottom: 1px solid var(--border);
    }
    tbody td {
      padding: 0.9rem 0.5rem;
      border-bottom: 1px solid var(--border);
      font-size: 0.9rem;
      color: var(--text-strong);
      vertical-align: middle;
    }
    tbody tr:last-child td { border-bottom: none; }
    .post-thumb {
      width: 56px;
      height: 40px;
      border-radius: 0.4rem;
      object-fit: cover;
      background: var(--page-bg);
    }
    .title-cell { display: flex; align-items: center; gap: 0.75rem; }
    .title-cell span { font-weight: 600; max-width: 320px; }
    .slug-pill {
      display: inline-block;
      background: var(--indigo-bg);
      color: var(--indigo);
      font-size: 0.78rem;
      font-weight: 600;
      padding: 0.2rem 0.6rem;
      border-radius: 999px;
    }
    .status-pill {
      display: inline-block;
      font-size: 0.75rem;
      font-weight: 600;
      padding: 0.2rem 0.6rem;
      border-radius: 999px;
      text-transform: capitalize;
    }
    .status-published { background: #eafaf1; color: #1e8449; }
    .status-draft { background: #fff6e5; color: #b98900; }
    .row-actions { display: flex; gap: 0.5rem; }
    .empty-state {
      text-align: center;
      color: var(--text-soft);
      font-size: 0.9rem;
      padding: 2rem 0;
    }
  </style>
</head>
<body>
  <div class="admin-layout">
    <?php require __DIR__ . '/../partials/sidebar.php'; ?>
    <div class="admin-main">
      <?php require __DIR__ . '/../partials/topbar.php'; ?>
      <main class="admin-content">

        <?php if ($error && isset($errorMessages[$error])): ?>
          <div class="banner banner-error"><?= htmlspecialchars($errorMessages[$error]) ?></div>
        <?php endif; ?>
        <?php if ($success && isset($successMessages[$success])): ?>
          <div class="banner banner-success"><?= htmlspecialchars($successMessages[$success]) ?></div>
        <?php endif; ?>

        <div class="card">
          <div class="card-head">
            <h2>All Posts</h2>
            <a href="/admin/posts/create" class="btn btn-primary">+ Add New Post</a>
          </div>
          <?php if (empty($posts)): ?>
            <p class="empty-state">No posts yet. Create your first one above.</p>
          <?php else: ?>
            <table>
              <thead>
                <tr>
                  <th>Post</th>
                  <th>Category</th>
                  <th>Status</th>
                  <th>Published</th>
                  <th style="width: 160px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($posts as $post): ?>
                  <tr>
                    <td>
                      <div class="title-cell">
                        <img class="post-thumb" src="<?= htmlspecialchars($post['image_path']) ?>" alt="" />
                        <div>
                          <span><?= htmlspecialchars($post['title']) ?></span><br />
                          <span class="slug-pill"><?= htmlspecialchars($post['slug']) ?></span>
                        </div>
                      </div>
                    </td>
                    <td><?= htmlspecialchars($post['category_name']) ?></td>
                    <td><span class="status-pill status-<?= htmlspecialchars($post['status']) ?>"><?= htmlspecialchars($post['status']) ?></span></td>
                    <td><?= htmlspecialchars(date('M j, Y', strtotime($post['published_at']))) ?></td>
                    <td>
                      <div class="row-actions">
                        <a class="btn btn-ghost" href="/admin/posts/edit?id=<?= (int) $post['id'] ?>">Edit</a>
                        <form method="POST" action="/admin/posts/delete" class="js-delete-form">
                          <input type="hidden" name="id" value="<?= (int) $post['id'] ?>" />
                          <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>

      </main>
    </div>
  </div>
  <script>
    document.querySelectorAll('.js-delete-form').forEach(function (form) {
      form.addEventListener('submit', function (e) {
        if (!confirm('Delete this post? This cannot be undone.')) {
          e.preventDefault();
        }
      });
    });
  </script>
</body>
</html>
