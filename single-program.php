<?php
  
  get_header();

  while(have_posts()) {
    the_post(); 
    pageBanner();
    ?>
    
  <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
          <p>
            <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link( 'program' ); ?>"><i class="dashicons dashicons-controls-back"></i> 
            Cours & Stages</a> 
            <span class="metabox__main">Mis en ligne le <?php the_time('d F Y'); ?> 
              in <?php echo get_the_category_list(', '); ?></span>
          </p>
        </div>
    <div class="generic-content">
      <?php the_content(); ?>
    </div>

    <?php
      $relatedEnseignants = new WP_Query( array(
        'posts_per_page' => -1, // -1 will return ALL
        'post_type' => 'enseignant',
        'orderby'   => 'title', // 'rand' for RANDOM, 'title' for alphabetical order following event title
        'order'     => 'ASC', // WP default is 'DESC'
        'meta_query'=> array( // Totally NEW to me : used here to filter events in the PAST or NOT !
          array(
            'key'   => 'related_programs',
            'compare' => 'LIKE', 
            'value' => '"' . get_the_ID() . '"'
          )

        )
      ));

      if ($relatedEnseignants->have_posts() ) {

        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium" >Enseignant.e</h2>';
        echo '<ul class="professor-cards">';

         while( $relatedEnseignants->have_posts() ) {
          $relatedEnseignants->the_post(); ?>
            <li class="professor-card__list-item">
              <a class="professor-card" href="<?php the_permalink(); ?>">
                <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>">
                <span class="professor-card__name">
                  <?php the_title(); ?>
                </span>
              </a>
            </li>
        <?php
        }
        echo '</ul>';
      }

      wp_reset_postdata();


      $today = date( 'Ymd' );
      $futureSessions = new WP_Query( array(
        'posts_per_page' => -1, // -1 will return ALL
        'post_type' => 'session',
        'meta_key'  => 'session_date',
        'orderby'   => 'meta_value', // 'rand' for RANDOM, 'title' for alphabetical order following event title
        'type'      => 'DATE', // Course bug fixed with 'meta_value' (not 'meta_value_num') and this new line with 'type' => 'DATE',
        'order'     => 'ASC', // WP default is 'DESC'
        'meta_query'=> array( // Totally NEW to me : used here to filter events in the PAST or NOT !
          array( // 'meta_query' needs an INNER ARRAY per filter condition
            'key'   => 'session_date',  // field key
            'compare' => '>=', // < ou = 
            'value' => $today, // to current date ? simplier with a $today variable (code easier to read)
            'type'  => 'DATE',
          ),
          array(
            'key'   => 'related_programs',
            'compare' => 'LIKE', 
            'value' => '"' . get_the_ID() . '"'
          )

        )
      ));

      if ($futureSessions->have_posts() ) {

        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium" >Prochaine(s) session(s) :</h2>';

        while( $futureSessions->have_posts() ) {
          $futureSessions->the_post(); 
          
          get_template_part( 'template-parts/content-session' );

        }

      }

      wp_reset_postdata();
      ?>

  <hr class="section-break">
      <p class="notes-webdev">
        Note WEBDEV : cr??er bouton "inscription ?? la prochaine s??rie"<br>
        OU "il reste des places pour le prochain cours (ou s??rie)"<br>
        avec IF statement et/ou new WP_Query : si la prochaine s??rie existe = si les inscriptions sont ouvertes, le bouton s'affiche et pointe vers le 'programme' suivant du m??me enseignant
      </p>
  </div>

  

  <?php }

  get_footer();

?>