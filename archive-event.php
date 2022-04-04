<?php get_header();

// Replace div.page-banner (hard coding) by pageBanner function (Lesson #46)
pageBanner( array(
  'altTitle' => 'Festivités 20&apos;22',
  'subtitle' => 'Nous vous attendons nombreux pour célébrer avec nous les 20 ans de notre société.',
));

  ?>

  <div class="container container--narrow page-section">
  <?php
    while( have_posts(  ) ) {
      the_post(  ); 
      
      get_template_part( 'template-parts/content-event' );
    }

    echo paginate_links();
  ?>

    <hr class="section-break">

    <p>Looking for a recap of past events ? <a href="<?php echo site_url('/past-events'); ?>">Check out our past events archive.</a></p>

  </div>


<?php
get_footer();
?>