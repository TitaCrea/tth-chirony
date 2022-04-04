<?php get_header();

// Replace div.page-banner (hard coding) by pageBanner function (Lesson #46)

pageBanner( array(
  'altTitle' => 'Prochaines sessions',
  'subtitle' => 'Dans le cadre de notre programme de cours, voici les prochaines dates agendées.',
));

?>

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
        $sessionFuture->the_post(); 
        
        get_template_part( 'template-parts/content', get_post_type() );
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
