<?php get_header();

if (is_category()) {
  $theTitle = single_cat_title('', false) . " Posts";
} elseif (is_author()) {
  $theTitle = "Publications de " . get_the_author();
} else {
  $theTitle = "Dans la rubrique " . get_the_archive_title(); 
}
pageBanner(array(
  'altTitle' => $theTitle, 
  'subtitle' => get_the_archive_description(),
  'photo' => get_theme_file_uri( '/images/apples-2.jpg' ),

));

?>

  <div class="container container--narrow page-section">
  <?php
    while( have_posts(  ) ) {
      the_post(  ); ?>

      <div class="post-item">
        <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

        <div class="metabox">
          <p>Posted by <?php the_author_posts_link(); ?> 
              on <?php the_time('d F Y'); ?> 
              in <?php echo get_the_category_list(', '); ?>
            </p>
        </div>

        <div class="generic-content">
          <?php the_excerpt(); ?>
          <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
        </div>



    
      </div>

    <?php
    }

    echo paginate_links();
  ?>
  </div>


<?php
get_footer();
?>