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

//add main-menu
class bootstrap_5_wp_nav_menu_walker extends Walker_Nav_menu
{
  private $current_item;
  private $dropdown_menu_alignment_values = [
    'dropdown-menu-start',
    'dropdown-menu-end',
    'dropdown-menu-sm-start',
    'dropdown-menu-sm-end',
    'dropdown-menu-md-start',
    'dropdown-menu-md-end',
    'dropdown-menu-lg-start',
    'dropdown-menu-lg-end',
    'dropdown-menu-xl-start',
    'dropdown-menu-xl-end',
    'dropdown-menu-xxl-start',
    'dropdown-menu-xxl-end'
  ];

  function start_lvl(&$output, $depth = 0, $args = null)
  {
    $dropdown_menu_class[] = '';
    foreach($this->current_item->classes as $class) {
      if(in_array($class, $this->dropdown_menu_alignment_values)) {
        $dropdown_menu_class[] = $class;
      }
    }
    $indent = str_repeat("\t", $depth);
    $submenu = ($depth > 0) ? ' sub-menu' : '';
    $output .= "\n$indent<ul class=\"dropdown-menu$submenu " . esc_attr(implode(" ",$dropdown_menu_class)) . " depth_$depth\">\n";
  }

  function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
    $this->current_item = $item;

    $indent = ($depth) ? str_repeat("\t", $depth) : '';

    $li_attributes = '';
    $class_names = $value = '';

    $classes = empty($item->classes) ? array() : (array) $item->classes;

    $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
    $classes[] = 'nav-item';
    $classes[] = 'nav-item-' . $item->ID;
    if ($depth && $args->walker->has_children) {
      $classes[] = 'dropdown-menu dropdown-menu-end';
    }

    $class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
    $class_names = ' class="' . esc_attr($class_names) . '"';

    $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
    $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

    $output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';

    $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
    $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
    $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
    $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

    $active_class = ($item->current || $item->current_item_ancestor || in_array("current_page_parent", $item->classes, true) || in_array("current-post-ancestor", $item->classes, true)) ? 'active' : '';
    $nav_link_class = ( $depth > 0 ) ? 'dropdown-item ' : 'nav-link ';
    $attributes .= ( $args->walker->has_children ) ? ' class="'. $nav_link_class . $active_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="'. $nav_link_class . $active_class . '"';

    $item_output = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }
}
// register main-menu
register_nav_menu('main-menu', 'Main menu');


//add title & woocommerce theme support

