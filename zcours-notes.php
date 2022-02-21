<?php
/**
 * Récapitulatif LESSONS 1 to 23
 * 
 * Lesson 2 > Dev Environment
 * Brad conseille Local by Flywheel et travaille avec. Comme j'avais bien aimé, je me dis qu'il pourra m'apprendre des trucs à ce sujet. Je réinstalle donc Local, et 2 sites  sur /anitahirschi/LOCAL Sites/
 * - la-nature-aux-pattes <-- le site de pratique pour le cours
 * - amicale-questre-vallee-de-joux <-- à définir
 * 
 * Lesson 4 > installation VS Code et premiers pas avec php : variables et fonctions
 * 
 * ------ section 3 : First Coding Steps:PHP ------
 * Lesson 6 > Creating a New Theme
 * 
    * Nous construisons les fichiers de notre thème WP 'from scratch' sur la base de deux fichiers HTML :
    * 
    * Créer le thème : 
    * - créer le dossier
    * - créer le fichier index.php
    * - créer le fichier style.css > en-tête commentée --> Theme Name: Author: Version:
    * ________ éléments nécessaires pour que WP reconnaisse un thème _________________________

    * - ajouter un fichier screenshot.png (1200x900px)
    * --> activer le thème / supprimer les thèmes inactifs
 * 
 * 
 * Lesson 7 > PHP functions (basics)
 *  
 */
?>
    <h1><?php bloginfo( 'name' ); ?></h1>
    <p><?php bloginfo( 'description' ); ?></p> 
<?php   // le 'slogan' du site
/*  1ers exemples de template tag que nous voyons hors template.php
 * 
 * 
 * Lesson 8 > PHP arrays (basics)
 *  déclaration d'une variable et intégration (echo) de celle-ci dans une expression HTML
 *  1er exemple d'array en ligne (statique) : 
 * 
 */
    $names = array( 'John', 'Brad', 'Jane' );
?>
    <p>Hi, my name is <?php echo $names[0] ?></p>
<?php
/*  [ ] <--- pour 'argumenter' une variable définie
*   dans un array, le compte des args (valeur) commence toujours à [0] 
*   dans l'exemple, l'écran affichera ... John !
*   le 's' dans le nom de la variable est important (pour la Loop) > stocker plusieurs valeurs dans une seule variable
*
*/
    $count = 1; // équivalent à $i = 1; dans d'autres exemples de la loop (codex WP)

    while( $count < 21 ) {
        echo "<li>$count</li>";
        $count++;
    }

    $names = array( 'John', 'Brad', 'Jane' );

    $count = 0;

    while( $count < count( $names )) {
        echo "<li>Bonjour, je m'appelle $names[$count]</li>";
        $count++;
    }
/** pourquoi ne pas utiliser ici une Loop 'foreach' ?
 *  réponse de Brad : il est important de se familiariser avec la boucle 'while' que WP utilise pour parcourir le contenu réel (posts, pages)
 * 
 * 
 * ------ section 4 : WP specific PHP ------
 * Lesson 9 > The Loop
 * 
 *  - écriture de la Loop dans index.php <-- grab the real WP content
 */
    while( have_posts() ) {
        the_post(); 
        // get_template_part ( 'template-parts/content', get_post_type() ); <--- WP starter themes Twenty series
        // OR everything I want to grab (wrapped in HTML) from 'the_post' !!! close php 'balises' before HTML divs !!! - the Loop is closed by the final bracket } of the fonction
        // why do we NOT endwhile() the loop ?
        ?>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php the_content();
    }
/** 
 *  - création du fichier single.php
 *      reprendre la loop précédente (index.php)
 *      supprimer le lien dans le titre (le titre d'un post n'a pas besoin de pointer vers lui-même)
 * */
    while( have_posts() ) {
        the_post(); 
        // everything I want to grab (wrapped in HTML) from 'the_post' !!! close php 'balises' !!!
        ?>
        <h2>><?php the_title(); ?></h2>
        <?php the_content();
    }
 /**
 *  - comme il n'y a pas (encore) de fichier page.php, 
 *      l'appel à une page déclenche un 'callback' vers le fichier index.php
 *      => le lien réapparaît
 *  - création du fichier page.php
 *      copier/coller la loop précédente
 * 
 * 
 * Lesson 10 > Header & Footer
 *  - commencer et terminer index.php avec les appels aux 2 parties :
 */
      get_header(); ?>

