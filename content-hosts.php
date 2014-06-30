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

      $parent = get_post_ancestors( $post );
      if ( $parent ) {
        $group_url = get_permalink( $parent[0] );
        $group_name = get_the_title( $parent[0] );
        $group_image = get_post_meta( $parent[0], '_rah_group_fb_icon', true );
      }
      $group_types = get_the_terms( $post->ID, 'type' );
      $types = implode( ', ', wp_list_pluck( $group_types, 'name' ) );
      $review_count = get_post_meta( $post->ID, '_host_review_count', true );

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
            <?php if (get_the_author() !=''){?>
            <div class="entry-meta"> <span class="cat-links">
              <?php the_category(', '); ?>
              </span><!-- .cat-links -->
            </div>
            <?php } ?>
            <!-- .entry-meta -->
            <h1 class="entry-title"> <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>">
              <?php the_title();?>
              </a> </h1>
            <!-- .entry-title -->
             <?php if (get_the_author() !=''){?>
            <div class="entry-meta clearfix">
              <div class="date"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>">
                Joined On: <?php the_time( get_option( 'date_format' ) ); ?>
                </a></div>
              <?php if ( isset( $group_name ) ) : ?>
              <div class="group"><img src="<?php echo $group_image; ?>" />
                <a href="<?php echo $group_url; ?>" title-"<?php echo esc_attr( $group_name ); ?>">
                <?php echo $group_name; ?>
              </a></div>
            <?php endif; ?>
              <br />
            <div class="widget-ratings-wrapper">
              <?php echo rah_generate_stars( get_post_meta( $post->ID, '_host_rating', true ) ); ?><br />
              <?php printf( _n( '%d Review', '%d Reviews', $review_count, 'interface' ), $review_count ); ?>
            </div>
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
                  echo '<a class="readmore" href="' . get_permalink() . 'new" title="'.the_title( '', '', false ).'">'.__( 'Rate Host', 'interface' ).'</a>';
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