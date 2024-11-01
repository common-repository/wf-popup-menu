<?php
function wf_cmb_box( $meta_boxes ) {
    $meta_boxes['wf_metabox'] = array(
        'id' => 'wf_metabox',
        'title' => 'Menu Item',
        'pages' => array('popup_menu'), // post type
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
				'id'          => 'left_menu',
				'type'        => 'group',
				'description' => __( 'Enter Left Menu Item', 'cmb' ),
				'options'     => 
					array(
						'group_title'   => __( 'Enter Your Link', 'cmb' ),
						'add_button'    => __( 'Add Another Link', 'cmb' ),
						'remove_button' => __( 'Remove Link', 'cmb' ),
						'sortable'      => true, // beta
				),
				'fields' => array(
					array(
						'name' => 'Entry URL',
						'id'   => 'left_url',
						'type' => 'text_url',
					),
					array(
						'name' => 'Entry Title',
						'id'   => 'left_title',
						'type' => 'text',
					),
				),
			),
			array(
				'id'          => 'right_menu',
				'type'        => 'group',
				'description' => __( 'Enter Right Menu Item', 'cmb' ),
				'options'     => 
					array(
						'group_title'   => __( 'Enter Your Link', 'cmb' ),
						'add_button'    => __( 'Add Another Link', 'cmb' ),
						'remove_button' => __( 'Remove Link', 'cmb' ),
						'sortable'      => true, // beta
				),
				'fields' => array(
					array(
						'name' => 'Entry URL',
						'id'   => 'right_url',
						'type' => 'text_url',
					),
					array(
						'name' => 'Entry Title',
						'id'   => 'right_title',
						'type' => 'text',
					),
				),
			),
		),
		);
 return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'wf_cmb_box' );

?>