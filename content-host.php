<?php
/**
 * This file displays page with right sidebar.
 *
 * @package Theme Horse
 * @subpackage Interface
 * @since Interface 1.0
 */
?>
<?php
   /**
    * interface_before_primary
    */
   do_action( 'interface_before_primary' );
?>
<div id="primary" class="no-margin-left">
  <?php
      /**
       * interface_before_loop_content
     *
     * HOOKED_FUNCTION_NAME PRIORITY
     *
     * interface_loop_before 10
       */
      do_action( 'interface_before_loop_content' );

      /**
       * interface_loop_content
     *
     * HOOKED_FUNCTION_NAME PRIORITY
     *
     * interface_theloop 10
       */
  global $post, $wp_query;
    if ( ! isset( $wp_query->query_vars['new'] ) && ! isset( $wp_query->query_vars['save'] ) && ! isset( $wp_query->query_vars['edit'] ) ) {

    if( have_posts() ) {
      while( have_posts() ) {
        the_post();
        do_action( 'interface_before_post' );
        ?>
        <section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <article>
            <!-- entry content clearfix -->
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args = array(
                'post_type'      => 'reviews',
                'post_status'    => 'publish',
                'post_parent'    => $post->ID,
                'posts_per_page' => -1
                );

            $reviewsQuery = new WP_Query( $args );
            unset($args);

            if ( $reviewsQuery->have_posts() ) :
              while ( $reviewsQuery->have_posts() ) :
                $reviewsQuery->the_post();
                $xpost = get_post_meta( get_the_id(), '_review_xpost', true );
                ?>
                  <header class="entry-header host-review-item">
                    <?php if ( $xpost === 'yes' ) : ?>
                      <div class="xpost-badge"><span class="dashicons dashicons-randomize"></span>&nbsp;Cross-Post Review</div><br />
                    <?php endif; ?>
                    <?php $comment_counts = get_comment_count( get_the_id() ); ?>
                    <?php if ( $comment_counts['total_comments'] > 0 ) : ?>
                      <div class="replied-badge"><span class="dashicons dashicons-testimonial"></span>&nbsp;Host Has Replied</div>
                    <?php endif; ?>
                    <!-- .entry-meta -->
                    <h1 class="entry-title">
                      <a href="<?php the_permalink(); ?>"><?php the_title();?></a>
                    </h1>
                    <!-- .entry-title -->
                    <div class="entry-meta clearfix">
                      <div class="date"><a href="#" title="<?php echo esc_attr( get_the_time() ); ?>">
                        <?php the_time( get_option( 'date_format' ) ); ?>
                        </a></div>
                      <div class="by-author"><a href="#">
                        Anonymous
                      </a></div>
                    </div>
                    <div class="star-ratings-wrapper">
                      <?php $star_ratings = get_post_meta( get_the_id(), '_review_star_ratings', true ); ?>
                      <?php
                      if ( is_array( $star_ratings ) && count( $star_ratings ) > 0 ) {
                        foreach ( $star_ratings as $key => $rating ) {
                          ?><div class="rating-loop-wrapper"><?php
                          $rating_title = ucwords( str_replace( array( '_', 'rating', 'and' ), array( ' ', '', '&' ), $key ) );
                          ?>
                          <div class="review-shortname"><?php echo trim( $rating_title ); ?>:</div>
                          <div class="review-stars"><?php echo rah_generate_stars( $rating ); ?></div>
                          </div><?php
                        }
                      }
                      ?>
                    </div>
                    <div class="entry-content">
                      <h6>Additional Comments</h6>
                      <?php the_content(); ?>
                    </div>
                    <!-- .entry-meta -->
                  </header>
                <?php
              endwhile;
            else:
              ?><h5>This host has no reviews yet. <a href="<?php echo the_permalink(); ?>new">Be the first!</a></h5><?php
            endif;
            ?>
            <nav>
                <?php previous_posts_link( 'Newer posts &raquo;' ); ?>
                <?php next_posts_link('Older &raquo;') ?>
            </nav>
            <?php
            wp_reset_query();
            wp_reset_postdata();
            ?>
          </article>
        </section>
        <!-- .post -->
        <?php
              do_action( 'interface_after_post' );

            }
          }
          else {
            ?>
        <h1 class="entry-title">
          <?php _e( 'No Posts Found.', 'interface' ); ?>
        </h1>
        <?php
           }
      } elseif( isset( $wp_query->query_vars['new'] ) ) {
        echo do_shortcode( '[host_review_form]' );
      } elseif( isset( $wp_query->query_vars['save'] ) ) {
        echo do_shortcode( '[host_review_save]' );
      } elseif( isset( $wp_query->query_vars['edit'] ) ) {
        echo do_shortcode( '[host_review_edit_form]' );
      }
      /**
       * interface_after_loop_content
     *
     * HOOKED_FUNCTION_NAME PRIORITY
     *
     * interface_next_previous 5
     * interface_loop_after 10
       */
      do_action( 'interface_after_loop_content' );
   ?>
</div>
<!-- #primary -->

<?php
   /**
    * interface_after_primary
    */
   do_action( 'interface_after_primary' );
?>
<div id="secondary">
  <?php get_sidebar( 'host' ); ?>
</div>
<!-- #secondary -->
