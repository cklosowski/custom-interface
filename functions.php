<?php

function rah_enqueue_scripts() {
	wp_deregister_style( 'google_fonts' );
	$protocol = is_ssl() ? 'https' : 'http';
	wp_register_style( 'google_fonts', $protocol . '://fonts.googleapis.com/css?family=PT+Sans:400,700italic,700,400italic' );
	wp_enqueue_style( 'google_fonts' );
}
add_action( 'wp_enqueue_scripts', 'rah_enqueue_scripts', 99 );

function rah_remove_actions() {
	remove_action( 'interface_footer', 'interface_footer_info', 30 );
	remove_action( 'interface_after_loop_content', 'interface_next_previous', 5 );
	remove_action( 'interface_searchform', 'interface_display_searchform', 10 );
}
add_action( 'init', 'rah_remove_actions', 99 );

function rah_add_ga() {
	?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-2194977-40', 'auto');
  ga('send', 'pageview');

</script>
	<?php
}
add_action( 'wp_head', 'rah_add_ga', 9999 );

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
  <li class="next">
    <?php next_posts_link( __( 'Next &raquo;', 'interface' ) ); ?>
  </li>
  <li class="previous">
    <?php previous_posts_link( __( '&laquo; Previous', 'interface' ) ); ?>
  </li>
</ul>
<?php
			endif;
		endif;
	}
}
add_action( 'interface_after_loop_content', 'rah_interface_next_previous', 5 );


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

function rah_interface_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
		// Proceed with normal comments.
		global $post;
	?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
  <article id="comment-<?php comment_ID(); ?>" class="comment">
    <header class="comment-meta comment-author vcard">
      <?php
      				$host_id = (int)get_host_id_from_user_id( $comment->user_id );
					echo '<a href="' . get_permalink( $post->post_parent ) . '">' . get_avatar( $comment, 75 ) . '</a>';
					printf( '<cite class="fn">%1$s %2$s</cite>',
						'<a href="' . get_permalink( $post->post_parent ) . '">' . get_the_title( $post->post_parent ) . '</a>',
						// If current post author is also comment author, make it known visually.
						( $host_id === $post->post_parent ) ? '<span> ' . __( 'Host', 'interface' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'interface' ), get_comment_date(), get_comment_time() )
					);
				?>
    </header>
    <!-- .comment-meta -->

    <?php if ( '0' == $comment->comment_approved ) : ?>
    <p class="comment-awaiting-moderation">
      <?php _e( 'Your comment is awaiting moderation.', 'interface' ); ?>
    </p>
    <?php endif; ?>
    <section class="comment-content comment">
      <?php comment_text(); ?>
      <?php edit_comment_link( __( 'Edit', 'interface' ), '<p class="edit-link">', '</p>' ); ?>
    </section>
    <!-- .comment-content -->
  </article>
  <!-- #comment-## -->
  <?php
}

function rah_interface_footer() {
	$output = '<div class="copyright">'.__( 'Copyright &copy;', 'interface' ).' '.interface_the_year().' ' .interface_site_link().' | Site Development by <a href="https://kungfugrep.com/?utm_campaign=credit&utm_source=hrb&utm_medium=footer-link">Chris Klosowski</a> & <a href="https://filament-studios.com/?utm_campaign=credit&utm_source=hrb&utm_medium=footer-link">Filament Studios</a></div>';
	echo $output;
}
add_action( 'interface_footer', 'rah_interface_footer', 30 );

function rah_search_form() {
?>
<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="searchform clearfix">
	<label class="assistive-text">
		<?php _e( 'Search Hosts', 'interface' ); ?>
	</label>
	<?php
	$value = '';
	if ( isset( $_GET['s'] ) ) {
		$value = esc_attr( $_GET['s'] );
	}
	?>
	<input type="search" placeholder="<?php esc_attr_e( 'Search Hosts', 'interface' ); ?>" class="s field" name="s" value="<?php echo $value; ?>">
	<input type="hidden" name="post_type" value="hosts" />
	<input type="submit" value="<?php esc_attr_e( 'Search', 'interface' ); ?>" class="search-submit">
	</form>
	<!-- .search-form -->
	<?php
}
add_action( 'interface_searchform', 'rah_search_form', 10 );

