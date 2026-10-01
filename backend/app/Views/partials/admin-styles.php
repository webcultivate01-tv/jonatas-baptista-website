<style>
  :root {
    --sb-width: 264px;
    --page-bg: #f7f8fb;
    --card-bg: #ffffff;
    --border: #e7e8ee;
    --text-strong: #111827;
    --text-mid: #6b7280;
    --text-soft: #9aa1af;
    --indigo: #4f46e5;
    --indigo-bg: #eef1ff;
    --danger: #dc2626;
    --danger-bg: #fdecec;
  }
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'Outfit', sans-serif;
    font-weight: 400;
    background: var(--page-bg);
    color: var(--text-strong);
    min-height: 100vh;
  }
  a { color: inherit; text-decoration: none; }

  .admin-layout {
    display: flex;
    min-height: 100vh;
  }

  /* Sidebar */
  .sidebar {
    width: var(--sb-width);
    flex-shrink: 0;
    background: var(--card-bg);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    padding: 1.5rem 1.1rem;
    position: sticky;
    top: 0;
    height: 100vh;
  }
  .sb-top {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.25rem 0.5rem 1.5rem;
    border-bottom: 1px solid var(--border);
    margin-bottom: 1.25rem;
  }
  .sb-top img {
    height: 40px;
    width: 40px;
    object-fit: contain;
    border-radius: 0.5rem;
    background: var(--indigo-bg);
    padding: 0.3rem;
  }
  .sb-title {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    font-size: 1.05rem;
    color: var(--text-strong);
    line-height: 1.2;
  }
  .sb-subtitle {
    font-size: 0.78rem;
    color: var(--text-soft);
  }
  .sb-nav {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
  }
  .sb-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.65rem 0.75rem;
    border-radius: 0.6rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--text-mid);
    transition: background 0.15s, color 0.15s;
  }
  .sb-link svg {
    width: 19px;
    height: 19px;
    flex-shrink: 0;
  }
  .sb-link:hover { background: #f3f4f8; color: var(--text-strong); }
  .sb-link.active {
    background: var(--indigo-bg);
    color: var(--indigo);
    font-weight: 600;
  }
  .sb-divider {
    height: 1px;
    background: var(--border);
    margin: 0.9rem 0.25rem;
  }
  .sb-bottom {
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid var(--border);
  }
  .sb-profile {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    padding: 0.4rem 0.5rem 0.9rem;
  }
  .sb-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: var(--indigo);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.9rem;
    flex-shrink: 0;
  }
  .sb-profile-name {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text-strong);
  }
  .sb-profile-role {
    font-size: 0.75rem;
    color: var(--text-soft);
  }
  .sb-logout {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-family: 'Outfit', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    background: #fff;
    color: var(--text-mid);
    border: 1.5px solid var(--border);
    border-radius: 0.6rem;
    padding: 0.6rem;
    cursor: pointer;
    transition: border-color 0.15s, color 0.15s, background 0.15s;
  }
  .sb-logout svg { width: 17px; height: 17px; }
  .sb-logout:hover { border-color: var(--danger); color: var(--danger); background: var(--danger-bg); }

  /* Main area */
  .admin-main {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
  }
  .topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--border);
    background: var(--card-bg);
    flex-wrap: wrap;
  }
  .topbar h1 {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-strong);
  }
  .topbar p {
    font-size: 0.85rem;
    color: var(--text-soft);
    margin-top: 0.15rem;
  }
  .topbar-right {
    display: flex;
    align-items: center;
    gap: 1.25rem;
  }
  .topbar-date {
    font-size: 0.85rem;
    color: var(--text-mid);
    white-space: nowrap;
  }
  .topbar-user {
    display: flex;
    align-items: center;
    gap: 0.6rem;
  }
  .topbar-username {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-strong);
  }
  .topbar-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--indigo);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.85rem;
    flex-shrink: 0;
  }
  .admin-content {
    padding: 2rem;
  }
</style>
