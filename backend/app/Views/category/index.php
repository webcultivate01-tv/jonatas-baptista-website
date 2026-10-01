<?php
$activeNav = 'category-management';
$pageTitle = 'Category Management';
$pageSubtitle = 'Add and manage the categories used on the blog page.';

$errorMessages = [
    'name_required' => 'Category name is required.',
    'duplicate' => 'A category with that name already exists.',
    'not_found' => 'That category could not be found.',
    'in_use' => 'That category has posts assigned to it. Move or delete those posts first.',
];
$successMessages = [
    'created' => 'Category added successfully.',
    'updated' => 'Category updated successfully.',
    'deleted' => 'Category deleted successfully.',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow" />
  <title>Category Management — Jonatas Baptista</title>
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
    .card + .card { margin-top: 1.5rem; }
    .card h2 {
      font-family: 'Playfair Display', serif;
      font-size: 1.15rem;
      font-weight: 700;
      color: var(--text-strong);
      margin-bottom: 1.25rem;
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
    .add-form {
      display: flex;
      align-items: flex-end;
      gap: 0.9rem;
      flex-wrap: wrap;
    }
    .add-form .field { flex: 1; min-width: 220px; margin: 0; }
    .field label {
      display: block;
      font-size: 0.78rem;
      font-weight: 600;
      letter-spacing: 0.04em;
      text-transform: uppercase;
      color: var(--text-soft);
      margin-bottom: 0.45rem;
    }
    .field input[type="text"] {
      width: 100%;
      font-family: 'Outfit', sans-serif;
      font-size: 0.95rem;
      color: var(--text-strong);
      background: #fff;
      border: 1.5px solid var(--border);
      border-radius: 0.55rem;
      padding: 0.65rem 0.9rem;
      transition: border-color 0.15s;
    }
    .field input[type="text"]:focus { outline: none; border-color: var(--indigo); }
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
    .slug-pill {
      display: inline-block;
      background: var(--indigo-bg);
      color: var(--indigo);
      font-size: 0.78rem;
      font-weight: 600;
      padding: 0.2rem 0.6rem;
      border-radius: 999px;
    }
    .row-actions { display: flex; gap: 0.5rem; }
    .empty-state {
      text-align: center;
      color: var(--text-soft);
      font-size: 0.9rem;
      padding: 2rem 0;
    }
    .edit-form { display: none; align-items: center; gap: 0.6rem; }
    .edit-form.is-open { display: flex; }
    tr.is-editing .view-row-content { display: none; }
    .edit-form input[type="text"] {
      font-family: 'Outfit', sans-serif;
      font-size: 0.9rem;
      border: 1.5px solid var(--border);
      border-radius: 0.5rem;
      padding: 0.5rem 0.75rem;
      flex: 1;
      min-width: 160px;
    }
    .edit-form input[type="text"]:focus { outline: none; border-color: var(--indigo); }
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
          <h2>Add New Category</h2>
          <form class="add-form" method="POST" action="/admin/categories/store">
            <div class="field">
              <label for="name">Category Name</label>
              <input type="text" id="name" name="name" placeholder="e.g. Retirement Planning" required />
            </div>
            <button type="submit" class="btn btn-primary">Add Category</button>
          </form>
        </div>

        <div class="card">
          <h2>Current Categories</h2>
          <?php if (empty($categories)): ?>
            <p class="empty-state">No categories yet. Add your first one above.</p>
          <?php else: ?>
            <table>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Slug</th>
                  <th style="width: 220px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($categories as $category): ?>
                  <tr id="row-<?= (int) $category['id'] ?>">
                    <td colspan="3">
                      <div class="view-row-content" style="display:flex; align-items:center; justify-content:space-between; gap:1rem;">
                        <div style="display:flex; align-items:center; gap:1rem; flex:1;">
                          <span style="min-width:200px;"><?= htmlspecialchars($category['name']) ?></span>
                          <span class="slug-pill"><?= htmlspecialchars($category['slug']) ?></span>
                        </div>
                        <div class="row-actions">
                          <button type="button" class="btn btn-ghost js-edit-toggle" data-id="<?= (int) $category['id'] ?>">Edit</button>
                          <form method="POST" action="/admin/categories/delete" class="js-delete-form">
                            <input type="hidden" name="id" value="<?= (int) $category['id'] ?>" />
                            <button type="submit" class="btn btn-danger">Delete</button>
                          </form>
                        </div>
                      </div>
                      <form class="edit-form" id="edit-form-<?= (int) $category['id'] ?>" method="POST" action="/admin/categories/update">
                        <input type="hidden" name="id" value="<?= (int) $category['id'] ?>" />
                        <input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" required />
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-ghost js-edit-cancel" data-id="<?= (int) $category['id'] ?>">Cancel</button>
                      </form>
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
    document.querySelectorAll('.js-edit-toggle').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var id = btn.dataset.id;
        var row = document.getElementById('row-' + id);
        var form = document.getElementById('edit-form-' + id);
        row.classList.add('is-editing');
        form.classList.add('is-open');
      });
    });
    document.querySelectorAll('.js-edit-cancel').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var id = btn.dataset.id;
        var row = document.getElementById('row-' + id);
        var form = document.getElementById('edit-form-' + id);
        row.classList.remove('is-editing');
        form.classList.remove('is-open');
      });
    });
    document.querySelectorAll('.js-delete-form').forEach(function (form) {
      form.addEventListener('submit', function (e) {
        if (!confirm('Delete this category? This cannot be undone.')) {
          e.preventDefault();
        }
      });
    });
  </script>
</body>
</html>
