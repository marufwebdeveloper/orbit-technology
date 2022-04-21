<?php

/**
 * Plugin Name: Team Member
 * Plugin URI: 
 * Description: Team Member
 * Version: 1.0.0
 */

add_action( 'wp_enqueue_scripts', function(){
	wp_enqueue_style( 'team-member-style', plugins_url( 'assets/css/style.css', __FILE__ ) );
});

add_action( 'init',function() {
    register_post_type( ss00_settings('post_type_url'),
        array(
        	'menu_icon' => 'dashicons-businessperson',
            'labels' => array(
                'name' => __( ss00_settings('post_type_name') ),
                'singular_name' => __( ss00_settings('post_type_name') ),
                'add_new_item' => __('Add '.ss00_settings('post_type_name'), 'txtdomain'),
				'new_item' => __('New '.ss00_settings('post_type_name'), 'txtdomain'),
				'view_item' => __('View '.ss00_settings('post_type_name'), 'txtdomain'),
				'not_found' => __('No '.ss00_settings('post_type_name').' found', 'txtdomain'),
				'not_found_in_trash' => __('No '.ss00_settings('post_type_name').' found in trash', 'txtdomain'),
				'all_items' => __('All '.ss00_settings('post_type_name'), 'txtdomain'),
				'insert_into_item' => __('Insert into '.ss00_settings('post_type_name'), 'txtdomain')
	        ),
            'has_archive' => true,
            'supports' => ['title', 'editor', 'thumbnail', 'author'],
            'public' => true,
            'rewrite' => array('slug' => ss00_settings('post_type_url'))
        )
    );
    register_taxonomy(ss00_settings('taxonomy_url'), [ss00_settings('post_type_url')], [
		'hierarchical' => true,
		'rewrite' => ['slug' => ss00_settings('taxonomy_url')],
		'show_admin_column' => true,
		'show_in_rest' => true,
		'labels' => [
			'name' => __(ss00_settings('taxonomy_name'), 'txtdomain'),
			'singular_name' => __(ss00_settings('taxonomy_name'), 'txtdomain'),
			'all_items' => __('All '.ss00_settings('taxonomy_name'), 'txtdomain'),
			'edit_item' => __('Edit '.ss00_settings('taxonomy_name'), 'txtdomain'),
			'view_item' => __('View '.ss00_settings('taxonomy_name'), 'txtdomain'),
			'update_item' => __('Update '.ss00_settings('taxonomy_name'), 'txtdomain'),
			'add_new_item' => __('Add New '.ss00_settings('taxonomy_name'), 'txtdomain'),
			'new_item_name' => __('New '.ss00_settings('taxonomy_name'), 'txtdomain'),
			'search_items' => __('Search '.ss00_settings('taxonomy_name'), 'txtdomain'),
			'popular_items' => __('Popular '.ss00_settings('taxonomy_name'), 'txtdomain'),
			'separate_items_with_commas' => __('Separate authors with comma', 'txtdomain'),
			'choose_from_most_used' => __('Choose from most used '.ss00_settings('taxonomy_name'), 'txtdomain'),
			'not_found' => __('No '.ss00_settings('taxonomy_name').' found', 'txtdomain'),
		]
	]);

	 
});

add_action( 'admin_menu', function(){
	add_submenu_page(
        'edit.php?post_type='.ss00_settings('post_type_url'),
        __('Settings', 'txtdomain'),
        __('Settings', 'txtdomain'),
        'manage_options',
        'team-member-settings',
        function(){
        	require_once dirname(__FILE__) .'/settings-team-member.php';
        });
} );


add_action( 'edit_form_after_title', function() {
	$screen = get_current_screen();
	if  ( ss00_settings('post_type_url') == $screen->post_type ) {
          echo '<h1>Bio : </h1>';
     } 
	
});
   
add_filter( 'enter_title_here', function ( $title ){
     $screen = get_current_screen();
   
     if  ( ss00_settings('post_type_url') == $screen->post_type ) {
          $title = 'Enter Member Name';
     }   
     return $title;
});

