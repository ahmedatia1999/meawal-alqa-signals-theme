<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

class ALQA_SIGNALS_Header_Widget extends Widget_Base
{

    public function get_name()
    {
        return 'alqa_signals_header';
    }

    public function get_title()
    {
        return __('Header', 'alqa_signals');
    }

    public function get_icon()
    {
        return 'eicon-header';
    }

    public function get_categories()
    {
        return ['general'];
    }

    protected function _register_controls()
    {
        // Logo Control
        $this->start_controls_section(
            'section_logo',
            [
                'label' => __('Logo', 'alqa_signals'),
            ]
        );

        $this->add_control(
            'logo_image',
            [
                'label' => __('Logo Image', 'alqa_signals'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->end_controls_section();

        // Menu Control
        $this->start_controls_section(
            'section_menu',
            [
                'label' => __('Menu', 'alqa_signals'),
            ]
        );

        $this->add_control(
            'menu_items',
            [
                'label' => __('Menu Items', 'alqa_signals'),
                'type' => Controls_Manager::REPEATER,
                'prevent_empty' => false,
                'fields' => [
                    [
                        'name' => 'menu_label',
                        'label' => __('Label', 'alqa_signals'),
                        'type' => Controls_Manager::TEXT,
                        'default' => __('Home', 'alqa_signals'),
                    ],
                    [
                        'name' => 'menu_link',
                        'label' => __('Link', 'alqa_signals'),
                        'type' => Controls_Manager::URL,
                        'placeholder' => __('https://your-link.com', 'alqa_signals'),
                        'default' => [
                            'url' => '#',
                        ],
                    ],
                ],
                'default' => [
                    ['menu_label' => 'Home', 'menu_link' => ['url' => '#']],
                    ['menu_label' => 'About Us', 'menu_link' => ['url' => '#']],
                ],
                'title_field' => '{{{ menu_label }}}',
            ]
        );

        $this->end_controls_section();


        // Contact Button Control
        $this->start_controls_section(
            'section_contact_button',
            [
                'label' => __('Contact Us Button', 'alqa_signals'),
            ]
        );

        $this->add_control(
            'contact_button_enabled',
            [
                'label' => __('Contact Button', 'alqa_signals'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'alqa_signals'),
                'label_off' => esc_html__('Hide', 'alqa_signals'),
                'return_value' => 'yes',
                'default' => 'yes',
                'title_field' => '{{{ menu_label }}}',
            ]
        );

        $this->add_control(
            'contact_button_text',
            [
                'label' => __('Text', 'alqa_signals'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Contact Us', 'alqa_signals'),
                'placeholder' => esc_html__('button label', 'alqa_signals')
            ]
        );

        $this->add_control(
            'contact_button_link',
            [
                'label' => __('Link', 'alqa_signals'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $base_url = preg_replace('|/en/?$|', '', site_url()); // Ensure base URL without "/en"
        $current_url = home_url($_SERVER['REQUEST_URI']);

        $is_english = strpos($current_url, '/en/') !== false || substr($current_url, -3) === '/en';

        if (isset($_GET['debug'])) {
            echo "\n\n";
            echo 'Base URL: ' . $base_url;
            echo "\n\n";
            echo 'Current URL: ' . $current_url;
            echo "\n\n";
            echo 'Is English: ' . ($is_english ? 'Yes' : 'No');
            echo "\n\n";
            exit;
        }

        $switch_url = $is_english ? $base_url . '/?lang=ar' : $base_url . '/?lang=en';
        $switch_label = $is_english ? 'العربية' : 'English';

?>


        <div class="mobile-menu">
            <div class="logo-mobile">
                <a href="<?php echo home_url(); ?>">
                    <img src="<?php echo esc_url($settings['logo_image']['url']); ?>" alt="Logo">
                </a>
                <div class="is-closed">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>
            <div class="mmenu">
                <ul class="main_menu clearfix">
                    <?php foreach ($settings['menu_items'] as $item): ?>
                        <li class="active">
                            <a class="page-scroll" href="<?php echo esc_url($item['menu_link']['url']); ?>"><?php echo esc_html($item['menu_label']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php if (is_user_logged_in()): ?>
                    <a class="page-scroll btn-scontact" href="<?php echo home_url('/user/'); ?>">
                        <i class="fa-solid fa-user"></i>
                    </a>
                <?php else: ?>
                    <a class="page-scroll btn-scontact xoo-el-login-tgr" href="javascript:void(0);">
                        <i class="fa-solid fa-right-to-bracket"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>

            <div>
                <div class="container">
                    <div class="logo-site">
                        <a href="<?php echo home_url(); ?>">
                            <img src="<?php echo esc_url($settings['logo_image']['url']); ?>" alt="Logo">
                        </a>
                    </div>
                    <ul class="main_menu clearfix">
                        <?php foreach ($settings['menu_items'] as $item): ?>
                            <li><a class="page-scroll" href="<?php echo esc_url($item['menu_link']['url']); ?>"><?php echo esc_html($item['menu_label']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="opt-mobail">
                        <ul>
                            <?php if (is_user_logged_in()): ?>
                                <li>
                                    <a class="page-scroll btn-scontact" href="<?php echo home_url('/user/'); ?>">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li>
                                    <a class="page-scroll btn-scontact xoo-el-login-tgr" href="javascript:void(0);">
                                        <i class="fa-solid fa-right-to-bracket"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li class="hamburger">
                                <a class="page-scroll">
                                    <i class="icon-hamburger"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--header-->
    <?php
    }
}
