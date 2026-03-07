<?php
declare(strict_types = 1);
require_once 'includes/database-connection.php';
require_once 'includes/functions.php';

// Validate ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    include 'page-not-found.php';
    exit;
}

// Get navigation
$sql        = "SELECT id, name FROM category WHERE navigation = 1;";
$navigation = pdo($pdo, $sql)->fetchAll();

// Get category info
$sql_cat = "SELECT id, name, description FROM category WHERE id = :id;";
$category = pdo($pdo, $sql_cat, [':id' => $id])->fetch();

if (!$category) {
    include 'page-not-found.php';
    exit;
}

// Get articles in this category
$sql_articles = "
    SELECT a.id, a.title, a.summary, a.created,
           i.file AS image_file, i.alt AS image_alt,
           m.forename, m.surname
    FROM article a
    LEFT JOIN image i   ON a.image_id  = i.id
    LEFT JOIN member m  ON a.member_id = m.id
    WHERE a.category_id = :id AND a.published = 1
    ORDER BY a.created DESC
";
$articles = pdo($pdo, $sql_articles, [':id' => $id])->fetchAll();

$section     = $id;
$title       = html_escape($category['name']);
$description = html_escape($category['description']);

// Category icons
$cat_icons = [
    'Hot Coffee'       => '☕',
    'Cold Coffee'      => '🧊',
    'Pastries'         => '🥐',
    'Specialty Drinks' => '✨',
];
$icon = $cat_icons[$category['name']] ?? '🍃';

require_once 'includes/header.php';
?>

<!-- Menu Hero -->
<section class="menu-hero">
  <div class="container">
    <p class="section-label" style="color:rgba(255,255,255,0.65);">Our Menu</p>
    <h1><?= $icon ?> <?= html_escape($category['name']) ?></h1>
    <p><?= html_escape($category['description']) ?></p>
  </div>
</section>

<!-- Category Strip Nav -->
<nav class="category-strip" aria-label="Menu categories">
  <div class="container">
    <a href="index.php" class="cat-link">
      <span class="cat-icon">🏠</span> Home
    </a>
    <?php foreach ($navigation as $link): ?>
    <a href="category.php?id=<?= $link['id'] ?>" class="cat-link <?= ($link['id'] == $id) ? 'active' : '' ?>">
      <span class="cat-icon"><?= $cat_icons[$link['name']] ?? '🍃' ?></span>
      <?= html_escape($link['name']) ?>
    </a>
    <?php endforeach; ?>
  </div>
</nav>

<!-- Menu Grid -->
<div class="container">
  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="index.php">Home</a>
    <span class="sep">›</span>
    <span><?= html_escape($category['name']) ?></span>
  </div>

  <?php if (empty($articles)): ?>
    <div class="alert alert-info">No items available in this category yet. Check back soon!</div>
  <?php else: ?>

  <div class="menu-grid">
    <?php foreach ($articles as $article): ?>
    <article class="menu-card">
      <a href="article.php?id=<?= $article['id'] ?>">
        <div class="menu-card-img">
          <?php
          $img_path = 'uploads/' . html_escape($article['image_file']);
          if ($article['image_file'] && file_exists($img_path)):
          ?>
            <img src="<?= $img_path ?>" alt="<?= html_escape($article['image_alt']) ?>" loading="lazy">
          <?php else: ?>
            <div class="img-placeholder" style="height:100%">
              <?= $icon ?>
              <span><?= html_escape($article['title']) ?></span>
            </div>
          <?php endif; ?>
        </div>
        <div class="menu-card-body">
          <h3><?= html_escape($article['title']) ?></h3>
          <p><?= html_escape($article['summary']) ?></p>
          <div class="menu-card-meta">
            <span class="meta-author">By <?= html_escape($article['forename'] . ' ' . $article['surname']) ?></span>
            <span class="btn btn-ghost" style="pointer-events:none">View →</span>
          </div>
        </div>
      </a>
    </article>
    <?php endforeach; ?>
  </div>

  <?php endif; ?>
</div>

<!-- CTA Banner -->
<section class="cta-banner" style="margin-top: 60px;">
  <div class="container">
    <h2>Explore More</h2>
    <p>Browse our other categories and find your perfect treat.</p>
    <a href="index.php" class="btn btn-white">Back to Home →</a>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
