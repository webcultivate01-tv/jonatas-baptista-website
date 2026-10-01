<?php
/**
 * Expects in scope: $pageTitle, $pageSubtitle, $user (array with 'name').
 */
$userName = $user['name'] ?? 'Admin';
$userInitial = strtoupper(substr(trim($userName), 0, 1)) ?: 'A';
?>
<header class="topbar">
  <div>
    <h1><?= htmlspecialchars($pageTitle ?? '') ?></h1>
    <?php if (!empty($pageSubtitle)): ?>
      <p><?= htmlspecialchars($pageSubtitle) ?></p>
    <?php endif; ?>
  </div>
  <div class="topbar-right">
    <span class="topbar-date" id="topbarClock"></span>
    <div class="topbar-user">
      <div class="topbar-avatar"><?= htmlspecialchars($userInitial) ?></div>
      <span class="topbar-username"><?= htmlspecialchars($userName) ?></span>
    </div>
  </div>
</header>
<script>
  (function () {
    var el = document.getElementById('topbarClock');
    if (!el) return;
    function render() {
      var now = new Date();
      var opts = { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
      el.textContent = now.toLocaleString('en-US', opts).replace(',', ',');
    }
    render();
    setInterval(render, 1000);
  })();
</script>
