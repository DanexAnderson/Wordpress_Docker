<?

function university_files() {

                //      name-tag                    JS file location,   dependencies, version, load end of page
    wp_enqueue_script('main_university_js', get_theme_file_uri('/js/scripts-bundled.js'), null, microtime(), true);
    wp_enqueue_style('custom_google_fonts', 
'//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_stylesheet_uri(), null, microtime());
}

add_action('wp_enqueue_scripts', 'university_files'); // wp function call before page theme loaded

function university_features() {

   /*  register_nav_menu( 'headerMenuLocation', 'Header Menu Location' );  // set Header Menu
    register_nav_menu( 'footerLocationOne', 'Footer Location One' );  // set Footer Menu1
    register_nav_menu( 'footerLocationTwo', 'Footer Location Two' ); // set Footer Menu2
    */

    add_theme_support('title-tag'); // set site title 
}

add_action( 'after_setup_theme', 'university_features'); // wp function call after theme loaded

function university_adjust_queries($query) {

    $today = date('Ymd');
    if (!is_admin() AND is_post_type_archive('event') and $query->is_main_query()) {
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array( array( 
            'key' => 'event_date',
            'compare' => '>=',
            'value' => $today,
            'type' => 'numeric'
            )));

    }

}

add_action( 'pre_get_posts', 'university_adjust_queries'); // intercept Query and Manipulate it



?>