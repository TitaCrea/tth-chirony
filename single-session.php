<?php
  
  get_header();

  while(have_posts()) {
    the_post(); ?>

  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri( '/images/apples.jpg' ); ?>)"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title(); ?></h1>
      <div class="page-banner__intro">
        <p>Présentation 'single' d'une session.</p>
      </div>
    </div>
  </div>
    
  <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
          <p>
            <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link( 'session' ); ?>"><i class="dashicons dashicons-welcome-learn-more"></i> 
            Cours </a> 
            <span class="metabox__main">Mis en ligne le <?php the_time('d F Y'); ?> 
              in <?php echo get_the_category_list(', '); ?></span>
          </p>
        </div>
    <div class="generic-content">
      <?php the_content(); ?>

      <?php 
        $relatedProgram = get_field( 'related_programs' );
        // trick to display what is the declared variable : print_r($relatedProgram);
        // a RELATION field returns an array of WP Objects of 1 or several 'related_programs' (link to another item)
        // SO we need a FOREACH Loop !
        foreach( $relatedProgram as $session ) { ?>

            <li><a href="<?php echo get_the_permalink($session); ?>"><?php echo get_the_title($session); ?></a></li>

        <?php

        }
        
        ?>


    </div>
  </div>

  

  <?php }

  get_footer();

?>