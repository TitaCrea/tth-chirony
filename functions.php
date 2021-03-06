<?php 
// added from Brad's final site
// require get_theme_file_path('/inc/like-route.php');
// require get_theme_file_path('/inc/search-route.php');

// function tthchirony_custom_rest() {
//   register_rest_field('post', 'authorName', array(
//     'get_callback' => function() {return get_the_author();}
//   ));

//   register_rest_field('note', 'userNoteCount', array(
//     'get_callback' => function() {return count_user_posts(get_current_user_id(), 'note');}
//   ));
// }

// add_action('rest_api_init', 'tthchirony_custom_rest');


// Dynamic Post/Page/CPT Banners
function pageBanner($args = NULL) {

  if (isset($args['altTitle'])) {
    $args['altTitle'] = $args['altTitle'];
  } else {
    if (get_field( 'page_alternate_title' ) AND !is_home()) {
      $args['altTitle'] = get_field('page_alternate_title');
    } else {
      $args['altTitle'] = get_the_title();
    }
  }

  if (isset($args['subtitle'])) {
    $args['subtitle'] = $args['subtitle'];
  } else {
    $args['subtitle'] = get_field('page_subtitle');
  }

  if (isset($args['photo'])) {
    $args['photo'] = $args['photo'];
  } else {
    if (get_field( 'page_background_image') AND !is_archive() AND !is_home()) {
      $args['photo'] = get_field( 'page_background_image' )['sizes']['pageBanner'];
    } else {
      $args['photo'] = get_theme_file_uri( '/images/ballons.jpg' );
    }
  } ?>

    <div class="page-banner">
      <div class="page-banner__bg-image" 
        style="background-image: 
        url(<?php echo $args['photo']; ?>)">
      </div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['altTitle']; ?></h1>
        <div class="page-banner__intro">
          <p><?php echo $args['subtitle']; ?></p>
        </div>
      </div>
    </div>

<?php }


function tthchirony_styles() {
  // hook 'wp_enqueue_scripts' with add-ons from Brad's final site
  wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyCkdahwu9WMpA1TMQdVcQUMD8-1avGqvlE', NULL, '1.0', true);
  wp_enqueue_script('tthchirony_main_js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
  
  wp_enqueue_style('tthchirony_fonts', '////fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  // Font Awesome : line from Brad's final site
  wp_enqueue_style('tthchirony_main_styles', get_theme_file_uri( '/build/style-index.css' ));
  wp_enqueue_style('tthchirony_extra_styles', get_theme_file_uri( '/build/index.css' ));

  // wp_localize_script('main-university-js', 'universityData', array(
  //   'root_url' => get_site_url(),
  //   'nonce' => wp_create_nonce('wp_rest')
  // ));

}

add_action('wp_enqueue_scripts', 'tthchirony_styles', 10);

// add-on Tita
function tth_dev_styles() {
  wp_enqueue_style('tthchirony_dev_styles', get_theme_file_uri( 'style.css'));
}
add_action('wp_enqueue_scripts', 'tth_dev_styles', 100);


function tthchirony_setup_theme() { 
  // hook 'after_setup_theme' : 
  add_theme_support( 'title-tag' ); // ajoute le titre du post ?? l'onglet du navigateur
  add_theme_support( 'post-thumbnails' );
  add_image_size( 'professorLandscape', 400, 260, true);
  add_image_size( 'professorPortrait', 480, 650, true);
  add_image_size('pageBanner', 1500, 350, true);
  // register_nav_menu( 'nameLocation', 'nameTitle' );
}

add_action( 'after_setup_theme', 'tthchirony_setup_theme' );

//Lesson 26 - Create Custom Post Types > Must Use Plugin : /mu-plugins/tth-chirony-cpt.php

//Lesson 33 - Manipulating Default URL Based Queries < PRE_GET_POSTS()
  // nous voulons - sur la page All Events - n'afficher que les ??v??nements ?? venir ET les classer du plus proche au plus ??loign?? dans le temps

function tthchirony_adjust_queries( $query ) { // WP will define an Object with the results of this query > $query
  // exemple simple, sans condition, avec $query->set ('posts_per_page', '1') : r??sultat = cela affecte TOUS les types de post, y compris dans l'admin WP !
  // nous avons besoin d'une condition IF 
  if( !is_admin() AND is_post_type_archive( 'event' ) AND $query->is_main_query() ) {
    // la 3e condition solidifie le code en nous assurant que la fonction travaille bien avec la main_query pour ex??cuter la suite
    $today = date( 'Ymd' ); // variable used in the meta_query below
    $query->set( 
      // nous d??finissons les param??tres qui nous permettent de filtrer les 'event' > ce que nous avons d??j?? fait (param??tres) sur la front-page > cette fois, nous le faisons avec $query->set( '$param', '$valeur' );
      'meta_key', 'event_beginning_date'
     );
     // pas d'array, c'est un param??tre par 'set()' - par contre, set() accepte les arrays en 2e arg.
    $query->set( 'orderby', 'meta_value_num' );
    $query->set( 'order', 'ASC' );
    $query->set( 'meta_query', array( 
      array( 
        'key'   => 'event_beginning_date',  
        'compare' => '>=', 
        'value' => $today, // do not forget to declare this $today variable by copying its declaration too
        'type'  => 'numeric',
      ),
      array( // ajout Tita : 2e Inner Array for the meta_query : seulement les 'events' dont le champ 'contenu-reserve' est vide == public
        'key'   => 'contenu-reserve',
        'compare' => 'NOT EXISTS',
      ) 
      ));
  }

  // Lesson 35, 2e condition (IF statement) sur le hook 'pre_get_posts' 
  // pour ne pas r??inventer la roue avec une custom WP_query sur la page archive-program.php
  // c'est ici que nous alt??rons la Query 
  // et c'est exactement ce que j'ai oubli?? dans l'exercice pratique que je me suis donn?? avec la cr??ation du CPT Session
  if( !is_admin() AND is_post_type_archive( 'program' ) AND $query->is_main_query() ) {
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
  }

  if (!is_admin() AND is_post_type_archive('place') AND $query->is_main_query()) {
    $query->set('posts_per_page', -1);
  }

}

add_action( 'pre_get_posts', 'tthchirony_adjust_queries' );