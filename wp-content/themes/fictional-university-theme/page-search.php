<?php
get_header( );

while(have_posts()) {

    the_post();
    pageBanner(

  );
    
    ?>


  <div class="container container--narrow page-section">

    <?php
    
      // echo get_the_ID();   // get the Page ID

     // echo wp_get_post_parent_id(get_the_ID()); // get Parent Page ID

     // the_title() // get title of current page

     // get_the_title(ID) // get the title of Page using ID

     // get_permalink(ID)  // get page url link for Page using ID

     // the_field('field')

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
      </ul>
    </div> 

        <?php } ?>

<?php get_search_form(); ?>
 
    
  <?php
 }

 get_footer();
?> 
  <?php 