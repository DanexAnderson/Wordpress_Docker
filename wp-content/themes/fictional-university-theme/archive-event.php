<?php  // All Events Page

get_header();

pageBanner( array(

  'title' => 'All Events',
  'subtitle' => 'See what is going on in our Academy.'
)
);

 ?>

<!-- <div class="page-banner">
    <div class="page-banner__bg-image" 
    style="background-image: url(<?php /* echo get_theme_file_uri('images/ocean.jpg') ?>) ;"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"> All Events <?php
       
  //   the_archive_title();
      
      /* if (is_category()){
            single_cat_title(); echo ' Archive';
      }
      if (is_author()){
          echo 'Post by '; the_author();
      } */ ?></h1>
      <div class="page-banner__intro">
        <p>See what is going on in our Academy</p>
      </div>
    </div>  
  </div>
 -->
<div class="container container--narrow page-section"> 
  <?php

  while(have_posts()) {

    the_post(); 

    get_template_part('template-parts/content-event');
  }

  echo paginate_links();

  ?>
<hr class="section-break" >

<p><a href="<?php echo site_url('/past-events'); ?>"> Check Out Past Events </a></p>

</div>


<?php
get_footer();

?>