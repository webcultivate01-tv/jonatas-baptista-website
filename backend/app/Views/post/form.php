<?php
$isEdit = $post !== null;
$activeNav = 'blog-management';
$pageTitle = $isEdit ? 'Edit Post' : 'Add New Post';
$pageSubtitle = $isEdit ? 'Update this article.' : 'Write a new article for the blog page.';

$errorMessages = [
    'fields_required' => 'Title and body are both required.',
    'category_required' => 'Please choose a valid category.',
    'duplicate' => 'A post with that title (slug) already exists.',
    'image_required' => 'A featured image is required for a new post.',
    'image_invalid' => 'That image could not be uploaded. Use JPG, PNG or WEBP under 5MB.',
];

$publishedDate = $isEdit ? date('Y-m-d', strtotime($post['published_at'])) : date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow" />
  <title><?= htmlspecialchars($pageTitle) ?> — Jonatas Baptista</title>
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
      max-width: 860px;
    }
    .banner {
      font-size: 0.88rem;
      padding: 0.75rem 1rem;
      border-radius: 0.6rem;
      margin-bottom: 1.5rem;
      max-width: 860px;
    }
    .banner-error {
      background: var(--danger-bg);
      border: 1px solid #f6c4c0;
      color: var(--danger);
    }
    .field { margin-bottom: 1.35rem; }
    .field label {
      display: block;
      font-size: 0.78rem;
      font-weight: 600;
      letter-spacing: 0.04em;
      text-transform: uppercase;
      color: var(--text-soft);
      margin-bottom: 0.45rem;
    }
    .field-row { display: flex; gap: 1.25rem; flex-wrap: wrap; }
    .field-row .field { flex: 1; min-width: 200px; }
    .field input[type="text"],
    .field input[type="number"],
    .field input[type="date"],
    .field input[type="file"],
    .field select,
    .field textarea {
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
    .field textarea { resize: vertical; min-height: 90px; }
    .field input:focus, .field select:focus, .field textarea:focus { outline: none; border-color: var(--indigo); }
    .field-hint { font-size: 0.78rem; color: var(--text-soft); margin-top: 0.35rem; }
    .current-image { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; }
    .current-image img { width: 90px; height: 60px; object-fit: cover; border-radius: 0.5rem; border: 1px solid var(--border); }

    /* Rich text editor */
    .editor-toolbar {
      display: flex;
      gap: 0.35rem;
      flex-wrap: wrap;
      border: 1.5px solid var(--border);
      border-bottom: none;
      border-radius: 0.55rem 0.55rem 0 0;
      padding: 0.5rem;
      background: #fafafd;
    }
    .editor-toolbar button {
      font-family: 'Outfit', sans-serif;
      font-size: 0.8rem;
      font-weight: 600;
      border: 1px solid var(--border);
      background: #fff;
      color: var(--text-mid);
      border-radius: 0.4rem;
      padding: 0.4rem 0.65rem;
      cursor: pointer;
    }
    .editor-toolbar button:hover { border-color: var(--indigo); color: var(--indigo); }
    #body-editor {
      min-height: 320px;
      border: 1.5px solid var(--border);
      border-radius: 0 0 0.55rem 0.55rem;
      padding: 1rem;
      font-family: 'Outfit', sans-serif;
      font-size: 0.95rem;
      color: var(--text-strong);
      line-height: 1.6;
    }
    #body-editor:focus { outline: none; border-color: var(--indigo); }
    #body-editor h2 { font-size: 1.25rem; font-weight: 700; margin: 1rem 0 0.5rem; }
    #body-editor h3 { font-size: 1.05rem; font-weight: 700; margin: 0.9rem 0 0.4rem; }
    #body-editor p { margin-bottom: 0.75rem; }
    #body-editor blockquote { border-left: 3px solid var(--indigo); padding-left: 1rem; color: var(--text-mid); margin: 1rem 0; }
    #body-editor ul { padding-left: 1.5rem; margin-bottom: 0.75rem; }

    .form-actions { margin-top: 1.5rem; display: flex; gap: 0.75rem; }
    .btn {
      font-family: 'Outfit', sans-serif;
      font-size: 0.88rem;
      font-weight: 600;
      border: none;
      border-radius: 0.55rem;
      padding: 0.75rem 1.5rem;
      cursor: pointer;
    }
    .btn-primary { background: var(--indigo); color: #fff; }
    .btn-primary:hover { background: #4338ca; }
    .btn-ghost {
      background: #fff;
      color: var(--text-mid);
      border: 1.5px solid var(--border);
    }
    .btn-ghost:hover { border-color: var(--indigo); color: var(--indigo); }
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

        <form class="card" method="POST" enctype="multipart/form-data"
              action="<?= $isEdit ? '/admin/posts/update' : '/admin/posts/store' ?>"
              id="post-form">
          <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= (int) $post['id'] ?>" />
          <?php endif; ?>

          <div class="field">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required
                   value="<?= htmlspecialchars($post['title'] ?? '') ?>" />
          </div>

          <div class="field-row">
            <div class="field">
              <label for="category_id">Category</label>
              <select id="category_id" name="category_id" required>
                <option value="">Select a category</option>
                <?php foreach ($categories as $category): ?>
                  <option value="<?= (int) $category['id'] ?>"
                    <?= (int) ($post['category_id'] ?? 0) === (int) $category['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="field">
              <label for="status">Status</label>
              <select id="status" name="status">
                <option value="published" <?= ($post['status'] ?? 'published') === 'published' ? 'selected' : '' ?>>Published</option>
                <option value="draft" <?= ($post['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
              </select>
            </div>
          </div>

          <div class="field-row">
            <div class="field">
              <label for="published_at">Published Date</label>
              <input type="date" id="published_at" name="published_at" value="<?= htmlspecialchars($publishedDate) ?>" />
            </div>
            <div class="field">
              <label for="read_minutes">Read Time (minutes)</label>
              <input type="number" id="read_minutes" name="read_minutes" min="1" max="60"
                     value="<?= htmlspecialchars((string) ($post['read_minutes'] ?? 5)) ?>" />
            </div>
          </div>

          <div class="field">
            <label for="tags">Tags (comma separated)</label>
            <input type="text" id="tags" name="tags" placeholder="e.g. Investment Strategy, Portfolio Building"
                   value="<?= htmlspecialchars($post['tags'] ?? '') ?>" />
          </div>

          <div class="field">
            <label for="image">Featured Image</label>
            <?php if ($isEdit): ?>
              <div class="current-image">
                <img src="<?= htmlspecialchars($post['image_path']) ?>" alt="" />
                <span class="field-hint">Current image — upload a new file to replace it.</span>
              </div>
            <?php endif; ?>
            <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp" />
            <div class="field-hint">JPG, PNG or WEBP, up to 5MB.<?= $isEdit ? '' : ' Required.' ?></div>
          </div>

          <div class="field">
            <label for="body-editor">Body</label>
            <div class="editor-toolbar">
              <button type="button" data-cmd="bold"><b>B</b></button>
              <button type="button" data-cmd="italic"><i>I</i></button>
              <button type="button" data-cmd="formatBlock" data-value="H2">H2</button>
              <button type="button" data-cmd="formatBlock" data-value="H3">H3</button>
              <button type="button" data-cmd="formatBlock" data-value="P">¶</button>
              <button type="button" data-cmd="insertUnorderedList">• List</button>
              <button type="button" data-cmd="formatBlock" data-value="BLOCKQUOTE">" Quote</button>
              <button type="button" id="link-btn">Link</button>
            </div>
            <div id="body-editor" contenteditable="true"><?= $post['body'] ?? '<p></p>' ?></div>
            <textarea name="body" id="body-input" style="display:none;"></textarea>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Save Changes' : 'Create Post' ?></button>
            <a href="/admin/posts" class="btn btn-ghost">Cancel</a>
          </div>
        </form>

      </main>
    </div>
  </div>
  <script>
    var editor = document.getElementById('body-editor');

    document.querySelectorAll('.editor-toolbar [data-cmd]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        editor.focus();
        document.execCommand(btn.dataset.cmd, false, btn.dataset.value || null);
      });
    });

    document.getElementById('link-btn').addEventListener('click', function () {
      var url = prompt('Link URL:');
      if (url) {
        editor.focus();
        document.execCommand('createLink', false, url);
      }
    });

    document.getElementById('post-form').addEventListener('submit', function () {
      document.getElementById('body-input').value = editor.innerHTML.trim();
    });
  </script>
</body>
</html>
