<?php

function university_post_types() {

    // Event Post Type (This is an entity)
    register_post_type('event', array(     // Add new menu 'Events' in Wordpress Admin

        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'events'),
        'has_archive' => true,
        'public' => true,
        'labels' => array('name' => 'Events',               // set menu name 
                         'add_new_item' => 'Add New Event',   // change display name from Post to Event
                         'edit_item' => 'Edit Event',
                         'all_items' => 'All Events',
                         'singular_name' => 'Event'
                        ),  
        'menu_icon' => 'dashicons-calendar-alt'   //  set menu icon
    ));


    // Program Post Type (This is an entity)
    register_post_type('program', array(     // Add new menu 'Events' in Wordpress Admin

        'supports' => array('title', 'editor'),
        'rewrite' => array('slug' => 'programs'),
        'has_archive' => true,
        'public' => true,
        'labels' => array('name' => 'Programs',               // set menu name 
                         'add_new_item' => 'Add New Program',   // change display name from Post to Event
                         'edit_item' => 'Edit Program',
                         'all_items' => 'All Programs',
                         'singular_name' => 'Program'
                        ),  
        'menu_icon' => 'dashicons-awards'   //  set menu icon
    ));


     // Professor Post Type (This is an entity)
     register_post_type('professor', array(     // Add new menu 'Events' in Wordpress Admin

        'supports' => array('title', 'editor', 'thumbnail'), // To add pics
        'public' => true,
        'labels' => array('name' => 'Professors',               // set menu name 
                         'add_new_item' => 'Add New Professor',   // change display name from Post to Event
                         'edit_item' => 'Edit Professor',
                         'all_items' => 'All Professors',
                         'singular_name' => 'professor'
                        ),  
        'menu_icon' => 'dashicons-welcome-learn-more'   //  set menu icon 
    ));
}

add_action('init', 'university_post_types');  // Add a new menu in Wordpress Admin

?>