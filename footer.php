    <footer class="site-footer">
      <div class="site-footer__inner container container--narrow">
        <div class="group">
          <div class="site-footer__col-one">
            <h1 class="school-logo-text school-logo-text--alt-color">
              <a href="<?php echo site_url() ?>"><strong>Amicale &Eacute;questre</strong><br>Vall&eacute;e de Joux</a>
            </h1>
            <p><a class="site-footer__link" href="#">555.555.5555</a></p>
            <p class="site-footer__text">Sauf mention, les photos d'illustration sont issues du site <a href="https://unsplash.com" target="_blank">Unsplash.com</a>. Vous en trouverez la liste nominative sur la page <a href='/credit-photos'>Crédit photos</a>.</p>
          </div>

          <div class="site-footer__col-two-three-group">
            <div class="site-footer__col-two">
              <h3 class="headline headline--small">Explore</h3>
              <nav class="nav-list">
                <ul>
                  <li><a href="<?php echo site_url('/about-us') ?>">About Us</a></li>
                  <li><a href="#">Programs</a></li>
                  <li><a href="#">Events</a></li>
                  <li><a href="#">Campuses</a></li>
                  <li><a href="#">Blog</a></li>
                </ul>
              </nav>
            </div>

            <div class="site-footer__col-three">
              <h3 class="headline headline--small">Learn</h3>
              <nav class="nav-list">
                <ul>
                  <li><a href="<?php echo site_url('/privacy-policy') ?>">Privacy Policy</a></li>
                  <li><a href="#">Programs</a></li>
                  <li><a href="#">Events</a></li>
                  <li><a href="#">Campuses</a></li>
                  <li><a href="#">Blog</a></li>
                </ul>
              </nav>

            </div>
          </div>

          <div class="site-footer__col-four">
            <h3 class="headline headline--small">Connect With Us</h3>
            <nav>
              <ul class="min-list social-icons-list group">
                <li>
                  <a href="#" class="social-color-facebook"><i class="fa-brands fa-facebook" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="#" class="social-color-twitter"><i class="fa-brands fa-twitter" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="#" class="social-color-youtube"><i class="fa-brands fa-youtube" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="#" class="social-color-linkedin"><i class="fa-brands fa-linkedin" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="#" class="social-color-instagram"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </footer>

    <!-- Lesson #59 -->
    <div class="search-overlay">
      <div class="search-overlay__top">
        <div class="container">
          <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
          <input type="text" id="search-term" class="search-term" placeholder="Que cherchez-vous ?">
          <i class="fa fa-window-close search-overlay__close" aria-hidden="false"></i>

        </div>
      </div>
    </div>

<?php 
    // appelle la barre d'admin si user is login in
    // l'endroit des scripts JS
    wp_footer(); ?>
</body>
</html>