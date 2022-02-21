<?php

function tth_chirony_styles() {
  wp_enqueue_script('tth_chirony_main_js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
  
  wp_enqueue_style('tth_chirony_fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i' );
  wp_enqueue_style('font_awesome', '//cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css');
    // lien trouvé ici https://www.bootstrapcdn.com/fontawesome/, ça marche pas mieux (pas d'erreur de chargement signalée dans l'inspecteur)
  wp_enqueue_style('tth_chirony_main_styles', get_theme_file_uri( '/build/style-index.css' ));
  wp_enqueue_style('tth_chirony_extra_styles', get_theme_file_uri( '/build/index.css' ));
}

add_action('wp_enqueue_scripts', 'tth_chirony_styles');


function tth_chirony_setup_theme() { 
  // hook 'after_setup_theme' : 
  add_theme_support( 'title-tag' ); // ajoute le titre du post à l'onglet du navigateur

  // register_nav_menu( 'nameLocation', 'nameTitle' );
}

add_action( 'after_setup_theme', 'tth_chirony_setup_theme' );

