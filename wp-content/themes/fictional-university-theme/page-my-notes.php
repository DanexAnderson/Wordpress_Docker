<?php

if (!is_user_logged_in()) {

    wp_redirect(esc_url(site_url('/'))); 
    exit; // exit after URL redirect to prevent unnecessary processing 
}

get_header( );

      // echo get_the_ID();   // get the Page ID

     // echo wp_get_post_parent_id(get_the_ID()); // get Parent Page ID

     // the_title() // get title of current page

     // get_the_title(ID) // get the title of Page using ID

     // get_permalink(ID)  // get page url link for Page using ID

while(have_posts()) {

    the_post();
    pageBanner(
      

  );
    
    ?>


  <div class="container container--narrow page-section">

  <div class="create-note"> 
    <h2 class="headline headline--medium"> Create New Note </h2>
    <input class="new-note-title" placeholder="Title">
    <textarea class=" new-note-body" placeholder="Your notes here.."></textarea>
    <span class=" submit-note">Create Note</span>
    <span class="note-limit-message">Note Limit reached: Delete existing note to make space </span>

</div><hr/>

  <ul class="min-list link-list" id="my-notes">
    <?php 

        $userNotes = new WP_Query(array(  // Wordpress SQL Query 

            'post_type' => 'note',
            'posts_per_page' => -1,
            'author' => get_current_user_id()
        ));

        
        while($userNotes->have_posts()) {

           $userNotes->the_post(); // Get the data Ready
           
        ?>
            <li data-id="<?php the_ID() ?>"> 
                <input readonly class="note-title-field"
                 value="<?php echo str_replace('Private: ','', esc_attr(get_the_title())); ?>">
                <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"> Edit </i></span>
                <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"> Delete </i></span>
                <textarea readonly class="note-body-field"><?php echo esc_textarea(get_the_content()); ?> </textarea>
                <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"> Save </i></span>
            </li>

        <?php 

        }
    
    ?> 

  </ul>


  </div>
 
    
  <?php
 }

 get_footer();
?> 
  