<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
echo "<div class='custom_category'>".get_field('custom_product_type')."</div>";
the_title( '<h1 class="product_title entry-title">', '</h1>' );
