<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow" />
  <title>Forgot Password — Jonatas Baptista</title>
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
    <h1 class="login-title">Forgot Password</h1>
    <p class="login-subtitle">Enter your admin email to reset your password</p>

    <?php if (!empty($error)): ?>
      <div class="error-banner">We couldn't find an admin account with that email.</div>
    <?php endif; ?>

    <form method="POST" action="/admin/forgot-password">
      <div class="field">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="you@example.com" required autofocus />
      </div>
      <button type="submit" class="btn-login">Continue</button>
    </form>
    <a href="/admin" class="forgot-link">Back to log in</a>
  </div>
</body>
</html>
