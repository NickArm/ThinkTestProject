<?
function custom_theme_files(){
    wp_enqueue_script('main_modernizr',get_theme_file_uri('/js/bootstrap.bundle.min.js'),NULL,true);
    wp_enqueue_style('theme_main_style_extra_style', get_theme_file_uri('/css/bootstrap.min.css'));
	wp_enqueue_style('theme_main_style', get_theme_file_uri('/style.css'));
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

function think_post_settings_page() {

	add_menu_page(
		'Home Page Post Settings',
		'Home Page Post Settings', 
		'manage_options', 
		'think-post-settings',
		'think_post_settings_content',
		'gear', 
		5
	);

}

add_action( 'admin_menu', 'think_post_settings_page' );

function think_post_settings_content(){

		echo '<div class="wrap"><h1>Home Page Post Settings</h1><form method="post" action="options.php">';
		settings_fields( 'think_post_settings' ); 
		do_settings_sections( 'think_post_settings' ); 
		submit_button();

	echo '</form></div>';

}



//add sub-menu to posts to count from api

function count_posts_from_api_page(){

     add_submenu_page(
                     'edit.php', //$parent_slug
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

?>