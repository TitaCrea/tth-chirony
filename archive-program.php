<?php get_header();

// Replace div.page-banner (hard coding) by pageBanner function (Lesson #46)
pageBanner( array(
  'altTitle' => 'Programme des cours',
  'subtitle' => 'Sauf indication contraire, les cours sont ouverts aux membres et non-membres.',
));

?>

  <div class="container container--narrow page-section">

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