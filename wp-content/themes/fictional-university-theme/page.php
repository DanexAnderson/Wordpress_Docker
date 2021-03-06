<?php
get_header( );

while(have_posts()) {

    the_post();
    pageBanner(
      
 /*      array(
 'title' => 'Banner Title',       // Set Page Banner Title
  'subtitle' => 'Banner Subtitle',  // Set Page Banner SubTitle
  'photo' => 'https://vinylbannersprinting.co.uk/wp-content/uploads/2016/03/Gp-08-RA-PREVIEW.png'
    ) */
  );
    
    ?>



<!-- <div class="page-banner">
    <div class="page-banner__bg-image" 
    style="background-image: url(<?php/* echo get_theme_file_uri('images/ocean.jpg') ?>) ;"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title() */?></h1>
      <div class="page-banner__intro">
        <p>Learn how the school of your dreams got started.</p>
      </div>
    </div>  
  </div> -->

  <div class="container container--narrow page-section">

    <?php


      // esc_html(var); // always use escape functions to prevent hacking
      // echo get_the_ID();   // get the Page ID

     // echo wp_get_post_parent_id(get_the_ID()); // get Parent Page ID

     // the_title() // get title of current page

     // get_the_title(ID) // get the title of Page using ID

     // get_permalink(ID)  // get page url link for Page using ID

    $theParent = wp_get_post_parent_id(get_the_ID());

    if ($theParent) {  ?>  

    <div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>"><i class="fa fa-home"
       aria-hidden="true"></i> Back to <?php echo get_the_title($theParent) ?></a> <span class="metabox__main">
           <?php the_title();?></span></p>
    </div>

   <?php    
    } ?>
    
    
    <?php
    
    $testArray = get_pages(array(
        'child_of' => get_the_ID()
    ));

    if ($theParent or $testArray) {  ?>

     <div class="page-links">
      <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>">
      <?php echo get_the_title() ?></a></h2>
      <ul class="min-list">
          <?php
          
          if ($theParent) {

            $findChildrenOf = $theParent;
          } else {
              $findChildrenOf = get_the_ID();
          }

          wp_list_pages(array(
             
             'title_li' => null,
             'child_of' => $findChildrenOf,
             'sort_column' => 'menu_order'
          )); 

          ?>
        <!-- <li class="current_page_item"><a href="#">Our History</a></li>
        <li><a href="#">Our Goals</a></li> -->
      </ul>
    </div> 

        <?php } ?>

    <div class="generic-content">
      <p>  </p>
      <p> <?php  the_content();?> </p>
    </div>

  </div>
 
    
  <?php
 }

 get_footer();
?> 
  <?php /* the_title() ?>
  <?php  the_content();
  
  ?> */