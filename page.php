<?php

get_header();

$is_el = function_exists('alqa_signals_is_elementor_built_page') && alqa_signals_is_elementor_built_page();

if ($is_el) :
    ?>
<main id="primary" class="site-content site-content--elementor alqa-elementor-page" role="main">
    <div class="site-content-inner site-content-inner--elementor p-0">
        <?php the_content(); ?>
    </div>
</main>
    <?php
else :
    ?>
<main id="primary" class="site-content single single-page" role="main">
    <h1 class="page-title" style="text-align: center; padding: 50px 0; background-color: gainsboro;margin-bottom: 50px;"><?php echo esc_html(get_the_title()); ?></h1>
    <div class="site-content-inner pt-5">
        <div class="container">
            <div class="row" style="justify-content: center; padding-bottom: 50px;">
                <div class="col-md-9">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>
</main>
    <?php
endif;

get_footer();
