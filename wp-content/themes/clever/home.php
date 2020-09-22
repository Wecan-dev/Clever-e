<?php get_header(); ?>

<?php get_template_part('sections/home/main-banner'); ?>
<?php get_template_part('sections/home/main-categories'); ?>
<?php get_template_part('sections/home/main-products'); ?>
<?php get_template_part('sections/home/main-club'); ?>
<?php get_template_part('sections/home/main-video'); ?>
<?php get_template_part('sections/home/main-newsletter'); ?>
<?php get_template_part('sections/home/main-seller'); ?>

              <?php if ( is_active_sidebar( 'sidebar-2' ) ) { ?>
              <aside class="in-header widget-area right" role="complementary">
                <?php dynamic_sidebar( 'sidebar-2' ); ?>
              </aside>
              <?php } ?>
<?php get_footer(); ?>