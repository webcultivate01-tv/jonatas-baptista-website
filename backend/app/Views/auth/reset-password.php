<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow" />
  <title>Reset Password — Jonatas Baptista</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <style>
    :root {
      --ink: #1b2233;
      --muted: #6b7385;
      --line: #dfe3ec;
      --red: #c0392b;
      --red-h: #a93226;
      --blue: #2c5fc7;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { min-height: 100%; }
    body {
      font-family: 'Outfit', sans-serif;
      font-weight: 400;
      color: var(--ink);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      background:
        radial-gradient(60rem 40rem at 0% 0%, rgba(192,57,43,0.10), transparent 60%),
        radial-gradient(60rem 40rem at 100% 100%, rgba(44,95,199,0.12), transparent 60%),
        #f6f7fb;
    }
    .login-card {
      width: 100%;
      max-width: 430px;
      background: #fff;
      border: 1px solid var(--line);
      border-radius: 1.25rem;
      padding: 2.75rem 2.25rem 2.25rem;
      box-shadow: 0 1px 2px rgba(27,34,51,0.04), 0 24px 60px -24px rgba(27,34,51,0.22);
    }
    .login-logo-wrap {
      width: 84px;
      height: 84px;
      margin: 0 auto 1.5rem;
      border-radius: 50%;
      background: linear-gradient(145deg, #1b2233, #0e1117);
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 10px 24px -8px rgba(14,17,23,0.45);
    }
    .login-logo { height: 70px; width: auto; display: block; }
    .login-title {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      font-size: 1.9rem;
      text-align: center;
      color: var(--ink);
      margin-bottom: 0.4rem;
    }
    .login-subtitle {
      text-align: center;
      font-size: 0.95rem;
      color: var(--muted);
      margin-bottom: 2rem;
    }
    .error-banner, .success-banner {
      font-size: 0.875rem;
      padding: 0.75rem 1rem;
      border-radius: 0.6rem;
      margin-bottom: 1.5rem;
      text-align: center;
    }
    .error-banner { background: #fdecea; border: 1px solid #f5c2bd; color: #a12a1f; }
    .success-banner { background: #e8f6ee; border: 1px solid #b7e1c7; color: #1e6b3d; }
    .field { margin-bottom: 1.25rem; }
    label {
      display: block;
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: var(--ink);
      margin-bottom: 0.5rem;
    }
    input[type="email"],
    input[type="password"],
    input[type="text"] {
      width: 100%;
      font-family: 'Outfit', sans-serif;
      font-size: 1rem;
      color: var(--ink);
      background: #fff;
      border: 1.5px solid var(--line);
      border-radius: 0.65rem;
      padding: 0.8rem 1rem;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    input::placeholder { color: #a3aabb; }
    input:hover { border-color: #c4cadb; }
    input:focus {
      outline: none;
      border-color: var(--red);
      box-shadow: 0 0 0 4px rgba(192,57,43,0.12);
    }
    .hint { margin-top: 0.4rem; font-size: 0.8rem; color: var(--muted); }
    .password-wrap { position: relative; }
    .password-wrap input { padding-right: 3rem; }
    .toggle-password {
      position: absolute;
      top: 0;
      right: 0;
      height: 100%;
      width: 3rem;
      display: flex;
      align-items: center;
      justify-content: center;
      background: none;
      border: none;
      cursor: pointer;
      color: var(--muted);
      padding: 0;
    }
    .toggle-password:hover { color: var(--ink); }
    .toggle-password svg { width: 20px; height: 20px; }
    .toggle-password .icon-eye-off { display: none; }
    .toggle-password.is-visible .icon-eye { display: none; }
    .toggle-password.is-visible .icon-eye-off { display: block; }
    .btn-login {
      width: 100%;
      font-family: 'Outfit', sans-serif;
      font-size: 0.95rem;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      background: linear-gradient(135deg, #d44332, var(--red));
      color: #fff;
      border: none;
      border-radius: 0.65rem;
      padding: 0.95rem;
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
      margin-top: 0.5rem;
      box-shadow: 0 10px 22px -10px rgba(192,57,43,0.7);
    }
    .btn-login:hover { transform: translateY(-1px); box-shadow: 0 14px 26px -10px rgba(192,57,43,0.8); }
    .btn-login:active { transform: translateY(0); }
    .forgot-link {
      display: block;
      text-align: center;
      margin-top: 1.5rem;
      font-size: 0.875rem;
      color: var(--muted);
      text-decoration: none;
    }
    .forgot-link:hover { color: var(--red); }
  </style>
</head>
<body>
  <div class="login-card">
    <div class="login-logo-wrap"><img src="/image/jb-logo.png" alt="Jonatas Baptista" class="login-logo" /></div>

    <?php if (!empty($invalid)): ?>
      <h1 class="login-title">Link Expired</h1>
      <p class="login-subtitle">This password reset link is invalid or has expired.</p>
      <a href="/admin/forgot-password" class="forgot-link">Request a new link</a>
    <?php else: ?>
      <h1 class="login-title">Reset Password</h1>
      <p class="login-subtitle">Choose a new password for your account</p>

      <?php if (!empty($error)): ?>
        <div class="error-banner">Passwords must match and be at least 8 characters.</div>
      <?php endif; ?>

      <form method="POST" action="/admin/reset-password">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>" />
        <div class="field">
          <label for="password">New Password</label>
          <div class="password-wrap">
            <input type="password" id="password" name="password" placeholder="••••••••" minlength="8" required autofocus />
            <button type="button" class="toggle-password" data-target="password" aria-label="Show password">
              <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z" /><circle cx="12" cy="12" r="3" /></svg>
              <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a20.3 20.3 0 0 1 5.06-5.94M9.9 4.24A10.87 10.87 0 0 1 12 4c7 0 11 7 11 7a20.3 20.3 0 0 1-3.22 4.06M14.12 14.12a3 3 0 1 1-4.24-4.24" /><path d="M1 1l22 22" /></svg>
            </button>
          </div>
          <p class="hint">At least 8 characters.</p>
        </div>
        <div class="field">
          <label for="confirm_password">Confirm Password</label>
          <div class="password-wrap">
            <input type="password" id="confirm_password" name="confirm_password" placeholder="••••••••" minlength="8" required />
            <button type="button" class="toggle-password" data-target="confirm_password" aria-label="Show password">
              <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z" /><circle cx="12" cy="12" r="3" /></svg>
              <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a20.3 20.3 0 0 1 5.06-5.94M9.9 4.24A10.87 10.87 0 0 1 12 4c7 0 11 7 11 7a20.3 20.3 0 0 1-3.22 4.06M14.12 14.12a3 3 0 1 1-4.24-4.24" /><path d="M1 1l22 22" /></svg>
            </button>
          </div>
        </div>
        <button type="submit" class="btn-login">Reset Password</button>
      </form>
      <a href="/admin" class="forgot-link">Back to log in</a>
    <?php endif; ?>
  </div>
  <script>
    document.querySelectorAll('.toggle-password').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var input = document.getElementById(btn.dataset.target);
        var showing = input.type === 'text';
        input.type = showing ? 'password' : 'text';
        btn.classList.toggle('is-visible', !showing);
        btn.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
      });
    });
  </script>
</body>
</html>
