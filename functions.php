<?php
function custom_theme_files(){
	
    wp_enqueue_script('main_modernizr',get_theme_file_uri('/js/bootstrap.bundle.min.js'),NULL,true);
	 wp_enqueue_script('main_modernizr',get_theme_file_uri('/js/custom.js'),NULL,true);
    wp_enqueue_style('theme_main_style_extra_style', get_theme_file_uri('/css/bootstrap.min.css'));
	wp_enqueue_style('theme_main_style', get_theme_file_uri('/style.css'));
	wp_enqueue_style('theme_main_style_owl_carousel', get_theme_file_uri('/css/owl.carousel.min.css'));
	wp_enqueue_style('theme_main_style_owl_carousel_theme', get_theme_file_uri('/css/owl.theme.default.min.css'));
}

			
			
			
			
add_action('wp_enqueue_scripts','custom_theme_files');

//add custom menus
function theme_features(){
	add_theme_support('title-tag'); 
    register_nav_menu('headerMenuLocation','Header Menu');
    register_nav_menu('footerLocation1','Footer Menu One');
    register_nav_menu('footerLocation2','Footer Menu Two');
    register_nav_menu('footerLocation3','Footer Menu Three');
}

add_action('after_setup_theme','theme_features');



//add Custom Post Settings

function custom_admin_menu() {
    add_menu_page(
        __( 'Post Settings', 'my-textdomain' ),
        __( 'Post Settings', 'my-textdomain' ),
        'manage_options',
        'custom-post-settings-page',
        'my_admin_page_contents',
        'dashicons-admin-generic',
        3
    );
}
add_action( 'admin_menu', 'custom_admin_menu' );

function my_admin_page_contents() {
    ?>
    <h1> <?php esc_html_e( 'Post Settings.', 'my-plugin-textdomain' ); ?> </h1>
    <form method="POST" action="options.php">
    <?php
    settings_fields( 'custom-post-settings-page' );
    do_settings_sections( 'custom-post-settings-page' );
    submit_button();
    ?>
    </form>
    <?php
}


add_action( 'admin_init', 'my_settings_init' );

function my_settings_init() {

    add_settings_section(
        'sample_page_setting_section',
        __( 'Custom settings', 'my-textdomain' ),
        'my_setting_section_callback_function',
        'custom-post-settings-page'
    );

		add_settings_field(
		   'set_no_of_posts_field',
		   __( 'How many posts will appear on the homepage', 'my-textdomain' ),
		   'my_setting_markup',
		   'custom-post-settings-page',
		   'sample_page_setting_section'
		);

		register_setting( 'custom-post-settings-page', 'set_no_of_posts_field' );
}


function my_setting_section_callback_function() {
}


function my_setting_markup() {
    ?>
    <input type="text" id="set_no_of_posts_field" name="set_no_of_posts_field" value="<?php echo get_option( 'set_no_of_posts_field' ); ?>">
    <?php
}





//add sub-menu to posts to count from api

function count_posts_from_api_page(){

     add_submenu_page(
                     'edit.php', 
                     'Count External Posts',
                     'Count External Posts',
                     'manage_options', 
                     'count-posts-from-api',
                     'count_posts_from_api_render_page'
     );

}
add_action('admin_menu', 'count_posts_from_api_page');

function count_posts_from_api_render_page() {
    echo '<h1> Count External Posts From API </h1>';
	echo '<div style="margin-bottom:25px;">API Url: https://jsonplaceholder.typicode.com/posts </div>';
	$url = "https://jsonplaceholder.typicode.com/posts";
	$json = file_get_contents($url);
	$json_data = json_decode($json, true);
	echo "<span style='font-size:18px; font-weight:bold;'>Count External Posts: </span><span style='font-size:30px;color:red;font-weight:bold;'>".count($json_data)."</span>";
}

//admin count views at posts

function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
function getPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    if ($count > 1000) {
        return round ( $count / 1000 , 1 ).'K Views';
    } else {
        return $count.' Views';
    }
}

function add_post_views_column($defaults) {
    $defaults['post_views'] = __('Views');
    return $defaults;
}
add_filter('manage_posts_columns', 'add_post_views_column');

function get_post_views($column_name, $id){
    if($column_name === 'post_views') {
        echo getPostViews(get_the_ID());
    }
}
add_action('manage_posts_custom_column', 'get_post_views', 10, 2);



/*-----------------------------------------SINGLE PRODUCT PAGE---------------------------*/


remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 1);

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 30 );


/*CHANE PRODUCT PRICE ORDER (NORMAL-SALE) based on every product case*/

if (!function_exists('my_commonPriceHtml')) {

    function my_commonPriceHtml($price_amt, $regular_price, $sale_price) {
        $html_price = '<p class="price">';
        //if product is in sale
        if (($price_amt == $sale_price) && ($sale_price != 0)) {
            $html_price .= '<ins>' . wc_price($sale_price) . '</ins>';
            $html_price .= '<del>' . wc_price($regular_price) . '</del>';
        }
        //in sale but free
        else if (($price_amt == $sale_price) && ($sale_price == 0)) {
            $html_price .= '<ins>Free!</ins>';
            $html_price .= '<del>' . wc_price($regular_price) . '</del>';
        }
        //not is sale
        else if (($price_amt == $regular_price) && ($regular_price != 0)) {
            $html_price .= '<ins>' . wc_price($regular_price) . '</ins>';
        }
        //for free product
        else if (($price_amt == $regular_price) && ($regular_price == 0)) {
            $html_price .= '<ins>Free!</ins>';
        }
        $html_price .= '</p>';
        return $html_price;
    }

}

//change price order on single product (no variations)

add_filter('woocommerce_get_price_html', 'my_simple_product_price_html', 100, 2);

function my_simple_product_price_html($price, $product) {
    if ($product->is_type('simple')) {
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
        $price_amt = $product->get_price();
        return my_commonPriceHtml($price_amt, $regular_price, $sale_price);
    } else {
        return $price;
    }
}

add_filter('woocommerce_variation_sale_price_html', 'my_variable_product_price_html', 10, 2);
add_filter('woocommerce_variation_price_html', 'my_variable_product_price_html', 10, 2);

function my_variable_product_price_html($price, $variation) {
    $variation_id = $variation->variation_id;
    //creating the product object
    $variable_product = new WC_Product($variation_id);

    $regular_price = $variable_product->get_regular_price();
    $sale_price = $variable_product->get_sale_price();
    $price_amt = $variable_product->get_price();

    return my_commonPriceHtml($price_amt, $regular_price, $sale_price);
}

add_filter('woocommerce_variable_sale_price_html', 'my_variable_product_minmax_price_html', 10, 2);
add_filter('woocommerce_variable_price_html', 'my_variable_product_minmax_price_html', 10, 2);


//change price order on when variation price ahas set
function my_variable_product_minmax_price_html($price, $product) {
    $variation_min_price = $product->get_variation_price('min', true);
    $variation_max_price = $product->get_variation_price('max', true);
    $variation_min_regular_price = $product->get_variation_regular_price('min', true);
    $variation_max_regular_price = $product->get_variation_regular_price('max', true);

    if (($variation_min_price == $variation_min_regular_price) && ($variation_max_price == $variation_max_regular_price)) {
        $html_min_max_price = $price;
    } else {
        $html_price = '<p class="price">';
        $html_price .= '<ins>' . wc_price($variation_min_price). '</ins>';
        $html_price .= '<del>' . wc_price($variation_min_regular_price) .'</del>';
        $html_min_max_price = $html_price;
    }

    return $html_min_max_price;
}

?>


