<?php
// Register  my custom  menu page
function register_my_custom_menu_page () {
		add_menu_page( __( 'Custom Menu Title', 'textdomain' ), 'My Gallery', 'manage_options', 'my-plugin/test.php', '', plugins_url( '/images/text-input.png', __FILE__ ) );
		//add_action('admin_init', 'gdpr_field_label_settings');
}

add_action( 'admin_menu', 'register_my_custom_menu_page' );

function wporg_custom_post_type () {
		register_post_type( 'wporg_product', [
						'labels'      => [
								'name'          => __( 'Gallery' ),
								'singular_name' => __( 'Gallery' ),
						],
						'public'      => TRUE,
						'has_archive' => TRUE,
						'attributes' => TRUE,
						'search_items' => true,
						'supports' => array('title', 'editor', 'thumbnail', 'comments', 'author', 'revisions', 'test' ),
						'rewrite'     => [ 'slug' => 'my_gallery' ], // my custom slug
				] );
}
add_action( 'init', 'wporg_custom_post_type' );

add_filter( 'manage_wporg_product_posts_columns', 'set_custom_edit_book_columns' );
function set_custom_edit_book_columns($columns) {
		$columns['shortcode'] = __( 'Shortcode', 'your_text_domain' );
		
		return $columns;
}
// Add the data to the custom columns for the book post type:
add_action( 'manage_wporg_product_posts_custom_column' , 'custom_book_column', 10, 2 );
function custom_book_column( $column, $post_id ) {
		switch ( $column ) {
				
				case 'shortcode' :
						echo '[gallery id="'.$post_id.'"][/gallery]';
						break;
		}
}



add_action( 'admin_init', 'add_post_gallery_so_14445904' );
add_action( 'add_meta_boxes_page', 'add_page_gallery_so_14445904' );
add_action( 'admin_head-post.php', 'print_scripts_so_14445904' );
add_action( 'admin_head-post-new.php', 'print_scripts_so_14445904' );
add_action( 'save_post', 'update_post_gallery_so_14445904', 10, 2 );

// Make it work only in selected templates
$rep_fields_templates = [ 'page-aboutus.php' ];
$rep_fields_posts     = [
		'wporg_product',
		'style',
		'brand'
];

/**
 * Add custom Meta Box
 */

// Add meta box to custom posts
function add_post_gallery_so_14445904 () {
		global $rep_fields_posts;
		add_meta_box( 'post_gallery', 'Slideshow Gallery', 'post_gallery_options_so_14445904', $rep_fields_posts, 'normal', 'core' );
}

// Add meta box to custom page templates
function add_page_gallery_so_14445904 () {
		global $post, $rep_fields_templates;
		if ( in_array( get_post_meta( $post->ID, '_wp_page_template', TRUE ), $rep_fields_templates ) ) {
				add_meta_box( 'post_gallery', 'Slideshow Gallery', 'post_gallery_options_so_14445904', 'page', 'normal', 'core' );
		}
}

/**
 * Print the Meta Box content
 */
function post_gallery_options_so_14445904 () {
		global $post;
		$gallery_data = get_post_meta( $post->ID, 'wporg_product', TRUE );
		
		// Use nonce for verification
		wp_nonce_field( plugin_basename( __FILE__ ), 'noncename_so_14445904' );
		?>
		<div id = "dynamic_form">
				<div id = "field_wrap">
						<?php
						if ( isset( $gallery_data['image_url'] ) )
						{
						for ( $i = 0;
						$i < count( $gallery_data['image_url'] );
						$i ++ )
						{
						?>
						<div class = "field_row">
								<div class = "field_left">
										<div class = "form_field">
												<!--<label>Image URL</label>-->
												<input type = "hidden"
															 class = "meta_image_url"
															 name = "gallery[image_url][]"
															 value = "<?php esc_html_e( $gallery_data['image_url'][ $i ] ); ?>"
												/> <input type = "hidden"
																	class = "meta_image_id"
																	name = "gallery[image_id][]"
																	value = "<?php esc_html_e( $gallery_data['image_id'][ $i ] ); ?>"
												/>
										</div>
										<div class = "form_field" style = "margin-bottom: 20px">
												<label>Description</label> <textarea
												class = "meta_image_desc"
												name = "gallery[image_desc][]"
												rows = "3"
												style = "width: 100%"><?php esc_html_e( $gallery_data['image_desc'][ $i ] ); ?></textarea>
										</div>
										<input class = "button" type = "button" value = "Choose File" onclick = "add_image(this)"/>&nbsp;&nbsp;&nbsp;
										<input class = "button" type = "button" value = "Remove" onclick = "remove_field(this)"/>
								</div>
								<div class = "field_right image_wrap">
										<img src = "<?php esc_html_e( $gallery_data['image_url'][ $i ] ); ?>"/>
								</div>
								<div class = "clear"/>
						</div>
				</div>
				<?php
				} // endif
				} // endforeach
				?>
		</div>
		<div style = "display:none" id = "master-row">
				<div class = "field_row">
						<div class = "field_left">
								<div class = "form_field">
										<!--<label>Image URL</label>-->
										<input class = "meta_image_url" value = "" name = "gallery[image_url][]"/> <input
										class = "meta_image_id" value = "" name = "gallery[image_id][]"/>
								</div>
								<div class = "form_field" style = "margin-bottom: 20px">
										<label>Description</label> <textarea class = "meta_image_desc" name = "gallery[image_desc][]"
																												 rows = "3" style = "width: 100%"></textarea>
								</div>
								<input type = "button" class = "button" value = "Choose Image" onclick = "add_image(this)"/>&nbsp;&nbsp;&nbsp;
								<input class = "button" type = "button" value = "Remove" onclick = "remove_field(this)"/>
						</div>
						<div class = "field_right image_wrap">
						</div>
						<div class = "clear"></div>
				</div>
		</div>
		<div id = "add_field_row">
				<input class = "button" type = "button" value = "Add Image" onclick = "add_field_row();"/>
		</div>
		<?php if ( 'trend' == get_post_type( $post->ID ) ) { ?>
				<p style = "color: #a00;">Make sure the number if images you add is a <b>multiple of 5</b>.</p>
		<?php } ?>
		</div>
		<?php
}

