<?php
declare(strict_types = 1);
require_once 'includes/database-connection.php';
require_once 'includes/functions.php';

$sql        = "SELECT id, name FROM category WHERE navigation = 1;";
$navigation = pdo($pdo, $sql)->fetchAll();
$section    = 0;

$query   = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
$results = [];

if ($query) {
    $sql_search = "
        SELECT a.id, a.title, a.summary, i.file AS image_file, i.alt AS image_alt, c.name AS category_name, c.id AS cat_id
        FROM article a
        LEFT JOIN image i ON a.image_id = i.id
        LEFT JOIN category c ON a.category_id = c.id
        WHERE a.published = 1 AND (a.title LIKE :q OR a.summary LIKE :q OR a.content LIKE :q)
        ORDER BY a.title
    ";
    $results = pdo($pdo, $sql_search, [':q' => '%' . $query . '%'])->fetchAll();
}

$title       = $query ? 'Search: ' . html_escape($query) : 'Search';
$description = 'Search our menu at Otokoe Coffee.';

$cat_icons = ['Hot Coffee'=>'☕','Cold Coffee'=>'🧊','Pastries'=>'🥐','Specialty Drinks'=>'✨'];

require_once 'includes/header.php';
?>

<div style="padding-top:72px;">
  <section class="menu-hero">
    <div class="container">
      <p class="section-label" style="color:rgba(255,255,255,0.65);">Search</p>
      <h1>🔍 Find Your Favourite</h1>
      <form action="search.php" method="get" style="margin-top:24px;display:flex;gap:12px;justify-content:center;max-width:500px;margin-left:auto;margin-right:auto;">
        <input type="search" name="q" value="<?= html_escape($query) ?>" placeholder="Search drinks, pastries..." 
          style="flex:1;padding:12px 20px;border-radius:50px;border:none;font-size:1rem;outline:none;font-family:'DM Sans',sans-serif;">
        <button type="submit" class="btn btn-primary" style="border-radius:50px;">Search</button>
      </form>
    </div>
  </section>

  <div class="container" style="padding:48px 24px;">
    <?php if ($query): ?>
      <p style="color:var(--text-light);margin-bottom:32px;">
        <?= count($results) ?> result(s) for "<strong><?= html_escape($query) ?></strong>"
      </p>
      <?php if (empty($results)): ?>
        <div class="alert alert-info">No items found. Try a different search term.</div>
      <?php else: ?>
        <div class="menu-grid">
          <?php foreach ($results as $item): ?>
          <article class="menu-card">
            <a href="article.php?id=<?= $item['id'] ?>">
              <div class="menu-card-img">
                <?php $img_path = 'uploads/' . html_escape($item['image_file']); ?>
                <?php if ($item['image_file'] && file_exists($img_path)): ?>
                  <img src="<?= $img_path ?>" alt="<?= html_escape($item['image_alt']) ?>" loading="lazy">
                <?php else: ?>
                  <div class="img-placeholder" style="height:100%"><?= $cat_icons[$item['category_name']] ?? '☕' ?></div>
                <?php endif; ?>
              </div>
              <div class="menu-card-body">
                <h3><?= html_escape($item['title']) ?></h3>
                <p><?= html_escape($item['summary']) ?></p>
                <div class="menu-card-meta">
                  <span class="meta-author"><?= html_escape($item['category_name']) ?></span>
                  <span class="btn btn-ghost" style="pointer-events:none">View →</span>
                </div>
              </div>
            </a>
          </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    <?php else: ?>
      <p style="color:var(--text-light);text-align:center;padding:40px 0;">Enter a search term above to find menu items.</p>
    <?php endif; ?>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>
