<?php
/**
 * This file displays page with right sidebar.
 *
 * @package Theme Horse
 * @subpackage Interface
 * @since Interface 1.0
 */
?>
<?php do_action( 'interface_before_primary' ); ?>
<div id="primary" class="no-margin-left">
<?php
do_action( 'interface_before_loop_content' );

global $post;

if( have_posts() ) {
	while( have_posts() ) {
		the_post();

		$parent = get_post_ancestors( $post );

		if ( $parent ) {
			$group_url   = get_permalink( $parent[0] );
			$group_name  = get_the_title( $parent[0] );
			$group_image = get_post_meta( $parent[0], '_rah_group_fb_icon', true );
		}

		$group_types     = get_the_terms( $post->ID, 'type' );
		$types           = implode( ', ', wp_list_pluck( $group_types, 'name' ) );
		$review_count    = get_post_meta( $post->ID, '_host_review_count', true );
		$host_since      = get_post_meta( $post->ID, '_user_host_since', true );

		$host_location   = get_post_meta( $post->ID, '_user_postal_code', true );
		$location_string = '';

		if ( ! empty( $host_location ) ) {
			$city  = rah_get_postal_city( $host_location );
			$state = rah_get_postal_state( $host_location );

			if ( ! empty( $city ) ) {
				$location_string .= $city . ', ';
			}

			$location_string .= $state;
		}
		do_action( 'interface_before_post' );
		?>

		<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php do_action( 'interface_before_post_header' ); ?>

			<article>

				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>">
					<div class="archive-avatar">
						<?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
					</div>
				</a>

				<header class="entry-header">

					<?php if ( get_the_author() !='' ) { ?>
						<div class="entry-meta">
							<span class="cat-links"><?php the_category(', '); ?></span>
						</div>
					<?php } ?>

					<h1 class="entry-title">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title();?></a>
					</h1>

				</header>

				<div class="entry-content clearfix">
					<div class="entry-meta clearfix">
						<?php if ( ! empty( $location_string ) ) : ?>
							<div class="location"><span class="dashicons dashicons-location-alt"></span><?php echo $location_string; ?></div>
						<?php endif; ?>

						<?php if ( ! empty( $host_since ) ) : ?>
						<?php $host_since = str_replace( '/', '/1/', $host_since ); ?>
						<div class="date">
							Host Since: <?php echo date( 'F Y', strtotime( $host_since ) ); ?>
						</div>
						<?php endif; ?>

						<div class="date">
							<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>">
								Joined On: <?php the_time( get_option( 'date_format' ) ); ?>
							</a>
						</div>

						<?php if ( !empty( $parent ) ) : ?>
							<div class="group"><?php if( $group_image ) :?><img src="<?php echo $group_image; ?>" /> &nbsp;<?php endif; ?>
								<a href="<?php echo $group_url; ?>" title-"<?php echo esc_attr( $group_name ); ?>">
									<?php echo $group_name; ?>
								</a>
							</div>
							<?php unset( $parent ); ?>
						<?php endif; ?>

						<?php $host_buys = wp_get_post_terms( get_the_ID(), 'buys' ); ?>
						<?php if ( ! empty( $host_buys ) ) : ?>
						<div class="hosts-buys clearfix">
							<strong>Runs Buys For</strong>
							<?php foreach ( $host_buys as $buy ) : ?>
								<?php $image = RAH_URL . 'assets/images/' . $buy->slug . '-logo.jpg'; ?>
								<img class="host-buy-logo" src="<?php echo $image; ?>" />
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
					</div>
					<?php the_excerpt(); ?>
				</div>

				<footer class="entry-meta clearfix">
					<div class="hosts-ratings-wrapper">
						<?php echo rah_generate_stars( get_post_meta( $post->ID, '_host_rating', true ) ); ?>&nbsp;
						<?php printf( _n( '%d Review', '%d Reviews', $review_count, 'interface' ), $review_count ); ?>
					</div>
					<?php echo '<a class="readmore" href="' . get_permalink() . 'new" title="'.strip_tags(the_title( '', '', false )).'">'.__( 'Rate Host', 'interface' ).'</a>'; ?>
				</footer>

			</article>

		</section>
		<!-- .post -->
		<?php
		do_action( 'interface_after_post' );

	}
} else { ?>
	<h1 class="entry-title">
		<?php _e( 'No Posts Found.', 'interface' ); ?>
	</h1>
<?php
}

do_action( 'interface_after_loop_content' );
?>
</div>
<!-- #primary -->

<?php do_action( 'interface_after_primary' ); ?>
<div id="secondary">
	<?php get_sidebar( 'right' ); ?>
</div>
<!-- #secondary -->