function theme_features(){
	add_theme_support('title-tag'); 
	
	add_theme_support('woocommerce', array(
		'product_grid' => array(
			'default_rows'=>10,
			'min_rows'=>5,
			'max_rows'=>10
			)
		));
		add_theme_support('wc-product-gallery-zoom');
		add_theme_support('wc-product-gallery-lightbox');
		add_theme_support('wc-product-gallery-slider');
	
		
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




    add_action('woocommerce_product_options_inventory_product_data', 'woocommerce_product_custom_fields');
    add_action('woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save');
    function woocommerce_product_custom_fields()
    {
        global $woocommerce, $post;
        echo '<div class="product_custom_field">';
        woocommerce_wp_text_input( array( 'id' => '_custom_product_material', 'label' => __('Material', 'woocommerce')  )  );
         woocommerce_wp_text_input(  array( 'id' => '_custom_product_lenght', 'label' => __('Lenght', 'woocommerce'))   );
        woocommerce_wp_text_input( array( 'id' => '_custom_product_width', 'label' => __('Width', 'woocommerce') )  );
		woocommerce_wp_text_input( array( 'id' => '_custom_product_capacity', 'label' => __('Capacity', 'woocommerce') )  );
		woocommerce_wp_text_input( array( 'id' => '_custom_product_cockpit', 'label' => __('Cockpit', 'woocommerce') )  );
		woocommerce_wp_text_input( array( 'id' => '_custom_product_weight', 'label' => __('Weight', 'woocommerce') )  );
		woocommerce_wp_text_input( array( 'id' => '_custom_product_storage_front', 'label' => __('Storage Front', 'woocommerce') )  );
		woocommerce_wp_text_input( array( 'id' => '_custom_product_storage_rear', 'label' => __('Storage Rear', 'woocommerce') )  );
        echo '</div>';
    }
	
	/*-----save extra fields in db--------*/
    function woocommerce_product_custom_fields_save($post_id)
    {

        $woocommerce_custom_product_material = $_POST['_custom_product_material'];
        if (!empty($woocommerce_custom_product_material))
            update_post_meta($post_id, '_custom_product_material', esc_attr($woocommerce_custom_product_material));

        $woocommerce_custom_product_lenght = $_POST['_custom_product_lenght'];
        if (!empty($woocommerce_custom_product_lenght))
			 update_post_meta($post_id, '_custom_product_lenght', esc_html($woocommerce_custom_product_lenght));

        $woocommerce_custom_product_width = $_POST['_custom_product_width'];
        if (!empty($woocommerce_custom_product_width))
            update_post_meta($post_id, '_custom_product_width', esc_html($woocommerce_custom_product_width));
		
		$woocommerce_custom_product_capacity = $_POST['_custom_product_capacity'];
        if (!empty($woocommerce_custom_product_capacity))
            update_post_meta($post_id, '_custom_product_capacity', esc_html($woocommerce_custom_product_capacity));
		
		$woocommerce_custom_product_cockpit = $_POST['_custom_product_cockpit'];
        if (!empty($woocommerce_custom_product_cockpit))
            update_post_meta($post_id, '_custom_product_cockpit', esc_html($woocommerce_custom_product_cockpit));
		
		$woocommerce_custom_product_weight= $_POST['_custom_product_weight'];
        if (!empty($woocommerce_custom_product_weight))
            update_post_meta($post_id, '_custom_product_weight', esc_html($woocommerce_custom_product_weight));
		
		$woocommerce_custom_product_storage_front= $_POST['_custom_product_storage_front'];
        if (!empty($woocommerce_custom_product_storage_front))
            update_post_meta($post_id, '_custom_product_storage_front', esc_html($woocommerce_custom_product_storage_front));
		
				$woocommerce_custom_product_storage_rear= $_POST['_custom_product_storage_rear'];
        if (!empty($woocommerce_custom_product_storage_rear))
            update_post_meta($post_id, '_custom_product_storage_rear', esc_html($woocommerce_custom_product_storage_rear));
		
    }
	
	
add_action( 'woocommerce_single_product_summary', 'hjs_below_single_product_summary', 50 );
function hjs_below_single_product_summary() {

		echo "<div class='single_product_custom_features_title'>Features</div>";
		echo '<table class="single_product_custom_features">';
			echo "<tr><td>Material</td><td>".get_post_meta(get_the_ID(), '_custom_product_material', true)."</td></tr>";
			echo "<tr><td>Lenght</td><td>".get_post_meta(get_the_ID(), '_custom_product_lenght', true)."</td></tr>";
			echo "<tr><td>Width</td><td>".get_post_meta(get_the_ID(), '_custom_product_width', true)."</td></tr>";
			echo "<tr><td>Capacity Approx</td><td>".get_post_meta(get_the_ID(), '_custom_product_capacity', true)."</td></tr>";
			echo "<tr><td>Cockpit</td><td>".get_post_meta(get_the_ID(), '_custom_product_cockpit', true)."</td></tr>";
			echo "<tr><td>Weight A-core</td><td>".get_post_meta(get_the_ID(), '_custom_product_weight', true)."</td></tr>";
			echo "<tr><td>Storage: Front</td><td>".get_post_meta(get_the_ID(), '_custom_product_storage_front', true)."</td></tr>";
			echo "<tr><td>Storage: Rear</td><td>".get_post_meta(get_the_ID(), '_custom_product_storage_rear', true)."</td></tr>";
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

//----------------change price order on single product (no variations)---------------------------------------//

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



























?>




