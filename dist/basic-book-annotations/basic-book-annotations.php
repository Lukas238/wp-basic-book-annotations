<?php
/**
 * Plugin Name: Basic Book Annotations
 * Plugin URI: http://c238.com.ar
 * Description: This plugin adds annotations for books in the Basic Book Library plugin.
 * Version: 1.0
 * Author: Lucas Dasso
 * Author URI: http://c238.com.ar
 */
 
 
/************
	SETUP
 ************/



 
// Register Custom Post Type BOOKS
function basicbookannotatios_custom_post_type_books() {

	$labels = array(
		'name'                => _x( 'Anotaciones', 'Post Type General Name', 'basicbookannotatios' ),
		'singular_name'       => _x( 'Anotación', 'Post Type Singular Name', 'basicbookannotatios' ),
		'menu_name'           => __( 'Anotaciones', 'basicbookannotatios' ),
		'parent_item_colon'   => __( 'Anotación padre:', 'basicbookannotatios' ),
		'all_items'           => __( 'Todas las Anotaciones', 'basicbookannotatios' ),
		'view_item'           => __( 'Ver Anotación', 'basicbookannotatios' ),
		'add_new_item'        => __( 'Agregar una nueva Anotación', 'basicbookannotatios' ),
		'add_new'             => __( 'Agregar Anotación', 'basicbookannotatios' ),
		'edit_item'           => __( 'Editar Anotación', 'basicbookannotatios' ),
		'update_item'         => __( 'Actualizar Anotación', 'basicbookannotatios' ),
		'search_items'        => __( 'Buscar Anotaciones', 'basicbookannotatios' ),
		'not_found'           => __( 'No se encontr&oacute; nung&uacute;na anotación', 'basicbookannotatios' ),
		'not_found_in_trash'  => __( 'No se encontr&oacute; nung&uacute;na anotación en la papelera', 'basicbookannotatios' ),
	);
	$rewrite = array(
		'slug'                => 'annotations',
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);
	$args = array(
		'label'               => __( 'Anotaciones', 'basicbookannotatios' ),
		'description'         => __( 'Posts de Anotaciones.', 'basicbookannotatios' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor'),
		'taxonomies'          => false,
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 22,
		'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'page',
	);
	register_post_type( 'bba_book_annotation', $args );

}

// Hook into the 'init' action
add_action( 'init', 'basicbookannotatios_custom_post_type_books', 0 );



/*
function basicbookannotations_shortcode_bookshelf( $atts ){
	
	$args = shortcode_atts(
		array(
			'genres' => '',
			'series' => '',
			'books_per_page' => '20'
		),
		$atts 
	);
	
	return basicbookannotations_bookshelf($args);
}
add_shortcode('bba-bookshelf', 'basicbookannotations_shortcode_bookshelf');
*/


/*
function basicbookannotations_bookshelf($args){
	
	wp_enqueue_style( 'basicbookannotations_bookshelf_styles', plugins_url( 'css/bookshelf.css', __FILE__) );
	
	extract( $args ); 

	$genres = ( trim($genres) <> '' ) ? explode(',', $genres) : $genres;
	$series = ( trim($series) <> '' ) ? explode(',', $series) : $series;
	
	
	$filters = array();
	
	
	if( is_array( $genres ) ){
		array_push($filters, array(
			   'taxonomy' => 'bbl_genres_taxonomy',
			   'field' => 'id',
			   'terms' => $genres
			)
		);
	}
	
	if( is_array( $series ) ){
		array_push($filters, array(
			   'taxonomy' => 'bbl_series_taxonomy',
			   'field' => 'id',
			   'terms' => $series
			)
		);
	}
	
	$bookshelf = new WP_Query(
		array(
			'post_type' => 'bbl_post_book',
			'tax_query' => $filters,
			'posts_per_page' => $books_per_page
		)
	);
		
	ob_start(); 
	
	include( dirname(__FILE__) . '/templates/bookshelf.php');
	
	$output_string = ob_get_contents();  
    ob_end_clean();  
	
	return $output_string; 
}
*/




// STYLES & SCRIPTS

// FRONT STYLES
function basicbookannotations_add_custom_styles() {
	wp_enqueue_style( 'pureCSS', '//cdnjs.cloudflare.com/ajax/libs/pure/0.5.0/pure-min.css' );
	wp_enqueue_style( 'fontAwosome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css' );
}
add_action( 'wp_enqueue_scripts', 'basicbookannotations_add_custom_styles' );


//	ADMIN STYLES & SCRIPTS
function basicbookannotations_add_custom_style_in_admin($hook) {
	global $post_type;
	
	// WP ADMIN
	//STYLES
	wp_enqueue_style( 'fontAwosome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'basicbookannotations_admin_Styles', plugins_url( 'css/admin.css', __FILE__) );
	
	
	// CUSTOM POST PAGEd
    if( ($hook == 'post-new.php' || $hook == 'post.php') &&  $post_type == 'bba_book_annotation' ){
		//STYLES
		wp_enqueue_style( 'pureCSS', '//cdnjs.cloudflare.com/ajax/libs/pure/0.5.0/pure-min.css' );
		wp_enqueue_style( 'magnific_popup_styles', '//cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/0.9.9/magnific-popup.css' );
		
		// SCRIPTS
		wp_enqueue_script('magnific_popup_scripts', '//cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/0.9.9/jquery.magnific-popup.min.js');
		wp_enqueue_script( 'basicbookannotations_edit', plugins_url( 'js/scripts_page_edit.js', __FILE__) );
	}
}
add_action( 'admin_enqueue_scripts', 'basicbookannotations_add_custom_style_in_admin' );





//DEFAUTL ANOTATION POST TITLE
add_filter( 'wp_insert_post_data' , 'bba_filter_post_data' , '99', 2 );
function bba_filter_post_data( $data , $postarr ) {
	global $post;
	$id = $post->ID;
	
	if( $data['post_title'] == '' ){
		$data['post_title'] = __('Anotación', 'basicbookannotations') .' #'. $id;;
	}
    return $data;
}

add_filter( 'enter_title_here', 'bba_enter_title_here' );
function bba_enter_title_here( $title){
	$screen = get_current_screen();
	global $post;
	$id = $post->ID;
	
	if ( $screen->post_type == 'bba_book_annotation' ) {
		$title = __('Anotación', 'basicbookannotations') .' #'. $id;
	}
	return $title;
}



//CUSTOM POST LIST COLUMNS
//manage_edit-{$post_type}_columns
add_filter('manage_edit-bba_book_annotation_columns', 'add_new_bba_book_annotation_columns');
function add_new_bba_book_annotation_columns( $columns ) {
    
	$columns = array(
		'cb' 		=>	'<input type="checkbox" />',
		'title' 	=> 	__('Anotación', 'basicbookannotations'),
		'book' 	=> 	__('Libro', 'basicbookannotations'),
		'author' 	=>	__('Autor', 'basicbookannotations')
	);
 
    return $columns ;
}

//manage_{$post_type}_posts_custom_column
add_action( 'manage_bba_book_annotation_posts_custom_column', 'add_new_bba_book_annotation_column_content', 10, 2 );
function add_new_bba_book_annotation_column_content( $column, $post_id ) {
	global $post;

	switch( $column ) {

		case 'title' :
			echo $post->post_title;
			break;
			
			
		case 'book' :
			$book_id = get_post_meta( $post_id, '_bba_annotations_bookname', true );
			
			if ( empty( $book_id ) ){
				echo __( 'Sin libro', 'basicbookannotations');
			}else{
				$book_name = get_the_title( $book_id );
				if ( empty( $book_name ) ){
					echo __( 'Sin libro', 'basicbookannotations');
				}else{
					echo $book_name;
				}
			}
			
			break;
			
		
		case 'author' :
			echo $post->post_author;
			break;
	
		default :
			break;
	}
}






//CUSTOM POST METABOX
function bba_book_annotation_add_meta_box() {
	if( post_type_exists( 'bbl_post_book' ) ){
		add_meta_box( 'basicbookannotations_meta_box_annotationsbook', __('Anotación', 'basicbookannotations') , 'basicbookannotations_meta_callback_annotationsbook', 'bba_book_annotation', 'normal');		
	}
}

add_action( 'add_meta_boxes', 'bba_book_annotation_add_meta_box' );

function basicbookannotations_meta_callback_annotationsbook( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'bba_annotation_nonce' );
	

	global $post;
	
	//Recupero los metadatos
    $meta_annotationsinfo = get_post_meta( $post->ID);	
    ?>
	<input type="hidden" id="book-post-id" value="<?php echo $post->ID; ?>" />
	
	<div class="pure-form pure-form-aligned">
		<div class="pure-control-group">
		
			<label><?php _e('Libro', 'basicbookannotations'); ?>:</label>
			<?php
			$args = array( 
			   'post_type' => 'bbl_post_book', 
			   'orderby' => 'title',
			   'order' => 'DESC'
			);
			$books = new WP_Query( $args );
			if ( $books->have_posts() ) {
			?>
			<select name="bba_annotations_bookname" id="bba-annotations-bookname">
				<option><?php _e('Seleccione un libro' ,'basicbookannotations'); ?></option>
			<?php
				while ( $books->have_posts() ) {
					$books->the_post();
					
					$selected = '';
					if( $meta_annotationsinfo['_bba_annotations_bookname'][0] == get_the_ID() ){
						$selected = ' selected="selected"';
					}
					
					echo '<option value="'. get_the_ID() .'"'. $selected .'>' . get_the_title() . '</option>';
				}
			?>
			</select>
			<?php
			}
			wp_reset_postdata();
			?>		
		</div>		
	</div><!-- .pure-form -->
	<?php
}



/**
 * Saves the custom meta input
 */
function basicbookannotations_meta_save_bookinfo( $post_id ) {
	if( post_type_exists( 'bbl_post_book' ) ){
 
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'bba_annotation_nonce' ] ) && wp_verify_nonce( $_POST[ 'bba_annotation_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	 
		// Exits script depending on save status
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return;
		}
		
		
		
	 
		//ANNOTATION BOOK NAME
		if( isset( $_POST[ 'bba_annotations_bookname' ] ) ) {
			
			if( $_POST[ 'bba_annotations_bookname' ] != '' ){
				update_post_meta( $post_id, '_bba_annotations_bookname', sanitize_text_field( $_POST[ 'bba_annotations_bookname' ] ) );	
			}else{
				delete_post_meta( $post_id, '_bba_annotations_bookname');
			}
		}
				
    }
} // end dirvetbasicbookannotations_meta_save_testimonios()
add_action( 'save_post', 'basicbookannotations_meta_save_bookinfo' );




?>