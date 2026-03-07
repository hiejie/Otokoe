<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Database error</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
  </head>
  <body style="padding: 3rem">
  <h1>You are not connected to the database, let's try to fix that...</h1>
  <p>First, this is what we think might be the issue:</p>
  <?php
    switch ($e->getCode()) {
        case 2002: echo '<p>The value for <code>$server</code> is incorrect. Try <code>localhost</code> or <code>127.0.0.1</code>.</p>'; break;
        case 1045: echo '<p>The username or password appear to be wrong.</p>'; break;
        case 1049: echo '<p>The value for <code>$db</code> is incorrect. Check the database name in phpMyAdmin.</p>'; break;
        default: echo '<p>Check that you have created the database and user account.</p>'; break;
    }
  ?>
  <p><b>SQLSTATE error code:</b> <?= $e->getCode() ?></p>
  <p><b>Error message: </b><?= $e->getMessage() ?></p>
  <?php exit; ?>
  </body>
</html>
