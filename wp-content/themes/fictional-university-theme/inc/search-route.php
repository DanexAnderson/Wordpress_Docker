<?php

function universityRegisterSearch() {

//                      namespace       route
    register_rest_route('university/v1', 'search', array (

        'methods' => WP_REST_SERVER::READABLE, // wordpress get request
        'callback' => 'universitySearchResults' // function call
    ) );

}

// API function
function universitySearchResults($data) // URL =>  http://localhost:3000/wp-json/university/v1/search
{
    $mainQuery = new WP_Query(array ( // wordpress Query , query array 

        'post_type' =>  array('post', 'page', 'professor', 'program', 'event', 'campus'),  // Query entity
        's' => sanitize_text_field( $data['term'] ) // search key 
    ));

    $results = array(

        'generalInfo' => array(),
        'professors' => array(),
        'events' => array(), 
        'progams' => array(), 
        'campuses' => array() 

    );

    while($mainQuery->have_posts()) {

        $mainQuery->the_post();

        if (get_post_type() == 'post' OR get_post_type() == 'page') {

            array_push($results['generalInfo'], array( // push search results to  respective array 

            'title' => get_the_title(),
            'permalink' => get_the_permalink()
        ) );
        }

        if (get_post_type() == 'professor') {

            array_push($results['professors'], array(

            'title' => get_the_title(),
            'permalink' => get_the_permalink()
        ) );
        }

        if (get_post_type() == 'program') {

            array_push($results['programs'], array(

            'title' => get_the_title(),
            'permalink' => get_the_permalink()
        ) );
        }

        if (get_post_type() == 'event') {

            array_push($results['events'], array(

            'title' => get_the_title(),
            'permalink' => get_the_permalink()
        ) );
        }

        if (get_post_type() == 'campus') {

            array_push($results['campuses'], array(

            'title' => get_the_title(),
            'permalink' => get_the_permalink()
        ) );
        }


        
    }

    return $results;
}


// Add a function to wordpress 
add_action('rest_api_init', 'universityRegisterSearch');
//       wordpress event    function name