<?php

require get_theme_file_path('/inc/search-route.php');

// Returns the Author Name of a Post within an API request.
function university_custom_rest() {

    register_rest_field('post', 'authorName', array(

        'get_callback' => function() {return get_the_author(); }
    ));

    // Returns The Note Count, the amount of Notes created
    register_rest_field('note', 'userNoteCount', array(

        'get_callback' => function() {return count_user_posts(get_current_user_id(), 'note'); }
    ));
}

add_action('rest_api_init', 'university_custom_rest'); // call APi Function

function pageBanner($BannerArgs = null) {

    // if no Banner Title set in page.php use default page title

    if (!$BannerArgs['title']) {

       $BannerArgs['title'] = get_the_title();
    }

    // if no Banner SubTitle set in page.php use default page Subtitle
    if (!$BannerArgs['subtitle']) {

       $BannerArgs['subtitle'] = get_field('page_banner_subtitle');
    }

    if (!$BannerArgs['photo']) {

        if(get_field ('page_banner_background_image')) {

            // set Banner Image from custom field entity
            $BannerArgs['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {

            // location of default image
            $BannerArgs['photo'] = get_theme_file_uri('/images/ocean.jpg');
        } 
    }


    ?>

<div class="page-banner">
    <div class="page-banner__bg-image" 
    style="background-image: url(<?php 
    
    echo $BannerArgs['photo'];
    //$pageBannerImage = get_field('page_banner_background_image');
    // echo $pageBannerImage['url'] 
   // echo $pageBannerImage['sizes']['pageBanner'] // 
    ?>) ;"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php echo $BannerArgs['title'] //the_title() ?></h1>
      <div class="page-banner__intro">
        <p><?php echo $BannerArgs['subtitle']; ?></p>
      </div>
    </div>  
  </div>

    <?php
}


function university_files() {

                //      name-tag                    JS file location,   dependencies, version, load end of page
    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyBt3MPXR1wiTsp9caPeGQ54lHqQjJKQwhY', null, microtime(), true);

                //      name-tag                    JS file location,   dependencies, version, load end of page
    wp_enqueue_script('main_university_js', get_theme_file_uri('/js/scripts-bundled.js'), null, microtime(), true);
    wp_enqueue_style('custom_google_fonts', 
'//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_stylesheet_uri(), null, microtime());

    // //Attach to Script file by name-tag      variable name
    wp_localize_script('main_university_js', 'universityData',
                         array(
                                'root_url' => get_site_url(), // returns URL for current Wordpress installation
                                'nonce' => wp_create_nonce('wp_rest'),  // Token for Api Authorization
                                )
    );
}

add_action('wp_enqueue_scripts', 'university_files'); // wp function call before page theme loaded

function university_features() {

   /*  register_nav_menu( 'headerMenuLocation', 'Header Menu Location' );  // set Header Menu
    register_nav_menu( 'footerLocationOne', 'Footer Location One' );  // set Footer Menu1
    register_nav_menu( 'footerLocationTwo', 'Footer Location Two' ); // set Footer Menu2
    */

    add_theme_support('title-tag'); // set site title 
    add_theme_support('post-thumbnails'); // create entitle featured image
    add_image_size('professorLandscape', 400, 260, true );
    add_image_size('professorPortrait', 400, 650, true );
    add_image_size('pageBanner', 1500, 350, true );
}

add_action( 'after_setup_theme', 'university_features'); // wp function call after theme loaded

function university_adjust_queries($query) {

    if(!is_admin() and is_post_type_archive('campus') and $query->is_main_query()) { // change behaviour of Campus archive post
        
        $query->set('posts_per_page', -1);

    }

    if(!is_admin() and is_post_type_archive('program') and $query->is_main_query()) { // change behaviour of program archive post
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);

    }

    $today = date('Ymd');
    if (!is_admin() AND is_post_type_archive('event') and $query->is_main_query()) { // change behaviour of events archive post
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

function universityMayKey($api) {

    
    $api['key'] = 'AIzaSyBt3MPXR1wiTsp9caPeGQ54lHqQjJKQwhY';
    
    return $api;
}

add_filter('acf/fields/google_map/api', 'universityMayKey');  // 


// Redirector Subsciber Accounts
add_action('admin_init', 'redirectSubsToFrontend');

function redirectSubsToFrontend() {

    $ourCurrentUser = wp_get_current_user();  // return the current signin user object 

    if(count($ourCurrentUser->roles)==1 AND $ourCurrentUser->roles[0] == 'subscriber') {

        wp_redirect(site_url('/'));
        exit;
    }
}


 add_action('wp_loaded', 'noSubsAdminBar'); // Remove Admin Bar 

function noSubsAdminBar() {

    $ourCurrentUser = wp_get_current_user();  // return the current signin user object 

    if(count($ourCurrentUser->roles)==1 AND $ourCurrentUser->roles[0] == 'subscriber') {

        show_admin_bar(false); // Remove Admin Bar 
    }
} 

// Customize Login Screen

add_filter('login_headerurl', 'ourHeaderUrl'); // Login Icon on click redirect

function ourHeaderUrl() {

    return esc_url(site_url('/')); // add URL link to login Header Icon 
}

// Add CSS to Login Screen
add_action('login_enqueue_scripts', 'ourLoginCSS');
 
function ourLoginCSS() {

    wp_enqueue_style('university_main_styles', get_stylesheet_uri());
    wp_enqueue_style('custom_google_fonts', 
    '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
}

add_filter('login_headertitle', 'ourLoginTitle'); // remove Powered by Wordpress at login Screen

function ourLoginTitle() {

    return get_bloginfo('name'); // return the name of the website
}

// Force Note posts to be private
// Interceptor Function 
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2); // 2 for two function parameters, 10 for priorty of execution

function makeNotePrivate($data, $postarr) { // $postarr contains the id of an element

    if ($data['post_type'] == 'note') {

        if(count_user_posts(get_current_user_id(), 'note') > 4 AND !$postarr['ID']) {

            die("You have reach your note limit.");
        }

        $data['post_content'] = sanitize_textarea_field( $data['post_content'] ); // remove html from text
        $data['post_title'] = sanitize_text_field( $data['post_title'] ); // remove html from text
    }

    if($data['post_type'] == 'note' AND $data['post_status'] != 'trash'){

    $data['post_status'] = "private";

    }

    return $data; 
}