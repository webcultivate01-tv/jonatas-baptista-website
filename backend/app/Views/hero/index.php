<?php
$activeNav = 'hero-blog';
$pageTitle = 'Hero Blog';
$pageSubtitle = 'Edit the title, description and right-side image of the blog page hero section.';

$errorMessages = [
    'fields_required' => 'Title and description are both required.',
    'image_invalid' => 'That image could not be uploaded. Use JPG, PNG or WEBP under 5MB.',
    'url_invalid' => 'Image URL must start with http://, https:// or /.',
    'not_found' => 'Hero section is missing. Run php backend/database/migrate.php.',
];
$successMessages = [
    'updated' => 'Hero section updated successfully.',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow" />
  <title>Hero Blog — Jonatas Baptista</title>
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
    .banner-error { background: var(--danger-bg); border: 1px solid #f6c4c0; color: var(--danger); }
    .banner-success { background: #eafaf1; border: 1px solid #b7e9cd; color: #1e8449; }
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
    .field input[type="text"],
    .field input[type="file"],
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
    .field textarea { resize: vertical; min-height: 110px; line-height: 1.5; }
    .field input:focus, .field textarea:focus { outline: none; border-color: var(--indigo); }
    .field-hint { font-size: 0.78rem; color: var(--text-soft); margin-top: 0.35rem; }
    .current-image img {
      display: block;
      max-width: 320px;
      width: 100%;
      border-radius: 0.6rem;
      border: 1px solid var(--border);
      margin-bottom: 0.75rem;
    }
    .btn {
      font-family: 'Outfit', sans-serif;
      font-size: 0.88rem;
      font-weight: 600;
      border: none;
      border-radius: 0.55rem;
      padding: 0.75rem 1.5rem;
      cursor: pointer;
      background: var(--indigo);
      color: #fff;
    }
    .btn:hover { background: #4338ca; }
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

        <?php if ($hero === null): ?>
          <div class="banner banner-error">No hero content found. Run <code>php backend/database/migrate.php</code> to create it.</div>
        <?php else: ?>
        <form class="card" method="POST" enctype="multipart/form-data" action="/admin/hero-blog/update">
          <div class="field">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required
                   value="<?= htmlspecialchars($hero['title']) ?>" />
          </div>

          <div class="field">
            <label for="description">Description</label>
            <textarea id="description" name="description" required><?= htmlspecialchars($hero['description']) ?></textarea>
          </div>

          <div class="field current-image">
            <label>Current Right-Side Image</label>
            <img src="<?= htmlspecialchars($hero['image_path']) ?>" alt="Current hero image" />
            <div class="field-hint">Stored URL: <?= htmlspecialchars($hero['image_path']) ?></div>
          </div>

          <div class="field">
            <label for="image_url">Image URL</label>
            <input type="text" id="image_url" name="image_url" placeholder="https://example.com/hero.png or /image/blog-hero.png"
                   value="<?= htmlspecialchars($hero['image_path']) ?>" />
            <div class="field-hint">Paste a new URL, or upload a file below (an uploaded file takes priority).</div>
          </div>

          <div class="field">
            <label for="image">Upload New Image</label>
            <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp" />
            <div class="field-hint">JPG, PNG or WEBP, up to 5MB. Optional.</div>
          </div>

          <button type="submit" class="btn">Save Changes</button>
        </form>
        <?php endif; ?>

      </main>
    </div>
  </div>
</body>
</html>
