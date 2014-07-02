<?php
remove_action( 'interface_after_loop_content', 'interface_next_previous', 5 );
add_action( 'interface_after_loop_content', 'rah_interface_next_previous', 5 );

function rah_interface_next_previous() {
	if( is_archive() || is_home() || is_search() ) {
		/**
		 * Checking WP-PageNaviplugin exist
		 */
		if ( function_exists('wp_pagenavi' ) ) :
			wp_pagenavi();

		else:
			global $wp_query;
			if ( $wp_query->max_num_pages > 1 ) :
			?>
<ul class="default-wp-page clearfix">
  <li class="previous">
    <?php next_posts_link( __( '&laquo; Next', 'interface' ) ); ?>
  </li>
  <li class="next">
    <?php previous_posts_link( __( 'Previous &raquo;', 'interface' ) ); ?>
  </li>
</ul>
<?php
			endif;
		endif;
	}
}

function interface_header_title() {
	global $post;
	if ( is_object( $post ) ) {
		if ( $post->post_type === 'hosts' ) {
			$interface_header_title = 'Host Directory';
		} elseif ( $post->post_type === 'groups' ) {
			$interface_header_title = 'Group Directory';
		} elseif ( $post->post_type === 'reviews' ) {
			$interface_header_title = 'Recently Approved Reviews';
		}
	}

	if( is_archive() ) {
		$interface_header_title = single_cat_title( '', FALSE );
	}
	elseif( is_404() ) {
		$interface_header_title = __( 'Page NOT Found', 'interface' );
	}
	elseif( is_search() ) {
		$interface_header_title = __( 'Search Results', 'interface' );
	}
	elseif( is_page_template()  ) {
		$interface_header_title = get_the_title();
	}
	else {
		$interface_header_title = get_the_title();
	}

	return $interface_header_title;

}