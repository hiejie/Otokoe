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

// Navigation
$sql        = "SELECT id, name FROM category WHERE navigation = 1;";
$navigation = pdo($pdo, $sql)->fetchAll();

// Get article
$sql_article = "
    SELECT a.id, a.title, a.summary, a.content, a.created, a.category_id,
           i.file AS image_file, i.alt AS image_alt,
           m.forename, m.surname, m.picture AS member_picture,
           c.name AS category_name, c.id AS cat_id
    FROM article a
    LEFT JOIN image  i ON a.image_id  = i.id
    LEFT JOIN member m ON a.member_id = m.id
    LEFT JOIN category c ON a.category_id = c.id
    WHERE a.id = :id AND a.published = 1
";
$article = pdo($pdo, $sql_article, [':id' => $id])->fetch();

if (!$article) {
    include 'page-not-found.php';
    exit;
}

// Related items
$sql_related = "
    SELECT a.id, a.title, a.summary, i.file AS image_file, i.alt AS image_alt
    FROM article a
    LEFT JOIN image i ON a.image_id = i.id
    WHERE a.category_id = :cat_id AND a.id != :id AND a.published = 1
    ORDER BY RAND()
    LIMIT 3
";
$related = pdo($pdo, $sql_related, [':cat_id' => $article['cat_id'], ':id' => $id])->fetchAll();

$section     = $article['cat_id'];
$title       = $article['title'];
$description = $article['summary'];

$cat_icons = [
    'Hot Coffee'       => '☕',
    'Cold Coffee'      => '🧊',
    'Pastries'         => '🥐',
    'Specialty Drinks' => '✨',
];
$icon = $cat_icons[$article['category_name']] ?? '🍃';

require_once 'includes/header.php';
?>

<!-- Article Hero Image -->
<section class="article-hero">
  <?php
  $img_path = 'uploads/' . html_escape($article['image_file']);
  if ($article['image_file'] && file_exists($img_path)):
  ?>
    <img src="<?= $img_path ?>" alt="<?= html_escape($article['image_alt']) ?>">
  <?php else: ?>
    <div style="width:100%;height:100%;background:linear-gradient(135deg,#004F33,#4A2C1A);display:flex;align-items:center;justify-content:center;font-size:6rem;">
      <?= $icon ?>
    </div>
  <?php endif; ?>

  <div class="article-hero-overlay">
    <div class="container">
      <div class="article-meta">
        <span><?= $icon ?> <?= html_escape($article['category_name']) ?></span>
        <span>📅 <?= format_date($article['created']) ?></span>
        <span>✍️ <?= html_escape($article['forename'] . ' ' . $article['surname']) ?></span>
      </div>
      <h1><?= html_escape($article['title']) ?></h1>
    </div>
  </div>
</section>

<!-- Category Strip -->
<nav class="category-strip" aria-label="Menu categories">
  <div class="container">
    <a href="index.php" class="cat-link">
      <span class="cat-icon">🏠</span> Home
    </a>
    <?php foreach ($navigation as $link): ?>
    <a href="category.php?id=<?= $link['id'] ?>" class="cat-link <?= ($link['id'] == $section) ? 'active' : '' ?>">
      <span class="cat-icon"><?= $cat_icons[$link['name']] ?? '🍃' ?></span>
      <?= html_escape($link['name']) ?>
    </a>
    <?php endforeach; ?>
  </div>
</nav>

<!-- Article Body -->
<div class="article-body">

  <!-- Breadcrumb -->
  <div class="breadcrumb" style="margin-bottom:24px">
    <a href="index.php">Home</a>
    <span class="sep">›</span>
    <a href="category.php?id=<?= $article['cat_id'] ?>"><?= html_escape($article['category_name']) ?></a>
    <span class="sep">›</span>
    <span><?= html_escape($article['title']) ?></span>
  </div>

  <a href="category.php?id=<?= $article['cat_id'] ?>" class="back-link">
    Back to <?= html_escape($article['category_name']) ?>
  </a>

  <span class="article-category-tag"><?= $icon ?> <?= html_escape($article['category_name']) ?></span>

  <h2 style="font-size:1.6rem;margin-bottom:14px"><?= html_escape($article['summary']) ?></h2>

  <div class="article-content">
    <?= nl2br(html_escape($article['content'])) ?>
  </div>

  <!-- Author Card -->
  <div class="article-author">
    <div class="author-avatar">
      <?php
      $pic_path = 'uploads/' . html_escape($article['member_picture'] ?? '');
      if ($article['member_picture'] && file_exists($pic_path)):
      ?>
        <img src="<?= $pic_path ?>" alt="<?= html_escape($article['forename']) ?>">
      <?php else: ?>
        👤
      <?php endif; ?>
    </div>
    <div class="author-info">
      <div class="name"><?= html_escape($article['forename'] . ' ' . $article['surname']) ?></div>
      <div class="role">Otokoe Team Member · <?= format_date($article['created']) ?></div>
    </div>
  </div>

</div><!-- /.article-body -->

<!-- Related Items -->
<?php if (!empty($related)): ?>
<section style="background:var(--cream);padding:60px 0;">
  <div class="container">
    <div class="section-header">
      <p class="section-label">You Might Also Like</p>
      <h2>More from <?= html_escape($article['category_name']) ?></h2>
    </div>
    <div class="drinks-grid">
      <?php foreach ($related as $item): ?>
      <article class="drink-card" onclick="window.location='article.php?id=<?= $item['id'] ?>'">
        <div class="drink-card-img">
          <?php
          $rel_img = 'uploads/' . html_escape($item['image_file']);
          if ($item['image_file'] && file_exists($rel_img)):
          ?>
            <img src="<?= $rel_img ?>" alt="<?= html_escape($item['image_alt']) ?>" loading="lazy">
          <?php else: ?>
            <div class="img-placeholder"><?= $icon ?></div>
          <?php endif; ?>
        </div>
        <div class="drink-card-body">
          <h3><?= html_escape($item['title']) ?></h3>
          <p><?= html_escape($item['summary']) ?></p>
          <div class="drink-card-footer">
            <a href="article.php?id=<?= $item['id'] ?>" class="btn btn-ghost">View Details</a>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