/**
 * Print styles and scripts
 */
function print_scripts_so_14445904 () {
		// Check for correct post_type
		global $post, $rep_fields_templates, $rep_fields_posts;
		if ( ! in_array( get_post_meta( $post->ID, '_wp_page_template', TRUE ), $rep_fields_templates ) && ! in_array( get_post_type( $post->ID ), $rep_fields_posts ) ) {
				return;
		}
		?>
		<style type = "text/css">
				.field_left {
						float         : left;
						width         : 75%;
						padding-right : 20px;
						box-sizing    : border-box;
				}
				.field_right {
						float : left;
						width : 25%;
				}
				.image_wrap img {
						max-width : 100%;
				}
				#dynamic_form input[type=text] {
						width : 100%;
				}
				#dynamic_form .field_row {
						border        : 1px solid #cecece;
						margin-bottom : 10px;
						padding       : 10px;
				}
				#dynamic_form label {
						display       : block;
						margin-bottom : 5px;
				}
		</style>
		<script type = "text/javascript">
        function add_image(obj) {

            var parent = jQuery(obj).parent().parent('div.field_row');
            var inputField = jQuery(parent).find("input.meta_image_url");
            var inputFieldID = jQuery(parent).find("input.meta_image_id");
            var fileFrame = wp.media.frames.file_frame = wp.media({
                multiple: false
            });
            fileFrame.on('select', function () {
                var selection = fileFrame.state().get('selection').first().toJSON();
                inputField.val(selection.url);
                inputFieldID.val(selection.id);
                jQuery(parent)
                    .find("div.image_wrap")
                    .html('<img src="' + selection.url + '" />');
            });
            fileFrame.open();
            //});
        };

        function remove_field(obj) {
            var parent = jQuery(obj).parent().parent();
            parent.remove();
        }

        function add_field_row() {
            var row = jQuery('#master-row').html();
            jQuery(row).appendTo('#field_wrap');
        }
		</script>
		<?php
}

/**
 * Save post action, process fields
 */
function update_post_gallery_so_14445904 ( $post_id, $post_object ) {
		// Doing revision, exit earlier **can be removed**
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
		}
		
		// Doing revision, exit earlier
		if ( 'revision' == $post_object->post_type ) {
				return;
		}
		
		// Verify authenticity
		if ( ! wp_verify_nonce( $_POST['noncename_so_14445904'], plugin_basename( __FILE__ ) ) ) {
				return;
		}
		
		global $rep_fields_templates, $rep_fields_posts;
		if ( ! in_array( get_post_meta( $post_id, '_wp_page_template', TRUE ), $rep_fields_templates ) && ! in_array( get_post_type( $post_id ), $rep_fields_posts ) ) {
				return;
		}
		
		if ( $_POST['gallery'] ) {
				// Build array for saving post meta
				$gallery_data = [];
				for ( $i = 0; $i < count( $_POST['gallery']['image_url'] ); $i ++ ) {
						if ( '' != $_POST['gallery']['image_url'][ $i ] ) {
								$gallery_data['image_url'][]  = $_POST['gallery']['image_url'][ $i ];
								$gallery_data['image_id'][]   = $_POST['gallery']['image_id'][ $i ];
								$gallery_data['image_desc'][] = $_POST['gallery']['image_desc'][ $i ];
						}
				}
				
				if ( $gallery_data ) {
						update_post_meta( $post_id, 'wporg_product', $gallery_data );
				} else {
						delete_post_meta( $post_id, 'wporg_product' );
				}
		} // Nothing received, all fields are empty, delete option
		else {
				delete_post_meta( $post_id, 'wporg_product' );
		}
}

function gallery ($atts) {
		
		$a = shortcode_atts( array(
				'id' => '',
		), $atts, 'gallery' );
		
		$postId = $a['id'];
		
		$output = '';
		if ( '' != get_post_meta( $postId, 'wporg_product', TRUE ) ) {
				$gallery = get_post_meta( $postId, 'wporg_product', TRUE );
		}
		
		if ( isset( $gallery['image_id'] ) ) {
				$count = count( $gallery['image_id'] );
				
				$output .= '<div id="myModal" class="modal">
  <span class="close cursor" onclick="closeModal()">&times;</span>
  <div class="modal-content"></div></div>';
				
				$output .= '<div class="gallery1">';
				$output .= '<ul>';
				for ( $i = 0; $i < $count; $i ++ ) {
						$output .= '<li><a class="my-gallery-link" href="' . $gallery['image_url'][ $i ] . '"><img width="300" height="200" src="' . $gallery['image_url'][ $i ] . '"></a>';
				}
				$output .= '</ul>';
				$output .= '</div>';
				$output .= '<div class="clearfix"></div>';
		}
		
		return $output;
}

add_shortcode( 'gallery', 'gallery' );