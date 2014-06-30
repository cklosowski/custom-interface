<?php
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