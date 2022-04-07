<?php
  
  get_header();

  while(have_posts()) {
    the_post();
    pageBanner();
     ?>

    
  <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
          <p>
            <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link( 'event' ); ?>"><i class="dashicons dashicons-controls-back"></i> 
            Manifestations </a> 
            <span class="metabox__main">Mis en ligne le <?php the_time('d F Y'); ?> 
              in <?php echo get_the_category_list(', '); ?></span>
          </p>
        </div>
    <div class="generic-content">
      <?php the_content(); ?>
    </div>
  </div>

  

  <?php }

  get_footer();

?>