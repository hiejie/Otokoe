    <footer>
      <div class="container">

        <div class="footer-grid">
          <!-- Brand -->
          <div class="footer-brand">
            <div class="logo-text">Otokoe</div>
            <p>Handcrafted coffee made with passion, premium beans, and a whole lot of love. Visit us and experience the warmth of Otokoe.</p>
          </div>

          <!-- Links -->
          <div class="footer-col">
            <h4>Menu</h4>
            <ul>
              <?php foreach ($navigation as $link) { ?>
              <li><a href="category.php?id=<?= $link['id'] ?>"><?= html_escape($link['name']) ?></a></li>
              <?php } ?>
            </ul>
          </div>

          <!-- Newsletter -->
          <div class="footer-col">
            <h4>Stay Updated</h4>
            <p style="font-size:0.86rem;margin-bottom:14px;line-height:1.6;">Get our latest offers and seasonal specials straight to your inbox.</p>
            <div class="newsletter-form">
              <input type="email" class="newsletter-input" placeholder="your@email.com" aria-label="Email address">
              <button class="newsletter-btn">→</button>
            </div>
          </div>
        </div><!-- /.footer-grid -->

        <div class="footer-bottom">
          <span>&copy; Otokoe Coffee <?= date('Y') ?>. All rights reserved.</span>
        </div>

      </div><!-- /.container -->
    </footer>

    <script src="js/site.js"></script>
  </body>
</html>
