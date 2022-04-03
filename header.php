<!doctype html>
<html lang="en">
  <head>
			<?php wp_head();?>
			<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
			<script src="wp-content/themes/think-custom-theme/js/owl.carousel.min.js"></script>
			<script src="wp-content/themes/think-custom-theme/js/custom.js"></script>
			<script>
			  $(document).ready(function(){
					  $('.owl-carousel').owlCarousel({
						  dots:false,
						nav:true,
						 navText: ["<div class='nav-button owl-prev'>‹</div>", "<div class='nav-button owl-next'>›</div>"],
						loop:true,
						margin:20,
						
						responsive:{
							0:{
								items:1
							},
							600:{
								items:3
							},
							1000:{
								items:4
							}
						}
					})
					});

    </script>
  </head>
<body>
 <header>





  <div class="position-relative overflow-hidden  text-center main-slider">
	<div class="container">
	
	 	<nav class="navbar navbar-expand-md p-3 p-md-5  navbar-light">
			<div class="container-fluid">
				<a href="/" class="logo align-items-center mb-3 mb-md-0">
							<img src="<?php echo get_theme_file_uri('assets/Logo/RitzLogoLight.svg');?>"/>
				</a>
					<a href="/" class="mobile-logo align-items-center mb-3 mb-md-0">
							<img src="<?php echo get_theme_file_uri('assets/Logo/RitzLogoDark.svg');?>"/>
				</a>
				
				
				<div class="collapse navbar-collapse" id="main-menu">
					<?php
					wp_nav_menu(array(
						'theme_location' => 'main-menu',
						'container' => false,
						'menu_class' => '',
						'fallback_cb' => '__return_false',
						'items_wrap' => '<ul id="%1$s" class="navbar-nav me-auto mb-2 mb-md-0 %2$s">%3$s</ul>',
						'depth' => 2,
						'walker' => new bootstrap_5_wp_nav_menu_walker()
					));
					?>
				</div>
						<div class="header-shop-icons">
							<span><a href="#"><img src="<?php echo get_theme_file_uri('assets/Icons/28/Search.svg');?>"/></a>	</span>
							<span>	<a href="#"><img src="<?php echo get_theme_file_uri('assets/Icons/28/Profile.svg');?>"/></a>	</span>
							<span>	<a href="#"><img src="<?php echo get_theme_file_uri('assets/Icons/28/Cart.svg');?>"/></a></span>
						  </div>
				<button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>		 
						</div>
				
		</nav>
		
    <div class="col-md-5 p-lg-5 mx-auto slider-content">
     <p class="lead fw-normal slogan-text">Let the adventure begin</p>
      <h1>Malta's Largest dedicated Kayak and SUP store</h1>
    </div>
  </div>
</div>
  
  
  
  
</header>
