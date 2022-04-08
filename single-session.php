<?php
  
  get_header();

  while(have_posts()) {
    the_post(); 
    pageBanner();
    
    ?>

    
  <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
          <p>
            <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link( 'session' ); ?>"><i class="dashicons dashicons-controls-back"></i> 
            Cours </a> 
            <span class="metabox__main">Mis en ligne le <?php the_time('d F Y'); ?> 
              in <?php echo get_the_category_list(', '); ?></span>
          </p>
        </div>
    <div class="generic-content">
      <?php the_content(); ?>

      <?php
        $relatedPlaces = get_field('related_place');
        if ($relatedPlaces) {
          echo '<hr class="section-break">';
          echo '<p class="">Lieu de la session :</p>';
          echo '<ul class="link-list min-list">';
          foreach($relatedPlaces as $place) { ?>
            <li><a href="<?php echo get_the_permalink($place); ?>"><?php echo get_the_title($place); ?></a></li>
          <?php }
          echo '</ul>';
        }
        
        $relatedPrograms = get_field('related_programs');
        if ($relatedPrograms) {
          echo '<hr class="section-break">';
          echo '<p class="">Cette session fait partie du cours :</p>';
          echo '<ul class="link-list min-list">';
          foreach($relatedPrograms as $program) { ?>
            <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
          <?php }
          echo '</ul>';
        }
        wp_reset_postdata();
      ?>


    </div>
  </div>

  

  <?php }

  get_footer();

?>