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
   global $post;
?>
<div id="primary" class="no-margin-left">
<div class="backtohost-wrapper">
  <a class="readmore backtohost" href="<?php echo get_permalink( $post->post_parent ); ?>">Back to Host</a>
</div>
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
      ?>
        <section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <article>
            <!-- entry content clearfix -->
            <?php
                $xpost = get_post_meta( get_the_id(), '_review_xpost', true );
                ?>
                  <header class="entry-header host-review-item">
                    <?php if ( $xpost === 'yes' ) : ?>
                      <div class="xpost-badge"><span class="dashicons dashicons-randomize"></span>&nbsp;Cross-Post Review</div><br />
                    <?php endif; ?>
                    <!-- .entry-meta -->
                    <h1 class="entry-title">
                      <?php the_title();?>
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
                      <?php echo $post->post_content; ?>
                    </div>
                    <!-- .entry-meta -->
                  </header>
          </article>
          <?php comments_template( '/comments-reviews.php' ); ?>
        </section>
        <!-- .post -->
        <?php
              do_action( 'interface_after_post' );
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
