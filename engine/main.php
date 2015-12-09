<?php


function engine_register_post_type( $name, $slug, $supports, $exclude_from_search = false, $rewrite = '') {
	if(!$labels) {
		$labels = array(
			'name' => ucfirst($name),
			'singular_name' => ucfirst($name),
			'add_new' => __('Dodaj nowe', 'engine'),
			'add_new_item' => __('Dodaj nowe', 'engine'),
			'edit_item' => __('Edytuj', 'engine'),
			'new_item' => __('Nowe', 'engine'),
			'view_item' => __('Zobacz', 'engine'),
			'search_items' => __('Szukaj', 'engine'),
			'not_found' =>  __('Brak','engine'),
			'not_found_in_trash' => __('Brak','engine'), 
			'parent_item_colon' => ''
		  );
	  }
		
		if ( $rewrite == '') {
			$rewrite = $slug;
		}
	  
	  $args = array(
		'labels' => $labels,
		'public' => true,
		'exclude_from_search' => $exclude_from_search,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'rewrite' => array('slug' => $rewrite),
		'supports' => $supports,
		'taxonomies' => array('groups', 'post_tag') 
	  ); 
	  register_post_type( strtolower($slug), $args );
}



function engine_register_taxonomy($name, $slug, $posttype, $hierarchical = true) {

	if (!is_array($posttype)) $posttype = array($posttype);
	
	register_taxonomy(
		$slug, 
		$posttype, 
		array(
			"hierarchical" => $hierarchical,
		 	"label" => $name, 
		 	"singular_label" => ucfirst($name), 
		 	"rewrite" => 
			 	array(
			 		'slug' => strtolower($slug), 
			 		'hierarchical' => true
			 	)
		)
	); 
}

?>
