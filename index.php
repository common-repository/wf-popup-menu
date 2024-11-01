<?php 
/*
Plugin Name: WF Popup Menu
Plugin URI: http://hamidulbd.com/plugins/wfpopupmenu
Description: You can create Nice Popup Menu With this plugin . 
Author: Work-Fighter
Author URI: http://hamidulbd.com
Version: 1.0
*/

/* Adding Latest jQuery from Wordpress */
function wf_popup_menu_wp_latest_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'wf_popup_menu_wp_latest_jquery');

function wf_popup_menu_script() {
wp_enqueue_script('ppm-custom-scrollbar-main', plugins_url('/js/jquery.square_menu.js',__FILE__ ), array('jquery'));
wp_enqueue_style('ppm-custom-scrollbar-css', plugins_url('/css/square_menu.css', __FILE__));
}
add_action('init', 'wf_popup_menu_script');

/* Custom Post Register For Popup Menu */
function wf_popup_menu_post() {
	register_post_type('popup_menu',
		array(
			'labels' => array(
					'name' => __('Popup Menu'),
					'singular_name' => __('Popup Menu'),
					'add_new' => __('Add Popup Menu'),
					'add_new_item' => __('Add New Popup Menu'),
					'edit_item' => __('Edit Popup Menu'),
					'new_item' => __('New Popup Menu'),
					'view_item' => __('View Popup Menu'),
					'not_found' => __('Sorry, we couldn\'t find the Popup Menu  you are looking for.' )
				),
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'menu_position' => 14,
//			'show_in_menu' => false,
			'has_archive' => true,
			'hierarchical' => false,
			'capability_type' => 'post',
			'rewrite' => array( 'slug' => 'popup_menu' ),
			'supports' => array( 'title' )
			)
		);
	}	
add_action( 'init', 'wf_popup_menu_post' );

/* Add Custom meta box into popup menu custom post */
add_action( 'init', 'wf_popup_menu_cmb_meta_boxes', 9999 );
function wf_popup_menu_cmb_meta_boxes() {
    if ( !class_exists( 'cmb_Meta_Box' ) ) {
        require_once( 'lib/init.php' );
    }
}
include_once('inc/custom_meta_box.php');


/* Add ShortCode */
function wf_popup_menu_shortcode( $atts ) {
	ob_start();
    extract( shortcode_atts( array (
        'post_id' => 33
    ), $atts ) );
	$query = new WP_Query( array(
		'post_type' => 'popup_menu',
		'p' => $post_id
		) );
	if ( $query->have_posts() ) 
while ( $query->have_posts() ) : $query->the_post();	
	 ?>
<div class="<?php echo $post_id ?>" >
    <nav class="left">
       <?php 
	   $entries = get_post_meta( get_the_ID(), 'left_menu', true );
		foreach ( (array) $entries as $key => $entry ) {
    $left_url = $left_title = '';
    if ( isset( $entry['left_url'] ) )
        $left_url = esc_html( $entry['left_url'] );
	if ( isset( $entry['left_title'] ) )
        $left_title = esc_html( $entry['left_title'] );
 echo '<a href="'. $left_url .'" alt="" >'.$left_title.'</a>';
}

?> 

    </nav>
    <nav class="right">
             <?php 
	   $entries = get_post_meta( get_the_ID(), 'right_menu', true );
		foreach ( (array) $entries as $key => $entry ) {
    $right_url = $right_title = '';
    if ( isset( $entry['right_url'] ) )
        $right_url = esc_html( $entry['right_url'] );
	if ( isset( $entry['right_title'] ) )
        $right_title = esc_html( $entry['right_title'] );
 echo '<a href="'. $right_url .'" alt="" >'.$right_title.'</a>';
}

?> 
    </nav>
</div>
<script type="text/javascript">
	  jQuery(document).ready( function() {
	    jQuery(".<?php echo $post_id ?>").square_menu();
	  });	
</script>
<?php endwhile;wp_reset_postdata(); 
$myvariable = ob_get_clean();
	return $myvariable;
	}
add_shortcode( 'wf_popup_post', 'wf_popup_menu_shortcode' );
	

/* Show ShortCode into manage post */
function wf_popup_menu_admin_columns($defaults) {
    $defaults['shortcode_name'] = 'Short-Code';
    return $defaults;
}
function wf_popup_menu_admin_columns_shortcode($column_name, $post_ID) {
    if ($column_name == 'shortcode_name') {
		echo '[wf_popup_post post_id='.get_the_ID().']';
    }
}
add_filter('manage_popup_menu_posts_columns', 'wf_popup_menu_admin_columns', 10);
add_action('manage_popup_menu_posts_custom_column', 'wf_popup_menu_admin_columns_shortcode', 10, 2);

?>