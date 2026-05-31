<?php

/**
 * Enqueue scripts and styles
 */

if (! function_exists('theme_scripts')) {
    function theme_scripts()
    {

        // ================= Fonts =================
        echo '<link rel="preload" href="https://fonts.cdnfonts.com/css/avenir-lt-pro?styles=60926,60921,60923,60919,60915" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
        echo '<link rel="preload" href="https://fonts.cdnfonts.com/css/somar-sans?styles=143705,143693,143669" as="style" onload="this.onload=null;this.rel=\'stylesheet\'>';


        // ================= Core =================
        wp_enqueue_script('jquery');


        // ================= CSS =================
        wp_enqueue_style(
            'bootstrap-css',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css'
        );

        wp_enqueue_style(
            'fontawesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'
        );

        wp_enqueue_style(
            'alqa_signals-style',
            get_template_directory_uri() . '/assets/css/style.css',
            array(),
            mt_rand()
        );

        wp_enqueue_style(
            'alqa_signals-responsive-style',
            get_template_directory_uri() . '/assets/css/responsive.css',
            array(),
            mt_rand()
        );

        wp_enqueue_style(
            'profile-css',
            THEME_URL . '/assets/css/profile.css',
            array(),
            mt_rand()
        );


        // ================= JS =================

        // Chart.js (NEW ADDITION)
        wp_register_script(
            'chart-js',
            'https://cdn.jsdelivr.net/npm/chart.js',
            array(),
            null,
            true
        );

        wp_enqueue_script('chart-js');


        wp_enqueue_script(
            'alqa_signals-script',
            get_template_directory_uri() . '/assets/js/script.js',
            array('jquery'),
            mt_rand(),
            true
        );

        wp_enqueue_script(
            'profile-js',
            THEME_URL . '/assets/js/profile.js',
            array('jquery'),
            mt_rand(),
            true
        );


        // ================= Localize =================

        wp_localize_script('alqa_signals-script', 'alqa', array(
            'home_url' => esc_url(home_url('/')),
            'theme_url' => esc_url(THEME_URL),
            'ajaxurl'   => admin_url('admin-ajax.php'),
        ));

        wp_localize_script('profile-js', 'alqa', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
        ));
    }
}


// Add action to enqueue scripts and styles in the last position
add_action('wp_enqueue_scripts', 'theme_scripts', 9999999);
