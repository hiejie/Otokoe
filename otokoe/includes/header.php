<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= html_escape($title) ?> — Otokoe Coffee</title>
    <meta name="description" content="<?= html_escape($description) ?>">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap">
  </head>
  <body>
    <header id="site-header">
      <div class="container">

        <div class="logo">
          <a href="index.php">
            <span class="logo-icon">☕</span>
            Otokoe
          </a>
        </div>

        <nav>
          <button id="toggle-navigation" aria-expanded="false">
            <span>☰</span><span class="hidden">Menu</span>
          </button>
          <ul id="menu">
            <?php foreach ($navigation as $link) { ?>
            <li><a href="category.php?id=<?= $link['id'] ?>"
              <?= (isset($section) && $section == $link['id']) ? 'class="on" aria-current="page"' : '' ?>>
              <?= html_escape($link['name']) ?>
            </a></li>
            <?php } ?>
            <li><a href="search.php" class="nav-search">
              <span>🔍</span><span class="search-text">Search</span>
            </a></li>
          </ul>
        </nav>

      </div><!-- /.container -->
    </header>
