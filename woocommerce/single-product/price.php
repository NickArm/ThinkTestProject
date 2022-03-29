<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>

<div style="overflow: hidden;">
<div style="float:left;" class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo $product->get_price_html(); ?></div>
<?php echo "<div class='points-tag' style='float:right;'>".get_field('product_points')."pts</div>";?>
</div>