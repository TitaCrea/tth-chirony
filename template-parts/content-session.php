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
    <p><?php echo wp_trim_words( get_the_content(), 18 ); ?><a href="<?php the_permalink(); ?>" class="nu gray"> Info++</a></p>
    </div>
</div>
