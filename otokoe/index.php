<?php
declare(strict_types = 1);
require_once 'includes/database-connection.php';
require_once 'includes/functions.php';

// Navigation categories
$sql        = "SELECT id, name FROM category WHERE navigation = 1;";
$navigation = pdo($pdo, $sql)->fetchAll();
$section    = 0;
$title       = 'Welcome to Otokoe Coffee';
$description = 'Handcrafted coffee. Premium quality. Cozy vibes. Visit Otokoe for the finest coffee experience.';

// Featured drinks — grab 6 published articles with images
$sql_featured = "
    SELECT a.id, a.title, a.summary, a.image_id, i.file AS image_file, i.alt AS image_alt, c.name AS category_name
    FROM article a
    LEFT JOIN image i ON a.image_id = i.id
    LEFT JOIN category c ON a.category_id = c.id
    WHERE a.published = 1 AND a.image_id IS NOT NULL
    ORDER BY a.created DESC
    LIMIT 6
";
$featured = pdo($pdo, $sql_featured)->fetchAll();

// Category icons map
$cat_icons = [
    'Hot Coffee'       => '☕',
    'Cold Coffee'      => '🧊',
    'Pastries'         => '🥐',
    'Specialty Drinks' => '✨',
];

require_once 'includes/header.php';
?>

<!-- =============================================
     HERO SECTION
     ============================================= -->
<section class="hero">
  <div class="hero-bg"></div>

  <div class="container">
    <div class="hero-content">
      <div class="hero-badge">Now Serving — Spring Collection</div>
      <h1>Brew Corner<br><em>Coffee</em></h1>
      <p class="hero-tagline">Handcrafted coffee. Premium quality. Cozy vibes.</p>
      <div class="hero-cta">
        <a href="#menu" class="btn btn-primary">View Menu</a>
        <a href="#about" class="btn btn-outline">Our Story</a>
      </div>
    </div>

    <!-- Floating accent cards -->
    <div class="hero-accent">
      <div class="hero-accent-card">
        <div class="card-icon">🌿</div>
        <div class="card-title">Sustainably Sourced</div>
        <div class="card-value">100% Arabica</div>
      </div>
      <div class="hero-accent-card">
        <div class="card-icon">⭐</div>
        <div class="card-title">Customer Rating</div>
        <div class="card-value">4.9 / 5.0</div>
      </div>
    </div>
  </div>

  <div class="hero-scroll">Scroll</div>
</section>

<!-- =============================================
     CATEGORY STRIP NAV
     ============================================= -->
<nav class="category-strip" aria-label="Menu categories">
  <div class="container">
    <a href="index.php" class="cat-link active">
      <span class="cat-icon">🏠</span> Home
    </a>
    <?php foreach ($navigation as $link): ?>
    <a href="category.php?id=<?= $link['id'] ?>" class="cat-link">
      <span class="cat-icon"><?= $cat_icons[$link['name']] ?? '🍃' ?></span>
      <?= html_escape($link['name']) ?>
    </a>
    <?php endforeach; ?>
  </div>
</nav>

<!-- =============================================
     FEATURED DRINKS
     ============================================= -->
<section class="featured" id="menu">
  <div class="container">
    <div class="section-header">
      <p class="section-label">Our Signature Selection</p>
      <h2>Featured Drinks &amp; Treats</h2>
      <p>Explore our handcrafted beverages and freshly baked goods, made fresh every day with premium ingredients.</p>
    </div>

    <div class="drinks-grid">
      <?php foreach ($featured as $item): ?>
      <article class="drink-card" onclick="window.location='article.php?id=<?= $item['id'] ?>'">
        <div class="drink-card-img">
          <?php
          $img_path = 'uploads/' . html_escape($item['image_file']);
          if ($item['image_file'] && file_exists($img_path)):
          ?>
            <img src="<?= $img_path ?>" alt="<?= html_escape($item['image_alt']) ?>" loading="lazy">
          <?php else: ?>
            <div class="img-placeholder">
              <?php
              $icons = ['Hot Coffee'=>'☕','Cold Coffee'=>'🧊','Pastries'=>'🥐','Specialty Drinks'=>'✨'];
              echo $icons[$item['category_name']] ?? '☕';
              ?>
              <span><?= html_escape($item['title']) ?></span>
            </div>
          <?php endif; ?>
          <span class="card-badge"><?= html_escape($item['category_name']) ?></span>
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

<!-- =============================================
     ABOUT SECTION
     ============================================= -->
<section class="about" id="about">
  <div class="container">
    <div class="about-grid">
      <div class="about-img">
        <img
          src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800&q=80"
          alt="Barista preparing coffee at Otokoe"
          loading="lazy"
          onerror="this.parentElement.innerHTML='<div class=\'img-placeholder\' style=\'height:100%\'>☕<span>Our Baristas at Work</span></div>'"
        >
        <div class="about-img-frame"></div>
      </div>

      <div class="about-text">
        <p class="section-label">Our Story</p>
        <h2>More Than Coffee.<br>It's a Feeling.</h2>
        <p>Otokoe was born from a simple belief — that a great cup of coffee should feel like a warm hug. We source our beans from sustainable farms around the world, roasting each batch in-house to unlock their full, complex flavors.</p>
        <p>From our first espresso pour to the last pastry out of the oven each morning, every detail is crafted with care. We believe in slow mornings, good conversations, and coffee that means something.</p>

        <div class="about-stats">
          <div class="stat-item">
            <div class="stat-number">24+</div>
            <div class="stat-label">Menu Items</div>
          </div>
          <div class="stat-item">
            <div class="stat-number">4</div>
            <div class="stat-label">Categories</div>
          </div>
          <div class="stat-item">
            <div class="stat-number">100%</div>
            <div class="stat-label">Handcrafted</div>
          </div>
        </div>

        <br>
        <a href="category.php?id=1" class="btn btn-primary">Explore Our Menu</a>
      </div>
    </div>
  </div>
</section>

<!-- =============================================
     STORE INFO
     ============================================= -->
<section class="store-info">
  <div class="container">
    <div class="section-header">
      <p class="section-label">Find Us</p>
      <h2>Visit Otokoe</h2>
      <p>We're conveniently located in the heart of the city. Come say hello — we'd love to make you your perfect cup.</p>
    </div>

    <div class="store-cards">
      <div class="store-card">
        <div class="store-card-icon">📍</div>
        <h3>Location</h3>
        <address>
          123 Brew Lane<br>
          Coffee District<br>
          Manila, Philippines
        </address>
      </div>

      <div class="store-card">
        <div class="store-card-icon">🕐</div>
        <h3>Opening Hours</h3>
        <p>
          Mon – Fri: 7:00 AM – 9:00 PM<br>
          Saturday: 8:00 AM – 10:00 PM<br>
          Sunday: 9:00 AM – 8:00 PM
        </p>
      </div>

      <div class="store-card">
        <div class="store-card-icon">📞</div>
        <h3>Get in Touch</h3>
        <p>
          📧 hello@otokoe.com<br>
          📱 +63 917 123 4567<br>
          Free Wi-Fi available
        </p>
      </div>
    </div>

</section>

<!-- =============================================
     CTA BANNER
     ============================================= -->
<section class="cta-banner">
  <div class="container">
    <p class="section-label" style="color:rgba(255,255,255,0.7);">Don't Miss Out</p>
    <h2>Ready for Your Perfect Cup?</h2>
    <p>Browse our full menu and discover your new favourite drink — from bold espressos to refreshing cold brews.</p>
    <a href="category.php?id=1" class="btn btn-white">See Full Menu →</a>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
