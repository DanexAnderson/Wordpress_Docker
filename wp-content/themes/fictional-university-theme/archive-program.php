<?php

get_header(); 

pageBanner( array(

  'title' => 'All Programs',
  'subtitle' => 'Check out our programs. There is something for everyone.'
)
);


?>

<!-- <div class="page-banner">
    <div class="page-banner__bg-image" 
    style="background-image: url(<?php /* echo get_theme_file_uri('images/ocean.jpg') ?>) ;"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"> All Programs<?php
       
  //   the_archive_title();
      
      /* if (is_category()){
            single_cat_title(); echo ' Archive';
      }
      if (is_author()){
          echo 'Post by '; the_author();
      } */ ?></h1>
      <div class="page-banner__intro">
        <p>Check out our programs. There is something for everyone.</p>
      </div>
    </div>  
  </div> -->

<div class="container container--narrow page-section"> 
  <ul class="link-list min-list">
  <?php

  while(have_posts()) {

    the_post(); ?>

<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a> </li>


    <!-- <div class="event-summary">
    
    <a class="event-summary__date t-center" href="#">
            <span class="event-summary__month"><?php  /*
            
            $eventDate = new DateTime(get_field('event_date'));
            echo $eventDate->format('M');

            // the_field('event_date');
             ?></span>
            <span class="event-summary__day"><?php echo $eventDate->format('d'); ?></span>  
          </a>

          <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
            <p><?php wp_trim_words(get_the_content(), 18); ?>
                 <a href="<?php the_permalink();  */?>" class="nu gray">Learn more</a></p>
          </div>
        </div> -->

    <?php
  }

  echo paginate_links();

  ?>
  </ul>

  

</div>


<?php
get_footer();

?>