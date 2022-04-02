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
 <header class="flex-wrap">
  <div class="position-relative overflow-hidden p-3 p-md-5 text-center no-slider">
  
	 
	
		<div class="container">
		  <nav class="navbar navbar-expand-lg" style="width: 100%;">
			  <div class="container-fluid">
				<a href="/" class="logo d-flex align-items-center mb-3 mb-md-0">
					<img src="<?php echo get_theme_file_uri('assets/Logo/RitzLogoDark.svg');?>"/>
				  </a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarsExample09">
				  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
					  <a class="nav-link dropdown-toggle" href="#" id="dropdown09" data-bs-toggle="dropdown" aria-expanded="false">KAYKAS</a>
					  <ul class="dropdown-menu" aria-labelledby="dropdown09">
						<li><a class="dropdown-item" href="#">Action</a></li>
						<li><a class="dropdown-item" href="#">Another action</a></li>
						<li><a class="dropdown-item" href="#">Something else here</a></li>
					  </ul>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="#">MARINE</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link">JETSURF</a>
					</li>
					<li class="nav-item dropdown">
					  <a class="nav-link" href="#"  aria-expanded="false">RACKS</a>
					  
					</li>
				  </ul>
				  <div class="light-header-shop-icons">
	  
					<span>
						<a href="#"><img src="<?php echo get_theme_file_uri('assets/Icons/28/Search.svg');?>"/></a>
					</span>
					<span>
						<a href="#"><img src="<?php echo get_theme_file_uri('assets/Icons/28/Profile.svg');?>"/></a>
					</span>
					<span>
						<a href="#"><img src="<?php echo get_theme_file_uri('assets/Icons/28/Cart.svg');?>"/></a>
					</span>
				  </div>
				 
				</div>
			  </div>
			</nav>
		
    <div class="product-device shadow-sm d-none d-md-block"></div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
  </div>
</header>
