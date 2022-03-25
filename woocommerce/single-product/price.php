<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>

<div style="overflow: hidden;">
<div style="float:left;" class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo $product->get_price_html(); ?></div>
<?php echo "<div style='float:right;'>POINTS: ".get_field('product_points')."</div>";?>
</div>