<?php
/**
 * Expects in scope: $activeNav (string key), $user (array with 'name').
 */
$activeNav = $activeNav ?? '';
$userName = $user['name'] ?? 'Admin';
$userInitial = strtoupper(substr(trim($userName), 0, 1)) ?: 'A';
?>
<aside class="sidebar">
  <div class="sb-top">
    <img src="/image/jb-logo.png" alt="Jonatas Baptista" />
    <div>
      <div class="sb-title">Admin Panel</div>
      <div class="sb-subtitle">Website Management</div>
    </div>
  </div>

  <nav class="sb-nav">
    <a href="/admin/dashboard" class="sb-link<?= $activeNav === 'dashboard' ? ' active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="3" width="7" height="7" rx="1.5"></rect><rect x="3" y="14" width="7" height="7" rx="1.5"></rect><rect x="14" y="14" width="7" height="7" rx="1.5"></rect></svg>
      Dashboard
    </a>
    <a href="/admin/hero-blog" class="sb-link<?= $activeNav === 'hero-blog' ? ' active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><path d="M21 15l-5-5L5 21"></path></svg>
      Hero Blog
    </a>
    <a href="/admin/posts" class="sb-link<?= $activeNav === 'blog-management' ? ' active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6"></path><line x1="8" y1="13" x2="16" y2="13"></line><line x1="8" y1="17" x2="16" y2="17"></line></svg>
      Blog Management
    </a>
    <a href="/admin/categories" class="sb-link<?= $activeNav === 'category-management' ? ' active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41 11 3.83A2 2 0 0 0 9.59 3.24L4 3v5.59a2 2 0 0 0 .59 1.41l9.58 9.59a2 2 0 0 0 2.83 0l3.59-3.59a2 2 0 0 0 0-2.83Z"></path><circle cx="7.5" cy="7.5" r="1.5"></circle></svg>
      Category Management
    </a>

    <div class="sb-divider"></div>

    <a href="/admin/account" class="sb-link<?= $activeNav === 'my-account' ? ' active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
      My Account
    </a>
  </nav>

  <div class="sb-bottom">
    <div class="sb-profile">
      <div class="sb-avatar"><?= htmlspecialchars($userInitial) ?></div>
      <div>
        <div class="sb-profile-name"><?= htmlspecialchars($userName) ?></div>
        <div class="sb-profile-role">Admin</div>
      </div>
    </div>
    <form method="POST" action="/admin/logout">
      <button type="submit" class="sb-logout">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
        Log out
      </button>
    </form>
  </div>
</aside>
