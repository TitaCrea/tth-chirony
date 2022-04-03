<?php get_header();

pageBanner(array(
  'altTitle' => 'Manifestations passées', 
  'subtitle' => 'Compte-rendus & galeries photos.'
));

?>

  <div class="container container--narrow page-section">

  <?php // Lesson 34 - on cherche à afficher les Past Events > Custom Query : 
        // we recycle the CQ we used on front-page.php
        // (CQ_1 : grab all 'event' CPT that are scheduled for today or in the future > '>=' )
        // grab all 'event' CPT with 'event_beginning_date' date field before $today > '<'

    $today = date( 'Ymd' );
    $pastEvents = new WP_Query( array(
        // 'posts_per_page' => 1, <-- pas besoin de cette ligne quand nos tests sont terminés > fallback to number of posts displayed in WP Settings
        'paged' => $paged, // Brad > get_query_var( 'paged', 1), 1 = default number - j'ai trouvé ce 'trick' dans les Q&R de la session
        'post_type' => 'event', // seul, ce paramètre renvoie tous les 'event'
        'meta_key'  => 'event_beginning_date',
        'orderby'   => 'meta_value', 
        'type'      => 'DATE', 
        // 'order'     => 'ASC', (l'ordre par défault de WP me convient : du plus 'récent' au plus ancien)
        'meta_query'=> array( 
            array( // 'meta_query' needs an INNER ARRAY per filter condition
            'key'   => 'event_beginning_date',  // field key
            'compare' => '<', // < : before today
            'value' => $today, // to current date ? simplier with a $today variable (code easier to read)
            'type'  => 'DATE',
            ) 
        )
    ) ); 

    while( $pastEvents->have_posts(  ) ) {
        $pastEvents->the_post(  ); ?>

        <div class="event-summary">
          <a class="event-summary__date t-center" href="#">
            <span class="event-summary__day"><?php 
              // Coding with Brad to retrieve MONTH from the 'Ymd' output of the custom field - Lesson #30
              $eventBeginning = new DateTime( get_field( 'event_beginning_date', false, false ) ); // DateTime is a Class, by default returns CURRENT Date & Time 
              echo $eventBeginning->format( 'd' );
            ?>
            </span>
            <span class="event-summary__month"><?php 
              echo $eventBeginning->format( 'M' ); // affiche l'abréviation en anglais > HOW for FRENCH ?
            ?></span>
          </a>
            <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
            <p><?php echo wp_trim_words( get_the_content(), 18 ); ?><a href="<?php the_permalink(); ?>" class="nu gray"> Learn more</a></p>
            </div>
        </div>

    <?php
    }
    // Lesson 34 - paramétrage du template tag 'paginate_links' pour l'ajuster à notre Custom Query CQ_2
    echo paginate_links( array(
        'total' => $pastEvents->max_num_pages, // + ajouter 'paged' => $paged, in the CQ_2 parameters
    ));
  ?>
  </div>


<?php
get_footer();
?>