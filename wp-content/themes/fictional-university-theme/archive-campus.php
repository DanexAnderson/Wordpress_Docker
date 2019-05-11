<?php

get_header(); 

pageBanner( array(

  'title' => 'Our Campuses',
  'subtitle' => 'Check out our exciting Campuses across the island.'
));


?>

<div class="container container--narrow page-section"> 

  <!-- <ul class="link-list min-list"> -->
 
 <div class="acf-map">

 <?php

  while(have_posts()) {

    the_post();
    
    $mapLocation = get_field('map_location');
    
    ?>

    <div class="marker" data-lat="<?php $mapLocation['lat'] ?>" data-lng="<?php $mapLocation['lng'] ?>">
    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </h3> <?php echo $mapLocation['address']; ?>
  </div>

<!-- <li><a href="<?php/* the_permalink(); ?>">
<?php the_title(); $mapLocation= get_field('map_location'); print_r($mapLocation); */?></a></li>
 -->

    <?php
  }

  echo paginate_links();

  ?>

 </div>
  <!-- </ul> -->

  

</div>


<?php
get_footer();

?>