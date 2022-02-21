<?php

  get_header();

  while(have_posts()) {
    the_post(); ?>

    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri( '/images/ocean.jpg' ); ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title(); ?></h1>
        <div class="page-banner__intro">
          <p>DON'T FORGET TO REPLACE ME LATER</p>
        </div>
      </div>
    </div>

    <div class="container container--narrow page-section"> <!-- the breadcrumbs box lesson 15 -->

    <?php 
      $theParent = wp_get_post_parent_id( get_the_ID() );
      if ( $theParent ) { ?>
        <div class="metabox metabox--position-up metabox--with-home-link">
          <p>
            <a class="metabox__blog-home-link" href="<?php echo get_permalink( $theParent ); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title( $theParent ); ?></a> <span class="metabox__main"><?php the_title() ?></span>
          </p>
        </div>
        <?php }
      ?>

      <?php 
        // je veux afficher le container .page-links 
        // CONDITION: seulement pour les pages qui sont parent OU enfant
        // je veux le masquer pour les pages 'orphelines' (ni parent, ni enfant)

        $beParent = get_pages( array(
          'child_of'  =>  get_the_ID(),
        ));

        if( $theParent or $beParent ) {
        ?>
        <div class="page-links">
          <h2 class="page-links__title"><a href="<?php echo get_permalink( $theParent ); ?>"><?php echo get_the_title( $theParent ); ?></a></h2>
          <ul class="min-list">
            <?php // lesson 17 : d'abord la fonction (déf. des variables), ensuite la balise <h2> ci-dessus, finir par la condition qui englobe le container .page-links
              if($theParent) { // si la variable !== 0, c'est-à-dire si la page n'est pas parent,
                // do this > new variable : enregistre l'ID de la page, merci ne fais rien d'autre
                $findChildrenOf = $theParent;
              }
                else { // si la variable == 0, si c'est une page PARENT
                  // stp donne-moi son ID que je puisse l'utiliser dans wp_list_pages juste en-dessous
                  $findChildrenOf = get_the_ID();

              }
              wp_list_pages( array( // associative array (lesson 17)
                'title_li'  =>  NULL,
                'child_of'  =>  $findChildrenOf,
                'sort_column' => 'menu_order', // numéro d'ordre attribué dans la meta-box Attributs de Page
              ) ); 
              ?>
          </ul>
        </div>
      <?php }
        ?>          
      <div class="generic-content">
        <?php //remplace les paragraphes <p> de Lorem ipsum
          the_content();?> 
      </div>
    </div>


  <?php }

  get_footer();

?>