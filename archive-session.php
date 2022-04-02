<?php get_header();
  ?>

  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri( '/images/apples.jpg' ); ?>)"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title">Prochains Cours</h1>
      <div class="page-banner__intro">
        <p>Dans le cadre de nos programmes, voici les prochaines sessions.</p>
      </div>
    </div>
  </div>

  <div class="container container--narrow page-section">
  <?php
    // Lesson #28 - Displaying CPT Events > new WP Query
    // Lesson #32 - Our Custom Query
    $today = date( 'Ymd' );
    $sessionFuture = new WP_Query( array(
        'posts_per_page' => -1, // -1 will return ALL
        'paged' => $paged,
        // BUG !! la pagination apparaît, la session la plus proche dans le temps s'affiche, mais les liens renvoient à archive.php (Welcome to Our Blog)
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
        ) 
        )
    ));

    while( $sessionFuture->have_posts() ) {
        $sessionFuture->the_post(); ?>
        <!-- HTML for displaying data in the query -->

        <div class="event-summary">
          <a class="event-summary__date t-center" href="#">
            <span class="event-summary__day"><?php 
              // Coding with Brad to retrieve MONTH from the 'Ymd' output of the custom field - Lesson #30
              $sessionDay = new DateTime( get_field( 'session_date', false, false ) ); // DateTime is a Class, by default returns CURRENT Date & Time 
              echo $sessionDay->format( 'd' );
            ?>
            </span>
            <span class="event-summary__month"><?php 
              echo $sessionDay->format( 'M' ); // affiche l'abréviation en anglais > HOW for FRENCH ?
            ?></span>
          </a>
            <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
            <p><?php echo wp_trim_words( get_the_content(), 18 ); ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
            </div>
        </div>

    <?php
    }

    echo paginate_links( array(
        'total' => $sessionFuture->max_num_pages,
    ));
  ?>

    <hr class="section-break">

    <p>Les sessions récemment terminées peuvent être <a href="<?php echo site_url('/past-sessions'); ?>">consultées sur notre page d'archive.</a></p>

  </div>


<?php
get_footer();
?>