<?php get_header();

  pageBanner(array(
    'altTitle' => 'Sessions terminés', 
    'subtitle' => 'Le lieu pour un feedback personnalisé.'
  ));

  ?>

  <div class="container container--narrow page-section">

  <?php

    $today = date( 'Ymd' );
    $pastSessions = new WP_Query( array(
        'posts_per_page' => 6, // pas besoin de cette ligne quand nos tests sont terminés > fallback to number of posts displayed in WP Settings
        'paged' => $paged, // Brad > get_query_var( 'paged', 1), 1 = default number - j'ai trouvé ce 'trick' dans les Q&R de la session
        'post_type' => 'session', // seul, ce paramètre renvoie tous les 'event'
        'meta_key'  => 'session_date',
        'orderby'   => 'meta_value', 
        'type'      => 'DATE', 
        // 'order'     => 'ASC', (l'ordre par défault de WP me convient : du plus 'récent' au plus ancien)
        'meta_query'=> array( 
            array( // 'meta_query' needs an INNER ARRAY per filter condition
            'key'   => 'session_date',  // field key
            'compare' => '<', // < : before today
            'value' => $today, // to current date ? simplier with a $today variable (code easier to read)
            'type'  => 'DATE',
            ) 
        )
    ) ); 

    while( $pastSessions->have_posts(  ) ) {
        $pastSessions->the_post(  ); ?>

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
            <p><?php echo wp_trim_words( get_the_content(), 18 ); ?><a href="<?php the_permalink(); ?>" class="nu gray"> Learn more</a></p>
            </div>
        </div>

    <?php
    }

    echo paginate_links( array(
        'total' => $pastSessions->max_num_pages,
    ));
  ?>

  </div>


<?php
get_footer();
?>