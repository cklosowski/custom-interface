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
      do_action( 'interface_before_post' );
      ?>

      <section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php do_action( 'interface_before_post_header' ); ?>
        <article>
          <header class="entry-header">
            <?php if (get_the_author() !=''){?>
            <div class="entry-meta"> <span class="cat-links">
              <?php the_category(', '); ?>
              </span><!-- .cat-links -->
            </div>
            <?php } ?>
            <!-- .entry-meta -->
            <h1 class="entry-title"> <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>">
              <img src="<?php echo $group_image; ?>" /> &nbsp;<?php the_title();?>
              </a> </h1>
            <!-- .entry-title -->
             <?php if (get_the_author() !=''){?>
            <div class="entry-meta clearfix">
              <div class="date"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>">
                Added On: <?php the_time( get_option( 'date_format' ) ); ?>
                </a></div>
              <div class="by-author"><a href="<?php the_permalink(); ?>">
                <?php printf( _n( '%d Host', '%d Hosts', $host_count, 'interface' ), $host_count ); ?>
              </a></div>
              <div class="hosts">

              </a></div>
            </div>
            <!-- .entry-meta -->
          </header>
          <!-- .entry-header -->
          <div class="entry-content clearfix">
            <?php the_excerpt(); ?>
          </div>
          <!-- .entry-content -->
          <footer class="entry-meta clearfix"> <span class="tag-links">
            <?php $tag_list = get_the_tag_list( '', __( ' ', 'interface' ) );
                  if(!empty($tag_list)){
                echo $tag_list;

                  }?>
            </span><!-- .tag-links -->
            <?php
                  echo '<a class="readmore" href="' . get_permalink() . '" title="'.the_title( '', '', false ).'">'.__( 'View Group', 'interface' ).'</a>';
                  ?>
          </footer>
          <!-- .entry-meta -->
           <?php } else { ?>
         </header>
              <?php the_content();
            } ?>
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