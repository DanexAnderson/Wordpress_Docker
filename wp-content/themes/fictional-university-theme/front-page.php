<?php get_header();
?>

<div class="page-banner">
  <div class="page-banner__bg-image" 
  style="background-image: url(<?php echo get_theme_file_uri('/images/library-hero.jpg') ?>);"></div>
    <div class="page-banner__content container t-center c-white">
      <h1 style="color:yellow" class="headline headline--large">Welcome!</h1>
      <h2 class="headline headline--medium">We think you&rsquo;ll like it here.</h2>
      <h3 class="headline headline--small">Why don&rsquo;t you check out the
           <strong>major</strong> you&rsquo;re interested in?</h3>
      <a href="<?php echo get_post_type_archive_link('program'); ?>" class="btn btn--large btn--blue">Find Your Major</a>
    </div>
  </div>

  <div class="full-width-split group">
    <div class="full-width-split__one">
      <div class="full-width-split__inner">
        <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>

        <?php 

          $today = date('Ymd');

          $homepageEvents = new WP_Query(array(  // Custom Query to get Customer Entity Event

            'posts_per_page' => 3,
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array( array(  // get Current upcoming Events
              'key' => 'event_date',
              'compare' => '>=',
              'value' => $today,
              'type' => 'numeric'
              ))
          ));

          while($homepageEvents->have_posts()) {  // Display Retrieved Events

           $homepageEvents->the_post(); 

              get_template_part('template-parts/content', 'event');  // include code from a file folder
            //  get_template_part('folderName/fileName', 'DashExtension' );  // include dynamic page contents


           }
           ?>

     

<!--         <div class="event-summary">
          <a class="event-summary__date t-center" href="#">
            <span class="event-summary__month">Apr</span>
            <span class="event-summary__day">02</span>  
          </a>
          <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny">
                <a href="#">Quad Picnic Party</a></h5>
            <p>Live music, a taco truck and more can found in our third annual quad picnic day.
                 <a href="#" class="nu gray">Learn more</a></p>
          </div>
        </div> -->

        
        <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('event'); ?>"
         class="btn btn--blue">View All Events</a></p>

      </div>
    </div>
    <div class="full-width-split__two">
      <div class="full-width-split__inner">
        <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>

        <?php 

        $homepagePost =  new WP_Query(array(
          'posts_per_page' => 3,
        ));

          while($homepagePost->have_posts()) {

            $homepagePost->the_post(); ?>

      <div class="event-summary">
          <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
            <span class="event-summary__month"><?php the_time('M'); ?></span>
            <span class="event-summary__day"><?php the_time('d'); ?></span>  
          </a>
          <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
            <p><?php 
                      if (has_excerpt()) {
                        echo get_the_excerpt();
                      } else {
                        echo wp_trim_words(get_the_content(),18);
                      }
            ?>
                <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
          </div>
        </div>
            <?php
          } wp_reset_postdata();
        ?>

       
       
        
        <p class="t-center no-margin"><a href="<?php echo site_url('/blog'); ?>"
         class="btn btn--yellow">View All Blog Posts</a></p>
      </div>
    </div>
  </div>

  <div class="hero-slider">
  <div class="hero-slider__slide" 
  style="background-image: url(<?php echo get_theme_file_uri('images/bus.jpg') ?>);">
    <div class="hero-slider__interior container">
      <div class="hero-slider__overlay">
        <h2 class="headline headline--medium t-center">Free Transportation</h2>
        <p class="t-center">All students have free unlimited bus fare.</p>
        <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
      </div>
    </div>
  </div>
  <div class="hero-slider__slide" 
  style="background-image: url(<?php echo get_theme_file_uri('images/apples.jpg') ?>);">
    <div class="hero-slider__interior container">
      <div class="hero-slider__overlay">
        <h2 class="headline headline--medium t-center">An Apple a Day</h2>
        <p class="t-center">Our dentistry program recommends eating apples.</p>
        <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
      </div>
    </div>
  </div>
  <div class="hero-slider__slide" 
  style="background-image: url(<?php echo get_theme_file_uri('images/bread.jpg') ?>);">
    <div class="hero-slider__interior container">
      <div class="hero-slider__overlay">
        <h2 class="headline headline--medium t-center">Free Food</h2>
        <p class="t-center">Fictional University offers lunch plans for those in need.</p>
        <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
      </div>
    </div>
  </div>
</div>

 <?php get_footer();
?>

 <?php
 /*
while(have_posts()) {

    the_post(); ?>

    <h2><a href="<?php the_permalink(); ?>"> <?php the_title() ?></a></h2>
  <?php  the_content();
  ?> 
    <hr>

  <?php
 } */ ?>
 