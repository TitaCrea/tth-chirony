<?php get_header();
  ?>

  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri( '/images/apples.jpg' ); ?>)"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title">Cours organisés par l'Amicale</h1>
      <div class="page-banner__intro">
        <p>Faites votre choix !</p>
      </div>
    </div>
  </div>

  <div class="container container--narrow page-section">
    <p>Nous sommes heureux de vous présenter les disciplines enseignées au sein de notre société.</p>
    <p>Sauf indication contraire, les cours sont ouverts aux membres et non-membres.</p>
    <ul class="link-list min-list"> <!-- --ul-- englobe la Loop, puis --li-- à l'intérieur de la Loop -->
      <?php
        while( have_posts(  ) ) {
          the_post(  ); ?>

          <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>

        <?php
        }

        echo paginate_links();
      ?>
    </ul>

  </div>


<?php
get_footer();
?>