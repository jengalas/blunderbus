<?php
/**
 * The template for displaying the font page.
 *
 * Template Name: Test Home Page
 *
 * @package Blunderbus
 */

get_header("homepage"); ?>

  <?php while ( have_posts() ) : the_post(); ?>

  <div class="row clearfix" id="main-content-with-carousel">
    <div class="container" style="background-color: transparent;">
      <div class="col-md-9 column">
        <?php if ( is_active_sidebar( 'custom-slider' )) :?>
        <div class="widget-area">
          <?php dynamic_sidebar( 'custom-slider' ); ?>
        </div>
        <?php endif;?>
      </div>
      <div class="col-md-3 column">
      <?php if ( is_active_sidebar( 'custom-about' )): ?>
      <div class="widget-area">
        <?php dynamic_sidebar( 'custom-about' ); ?>
      </div>
      <?php endif;?>
      </div>
    </div>
  </div>
  <div class="row clearfix">
    <div class="container" style="background-color: transparent;">
      <?php if ( is_active_sidebar( 'custom' )): ?>
      <div class="widget-area">
        <?php dynamic_sidebar( 'custom' ); ?>
      </div>
      <?php endif;?>
    </div>
  </div>

    <?php
      // If comments are open or we have at least one comment, load up the comment template
      if ( comments_open() || '0' != get_comments_number() )
        comments_template();
    ?>

  <?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>
