<?php
declare(strict_types = 1);
http_response_code(404);
require_once 'includes/database-connection.php';
require_once 'includes/functions.php';

$sql        = "SELECT id, name FROM category WHERE navigation = 1;";
$navigation = pdo($pdo, $sql)->fetchAll();
$section     = '';
$title       = 'Page Not Found';
$description = 'Sorry, we could not find the page you are looking for.';
?>
<?php require_once 'includes/header.php'; ?>

<div style="padding-top: 72px;">
  <section class="not-found">
    <div class="container">
      <div class="not-found-inner">
        <div class="big-num">404</div>
        <h1>Page Not Found</h1>
        <p>Sorry! We cannot find that page. The page may have moved or doesn't exist.</p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
          <a href="index.php" class="btn btn-primary">← Back to Home</a>
          <a href="category.php?id=1" class="btn btn-ghost">View Menu</a>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once 'includes/footer.php'; ?>
