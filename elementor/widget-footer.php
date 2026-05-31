<?php

if (! defined('ABSPATH')) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Repeater;

class ALQA_SIGNALS_Footer_Widget extends Widget_Base
{

	public function get_name()
	{
		return 'alqa_signals_footer';
	}

	public function get_title()
	{
		return __('Footer Section', 'alqa_signals');
	}

	public function get_icon()
	{
		return 'eicon-footer';
	}

	public function get_categories()
	{
		return ['general'];
	}

	protected function _register_controls()
	{

		$this->start_controls_section(
			'section_logo_copyright',
			[
				'label' => __('Logo & Copyright', 'alqa_signals'),
			]
		);

		$this->add_control(
			'footer_logo',
			[
				'label' => __('Footer Logo', 'alqa_signals'),
				'type'  => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'copyright_text',
			[
				'label'   => __('Copyright Content', 'alqa_signals'),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => 'Copyright &copy; ' . date('Y') . ' <span>ALQA-Signals</span>. All rights reserved.',
				'description' => __('Add the full text here and wrap highlighted text with <span>...</span>.', 'alqa_signals'),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_footer_menus',
			[
				'label' => __('Footer Menus', 'alqa_signals'),
			]
		);

		$menu_repeater = new Repeater();

		$menu_repeater->add_control(
			'menu_title',
			[
				'label' => __('Menu Title', 'alqa_signals'),
				'type'  => Controls_Manager::TEXT,
				'default' => 'Menu Title',
			]
		);

		$menu_repeater->add_control(
			'menu_items',
			[
				'label' => __('Menu Links', 'alqa_signals'),
				'type'  => Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'item_label',
						'label' => 'Link Text',
						'type' => Controls_Manager::TEXT,
					],
					[
						'name' => 'item_url',
						'label' => 'Link URL',
						'type' => Controls_Manager::URL,
					],
				],
			]
		);

		$this->add_control(
			'footer_menus',
			[
				'label' => __('Footer Columns', 'alqa_signals'),
				'type'  => Controls_Manager::REPEATER,
				'fields' => $menu_repeater->get_controls(),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_social_links',
			[
				'label' => __('Social Media', 'alqa_signals'),
			]
		);

		$social_repeater = new Repeater();

		$social_repeater->add_control(
			'social_icon_type',
			[
				'label' => __('Icon Source', 'alqa_signals'),
				'type'  => Controls_Manager::SELECT,
				'default' => 'library',
				'options' => [
					'library' => __('Icon Library', 'alqa_signals'),
					'upload'  => __('Upload Icon', 'alqa_signals'),
				],
			]
		);

		$social_repeater->add_control(
			'social_icon_library',
			[
				'label' => __('Icon Library', 'alqa_signals'),
				'type'  => Controls_Manager::ICONS,
				'condition' => [
					'social_icon_type' => 'library',
				],
			]
		);

		$social_repeater->add_control(
			'social_icon_upload',
			[
				'label' => __('Upload Icon', 'alqa_signals'),
				'type'  => Controls_Manager::MEDIA,
				'condition' => [
					'social_icon_type' => 'upload',
				],
			]
		);

		$social_repeater->add_control(
			'social_link',
			[
				'label' => 'Social Link',
				'type'  => Controls_Manager::URL,
			]
		);

		$this->add_control(
			'social_links',
			[
				'label' => __('Social Media Links', 'alqa_signals'),
				'type'  => Controls_Manager::REPEATER,
				'fields' => $social_repeater->get_controls(),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_footer_disclaimer',
			[
				'label' => __('Footer Disclaimer', 'alqa_signals'),
			]
		);

		$this->add_control(
			'footer_disclaimer',
			[
				'label' => __('Disclaimer Content', 'alqa_signals'),
				'type'  => Controls_Manager::WYSIWYG,
				'default' => '',
			]
		);

		$this->add_control(
			'show_only_on_performance',
			[
				'label' => 'Show Only On Performance Page',
				'type'  => Controls_Manager::SWITCHER,
				'label_on' => 'Yes',
				'label_off' => 'No',
				'default' => '',
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		?>

		<footer id="footer">
			<div class="container">
				<div class="row">

					<div class="col-lg-3">
						<div class="cont-ft wow fadeInUp">

							<?php if (! empty($settings['footer_logo']['url'])) : ?>
								<figure class="logo-ft">
									<img src="<?php echo esc_url($settings['footer_logo']['url']); ?>" alt="Footer Logo" />
								</figure>
							<?php endif; ?>

							<p class="copyRight">
								<?php
								echo wp_kses(
									$settings['copyright_text'],
									[
										'span' => [
											'class' => [],
										],
										'br' => [],
									]
								);
								?>
							</p>

						</div>
					</div>

					<?php if (! empty($settings['footer_menus'])) : ?>
						<?php foreach ($settings['footer_menus'] as $menu) : ?>
							<div class="col-lg-3 col-6">
								<div class="menu-ft wow fadeInUp">
									<h5><?php echo esc_html($menu['menu_title']); ?></h5>
									<ul class="li-ft">
										<?php foreach ($menu['menu_items'] as $item) : ?>
											<li>
												<a href="<?php echo esc_url($item['item_url']['url']); ?>">
													<?php echo esc_html($item['item_label']); ?>
												</a>
											</li>
										<?php endforeach; ?>
									</ul>

									<?php if ($menu === end($settings['footer_menus'])) : ?>
										<ul class="social-media">
											<?php foreach ($settings['social_links'] as $social) : ?>
												<li>
													<a href="<?php echo esc_url($social['social_link']['url']); ?>" target="_blank">
														<?php
														if (
															isset($social['social_icon_type']) &&
															'upload' === $social['social_icon_type'] &&
															! empty($social['social_icon_upload']['url'])
														) :
														?>
															<img
																class="footer-social-uploaded-icon"
																src="<?php echo esc_url($social['social_icon_upload']['url']); ?>"
																alt="<?php echo esc_attr__('Social Icon', 'alqa_signals'); ?>" />
														<?php
														elseif (! empty($social['social_icon_library']['value'])) :
															Icons_Manager::render_icon($social['social_icon_library'], ['aria-hidden' => 'true']);
														elseif (! empty($social['social_icon_class'])) :
														?>
															<i class="<?php echo esc_attr($social['social_icon_class']); ?>"></i>
														<?php endif; ?>
													</a>
												</li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>

								</div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>

				</div>

				<?php
				$show_disclaimer = true;

				if ($settings['show_only_on_performance'] === 'yes') {
					$show_disclaimer = is_page('performance');
				}

				if ($show_disclaimer && ! empty($settings['footer_disclaimer'])) :
				?>
					<div class="bottom-ft wow fadeInUp">
						<p><?php echo wp_kses_post($settings['footer_disclaimer']); ?></p>
					</div>
				<?php endif; ?>

			</div>
		</footer>

<?php
	}
}
