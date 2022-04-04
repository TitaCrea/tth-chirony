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