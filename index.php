<?php
/**
 * Main template — portfolio excerpt only.
 * Not a complete installable theme without functions.php and full widget set.
 *
 * @link https://www.meawal.com
 */
get_header();

if (have_posts()) :
    while (have_posts()) :
        the_post();
        get_template_part('template-parts/post-card');
    endwhile;
endif;

get_footer();