<?php get_footer(); 

/**
 *  - démarrer les balises HTML en haut du fichier header.php que l'on crée 
 */
?>
    <!DOCTYPE html>
    <html>
        <head>
            <?php wp_head(); // s'occupe des éléments du header (charset, stylesheets, scripts, fonts)
                // --> création du fichier functions.php pour wp_enqueue_styles & scripts
                ?>
        </head>
        <body>
            <h1></h1>
<!---
 *  - créer le fichier footer.php et y mettre (tout en bas) les balises HTML de fermeture du body et du fichier HTML 
--->
    <?php // on ajoute l'appel générique 
        wp_footer(); ?>
        </body>
    </html>

<?php
/*
 *  - création du fichier functions.php <-- enqueue fonts, styles & scripts
 */
    add_action( 'a', 'b' ); // a = action_HOOK et b = myFctName

    // générique
    function myFctName() {
        // everything I want my function to do
    }
    add_action( 'action_hook', 'myFctName', $arg, $priority ) // $arg ?

    // spécifique
    function tthcode_enqueue() {
        wp_enqueue_style( 'tthcode-styles', get_stylesheet_directory_uri( '/build/style-index.css' ), );       
        wp_enqueue_style( 'tthcode-extra-styles', get_stylesheet_directory_uri( '/build/index.css' ), );
            // /build <--- l'endroit où par convention viennent se placer (et se mettre à jour automatiquement) les fichiers CSS et jQuery (minifiés ou pas) générés sur la base des fichiers .scss (SASS)
    }
    add_action( 'action_hook', 'tthcode_enqueue', $arg, $priority ) // $arg ?

/** 
 * Lesson 12+13 > Convert Static HTML Template into wp theme
 *  - télécharger la base HTML sur le repo Github de Brad
 *      https://github.com/LearnWebCode/university-static
 *  - prendre les deux pages : index.html et interior-page-template.html
 *      ainsi que les dossiers d'assets (build, css, images, src)
 *  - compléter tthcode_enqueue dans functions.php
 *      je le complète ici selon le modèle de Brad
 *      pour les liens externes, reprendre les liens qui se trouvent dans le head de index.html, sans le https:
 *      dans mon exercice pratique, la Font Awesome ne se charge pas ^^
 *      j'ai cherché dans la doc Bootstrap > serveur CDN, et remplacé avec le nouveau lien dans functions.php
 *      > ça marche toujours pas
 *  - dispatcher le contenu du fichier index.html dans les trois templates-parts nécessaires :
 *      index.php  <--- tout le contenu HTML, puis extraire vers les 2 fichiers :
 *      header.php <--- toute la div.header
 *      footer.php <--- toute la div.footer
 *
 * 
 * 
 * ------ section 5 : Pages ------
 * Lesson 14 > Interior Page Template
 * 
 * 
 * 
 * 
 * 
 * 
 * Lesson 15 > Parent & Children Pages
 * 
 * 
 * 
 * 
 * 
 * Lesson 16 > To Echo or Not To Echo
 * 
 * 
 * 
 * 
 * Lesson 17 > Menu of Child Page Links
 * 
 * 
 * 
 * 
 * Lesson 18 > A Few Quick Edits / Improvements
 * 
 * 
 * 
 * 
 * Lesson 19+20 > Navigation Menus
 * 
 * 
 * 
 * 
 * ------ section 6 : the Blog Section ------
 * Lesson 21+22 > Blog Listing Page (index.php vs front-page.php)
 * 
 * 
 * 
 * 
 * Lesson 23 > Blog Archives (archive.php)
 * 
 * 
 * 
 * 
 * Lesson 24 > Custom Queries
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 *  * ------ section 5 : Pages ------
 * Lesson 14 > Interior Page Template
* 
* 
* - créer le fichier functions.php
* - index.html
* - interior-page.html
* 
* Nous avons démarré avec :
* - header.php
* - index.php
* - footer.php
* 
* 
* 
* 
* * 
 * 
 * 
 * 
 */















?>