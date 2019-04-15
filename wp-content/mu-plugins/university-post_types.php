<?php

function university_post_types() {

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
}

add_action('init', 'university_post_types');  // Add a new menu in Wordpress Admin

?>