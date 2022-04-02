<?php get_header();
?>

    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri( '/images/library-hero.png') ?>;"></div>
      <div class="page-banner__content container t-center c-white">
        <h2 class="headline headline--medium">Amicale &Eacute;questre de la Vallée de Joux</h2>
        <h1 class="headline headline--large">Bienvenue !</h1>
        <h3 class="headline headline--small"></h3>
        <a href="<?php echo get_post_type_archive_link('program'); ?>" class="btn btn--large btn--blue">ACTUEL ! Notre programme de cours</a>
      </div>
    </div>

    <div class="full-width-split group">
      <div class="full-width-split__one">
        <div class="full-width-split__inner">
          <h2 class="headline headline--small-plus t-center">20'22 : nous Jubilons !!</h2>

          <?php
            // Lesson #28 - Displaying CPT Events > new WP Query
            // Lesson #32 - Our Custom Query
            $today = date( 'Ymd' );
            $homepageEvents = new WP_Query( array(
              'posts_per_page' => 2, // -1 will return ALL
              'post_type' => 'event',
              'meta_key'  => 'event_beginning_date',
              'orderby'   => 'meta_value', // 'rand' for RANDOM, 'title' for alphabetical order following event title
              'type'      => 'DATE', // Course bug fixed with 'meta_value' (not 'meta_value_num') and this new line with 'type' => 'DATE',
              'order'     => 'ASC', // WP default is 'DESC'
              'meta_query'=> array( // Totally NEW to me : used here to filter events in the PAST or NOT !
                array( // 'meta_query' needs an INNER ARRAY per filter condition
                  'key'   => 'event_beginning_date',  // field key
                  'compare' => '>=', // < ou = 
                  'value' => $today, // to current date ? simplier with a $today variable (code easier to read)
                  'type'  => 'DATE',
                ),
                array( // ajout Tita : 2e Inner Array for the meta_query : seulement les 'events' dont le champ 'contenu-reserve' est vide == public
                  'key'   => 'contenu-reserve',
                  'compare' => 'NOT EXISTS',
                ) 
              )
            ));

            while( $homepageEvents->have_posts() ) {
              $homepageEvents->the_post(); ?>
                <!-- HTML for displaying data in the query -->
                <div class="event-summary">
                  <a class="event-summary__date t-center" href="#">
                    <span class="event-summary__day"><?php 
                      // Coding with Brad to retrieve MONTH from the 'Ymd' output of the custom field - Lesson #30
                      $eventBeginning = new DateTime( get_field( 'event_beginning_date', false, false ) ); // DateTime is a Class, by default returns CURRENT Date & Time 
                      echo $eventBeginning->format( 'd' );
                    ?>
                    </span>
                    <span class="event-summary__month"><?php 
                      echo __( $eventBeginning->format( 'M' ) ); // affiche l'abréviation en anglais > HOW for FRENCH ?
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
            wp_reset_postdata();
            ?>

            <!-- BUTTON All Events > get_post_type_archive_link( 'post_type_name' ) -->
          <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link( 'event' ); ?>" class="btn btn--blue">Tout sur les Festivités 20'22 &raquo;</a></p>
        </div>
      </div>
      <div class="full-width-split__two">
        <div class="full-width-split__inner">
          <h2 class="headline headline--small-plus t-center">Derniers articles du blog</h2>

          <?php // our first custom query - Lesson #24
            $latestposts = new WP_Query(array(
              // no number at the beginning of the var name
              // associative array made with the WP_Query to interrogate ($args)
              'posts_per_page' => 2,
            )); 
            /**
            * we declare a new instance of WP Class (familier à la programmation orientée Objet)
            * A Class is like a Blue Print (** un CHABLON, un PATRON de couture **) or a recipe that we can use again and again to create different Objects.
            * exemple with $dog and $cat in a new instance Animal() <-- the Class Animal() offers to Objects $dog and $cat functions and methods, for example 'drink water' (because it's common to both, they (can) share the same instance)
            * then look into the Object with -> and call the function()
            *      $dog->drinkWater();
            * the code for the Class Animal() could be saved in an other file and once created we can just forget it.
            * inside () <-- tell the Class what type of content do we need / query
            * --> array of arguments (associative array) to tell what we want to 'grab'
            * and THEN, within the while loop, we INDICATES the variable it has to address to the generic have_posts() !!!
            * and the same for the_post();
            */


            while( $latestposts->have_posts() ) { 
              $latestposts->the_post(); // this GETS proper all data ready
                // now we are free to do something with the posts
                ?>
                  <div class="event-summary">
                    <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink() ?>">
                      <span class="event-summary__day"><?php the_time( 'd' ) ?></span>
                      <span class="event-summary__month"><?php the_time( 'M' ) ?></span>
                    </a>
                    <div class="event-summary__content">
                      <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h5>
                      <p><?php if( has_excerpt() ) { // SPECIAL Brad's Tip
                        echo get_the_excerpt(); // replace the_excerpt() that has 'space around'.
                         } 
                        else {
                          echo wp_trim_words( get_the_content(), 18 );
                        } ?>
                        <a href="<?php the_permalink(); ?>" class="nu gray">Lire la suite &raquo;</a></p>
                    </div>
                  </div>

            <?php
              }
              wp_reset_postdata(  );
            ?>

          <!-- <div class="event-summary">
            <a class="event-summary__date event-summary__date--beige t-center" href="#">
              <span class="event-summary__month">Jan</span>
              <span class="event-summary__day">20</span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h5>
              <p>For the 100th year in a row we are voted #1. <a href="#" class="nu gray">Read more</a></p>
            </div>
          </div> -->
          <!-- <div class="event-summary">
            <a class="event-summary__date event-summary__date--beige t-center" href="#">
              <span class="event-summary__month">Feb</span>
              <span class="event-summary__day">04</span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="#">Professors in the National Spotlight</a></h5>
              <p>Two of our professors have been in national news lately. <a href="#" class="nu gray">Read more</a></p>
            </div>
          </div> -->

          <!-- BUTTON View all Blog posts : echo site_url( '/blog' ) -->
          <p class="t-center no-margin"><a href="<?php echo site_url('/blog'); ?>" class="btn btn--yellow">Tous les Articles &raquo;</a></p>
        </div>
      </div>
    </div>

    <div class="hero-slider">
      <div data-glide-el="track" class="glide__track">
        <div class="glide__slides">
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri( 'images/bus.jpg' ) ?>;">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">Free Transportation</h2>
                <p class="t-center">All students have free unlimited bus fare.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri( 'images/apples.jpg' ) ?>;">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">An Apple a Day</h2>
                <p class="t-center">Our dentistry program recommends eating apples.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri( 'images/bread.jpg' ) ?>;">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">Free Food</h2>
                <p class="t-center">Fictional University offers lunch plans for those in need.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
        </div>
        <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
      </div>
    </div>


<?php
  get_footer();

?>