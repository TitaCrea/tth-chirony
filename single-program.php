<?php
  
  get_header();

  while(have_posts()) {
    the_post(); ?>

  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri( '/images/apples.jpg' ); ?>)"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title(); ?></h1>
      <div class="page-banner__intro">
        <p><?php the_field('program_subtitle'); ?></p>
      </div>
    </div>
  </div>
    
  <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
          <p>
            <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link( 'program' ); ?>"><i class="dashicons dashicons-calendar-alt"></i> 
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
        echo '<h2 class="headline headline--medium" >Infos ++</h2>';

        while( $relatedEnseignants->have_posts() ) {
          $relatedEnseignants->the_post(); ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br>
              En savoir plus sur l'enseignant.e <?php the_field('enseignant_name'); ?>.</li>

        <?php
        }

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
          $futureSessions->the_post(); ?>
            <!-- HTML for displaying data in the query -->
            <div class="event-summary">
              <a class="event-summary__date t-center" href="#">
                <span class="event-summary__day"><?php 
                  // Coding with Brad to retrieve MONTH from the 'Ymd' output of the custom field - Lesson #30
                  $sessionBeginning = new DateTime( get_field( 'session_date', false, false ) ); // DateTime is a Class, by default returns CURRENT Date & Time 
                  echo $sessionBeginning->format( 'd' );
                ?>
                </span>
                <span class="event-summary__month"><?php 
                  echo __( $sessionBeginning->format( 'M' ) ); // affiche l'abréviation en anglais > HOW for FRENCH ?
                ?></span>
              </a>
              <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <p><?php if( has_excerpt() ) { // OR the_excerpt EITHER 18 first words from the_content
                    echo get_the_excerpt();
                      } 
                    else {
                      echo wp_trim_words( get_the_content(), 18 );
                    } ?>
                    <a href="<?php the_permalink(); ?>" class="nu gray">En savoir plus &raquo;</a></p>
              </div>
            </div>

        <?php
        }

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

  

  <?php }

  get_footer();

?>