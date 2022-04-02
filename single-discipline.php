<?php
  
  get_header();

  while(have_posts()) {
    the_post(); ?>

  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri( '/images/apples.jpg' ); ?>)"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title(); ?></h1>
      <div class="page-banner__intro">
        <p>Enseignement de <strong><?php the_field('discipline_teacher'); ?></strong></p>
      </div>
    </div>
  </div>
    
  <div class="container container--narrow page-section">
    <!-- suppression lesson #40
        <div class="metabox metabox--position-up metabox--with-home-link">
          <p>
            <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link( 'event' ); ?>"><i class="dashicons dashicons-calendar-alt"></i> 
            Recent Events </a> 
            <span class="metabox__main">Mis en ligne le <?php the_time('d F Y'); ?> 
              in <?php echo get_the_category_list(', '); ?></span>
          </p>
        </div> -->
    <div class="generic-content">
      <div class="row group">
        
        <div class="two-thirds">
          <?php the_content( ); ?>
          <hr>
          <?php the_field ('dummy_field'); ?>
        </div>
        <div class="one-third">
          <?php the_post_thumbnail( ); ?>
          <p>avec <?php the_field('discipline_teacher'); ?></p>
        </div>
      </div>

      <?php
        $relatedPrograms = get_field('related_programs');
        if ($relatedPrograms) {
          echo '<hr class="section-break">';
          echo '<p class="">Cours actuel(s) :</p>';
          echo '<ul class="link-list min-list">';
          foreach($relatedPrograms as $program) { ?>
            <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
          <?php }
          echo '</ul>';
        }
        wp_reset_postdata();
      ?>

    <hr class="section-break">
      <p class="notes-webdev">
        Note WEBDEV : créer bouton "inscription à la prochaine série"<br>
        OU "il reste des places pour le prochain cours (ou série)"<br>
        avec IF statement et/ou new WP_Query : si la prochaine série existe = si les inscriptions sont ouvertes, le bouton s'affiche et pointe vers le 'programme' suivant du même enseignant
      </p>

    </div>
  </div>

  

  <?php }

  get_footer();

?>