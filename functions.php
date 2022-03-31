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
	
	add_theme_support('woocommerce', array(
		'thumbnail_image_width' => 1280,
		'single_image_width'=>255,
		'product_grid' => array(
			'default_rows'=>10,
			'min_rows'=>5,
			'max_rows'=>10
			)
		));
		add_theme_support('wc-product-gallery-zoom');
		add_theme_support('wc-product-gallery-lightbox');
		add_theme_support('wc-product-gallery-slider');
		
		if(!isset($content_width)){
			$content_width=600;
		}
		
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


add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['description'] );          // Remove the description tab
    unset( $tabs['reviews'] );          // Remove the reviews tab
    unset( $tabs['additional_information'] );   // Remove the additional information tab
    return $tabs;
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 30 );

/*------------------------------------------EXTRA FIELDS----------------------------------------------*/


    // Display Fields
    add_action('woocommerce_product_options_general_product_data', 'woocommerce_product_custom_fields');
    // Save Fields
    add_action('woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save');
    function woocommerce_product_custom_fields()
    {
        global $woocommerce, $post;
        echo '<div class="product_custom_field">';
        // Custom Product Text Field
        woocommerce_wp_text_input(
            array(
                'id' => '_custom_product_material',
                'label' => __('Material', 'woocommerce')
            )
        );
        //Custom Product Number Field
         woocommerce_wp_text_input(
            array(
                'id' => '_custom_product_lenght',
                'label' => __('Lenght', 'woocommerce')
            )
        );
        //Custom Product  Textarea
        woocommerce_wp_text_input(
            array(
                'id' => '_custom_product_width',
                'label' => __('Width', 'woocommerce')
            )
        );
        echo '</div>';
    }
	
	/*-----save extra fields in db--------*/
    function woocommerce_product_custom_fields_save($post_id)
    {
        // Custom Product Text Field
        $woocommerce_custom_product_material = $_POST['_custom_product_material'];
        if (!empty($woocommerce_custom_product_material))
            update_post_meta($post_id, '_custom_product_material', esc_attr($woocommerce_custom_product_material));
    // Custom Product Number Field
        $woocommerce_custom_product_lenght = $_POST['_custom_product_lenght'];
        if (!empty($woocommerce_custom_product_lenght))
            update_post_meta($post_id, '_custom_product_lenght', esc_attr($woocommerce_custom_product_lenght));
    // Custom Product Textarea Field
        $woocommerce_custom_product_width = $_POST['_custom_product_width'];
        if (!empty($woocommerce_custom_product_width))
            update_post_meta($post_id, '_custom_product_width', esc_html($woocommerce_custom_product_width));
    }
	
	
	
add_action( 'woocommerce_single_product_summary', 'hjs_below_single_product_summary', 50 );
function hjs_below_single_product_summary() {
		echo "<div class='single_product_custom_features_title'>Features</div>";
		echo '<table class="single_product_custom_features">';
		// Display the value of custom product text field
			echo "<tr><td>Material</td><td>".get_post_meta(get_the_ID(), '_custom_product_material', true)."</td></tr>";
		// Display the value of custom product number field
			echo "<tr><td>Lenght</td><td>".get_post_meta(get_the_ID(), '_custom_product_lenght', true)."</td></tr>";
		// Display the value of custom product text area
			echo "<tr><td>Width</td><td>".get_post_meta(get_the_ID(), '_custom_product_width', true)."</td></tr>";
		echo '</table>';
}
	
	
	
	
	
/*------------------------------------------CHANE PRODUCT PRICE ORDER (NORMAL-SALE) based on every product case----------------------------------------------*/

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

//----------------change price order on single product (no variations)---------------------------------------

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


//-------------------change price order on when variation price ahas set--------------------------------
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


remove_action('woocommerce_sidebar','woocommerce_get_sidebar');




//----------------change varation select to buttons-----------------------------
function variation_radio_buttons($html, $args) {
  $args = wp_parse_args(apply_filters('woocommerce_dropdown_variation_attribute_options_args', $args), array(
    'options'          => false,
    'attribute'        => false,
    'product'          => false,
    'selected'         => false,
    'name'             => '',
    'id'               => '',
    'class'            => '',
    'show_option_none' => __('Choose an option', 'woocommerce'),
  ));

  if(false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product) {
    $selected_key     = 'attribute_'.sanitize_title($args['attribute']);
    $args['selected'] = isset($_REQUEST[$selected_key]) ? wc_clean(wp_unslash($_REQUEST[$selected_key])) : $args['product']->get_variation_default_attribute($args['attribute']);
  }

  $options               = $args['options'];
  $product               = $args['product'];
  $attribute             = $args['attribute'];
  $name                  = $args['name'] ? $args['name'] : 'attribute_'.sanitize_title($attribute);
  $id                    = $args['id'] ? $args['id'] : sanitize_title($attribute);
  $class                 = $args['class'];
  $show_option_none      = (bool)$args['show_option_none'];
  $show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __('Choose an option', 'woocommerce');

  if(empty($options) && !empty($product) && !empty($attribute)) {
    $attributes = $product->get_variation_attributes();
    $options    = $attributes[$attribute];
  }

  $radios = '<div class="variation-radios">';

  if(!empty($options)) {
    if($product && taxonomy_exists($attribute)) {
      $terms = wc_get_product_terms($product->get_id(), $attribute, array(
        'fields' => 'all',
      ));

      foreach($terms as $term) {
		  
		  
        if(in_array($term->slug, $options, true)) {
          $id = $name.'-'.$term->slug;
          $radios .= '<input type="radio" id="'.esc_attr($id).'" name="'.esc_attr($name).'" value="'.esc_attr($term->slug).'" '.checked(sanitize_title($args['selected']), $term->slug, false).'><label for="'.esc_attr($id).'">'.esc_html(apply_filters('woocommerce_variation_option_name', $term->name)).'</label>';
        }
      }
    } else {
      foreach($options as $option) {
        $id = $name.'-'.$option;
        $checked    = sanitize_title($args['selected']) === $args['selected'] ? checked($args['selected'], sanitize_title($option), false) : checked($args['selected'], $option, false);
        $radios    .= '<input type="radio" id="'.esc_attr($id).'" name="'.esc_attr($name).'" value="'.esc_attr($option).'" id="'.sanitize_title($option).'" '.$checked.'><label for="'.esc_attr($id).'">'.esc_html(apply_filters('woocommerce_variation_option_name', $option)).'</label>';
      }
    }
  }

  $radios .= '</div>';
    
  return $html.$radios;
}
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'variation_radio_buttons', 20, 2);

function variation_check($active, $variation) {
  if(!$variation->is_in_stock() && !$variation->backorders_allowed()) {
    return false;
  }
  return $active;
}
add_filter('woocommerce_variation_is_active', 'variation_check', 10, 2);




?>




