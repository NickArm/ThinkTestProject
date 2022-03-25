<?php
	get_header();
?>

 <!-------------------------  2x2 GRID -------------------------------> 
<body>
<div class="main-four-categories container px-4 main-section">
		<div class="social-icons">
					<span>
						<a href="#"><img src="<?php echo get_theme_file_uri('assets/Icons/Social Media/Facebook Colour.svg');?>"/></a>
					</span>
					<span>
						<a href="#"><img src="<?php echo get_theme_file_uri('assets/Icons/Social Media/Instagram Dark.svg');?>"/></a>
					</span>
					
		</div>
		<div class="row row-cols-1 row-cols-lg-2 align-items-stretch g-4">
		  <div class="col">
			<div class="card card-cover h-100 overflow-hidden rounded-5" style="background-image: url('<?php echo get_theme_file_uri('assets/categories/kayak.png');?>');background-size: cover;">
			  <div class="d-flex flex-column h-100 main-four-categories-content">
				<h2>Kaykas</h2>
				<span class="main-category-shop-now">Shop Kayaks ></span>

			  </div>
			</div>
		  </div>

		  <div class="col">
			<div class="card card-cover h-100 overflow-hidden rounded-5" style="background-image: url('<?php echo get_theme_file_uri('assets/categories/marine.png');?>');background-size: cover;">
			  <div class="d-flex flex-column h-100 main-four-categories-content">
				<h2>Marine</h2>
				<span class="main-category-shop-now">Shop Marines ></span>
			  </div>
			</div>
		  </div>
		  
		  <div class="col">
			<div class="card card-cover h-100 overflow-hidden rounded-5" style="background-image: url('<?php echo get_theme_file_uri('assets/categories/surf.png');?>');background-size: cover;">
			  <div class="d-flex flex-column h-100 main-four-categories-content">
				<h2>JetSurf</h2>
				<span class="main-category-shop-now">Shop JetSurfs ></span>

			  </div>
			</div>
		  </div>
		  
		  <div class="col">
			<div class="card card-cover h-100 overflow-hidden  rounded-5" style="background-image: url('<?php echo get_theme_file_uri('assets/categories/racks.png');?>');background-size: cover;">
			  <div class="d-flex flex-column h-100 main-four-categories-content">
				<h2>Racks</h2>
				<span class="main-category-shop-now">Shop Racks ></span>
			  </div>
			</div>
		  </div>
		  
		</div>
	  </div>
	  
	  <!---------------------------OUR FAVORITES------------------------------------->
	  
	 <div class="py-5 our-favorites main-section">
    <div class="container">
		<h2 class="section-title">Our Favorites</h2>	  
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
        <div class="col">
          <div class="card">
			<img src="<?php echo get_theme_file_uri('assets/categories/Kayaks/Fishing.png');?>"/>
          </div>
		  <div class="card_body">
			<span class="our-favorites-categories">PERFOMANCE TOURING</span>
              <h5 class="card-text">Zergun Ormer HV(Skeg + Rudder)</h5>
              <span class="our-favorites-price">€1,345</span>
            </div>
        </div>
        <div class="col">
          <div class="card">
           <img src="<?php echo get_theme_file_uri('assets/categories/Kayaks/Kids.png');?>" />
		   </div>
           <div class="card_body">
			<span class="our-favorites-categories">PERFOMANCE TOURING</span>
              <h5 class="card-text">Perception Expression 11</h5>
              <span class="our-favorites-price">€925</span>
            </div>
          
        </div>
        <div class="col">
          <div class="card">
            <img src="<?php echo get_theme_file_uri('assets/categories/Kayaks/SUPs.png');?>"/>
			</div>
            <div class="card_body">
			 
			<span class="our-favorites-categories">PERFOMANCE TOURING</span>
              <h5 class="card-text">Perception Expression 15</h5>
              <span class="our-favorites-price">€1,120</span>
            </div>
         
        </div>

        <div class="col">
          <div class="card">
            <img src="<?php echo get_theme_file_uri('assets/categories/Kayaks/Surfski.png');?>"/>
			</div>
            <div class="card_body">
			<span class="our-favorites-categories">PERFOMANCE TOURING</span>
              <h5 class="card-text">Edge 14.5 - rudder</h5>
              <span class="our-favorites-price">€975</span>
            </div>
          
        </div>
        

      </div>
    </div>
  </div>
  
  
  <!---------------------------OUR BLOG------------------------------------->

	<div class="our-blog main-section">
    <div class="container">
	<h2 class="section-title">Keep Updated</h2>	  
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php 
		$homepagePosts = new WP_Query(array(
			'posts_per_page'=>3
		));
		
		
		while ($homepagePosts -> have_posts()){
		$homepagePosts->the_post();?>
	  
        <div class="col">
          <div class="card ">
            <?php the_post_thumbnail();?> 
            <div class="card-body">
				<div class="card-body-details">
					<div class="blog-tag"><?php echo get_the_category_list();?></div><div class="blog-details"><?php the_time('n.j.Y');?></div>
				</div>
				<a href="<?php the_permalink(); ?>"><h5 class="card-text"><?php the_title(); ?></h5></a>
      
            </div>
          </div>
        </div>
		<?php } wp_reset_postdata();?>

        

      </div>
    </div>
  </div>
  
  
</main>


<?php
	get_footer();
?>