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
	  
	  
	   <!-------------------------  TOP CATEGORIES ------------------------------->
<div class="top-categories main-section">
    <div class="container">
	<h2 class="section-title">Top Categories</h2>	  
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
	 <?php 
	  
  $args = array(
         'taxonomy'     => 'product_cat',
		 'hide_empty' => false
  );
 $all_categories = get_categories( $args );
 foreach ($all_categories as $cat) {
		$category_id = $cat->term_id;    
		$thumbnail_id  = (int) get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
		$cat_thumb_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
		$category = get_term_by('slug', $cat->name ,'product_cat'); 
		$cat_show_check = get_field('cat_show_in_homepage', $category );
		$thmb = wp_get_attachment_image_src($cat_thumb_id, 'medium');
		$parentcats = get_ancestors($category_id, 'product_cat');
		
		if ($cat_show_check == 1 ){
			
		?>
		  <div class="col">
          <div class="card ">
            
            <div class="card-body">
				<div class="parentcat"><a href="<?php echo get_term_link($cat->slug, 'product_cat') ;?>"><?php echo get_term( $parentcats [0])->name; ?></a></div>
				<a href="<?php echo get_term_link($cat->slug, 'product_cat') ;?>"><h5 class="card-text"><?php echo $cat->name; ?></h5></a>
            </div>
			<img src="<?php echo $thmb[0]; ?>" alt="<?php echo $cat->name; ?>" />
          </div>
        </div>
		
		<?
		}

         
}
	
	
	
	?>



        

      </div>
    </div>
  </div>
  
  
  
	  
	  <!---------------------------OUR FAVORITES------------------------------------->
	  
<div class="py-5 our-favorites main-section">
    <div class="container">
		<h2 class="section-title">Our Favorites</h2>	  
     
	  <div class="owl-carousel ">
	  
        <?php
		$homepageProducts = new WP_Query(array(
			'post_type' => 'product'
		));
		
		while ($homepageProducts -> have_posts()){
		$homepageProducts->the_post();
		$product = new WC_Product( $post->ID );
		$show_check = get_field('show_in_homepage') ;
		if ($show_check == 1 ){
		?>
		<div>
          <div class="carousel_thumb">
			<?php echo the_post_thumbnail('large');?>
			<span class="home-products-points-tag"><?php echo get_field('product_points'); ?>pts</span>
          </div>
		  <div class="card_body">
			<span class="our-favorites-categories"><?php echo get_field('custom_product_type'); ?></span>
              <a href="<?php the_permalink(); ?>"><h5 class="card-text"><?php the_title(); ?></h5></a>
              <span class="our-favorites-price"><?php echo preg_replace('/.00/', '',  $product->get_price_html());?></span>
			</div>
        </div>
		<?php  }		} wp_reset_postdata();?>
      </div>
   
  </div>
  
  <!---------------------------OUR BLOG------------------------------------->

	<div class="our-blog main-section">
    <div class="container">
	<h2 class="section-title">Keep Updated</h2>	  
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php 
		$num_posts = get_option( 'set_no_of_posts_field' );
		if ( empty($num_posts)){$num_posts=3;}
		$homepagePosts = new WP_Query(array(
			'posts_per_page'=>$num_posts
		));		
		while ($homepagePosts -> have_posts()){
		$homepagePosts->the_post();?>
	  
        <div class="col">
          <div class="card ">
            <?php the_post_thumbnail('large');?> 
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