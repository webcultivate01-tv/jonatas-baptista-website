<?php
$activeNav = 'dashboard';
$pageTitle = 'Dashboard';
$pageSubtitle = 'Welcome back' . (isset($user['name']) ? ', ' . $user['name'] : '') . '.';

$e = static fn ($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');

// Donut geometry (published vs drafts)
$radius = 52;
$circ = 2 * M_PI * $radius;
$pubShare = $stats['posts'] > 0 ? $stats['published'] / $stats['posts'] : 0;
$pubLen = $circ * $pubShare;
$pubPct = (int) round($pubShare * 100);

$maxCat = max(1, ...array_map(static fn ($c) => (int) $c['total'], $categoryBreakdown ?: [['total' => 1]]));
$maxMonth = max(1, ...array_map(static fn ($m) => $m['total'], $monthly));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow" />
  <title>Dashboard — Jonatas Baptista</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <?php require __DIR__ . '/../partials/admin-styles.php'; ?>
  <style>
    :root {
      --navy: #0e1117; --navy-card: #1c2232;
      --blue: #2a5fc7; --blue-light: #3b76e8; --blue-bg: #eaf0fc;
      --green: #12a36b; --green-bg: #e3f6ee;
      --gold: #e0a030; --gold-bg: #fdf3df;
    }
    .admin-content { max-width: 1280px; }
    .card {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 1.1rem;
      padding: 1.6rem;
      box-shadow: 0 1px 2px rgba(16,24,40,.04);
    }
    .card h2 { font-family: 'Playfair Display', serif; font-size: 1.15rem; font-weight: 700; }
    .card .sub { font-size: 0.82rem; color: var(--text-soft); margin: 0.2rem 0 1.4rem; }

    /* Stat cards */
    .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 1.5rem; }
    .stat { display: flex; align-items: center; gap: 1rem; position: relative; overflow: hidden; transition: transform .15s, box-shadow .15s; }
    .stat::before { content: ""; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: var(--accent); }
    a.stat:hover { transform: translateY(-3px); box-shadow: 0 10px 24px rgba(16,24,40,.08); }
    .stat.blue { --accent: var(--blue); --accent-bg: var(--blue-bg); }
    .stat.green { --accent: var(--green); --accent-bg: var(--green-bg); }
    .stat.gold { --accent: var(--gold); --accent-bg: var(--gold-bg); }
    .stat.navy { --accent: var(--blue-light); --accent-bg: var(--blue-bg); }
    .stat-icon { width: 48px; height: 48px; border-radius: 0.85rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: var(--accent-bg); color: var(--accent); }
    .stat-icon svg { width: 24px; height: 24px; }
    .stat-num { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; line-height: 1; }
    .stat-label { font-size: 0.85rem; color: var(--text-mid); margin-top: 0.3rem; }

    .chart-grid { display: grid; grid-template-columns: 1fr 1.4fr; gap: 1.25rem; margin-bottom: 1.25rem; }
    .chart-grid.flip { grid-template-columns: 1.4fr 1fr; }

    /* Dark donut card */
    .donut-wrap { display: flex; flex-direction: column; align-items: center; gap: 1.5rem; }
    .donut { width: 170px; height: 170px; }
    .donut circle { fill: none; stroke-width: 14; }
    .donut .track { stroke: #eef0f6; }
    .donut .arc { stroke: url(#arcGrad); stroke-linecap: round; transform: rotate(-90deg); transform-origin: 60px 60px; }
    .donut .pct { font-family: 'Playfair Display', serif; font-weight: 700; fill: var(--blue); }
    .donut .cap { fill: var(--text-soft); font-family: 'Outfit', sans-serif; }
    .legend { display: flex; gap: .75rem; width: 100%; }
    .legend > div { flex: 1; background: var(--blue-bg); border-radius: .75rem; padding: .7rem .9rem; font-size: .8rem; color: var(--text-mid); }
    .legend b { display: block; font-family: 'Playfair Display', serif; font-size: 1.4rem; color: var(--blue); margin-top: .1rem; }
    .legend .dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: .4rem; }

    /* Category bars */
    .bar-row { margin-bottom: 1rem; }
    .bar-row:last-child { margin-bottom: 0; }
    .bar-meta { display: flex; justify-content: space-between; font-size: 0.88rem; margin-bottom: 0.4rem; font-weight: 500; }
    .bar-meta span:last-child { color: var(--blue); font-weight: 600; }
    .bar-track { height: 10px; background: #eef0f6; border-radius: 99px; overflow: hidden; }
    .bar-fill { height: 100%; background: linear-gradient(90deg, var(--blue), var(--blue-light)); border-radius: 99px; }

    /* Column chart */
    .cols {
      display: flex; align-items: stretch; gap: 1rem; height: 220px;
      background: repeating-linear-gradient(to top, transparent 0, transparent calc(25% - 1px), #eef0f6 calc(25% - 1px), #eef0f6 25%);
      background-size: 100% calc(100% - 28px); background-repeat: no-repeat;
    }
    .col { flex: 1; display: flex; flex-direction: column; align-items: center; }
    .col-plot { flex: 1; width: 100%; display: flex; flex-direction: column; justify-content: flex-end; align-items: center; gap: .35rem; }
    .col-val { font-size: .8rem; font-weight: 600; color: var(--text-mid); }
    .col-bar { width: 100%; max-width: 46px; background: linear-gradient(180deg, var(--blue-light), var(--blue)); border-radius: .5rem .5rem 0 0; min-height: 3px; }
    .col-bar.zero { background: #dfe2ec; }
    .col-label { height: 28px; line-height: 28px; font-size: .78rem; color: var(--text-soft); }

    /* Recent */
    .recent-head { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: .75rem; }
    .recent-head a { font-size: .82rem; font-weight: 600; color: var(--blue); background: var(--blue-bg); padding: .35rem .8rem; border-radius: 99px; }
    .recent-list { list-style: none; }
    .recent-list li { display: flex; align-items: center; gap: .85rem; padding: .8rem 0; border-top: 1px solid var(--border); }
    .recent-list li:first-child { border-top: 0; }
    .r-dot { width: 38px; height: 38px; border-radius: .7rem; background: var(--blue-bg); color: var(--blue); display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: .85rem; flex-shrink: 0; }
    .r-body { flex: 1; min-width: 0; }
    .r-title { display: block; font-size: .9rem; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .r-title:hover { color: var(--blue); }
    .r-meta { font-size: .78rem; color: var(--text-soft); }
    .badge { padding: .2rem .65rem; border-radius: 99px; font-size: .72rem; font-weight: 600; flex-shrink: 0; }
    .badge.published { background: var(--green-bg); color: var(--green); }
    .badge.draft { background: var(--gold-bg); color: #b97a10; }
    .empty { color: var(--text-soft); font-size: .9rem; }

    @media (max-width: 1100px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 900px) { .chart-grid, .chart-grid.flip { grid-template-columns: 1fr; } .admin-content { padding: 1.25rem; } }
    @media (max-width: 560px) { .stat-grid { grid-template-columns: 1fr; } }
  </style>
</head>
<body>
  <div class="admin-layout">
    <?php require __DIR__ . '/../partials/sidebar.php'; ?>
    <div class="admin-main">
      <?php require __DIR__ . '/../partials/topbar.php'; ?>
      <main class="admin-content">

        <section class="stat-grid">
          <a href="/admin/posts" class="card stat blue">
            <div class="stat-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h6"/></svg>
            </div>
            <div><div class="stat-num"><?= $stats['posts'] ?></div><div class="stat-label">Total Blogs</div></div>
          </a>
          <a href="/admin/posts" class="card stat green">
            <div class="stat-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="m8.5 12.5 2.5 2.5 4.5-5"/></svg>
            </div>
            <div><div class="stat-num"><?= $stats['published'] ?></div><div class="stat-label">Published</div></div>
          </a>
          <a href="/admin/posts" class="card stat gold">
            <div class="stat-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg>
            </div>
            <div><div class="stat-num"><?= $stats['drafts'] ?></div><div class="stat-label">Drafts</div></div>
          </a>
          <a href="/admin/categories" class="card stat navy">
            <div class="stat-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
            </div>
            <div><div class="stat-num"><?= $stats['categories'] ?></div><div class="stat-label">Categories</div></div>
          </a>
        </section>

        <section class="chart-grid">
          <div class="card">
            <h2>Publishing Status</h2>
            <p class="sub">Published articles versus drafts</p>
            <div class="donut-wrap">
              <svg class="donut" viewBox="0 0 120 120" role="img" aria-label="<?= $pubPct ?>% of blogs are published">
                <defs>
                  <linearGradient id="arcGrad" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0" stop-color="#2a5fc7"/><stop offset="1" stop-color="#3b76e8"/>
                  </linearGradient>
                </defs>
                <circle class="track" cx="60" cy="60" r="<?= $radius ?>"/>
                <?php if ($stats['published'] > 0): ?>
                  <circle class="arc" cx="60" cy="60" r="<?= $radius ?>" stroke-dasharray="<?= round($pubLen, 2) ?> <?= round($circ, 2) ?>"/>
                <?php endif; ?>
                <text class="pct" x="60" y="62" text-anchor="middle" font-size="24"><?= $pubPct ?>%</text>
                <text class="cap" x="60" y="77" text-anchor="middle" font-size="7.5">PUBLISHED</text>
              </svg>
              <div class="legend">
                <div><span class="dot" style="background:var(--blue)"></span>Published<b><?= $stats['published'] ?></b></div>
                <div><span class="dot" style="background:var(--gold)"></span>Drafts<b><?= $stats['drafts'] ?></b></div>
              </div>
            </div>
          </div>

          <div class="card">
            <h2>Blogs per Category</h2>
            <p class="sub">How your articles are distributed</p>
            <?php if (!$categoryBreakdown): ?>
              <p class="empty">No categories yet.</p>
            <?php endif; ?>
            <?php foreach ($categoryBreakdown as $cat): ?>
              <div class="bar-row">
                <div class="bar-meta"><span><?= $e($cat['name']) ?></span><span><?= (int) $cat['total'] ?></span></div>
                <div class="bar-track"><div class="bar-fill" style="width: <?= round(((int) $cat['total'] / $maxCat) * 100) ?>%"></div></div>
              </div>
            <?php endforeach; ?>
          </div>
        </section>

        <section class="chart-grid flip">
          <div class="card">
            <h2>Blogs Created</h2>
            <p class="sub">Last 6 months</p>
            <div class="cols">
              <?php foreach ($monthly as $m): ?>
                <div class="col">
                  <div class="col-plot">
                    <span class="col-val"><?= $m['total'] ?></span>
                    <div class="col-bar<?= $m['total'] === 0 ? ' zero' : '' ?>" style="height: <?= $m['total'] === 0 ? '3px' : round(($m['total'] / $maxMonth) * 85) . '%' ?>"></div>
                  </div>
                  <span class="col-label"><?= $e($m['label']) ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="card">
            <div class="recent-head">
              <div>
                <h2>Recent Blogs</h2>
                <p class="sub" style="margin-bottom:0">Latest 5 articles</p>
              </div>
              <a href="/admin/posts">View all</a>
            </div>
            <?php if (!$recentPosts): ?>
              <p class="empty">No blogs yet.</p>
            <?php else: ?>
              <ul class="recent-list">
                <?php foreach ($recentPosts as $p): ?>
                  <li>
                    <div class="r-dot"><?= $e(mb_strtoupper(mb_substr($p['title'], 0, 1))) ?></div>
                    <div class="r-body">
                      <a class="r-title" href="/admin/posts/edit?id=<?= (int) $p['id'] ?>"><?= $e($p['title']) ?></a>
                      <span class="r-meta"><?= $e($p['category_name']) ?> · <?= $e(date('M j, Y', strtotime($p['created_at']))) ?></span>
                    </div>
                    <span class="badge <?= $p['status'] === 'published' ? 'published' : 'draft' ?>"><?= $p['status'] === 'published' ? 'Published' : 'Draft' ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </section>

      </main>
    </div>
  </div>
</body>
</html>