add_action( 'add_meta_boxes', function() {
    add_meta_box( 'team_member_position', 'Position / Designation', function($post){
    	$meta_val = get_post_meta( $post->ID, 'team-member-position', true );
    	echo "<input type='text' name='team-member-position' value='".esc_attr( $meta_val )."' placeholder='Enter Member Position/Designation' style='width:100%'/>";
    }, ss00_settings('post_type_url'), 'normal' ,'high');
} );
 

add_action( 'save_post', function( $post_id ) {
    if ( isset( $_POST['team-member-position'] ) ) {
        update_post_meta( $post_id, 'team-member-position', $_POST['team-member-position'] );
    }
} );



add_filter( 'single_template', function ( $single_template ){
    global $post;
    if($post->post_type == ss00_settings('post_type_url')){
    	$file = dirname(__FILE__) .'/single-team-member.php';
    	if( file_exists( $file ) ) $single_template = $file;
    }
    return $single_template;
} );

add_filter( 'archive_template', function ( $single_template ){
    global $post;
    if($post->post_type == ss00_settings('post_type_url')){
    	$file = dirname(__FILE__) .'/archive-team-member.php';
    	if( file_exists( $file ) ) $single_template = $file;
    }
    return $single_template;
} );



add_shortcode( 'team_members', function( $atts = '' ) {
    $params = shortcode_atts( array(
        'number_of_member' => '',
        'image_position' => '', // top,bottom
        'view_more_button' =>'' // show/hide
    ), $atts );

	ob_start();
	require_once dirname(__FILE__) .'/short-code-team-member.php';
	$output = ob_get_contents();
	ob_end_clean();

    return $output;
});


function ss00_settings($need){
	$settings = get_option('ss00_team_member_settings');
	$settings = [
		'post_type_name' => $settings['post_type_name']??'Team Members',
		'post_type_url' => isset($settings['post_type_url'])?str_replace(' ','-',$settings['post_type_url']):'team-member',
		'taxonomy_name' => $settings['taxonomy_name']??'Member Type',
		'taxonomy_url' => isset($settings['taxonomy_url'])?str_replace(' ','-',$settings['post_type_url']):'team-member-type'
	];

	return $settings[$need]??'';
}


/*
add_action('init', function() {

    register_post_type('team-member', [
        'label' => __('Team Member', 'txtdomain'),
        'public' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-book',
        'supports' => ['title', 'editor', 'thumbnail', 'author', 'revisions', 'comments'],
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'team-member'],
        'labels' => [
            'singular_name' => __('Team-Member', 'txtdomain'),
            'add_new_item' => __('Add new member', 'txtdomain'),
            'new_item' => __('New member', 'txtdomain'),
            'view_item' => __('View member', 'txtdomain'),
            'not_found' => __('No team member found', 'txtdomain'),
            'not_found_in_trash' => __('No team member found in trash', 'txtdomain'),
            'all_items' => __('All Team Member', 'txtdomain'),
            'insert_into_item' => __('Insert into team-member', 'txtdomain')
        ],      
    ]);
    register_taxonomy('member_type', ['team-member'], [
        'label' => __('Member Type', 'txtdomain'),
        'hierarchical' => true,
        'rewrite' => ['slug' => 'team-member-type'],
        'show_admin_column' => true,
        'show_in_rest' => true,
        'labels' => [
            'singular_name' => __('Member type', 'txtdomain'),
            'all_items' => __('All Member types', 'txtdomain'),
            'edit_item' => __('Edit Member type', 'txtdomain'),
            'view_item' => __('View Member type', 'txtdomain'),
            'update_item' => __('Update Member type', 'txtdomain'),
            'add_new_item' => __('Add New Member type', 'txtdomain'),
            'new_item_name' => __('New Member type Name', 'txtdomain'),
            'search_items' => __('Search Member types', 'txtdomain'),
            'popular_items' => __('Popular Member types', 'txtdomain'),
            'separate_items_with_commas' => __('Separate authors with comma', 'txtdomain'),
            'choose_from_most_used' => __('Choose from most used member type', 'txtdomain'),
            'not_found' => __('No Member types found', 'txtdomain'),
        ]
    ]);
});
*/
