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
  global $post;

  if( have_posts() ) {
    while( have_posts() ) {
      the_post();

      $group_image = get_post_meta( $post->ID, '_rah_group_fb_icon', true );
      $hosts = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'hosts', 'posts_per_page' => -1, 'post_status' => 'publish' ), ARRAY_A );
      $host_count = is_array( $hosts ) ? count( $hosts ) : 0;
      $group_stats = rah_get_group_rating_stats( $post->ID );
      do_action( 'interface_before_post' );
      ?>
      <section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <article>
          <header class="entry-header">
            <?php if(get_the_time( get_option( 'date_format' ) )) { ?>

            <h1 class="entry-title">
              <?php if( $group_image ) :?><img src="<?php echo $group_image; ?>" /> &nbsp;<?php endif; ?><?php the_title();?>
              <?php if( $group_stats['group_rating'] > 0 ) :?>
                <div class="group-title-ratings"><?php echo rah_generate_stars( $group_stats['group_rating'] ); ?></div>
              <?php endif; ?>
            </h1>
            <!-- .entry-title -->
            <div class="entry-meta clearfix">
              <div class="date"><span>
                Added On: <?php the_time( get_option( 'date_format' ) ); ?>
                </span></div>
              <div class="by-author"><a href="<?php the_permalink(); ?>">
                <?php printf( _n( '%d Host', '%d Hosts', $host_count, 'interface' ), $host_count ); ?>
              </a></div>
              <?php if( $group_stats['group_reviews'] > 0 ) :?>
              <div class="comments"><span>Host Reviews: <?php echo $group_stats['group_reviews']; ?></span></div>
              <?php endif; ?>
            </div>
            <!-- .entry-meta -->
          </header>
          <!-- .entry-header -->
          <?php } ?>
          <div class="entry-content clearfix">
            <?php the_content(); ?>
            <h5>Hosts</h5>
            <?php foreach ( $hosts as $host ) : ?>
            <div>
              <a href="<?php echo get_permalink( $host['ID'] ); ?>">
                <div class="archive-avatar">
                  <?php echo get_avatar( get_user_id_from_host_id( $host['ID'] ) ); ?>
                  <p>
                    <div><?php echo $host['post_title']; ?></div>
                    <div class="star-ratings-wrapper">
                      <?php echo rah_generate_stars( get_post_meta( $host['ID'], '_host_rating', true ) ); ?>
                    </div>
                  </p>
                </div>
              </a>
            </div>
            <?php endforeach; ?>
          </div>
          <?php if(get_the_time( get_option( 'date_format' ) )) { ?>
        </header>
        <?php } ?>

          <!-- entry content clearfix -->

          <?php if( is_single() ) {
                    $tag_list = get_the_tag_list( '', __( ' ', 'interface' ) );

                  if( !empty( $tag_list ) ) { ?>
          <footer class="entry-meta clearfix"> <span class="tag-links">
            <?php
                      echo $tag_list;?>
            </span><!-- .tag-links -->
          </footer>
          <!-- .entry-meta -->
          <?php  }
                   }
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
  <?php get_sidebar( 'right' ); ?>
</div>
<!-- #secondary -->