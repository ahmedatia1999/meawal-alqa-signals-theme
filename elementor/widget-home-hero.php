<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

class ALQA_SIGNALS_Home_Hero_Widget extends Widget_Base
{

    public function get_name()
    {
        return 'alqa_signals_home_hero';
    }

    public function get_title()
    {
        return __('Home Hero Section', 'alqa_signals');
    }

    public function get_icon()
    {
        return 'eicon-slider-full-screen';
    }

    public function get_categories()
    {
        return ['general'];
    }

    protected function _register_controls()
    {
        // Start Hero Section
        $this->start_controls_section(
            'section_hero',
            [
                'label' => __('Hero Section Content', 'alqa_signals'),
            ]
        );

        // Background Image Control
        $this->add_control(
            'hero_background_image',
            [
                'label' => __('Background Image', 'alqa_signals'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        // Subheading Control
        $this->add_control(
            'hero_subheading',
            [
                'label' => __('Subheading', 'alqa_signals'),
                'type' => Controls_Manager::TEXT,
                'default' => __(' Augmented reality', 'alqa_signals'),
            ]
        );

        // Main Heading Control
        $this->add_control(
            'hero_heading',
            [
                'label' => __('Main Heading', 'alqa_signals'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Data-driven financial literacy for high-conviction decisions', 'alqa_signals'),
            ]
        );

        // Description Control
        $this->add_control(
            'hero_description',
            [
                'label' => __('Hero Description', 'alqa_signals'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Quantitative analyses and research to empower confident investment decisions.', 'alqa_signals'),
            ]
        );

        // Enable or disable CTA button

        $this->add_control(
            'hero_enable_cta',
            [
                'label' => __('Enable CTA Button', 'alqa_signals'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'alqa_signals'),
                'label_off' => __('Hide', 'alqa_signals'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );


        $this->add_control(
            'hero_ctas',
            [
                'label' => __('Menu Items', 'alqa_signals'),
                'type' => Controls_Manager::REPEATER,
                'prevent_empty' => false,
                'fields' => [
                    [
                        'name' => 'cta_text',
                        'label' => __('CTA Button Text', 'alqa_signals'),
                        'type' => Controls_Manager::TEXT,
                        'default' => __('CTA Goes Here', 'alqa_signals'),
                    ],
                    [
                        'name' => 'cta_link',
                        'label' => __('CTA Button Link', 'alqa_signals'),
                        'type' => Controls_Manager::URL,
                        'placeholder' => __('https://your-link.com', 'alqa_signals'),
                        'default' => [
                            'url' => '#',
                        ],
                    ],
                    [
                        'name' => 'cta_special',
                        'label' => __('Special', 'alqa_signals'),
                        'type' => Controls_Manager::SWITCHER,
                        'label_on' => esc_html__('Special', 'alqa_signals'),
                        'label_off' => esc_html__('Default', 'alqa_signals'),
                        'return_value' => 'yes',
                        'default' => 'yes',
                    ],
                ],
                'default' => [
                    ['cta_text' => 'Join Membership', 'cta_link' => ['url' => '#']],
                    ['cta_text' => 'See Methodology', 'cta_link' => ['url' => '#']],
                ],
                'title_field' => '{{{ cta_text }}}',
            ]
        );

        $this->end_controls_section();


        // Features Control
        $this->start_controls_section(
            'hero_features_section',
            [
                'label' => __('Features', 'alqa_signals'),
            ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'feature_label',
            [
                'label' => __('Feature Label', 'alqa_signals'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Feature Text', 'alqa_signals'),
            ]
        );

        $this->add_control(
            'hero_features',
            [
                'label' => __('Features', 'alqa_signals'),
                'type' => Controls_Manager::REPEATER,
                'prevent_empty' => false,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ feature_label }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>

        <section class="section_home" style="background: url(<?php echo esc_url($settings['hero_background_image']['url']); ?>)">
            <div class="container">
                <div class="home_txt wow fadeInUp">
                    <div class="augmented">
                        <span><?php echo esc_html($settings['hero_subheading']); ?></span>
                    </div>
                    <h1><?php echo esc_html($settings['hero_heading']); ?></h1>
                    <p><?php echo esc_html($settings['hero_description']); ?></p>
                    <?php if ('yes' === $settings['hero_enable_cta']) : ?>
                        <ul>
                            <?php foreach ($settings['hero_ctas'] as $cta) : ?>
                                <li><a class="<?= $cta["cta_special"] == "yes" ? "btn-see" : "btn-join"; ?>" href="<?php echo esc_url($cta['cta_link']['url']); ?>"><?php echo esc_html($cta['cta_text']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php if (isset($settings['hero_features']) && !empty($settings['hero_features'])) : ?>
                        <div class="lst-feat">
                            <?php foreach ($settings['hero_features'] as $feature) : ?>
                                <div>
                                    <p><?= $feature["feature_label"] ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!--section_home-->
<?php
    }
}
