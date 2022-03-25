
<?php get_header();
setPostViews(get_the_ID());
?>


<?php
while(have_posts()){
	the_post(); ?>
	
	<div class="container">
	<h1 style="color:#1a1a1a;"><?php  the_title();?></h1>
	<div><?php  the_content();?></div>
	</div>
	
<?php } ?>


<?php get_footer();?>