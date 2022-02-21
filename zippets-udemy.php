<?php
/** SNIPPET site_url()
     * WP basics lesson xx > lesson 19 : on transforme cette partie en menu dynamique
     * dans le lien ci-dessous site_url() renvoie à l'accueil, on y ajoute le slug de la page
     * <?php echo site_url( '/post-slug' ) ?>
 */
?>

<header class="php">
    <nav class="main-navigation">
        <ul>
        <li><a href="<?php echo site_url('/about-us') ?>">About Us</a></li>
        <li><a href="#">Programs</a></li>
        <li><a href="#">Events</a></li>
        <li><a href="#">Campuses</a></li>
        <li><a href="#">Blog</a></li>
        </ul>
    </nav>

</header>


<?php
/** SNIPPETS & HOW TO mettre en place les MENUS du thème
     * WP lesson 19 > lesson 20 : Brad préfère garder les menus codés en dur,
     * il supprime les éléments dans functions.php
     * et les appels au menu dans header.php et footer.php
 */

 // dans functions.php, HOOK 'after_setup_theme' > function tth_chirony_setup_theme()
 
    // je crée les emplacements (location) des MENUS dans mon thème que je pourrai ensuite administrer dans l'admin WP
    // pour un client, le main menu p. ex. devrait plutôt être codé en dur (HTML) pour éviter toute manipulation par l'admin
  register_nav_menu( 'headerMenuLocation', 'Header Menu Location');

  register_nav_menu( 'footerLeftColumn', 'Footer Menu Left Column');

  register_nav_menu( 'footerCentralColumn', 'Footer Menu Central Column');

  register_nav_menu( 'footerRightColumn', 'Footer Menu Right Column');

// dans header.php et footer.php > wp_nav_menu( array( 'theme_location => ' ... ', ))
// exemple : ATTENTION aux parenthèses !! array
?>
    <nav class="nav-list">
        <?php 
            wp_nav_menu( array( // on insère le menu (1) préparé dans functions.php (location) et (2) créé dans admin WP
                'theme_location'  =>  'footerCentralColumn',
            ) 
        ); ?>
    </nav>