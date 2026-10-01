<?php
$activeNav = 'my-account';
$pageTitle = 'My Account';
$pageSubtitle = 'Update your name, email and password.';

$errorMessages = [
    'name_invalid' => 'Please enter a name (up to 100 characters).',
    'email_invalid' => 'Please enter a valid email address.',
    'email_taken' => 'That email address is already used by another account.',
    'password_short' => 'Your new password must be at least 8 characters.',
    'password_mismatch' => 'The new password and confirmation do not match.',
];
$successMessages = [
    'profile' => 'Your profile has been updated.',
    'password' => 'Your password has been changed. Use it the next time you log in.',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow" />
  <title>My Account — Jonatas Baptista</title>
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
    .card-row {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 1.5rem;
      align-items: start;
    }
    @media (max-width: 900px) {
      .card-row { grid-template-columns: 1fr; }
    }
    .card h2 {
      font-family: 'Playfair Display', serif;
      font-size: 1.15rem;
      font-weight: 700;
      color: var(--text-strong);
      margin-bottom: 0.4rem;
    }
    .card .hint {
      font-size: 0.85rem;
      color: var(--text-soft);
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
    .field { margin-bottom: 1.1rem; }
    .field label {
      display: block;
      font-size: 0.78rem;
      font-weight: 600;
      letter-spacing: 0.04em;
      text-transform: uppercase;
      color: var(--text-soft);
      margin-bottom: 0.45rem;
    }
    .field input {
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
    .field input:focus { outline: none; border-color: var(--indigo); }
    .btn {
      font-family: 'Outfit', sans-serif;
      font-size: 0.88rem;
      font-weight: 600;
      border: none;
      border-radius: 0.55rem;
      padding: 0.7rem 1.35rem;
      cursor: pointer;
      transition: background 0.15s;
    }
    .btn-primary { background: var(--indigo); color: #fff; }
    .btn-primary:hover { background: #4338ca; }
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

        <div class="card-row">
        <div class="card">
          <h2>Profile</h2>
          <p class="hint">Your name is shown in the admin panel. Your email is used to log in.</p>
          <form method="POST" action="/admin/account/profile">
            <div class="field">
              <label for="name">Name</label>
              <input type="text" id="name" name="name" maxlength="100" value="<?= htmlspecialchars($admin['name']) ?>" required />
            </div>
            <div class="field">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" maxlength="150" value="<?= htmlspecialchars($admin['email']) ?>" required />
            </div>
            <button type="submit" class="btn btn-primary">Save Profile</button>
          </form>
        </div>

        <div class="card">
          <h2>Change Password</h2>
          <p class="hint">You're already logged in, so you don't need your current password. Just choose a new one (at least 8 characters).</p>
          <form method="POST" action="/admin/account/password" autocomplete="off">
            <div class="field">
              <label for="password">New Password</label>
              <input type="password" id="password" name="password" minlength="8" autocomplete="new-password" required />
            </div>
            <div class="field">
              <label for="confirm_password">Confirm New Password</label>
              <input type="password" id="confirm_password" name="confirm_password" minlength="8" autocomplete="new-password" required />
            </div>
            <button type="submit" class="btn btn-primary">Update Password</button>
          </form>
        </div>
        </div>

      </main>
    </div>
  </div>
</body>
</html>
