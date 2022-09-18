<?php
namespace Elementor;

use Elementor\Modules\DynamicTags\Module as TagsModule;

if (!defined('ABSPATH')) {
    exit;
}

class Emage_Hover extends Widget_Base {

    protected $config = null;
	
	public function get_name() {
		return 'emage_hover_effects';
	}

	public function get_title() {
		return esc_html__('Emage Hover Effects', 'ehe-lang');
	}

	public function get_icon() {
		return 'eicon-image-rollover';
	}

	public function get_help_url() {
		return 'https://docs.blocksera.com/emage-hover-effects-for-elementor?utm_source=wp&utm_medium=elementor&utm_term=emage';
	}

	public function get_custom_help_url() {
		return 'https://docs.blocksera.com/emage-hover-effects-for-elementor?utm_source=wp&utm_medium=elementor&utm_term=emage';
	}
	
	public function get_script_depends() {
		return ['emage'];
	}

	protected function _register_controls() {
        $this->addcontent();
        //$this->addlicense();
		$this->addstyle();
    }
    
    protected function get_license($key) {
        if ($this->config == null) {
            $defaults = array(
                'license' => 'false',
                'license_key' => ''
            );
			$this->config = array_merge($defaults, get_option('ehe_config', array()));
		}
        return $this->config[$key];
	}

    protected function addlicense() {
        $this->start_controls_section(
			'license_section',
			[
				'label' => __( 'License', 'plugin-name' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
			'license',
			[
				'type' => Controls_Manager::HIDDEN,
				'default' => is_admin() ? $this->get_license('license') : 'regular',
			]
		);

        $this->add_control(
			'license_intro',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => __('<p style="line-height:1.3;">Enter your purchase code below to activate your addon.</p><br><p style="line-height:1.3;">Activating the plugin unlocks additional settings, automatic future updates, and support from developers.</p>', 'plugin-name')
			]
        );

        $this->add_control(
			'license_link',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => __('<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">Where is my purchase code?</a><br><br><a href="https://codecanyon.net/item/emage-image-hover-effects-for-elementor-page-builder/22563091" target="_blank">Buy a new license</a>', 'plugin-name')
			]
        );

        $this->add_control(
			'license_purchase_code',
			[
                'label' => __( 'Purchase Code', 'plugin-domain' ),
                'label_block' => true,
				'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', 'plugin-domain' ),
                'default' => $this->get_license('license_key')
			]
        );

        $this->add_control(
			'license_notice',
			[
				'show_label' => false,
				'type' => Controls_Manager::RAW_HTML,
				'raw' => __('', 'plugin-domain'),
			]
        );

        $this->add_control(
            'license_activate_btn',
            [
                'label' => __('Status: <b>Inactive</b>', 'plugin-name'),
                'type' => Controls_Manager::BUTTON,
                'separator' => 'before',
                'button_type' => 'success',
                'text' => '&nbsp;&nbsp;<span class="elementor-state-icon">&nbsp;<i class="fa fa-spin fa-circle-o-notch" aria-hidden="true"></i></span><span class="publish-label">Activate</span>&nbsp;&nbsp;',
                'event' => 'emage:editor:activate',
                'condition' => [
					'license' => 'false'
				]
            ]
        );

        $this->add_control(
            'license_deactivate_btn',
            [
                'label' => __('Status: <b>Active</b>', 'plugin-name'),
                'type' => Controls_Manager::BUTTON,
                'separator' => 'before',
                'button_type' => 'default',
                'text' => __('&nbsp;&nbsp;<span class="elementor-state-icon">&nbsp;<i class="fa fa-spin fa-circle-o-notch" aria-hidden="true"></i></span><span class="publish-label">Deactivate</span>&nbsp;&nbsp;', 'plugin-domain'),
                'event' => 'emage:editor:deactivate',
                'condition' => [
					'license!' => 'false'
				]
            ]
        );
        
        $this->end_controls_section();
    }
    
	protected function addcontent() {

		$this->start_controls_section(
			'image_section',
			[
				'label' => __( 'Image', 'plugin-name' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
					'license!' => 'false'
				]
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __('Choose Image', 'plugin-domain'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => EHE_URL . 'assets/desert.jpeg',
				],
				'dynamic' => [
                    'active' => true,
                    'categories' => [TagsModule::IMAGE_CATEGORY,TagsModule::POST_META_CATEGORY],
                ]
			]
		);

		$this->add_control(
			'image_effect',
			[
				'label' => __( 'Hover Effect', 'plugin-domain' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT2,
                'default' => 'imghvr-anim-zoom-in',
				'options' => [
					'imghvr-anim-none'  => __( 'None', 'plugin-domain' ),
					'imghvr-anim-grayscale'  => __( 'Grayscale', 'plugin-domain' ),
					'imghvr-anim-color'  => __( 'Color', 'plugin-domain' ),
                    'imghvr-anim-dive'  => __( 'Dive', 'plugin-domain' ),
                    'imghvr-anim-none imghvr-anim-swap'  => __( 'Swap', 'plugin-domain' ),
					'imghvr-anim-scroll|imghvr-padding'  => __( 'Scroll', 'plugin-domain' ),
					'imghvr-anim-zoom-in' => __('Zoom In', 'plugin-domain'),
					'imghvr-anim-zoom-out' => __('Zoom Out', 'plugin-domain'),
					'imghvr-anim-zoom-in-out' => __('Zoom In Out', 'plugin-domain'),
					'imghvr-anim-zoom-out-in' => __('Zoom Out In', 'plugin-domain'),
					'imghvr-anim-zoom-in imghvr-anim-blur'  => __( 'Zoom In Blur', 'plugin-domain' ),
					'imghvr-anim-zoom-out imghvr-anim-blur'  => __( 'Zoom Out Blur', 'plugin-domain' ),
					'imghvr-anim-rotate'  => __( 'Rotate', 'plugin-domain' ),
					'imghvr-anim-blur'  => __( 'Blur', 'plugin-domain' ),
					'imghvr-anim-scale-rotate-left'  => __( 'Scale Rotate Left', 'plugin-domain' ),
					'imghvr-anim-scale-rotate-right'  => __( 'Scale Rotate Right', 'plugin-domain' ),
					'imghvr-anim-move imghvr-anim-move-up'  => __( 'Move Up', 'plugin-domain' ),
					'imghvr-anim-move imghvr-anim-move-down'  => __( 'Move Down', 'plugin-domain' ),
					'imghvr-anim-move imghvr-anim-move-left'  => __( 'Move Left', 'plugin-domain' ),
					'imghvr-anim-move imghvr-anim-move-right'  => __( 'Move Right', 'plugin-domain' ),
					'imghvr-anim-slide-out imghvr-anim-slide-out-up'  => __( 'Slide Up', 'plugin-domain' ),
					'imghvr-anim-slide-out imghvr-anim-slide-out-down'  => __( 'Slide Down', 'plugin-domain' ),
					'imghvr-anim-slide-out imghvr-anim-slide-out-left'  => __( 'Slide Left', 'plugin-domain' ),
					'imghvr-anim-slide-out imghvr-anim-slide-out-right'  => __( 'Slide Right', 'plugin-domain' ),
					'imghvr-anim-hinge imghvr-anim-hinge-up|imghvr-perspective'  => __( 'Hinge Up', 'plugin-domain' ),
					'imghvr-anim-hinge imghvr-anim-hinge-down|imghvr-perspective'  => __( 'Hinge Down', 'plugin-domain' ),
					'imghvr-anim-hinge imghvr-anim-hinge-left|imghvr-perspective'  => __( 'Hinge Left', 'plugin-domain' ),
					'imghvr-anim-hinge imghvr-anim-hinge-right|imghvr-perspective'  => __( 'Hinge Right', 'plugin-domain' ),
					'imghvr-anim-flip imghvr-anim-flip-hor'  => __( 'Flip Horizontal', 'plugin-domain' ),
					'imghvr-anim-flip imghvr-anim-flip-vert'  => __( 'Flip Vertical', 'plugin-domain' ),
					'imghvr-anim-flip imghvr-anim-flip-diag-left'  => __( 'Flip Diagonal Left', 'plugin-domain' ),
					'imghvr-anim-flip imghvr-anim-flip-diag-right'  => __( 'Flip Diagonal Right', 'plugin-domain' ),
					'imghvr-anim-fold imghvr-anim-fold-up'  => __( 'Fold Up', 'plugin-domain' ),
					'imghvr-anim-fold imghvr-anim-fold-down'  => __( 'Fold Down', 'plugin-domain' ),
					'imghvr-anim-fold imghvr-anim-fold-left'  => __( 'Fold Left', 'plugin-domain' ),
					'imghvr-anim-fold imghvr-anim-fold-right'  => __( 'Fold Right', 'plugin-domain' ),
					'imghvr-anim-zoom-out-slide imghvr-anim-zoom-out-slide-up'  => __( 'Zoom Out Up', 'plugin-domain' ),
					'imghvr-anim-zoom-out-slide imghvr-anim-zoom-out-slide-down'  => __( 'Zoom Out Down', 'plugin-domain' ),
					'imghvr-anim-zoom-out-slide imghvr-anim-zoom-out-slide-left'  => __( 'Zoom Out Left', 'plugin-domain' ),
					'imghvr-anim-zoom-out-slide imghvr-anim-zoom-out-slide-right'  => __( 'Zoom Out Right', 'plugin-domain' ),
					'imghvr-anim-zoom-out-flip imghvr-anim-zoom-out-flip-hor'  => __( 'Zoom Out Flip Horizontal', 'plugin-domain' ),
					'imghvr-anim-zoom-out-flip imghvr-anim-zoom-out-flip-vert'  => __( 'Zoom Out Flip Vetical', 'plugin-domain' ),
					'imghvr-anim-pivot-out imghvr-anim-pivot-out-top-left'  => __( 'Pivot Top Left', 'plugin-domain' ),
					'imghvr-anim-pivot-out imghvr-anim-pivot-out-top-right'  => __( 'Pivot Top Right', 'plugin-domain' ),
					'imghvr-anim-pivot-out imghvr-anim-pivot-out-bottom-left'  => __( 'Pivot Bottom Left', 'plugin-domain' ),
					'imghvr-anim-pivot-out imghvr-anim-pivot-out-bottom-right'  => __( 'Pivot Bottom Right', 'plugin-domain' ),
					'imghvr-anim-rotate-around'  => __( 'Rotate Around', 'plugin-domain' ),
					'imghvr-anim-lightspeed imghvr-anim-lightspeed-out-left'  => __( 'Light Speed Out Left', 'plugin-domain' ),		
					'imghvr-anim-lightspeed imghvr-anim-lightspeed-out-right'  => __( 'Light Speed Out Right', 'plugin-domain' ),
					'imghvr-anim-fall imghvr-anim-fall-away-horizontal'  => __( 'Fall Away Horizontal', 'plugin-domain' ),	
					'imghvr-anim-fall imghvr-anim-fall-away-vertical'  => __( 'Fall Away Vertical', 'plugin-domain' ),	
					'imghvr-anim-fall imghvr-anim-fall-away-rotate'  => __( 'Fall Away Rotate', 'plugin-domain' ),
					'imghvr-anim-fall imghvr-anim-fall-away-rotate-invert'  => __( 'Fall Away Rotate Invert', 'plugin-domain' ),
					'imghvr-anim-throw-out imghvr-anim-throw-out-up' => __('Throw Up', 'plugin-domain'),
					'imghvr-anim-throw-out imghvr-anim-throw-out-down' => __('Throw Down', 'plugin-domain'),
					'imghvr-anim-throw-out imghvr-anim-throw-out-left' => __('Throw Left', 'plugin-domain'),
					'imghvr-anim-throw-out imghvr-anim-throw-out-right' => __('Throw Right', 'plugin-domain'),
					'imghvr-anim-cube-out imghvr-anim-cube-out-up|imghvr-perspective imghvr-overflow' => __('Cube Up', 'plugin-domain'),
					'imghvr-anim-cube-out imghvr-anim-cube-out-down|imghvr-perspective imghvr-overflow' => __('Cube Down', 'plugin-domain'),
					'imghvr-anim-cube-out imghvr-anim-cube-out-right|imghvr-perspective imghvr-overflow' => __('Cube Left', 'plugin-domain'),
					'imghvr-anim-cube-out imghvr-anim-cube-out-left|imghvr-perspective imghvr-overflow' => __('Cube Right', 'plugin-domain'),
					'imghvr-anim-stack' => __('Stack', 'plugin-domain'),
					'imghvr-anim-bounce-out' => __('Bounce Out', 'plugin-domain'),
					'imghvr-anim-bounce-out-up' => __('Bounce Out Up', 'plugin-domain'),
					'imghvr-anim-bounce-out-down' => __('Bounce Out Down', 'plugin-domain'),
					'imghvr-anim-bounce-out-left' => __('Bounce Out Left', 'plugin-domain'),
					'imghvr-anim-bounce-out-right' => __('Bounce Out Right', 'plugin-domain'),
				],
			]
        );

        $this->add_control(
			'swap_help_text',
			[
				'show_label' => false,
				'type' => Controls_Manager::RAW_HTML,
				'raw' => __('<div style="color:#0b5885;background-color:#d0eeff;border-color:#bee7ff;padding: .75rem 1.25rem;border-radius: .25rem;line-height: 1.3em;border: 1px solid #bbcff5;">Add hover image in <br><b>Style > Overlay > Background Type</b></div>'),
				'condition' => [
					'image_effect' => 'imghvr-anim-none imghvr-anim-swap'
				]
			]
		);

        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
                'name' => 'image',
                'default' => 'large',
                'separator' => 'none'
			]
		);
		
		$this->add_responsive_control(
			'image_align',
			[
				'label' => __( 'Alignment', 'plugin-domain' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'plugin-domain' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'plugin-domain' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'plugin-domain' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' => __( 'Opacity', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .imghvr-anim-color' => 'opacity: {{SIZE}};',
					'{{WRAPPER}} .imghvr:hover .imghvr-anim-color' => 'opacity: 1;',
				],
				'condition' => [
					'image_effect' => 'imghvr-anim-color'
				]
			]
		);

		$this->add_control(
			'image_duration',
			[
				'label' => __( 'Transition Duration', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3,
						'step' => 0.05,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0.35,
				],
				'selectors' => [
					'{{WRAPPER}} .imghvr, {{WRAPPER}} .imghvr img' => 'transition: {{SIZE}}s; animation-duration: {{SIZE}}s;'
				]
			]
		);

		$this->add_control(
			'image_hr',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'target',
			[
				'label' => __( 'Link', 'plugin-domain' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'  => __( 'None', 'plugin-domain' ),
					'link' => __( 'URL', 'plugin-domain' ),
					'lightbox' => __( 'Light Box', 'plugin-domain' ),
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link to', 'plugin-domain' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __('https://your-link.com', 'plugin-domain'),
				'dynamic' => [
					'active' => true,
					'categories' => [TagsModule::URL_CATEGORY]
				],
				'condition' => [
					'target' => 'link'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'overlay_section',
			[
				'label' => __( 'Overlay', 'plugin-name' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
					'license!' => 'false'
				]
			]
		);

		$this->add_control(
			'overlay_show',
			[
				'label' => __( 'Show Overlay', 'plugin-domain' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'overlay_effect',
			[
				'label' => __( 'Hover Effect', 'plugin-domain' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT2,
				'default' => 'imghvr-anim-fade-in imghvr-anim-single',
				'options' => [
					'imghvr-anim-none imghvr-anim-single'  => __( '-- Show Always --', 'plugin-domain' ),
					'imghvr-anim-fade-in imghvr-anim-single'  => __( 'Fade', 'plugin-domain' ),
					'imghvr-anim-zoom-in-alt imghvr-anim-single'  => __( 'Zoom In', 'plugin-domain' ),
					'imghvr-anim-crop imghvr-anim-single'  => __( 'Crop', 'plugin-domain' ),
					'imghvr-anim-none imghvr-anim-bg-none imghvr-anim-single'  => __( 'No Background', 'plugin-domain' ),
					'imghvr-anim-slide-in imghvr-anim-single imghvr-anim-slide-in-up'  => __( 'Slide Up', 'plugin-domain' ),
					'imghvr-anim-slide-in imghvr-anim-single imghvr-anim-slide-in-down'  => __( 'Slide Down', 'plugin-domain' ),
					'imghvr-anim-slide-in imghvr-anim-single imghvr-anim-slide-in-left'  => __( 'Slide Left', 'plugin-domain' ),
					'imghvr-anim-slide-in imghvr-anim-single imghvr-anim-slide-in-right'  => __( 'Slide Right', 'plugin-domain' ),
					'imghvr-anim-slide-in imghvr-anim-single imghvr-anim-slide-in-top-left'  => __( 'Slide Top Left', 'plugin-domain' ),
					'imghvr-anim-slide-in imghvr-anim-single imghvr-anim-slide-in-top-right'  => __( 'Slide Top Right', 'plugin-domain' ),
					'imghvr-anim-slide-in imghvr-anim-single imghvr-anim-slide-in-bottom-left'  => __( 'Slide Bottom Left', 'plugin-domain' ),
					'imghvr-anim-slide-in imghvr-anim-single imghvr-anim-slide-in-bottom-right'  => __( 'Slide Bottom Right', 'plugin-domain' ),
					'imghvr-anim-shutter-out imghvr-anim-single imghvr-anim-shutter-out-hor'  => __( 'Shutter Out Horizontal', 'plugin-domain' ),
					'imghvr-anim-shutter-out imghvr-anim-single imghvr-anim-shutter-out-vert'  => __( 'Shutter Out Vertical', 'plugin-domain' ),
					'imghvr-anim-shutter-out imghvr-anim-single imghvr-anim-shutter-out-diag-left'  => __( 'Shutter Out Diagonal Left', 'plugin-domain' ),
					'imghvr-anim-shutter-out imghvr-anim-single imghvr-anim-shutter-out-diag-right'  => __( 'Shutter Out Diagonal Right', 'plugin-domain' ),
					'imghvr-anim-shutter-in imghvr-anim-pseudo imghvr-anim-shutter-in-hor'  => __( 'Shutter In Horizontal', 'plugin-domain' ),
					'imghvr-anim-shutter-in imghvr-anim-pseudo imghvr-anim-shutter-in-vert'  => __( 'Shutter In Vertical', 'plugin-domain' ),
					'imghvr-anim-shutter-in-out imghvr-anim-pseudo imghvr-anim-shutter-in-out-hor'  => __( 'Shutter In Out Horizontal', 'plugin-domain' ),
					'imghvr-anim-shutter-in-out imghvr-anim-pseudo imghvr-anim-shutter-in-out-vert'  => __( 'Shutter In Out Vertical', 'plugin-domain' ),
					'imghvr-anim-shutter-in-out imghvr-anim-pseudo imghvr-anim-shutter-in-out-diag-left'  => __( 'Shutter In Out Diagonal Left', 'plugin-domain' ),
					'imghvr-anim-shutter-in-out imghvr-anim-pseudo imghvr-anim-shutter-in-out-diag-right'  => __( 'Shutter In Out Diagonal Right', 'plugin-domain' ),
					'imghvr-anim-strip-shutter imghvr-anim-pseudo imghvr-anim-strip-shutter-up'  => __( 'Strip Shutter Up', 'plugin-domain' ),
					'imghvr-anim-strip-shutter imghvr-anim-pseudo imghvr-anim-strip-shutter-down'  => __( 'Strip Shutter Down', 'plugin-domain' ),
					'imghvr-anim-strip-shutter imghvr-anim-pseudo imghvr-anim-strip-shutter-left'  => __( 'Strip Shutter Left', 'plugin-domain' ),
					'imghvr-anim-strip-shutter imghvr-anim-pseudo imghvr-anim-strip-shutter-right'  => __( 'Strip Shutter Right', 'plugin-domain' ),
					'imghvr-anim-strip-hor imghvr-anim-pseudo imghvr-anim-strip-hor-up'  => __( 'Strip Horizontal Up', 'plugin-domain' ),
					'imghvr-anim-strip-hor imghvr-anim-pseudo imghvr-anim-strip-hor-down'  => __( 'Strip Horizontal Down', 'plugin-domain' ),
					'imghvr-anim-strip-hor imghvr-anim-pseudo imghvr-anim-strip-hor-top-left'  => __( 'Strip Horizontal Top Left', 'plugin-domain' ),
					'imghvr-anim-strip-hor imghvr-anim-pseudo imghvr-anim-strip-hor-top-right'  => __( 'Strip Horizontal Top Right', 'plugin-domain' ),
					'imghvr-anim-strip-hor imghvr-anim-pseudo imghvr-anim-strip-hor-bottom-left'  => __( 'Strip Horizontal Bottom Left', 'plugin-domain' ),
					'imghvr-anim-strip-hor imghvr-anim-pseudo imghvr-anim-strip-hor-bottom-right'  => __( 'Strip Horizontal Bottom Right', 'plugin-domain' ),
					'imghvr-anim-strip-vert imghvr-anim-pseudo imghvr-anim-strip-vert-left'  => __( 'Strip Vertical Left', 'plugin-domain' ),
					'imghvr-anim-strip-vert imghvr-anim-pseudo imghvr-anim-strip-vert-right'  => __( 'Strip Vertical Right', 'plugin-domain' ),
					'imghvr-anim-strip-vert imghvr-anim-pseudo imghvr-anim-strip-vert-top-left'  => __( 'Strip Vertical Top Left', 'plugin-domain' ),
					'imghvr-anim-strip-vert imghvr-anim-pseudo imghvr-anim-strip-vert-top-right'  => __( 'Strip Vertical Top Right', 'plugin-domain' ),
					'imghvr-anim-strip-vert imghvr-anim-pseudo imghvr-anim-strip-vert-bottom-left'  => __( 'Strip Vertical Bottom Left', 'plugin-domain' ),
					'imghvr-anim-strip-vert imghvr-anim-pseudo imghvr-anim-strip-vert-bottom-right'  => __( 'Strip Vertical Bottom Right', 'plugin-domain' ),
					'imghvr-anim-pixel imghvr-anim-pseudo imghvr-anim-pixel-up'  => __( 'Pixel Up', 'plugin-domain' ),
					'imghvr-anim-pixel imghvr-anim-pseudo imghvr-anim-pixel-down'  => __( 'Pixel Down', 'plugin-domain' ),
					'imghvr-anim-pixel imghvr-anim-pseudo imghvr-anim-pixel-left'  => __( 'Pixel Left', 'plugin-domain' ),
					'imghvr-anim-pixel imghvr-anim-pseudo imghvr-anim-pixel-right'  => __( 'Pixel Right', 'plugin-domain' ),
					'imghvr-anim-pixel imghvr-anim-pseudo imghvr-anim-pixel-top-left'  => __( 'Pixel Top Left', 'plugin-domain' ),
					'imghvr-anim-pixel imghvr-anim-pseudo imghvr-anim-pixel-top-right'  => __( 'Pixel Top Right', 'plugin-domain' ),
					'imghvr-anim-pixel imghvr-anim-pseudo imghvr-anim-pixel-bottom-left'  => __( 'Pixel Bottom Left', 'plugin-domain' ),
					'imghvr-anim-pixel imghvr-anim-pseudo imghvr-anim-pixel-bottom-right'  => __( 'Pixel Bottom Right', 'plugin-domain' ),
					'imghvr-anim-pivot-in imghvr-anim-single imghvr-anim-pivot-in-top-left'  => __( 'Pivot Top Left', 'plugin-domain' ),
					'imghvr-anim-pivot-in imghvr-anim-single imghvr-anim-pivot-in-top-right'  => __( 'Pivot Top Right', 'plugin-domain' ),
					'imghvr-anim-pivot-in imghvr-anim-single imghvr-anim-pivot-in-bottom-left'  => __( 'Pivot Bottom Left', 'plugin-domain' ),
					'imghvr-anim-pivot-in imghvr-anim-single imghvr-anim-pivot-in-bottom-right'  => __( 'Pivot Bottom Right', 'plugin-domain' ),
					'imghvr-anim-blocks imghvr-anim-pseudo imghvr-anim-blocks-rotate-left' => __('Blocks Rotate Left', 'plugin-domain'),
					'imghvr-anim-blocks imghvr-anim-pseudo imghvr-anim-blocks-rotate-right' => __('Blocks Rotate Right', 'plugin-domain'),
					'imghvr-anim-blocks imghvr-anim-pseudo imghvr-anim-blocks-rotate-in-left' => __('Blocks Rotate In Left', 'plugin-domain'),
					'imghvr-anim-blocks imghvr-anim-pseudo imghvr-anim-blocks-rotate-in-right' => __('Blocks Rotate In Right', 'plugin-domain'),
					'imghvr-anim-blocks imghvr-anim-pseudo imghvr-anim-blocks-in' => __('Blocks In', 'plugin-domain'),
					'imghvr-anim-blocks imghvr-anim-pseudo imghvr-anim-blocks-out' => __('Blocks Out', 'plugin-domain'),
					'imghvr-anim-blocks imghvr-anim-pseudo imghvr-anim-blocks-float-up' => __('Blocks Float Up', 'plugin-domain'),
					'imghvr-anim-blocks imghvr-anim-pseudo imghvr-anim-blocks-float-down' => __('Blocks Float Down', 'plugin-domain'),
					'imghvr-anim-blocks imghvr-anim-pseudo imghvr-anim-blocks-float-left' => __('Blocks Float Left', 'plugin-domain'),
					'imghvr-anim-blocks imghvr-anim-pseudo imghvr-anim-blocks-float-right' => __('Blocks Float Right', 'plugin-domain'),
					'imghvr-anim-blocks imghvr-anim-pseudo imghvr-anim-blocks-zoom-top-left' => __('Blocks Zoom Top Left', 'plugin-domain'),
					'imghvr-anim-blocks imghvr-anim-pseudo imghvr-anim-blocks-zoom-top-right' => __('Blocks Zoom Top Right', 'plugin-domain'),
					'imghvr-anim-blocks imghvr-anim-pseudo imghvr-anim-blocks-zoom-bottom-left' => __('Blocks Zoom Bottom Left', 'plugin-domain'),
					'imghvr-anim-blocks imghvr-anim-pseudo imghvr-anim-blocks-zoom-bottom-right' => __('Blocks Zoom Bottom Right', 'plugin-domain'),
					'imghvr-anim-throw-in imghvr-anim-single imghvr-anim-throw-in-up' => __('Throw Up', 'plugin-domain'),
					'imghvr-anim-throw-in imghvr-anim-single imghvr-anim-throw-in-down' => __('Throw Down', 'plugin-domain'),
					'imghvr-anim-throw-in imghvr-anim-single imghvr-anim-throw-in-left' => __('Throw Left', 'plugin-domain'),
					'imghvr-anim-throw-in imghvr-anim-single imghvr-anim-throw-in-right' => __('Throw Right', 'plugin-domain'),
					'imghvr-anim-flash imghvr-anim-pseudo imghvr-anim-flash-top-left' => __('Flash Top Left', 'plugin-domain'),
					'imghvr-anim-flash imghvr-anim-pseudo imghvr-anim-flash-top-right' => __('Flash Top Right', 'plugin-domain'),
					'imghvr-anim-flash imghvr-anim-pseudo imghvr-anim-flash-bottom-left' => __('Flash Bottom Left', 'plugin-domain'),
					'imghvr-anim-flash imghvr-anim-pseudo imghvr-anim-flash-bottom-right' => __('Flash Bottom Right', 'plugin-domain'),
					'imghvr-anim-splash imghvr-anim-pseudo imghvr-anim-splash-up' => __('Splash Up', 'plugin-domain'),
					'imghvr-anim-splash imghvr-anim-pseudo imghvr-anim-splash-down' => __('Splash Down', 'plugin-domain'),
					'imghvr-anim-splash imghvr-anim-pseudo imghvr-anim-splash-left' => __('Splash Left', 'plugin-domain'),
					'imghvr-anim-splash imghvr-anim-pseudo imghvr-anim-splash-right' => __('Splash Right', 'plugin-domain'),
					'imghvr-anim-stack imghvr-anim-single imghvr-anim-stack-up' => __('Stack Up', 'plugin-domain'),
					'imghvr-anim-stack imghvr-anim-single imghvr-anim-stack-down' => __('Stack Down', 'plugin-domain'),
					'imghvr-anim-stack imghvr-anim-single imghvr-anim-stack-left' => __('Stack Left', 'plugin-domain'),
					'imghvr-anim-stack imghvr-anim-single imghvr-anim-stack-right' => __('Stack Right', 'plugin-domain'),
					'imghvr-anim-circle imghvr-anim-pseudo imghvr-anim-circle-up' => __('Circle Up', 'plugin-domain'),
					'imghvr-anim-circle imghvr-anim-pseudo imghvr-anim-circle-down' => __('Circle Down', 'plugin-domain'),
					'imghvr-anim-circle imghvr-anim-pseudo imghvr-anim-circle-left' => __('Circle Left', 'plugin-domain'),
					'imghvr-anim-circle imghvr-anim-pseudo imghvr-anim-circle-right' => __('Circle Right', 'plugin-domain'),
					'imghvr-anim-circle imghvr-anim-pseudo imghvr-anim-circle-top-left' => __('Circle Top Left', 'plugin-domain'),
					'imghvr-anim-circle imghvr-anim-pseudo imghvr-anim-circle-top-right' => __('Circle Top Right', 'plugin-domain'),
					'imghvr-anim-circle imghvr-anim-pseudo imghvr-anim-circle-bottom-left' => __('Circle Bottom Left', 'plugin-domain'),
					'imghvr-anim-circle imghvr-anim-pseudo imghvr-anim-circle-bottom-right' => __('Circle Bottom Right', 'plugin-domain'),
					'imghvr-anim-book imghvr-anim-pseudo imghvr-anim-book-open-horiz|imghvr-perspective imghvr-overflow' => __('Book Open Horizontal', 'plugin-domain'),
					'imghvr-anim-book imghvr-anim-pseudo imghvr-anim-book-open-vert|imghvr-perspective imghvr-overflow' => __('Book Open Vertical', 'plugin-domain'),
					'imghvr-anim-border-reveal imghvr-anim-pseudo' => __('Border Reveal', 'plugin-domain'),
					'imghvr-anim-border-reveal imghvr-anim-pseudo imghvr-anim-border-reveal-horiz' => __('Border Reveal Horizontal', 'plugin-domain'),
					'imghvr-anim-border-reveal imghvr-anim-pseudo imghvr-anim-border-reveal-vert' => __('Border Reveal Vertical', 'plugin-domain'),
					'imghvr-anim-border-reveal imghvr-anim-pseudo imghvr-anim-border-reveal-corners-2' => __('Border Reveal Diagonal Left', 'plugin-domain'),
					'imghvr-anim-border-reveal imghvr-anim-pseudo imghvr-anim-border-reveal-corners-1' => __('Border Reveal Diagonal Right', 'plugin-domain'),
					'imghvr-anim-border-reveal imghvr-anim-pseudo imghvr-anim-border-reveal-top-left' => __('Border Reveal Top Left', 'plugin-domain'),
					'imghvr-anim-border-reveal imghvr-anim-pseudo imghvr-anim-border-reveal-top-right' => __('Border Reveal Top Right', 'plugin-domain'),
					'imghvr-anim-border-reveal imghvr-anim-pseudo imghvr-anim-border-reveal-bottom-left' => __('Border Reveal Bottom Left', 'plugin-domain'),
					'imghvr-anim-border-reveal imghvr-anim-pseudo imghvr-anim-border-reveal-bottom-right' => __('Border Reveal Bottom Right', 'plugin-domain'),
					'imghvr-anim-border-reveal imghvr-anim-pseudo imghvr-anim-border-reveal-cc-1' => __('Border Reveal Clockwise', 'plugin-domain'),
					'imghvr-anim-border-reveal imghvr-anim-pseudo imghvr-anim-border-reveal-ccc-1' => __('Border Reveal Anti Clockwise', 'plugin-domain'),
					'imghvr-anim-border-reveal imghvr-anim-pseudo imghvr-anim-border-reveal-cc-2' => __('Border Reveal Split Clockwise', 'plugin-domain'),
					'imghvr-anim-border-reveal imghvr-anim-pseudo imghvr-anim-border-reveal-ccc-2' => __('Border Reveal Split Anti Clockwise', 'plugin-domain'),
					'imghvr-anim-border-reveal imghvr-anim-pseudo imghvr-anim-border-reveal-cc-3' => __('Border Reveal Attach Clockwise', 'plugin-domain'),
					'imghvr-anim-border-reveal imghvr-anim-pseudo imghvr-anim-border-reveal-ccc-3' => __('Border Reveal Attach Anti Clockwise', 'plugin-domain'),
					'imghvr-anim-blinds imghvr-anim-pseudo imghvr-anim-blinds-horiz' => __('Blinds Horizontal', 'plugin-domain'),
					'imghvr-anim-blinds imghvr-anim-pseudo imghvr-anim-blinds-vert' => __('Blinds Vertical', 'plugin-domain'),
					'imghvr-anim-blinds imghvr-anim-pseudo imghvr-anim-blinds-up' => __('Blinds Up', 'plugin-domain'),
					'imghvr-anim-blinds imghvr-anim-pseudo imghvr-anim-blinds-down' => __('Blinds Down', 'plugin-domain'),
					'imghvr-anim-blinds imghvr-anim-pseudo imghvr-anim-blinds-left' => __('Blinds Left', 'plugin-domain'),
					'imghvr-anim-blinds imghvr-anim-pseudo imghvr-anim-blinds-right' => __('Blinds Right', 'plugin-domain'),
				],
				'condition' => [
					'overlay_show' => 'yes'
				]
			]
		);

		$this->add_control(
			'overlay_duration',
			[
				'label' => __( 'Transition Duration', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3,
						'step' => 0.05,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0.35,
				],
				'selectors' => [
					'{{WRAPPER}} .imghvr-overlay, {{WRAPPER}} .imghvr-anim-pseudo:before, {{WRAPPER}} .imghvr-anim-pseudo:after, {{WRAPPER}} .imghvr-anim-pseudo div:before, {{WRAPPER}} .imghvr-anim-pseudo div:after' => 'transition-duration: {{SIZE}}s; animation-duration: {{SIZE}}s;',
					'{{WRAPPER}} .imghvr:hover .imghvr-overlay, {{WRAPPER}} .imghvr:hover .imghvr-anim-pseudo:before, {{WRAPPER}} .imghvr:hover .imghvr-anim-pseudo:after, {{WRAPPER}} .imghvr:hover .imghvr-anim-pseudo div:before, {{WRAPPER}} .imghvr:hover .imghvr-anim-pseudo div:after' => 'transition-duration: {{SIZE}}s; animation-duration: {{SIZE}}s;'
				],
				'condition' => [
					'overlay_show' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => __('Content', 'plugin-name'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
					'license!' => 'false'
				]
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'plugin-domain' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => 'Image',
				'dynamic' => [
                    'active' => true,
                    'categories' => [TagsModule::TEXT_CATEGORY,TagsModule::POST_META_CATEGORY],
                ]
			]
        );

		$this->add_control(
			'subtitle',
			[
				'label' => __('Sub Title', 'plugin-domain'),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => 'Hover Effects',
				'dynamic' => [
                    'active' => true,
                    'categories' => [TagsModule::TEXT_CATEGORY,TagsModule::POST_META_CATEGORY],
                ]
			]
		);

		$this->add_control(
			'content',
			[
				'label' => __( 'Content', 'plugin-domain' ),
				'description' => __( 'Supports HTML format', 'plugin-domain' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 4,
				'dynamic' => [
                    'active' => true,
                    'categories' => [TagsModule::TEXT_CATEGORY,TagsModule::POST_META_CATEGORY],
                ]
			]
        );
        
        $this->add_control(
			'content_icon',
			[
				'label' => __('Icon', 'text-domain'),
				'type' => Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'align',
			[
				'label' => __( 'Alignment', 'plugin-domain' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'plugin-domain' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'plugin-domain' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'plugin-domain' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'center',
				'toggle' => false
			]
		);

		$this->add_control(
			'valign',
			[
				'label' => __( 'Vertical Alignment', 'plugin-domain' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Top', 'plugin-domain' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Middle', 'plugin-domain' ),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => __( 'Bottom', 'plugin-domain' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .imghvr .imghvr-content-wrapper' => 'justify-content: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'content_hr',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'content_effect',
			[
				'label' => __( 'Hover Effect', 'plugin-domain' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT2,
				'default' => 'imghvr-anim-fade-in',
				'options' => [
					'imghvr-anim-none'  => __( '-- Show Always --', 'plugin-domain' ),
					'imghvr-anim-fade-in'  => __( 'Fade', 'plugin-domain' ),
					'imghvr-anim-zoom-in-alt'  => __( 'Zoom In', 'plugin-domain' ),
					'imghvr-anim-slide-in imghvr-anim-slide-in-up'  => __( 'Slide Up', 'plugin-domain' ),
					'imghvr-anim-slide-in imghvr-anim-slide-in-down'  => __( 'Slide Down', 'plugin-domain' ),
					'imghvr-anim-slide-in imghvr-anim-slide-in-left'  => __( 'Slide Left', 'plugin-domain' ),
					'imghvr-anim-slide-in imghvr-anim-slide-in-right'  => __( 'Slide Right', 'plugin-domain' ),
					'imghvr-anim-slide-in imghvr-anim-slide-in-top-left'  => __( 'Slide Top Left', 'plugin-domain' ),
					'imghvr-anim-slide-in imghvr-anim-slide-in-top-right'  => __( 'Slide Top Right', 'plugin-domain' ),
					'imghvr-anim-slide-in imghvr-anim-slide-in-bottom-left'  => __( 'Slide Bottom Left', 'plugin-domain' ),
					'imghvr-anim-slide-in imghvr-anim-slide-in-bottom-right'  => __( 'Slide Bottom Right', 'plugin-domain' ),
					'imghvr-anim-fade imghvr-anim-fade-up'  => __( 'Fade Up', 'plugin-domain' ),
					'imghvr-anim-fade imghvr-anim-fade-down'  => __( 'Fade Down', 'plugin-domain' ),
					'imghvr-anim-fade imghvr-anim-fade-left'  => __( 'Fade Left', 'plugin-domain' ),
					'imghvr-anim-fade imghvr-anim-fade-right'  => __( 'Fade Right', 'plugin-domain' ),
					'imghvr-anim-hinge imghvr-anim-hinge-up|imghvr-perspective'  => __( 'Hinge Up', 'plugin-domain' ),
					'imghvr-anim-hinge imghvr-anim-hinge-down|imghvr-perspective'  => __( 'Hinge Down', 'plugin-domain' ),
					'imghvr-anim-hinge imghvr-anim-hinge-left|imghvr-perspective'  => __( 'Hinge Left', 'plugin-domain' ),
					'imghvr-anim-hinge imghvr-anim-hinge-right|imghvr-perspective'  => __( 'Hinge Right', 'plugin-domain' ),
					'imghvr-anim-flip imghvr-anim-flip-hor'  => __( 'Flip Horizontal', 'plugin-domain' ),
					'imghvr-anim-flip imghvr-anim-flip-vert'  => __( 'Flip Vertical', 'plugin-domain' ),
					'imghvr-anim-flip imghvr-anim-flip-diag-left'  => __( 'Flip Diagonal Left', 'plugin-domain' ),
					'imghvr-anim-flip imghvr-anim-flip-diag-right'  => __( 'Flip Diagonal Right', 'plugin-domain' ),
					'imghvr-anim-fold imghvr-anim-fold-down'  => __( 'Fold Up', 'plugin-domain' ),
					'imghvr-anim-fold imghvr-anim-fold-up'  => __( 'Fold Down', 'plugin-domain' ),
					'imghvr-anim-fold imghvr-anim-fold-left'  => __( 'Fold Left', 'plugin-domain' ),
					'imghvr-anim-fold imghvr-anim-fold-right'  => __( 'Fold Right', 'plugin-domain' ),
					'imghvr-anim-zoom-in-flip imghvr-anim-zoom-in-flip-hor'  => __( 'Zoom In Flip Horizontal', 'plugin-domain' ),
					'imghvr-anim-zoom-in-flip imghvr-anim-zoom-in-flip-vert'  => __( 'Zoom In Flip Vetical', 'plugin-domain' ),
					'imghvr-anim-pivot-in imghvr-anim-pivot-in-top-left'  => __( 'Pivot Top Left', 'plugin-domain' ),
					'imghvr-anim-pivot-in imghvr-anim-pivot-in-top-right'  => __( 'Pivot Top Right', 'plugin-domain' ),
					'imghvr-anim-pivot-in imghvr-anim-pivot-in-bottom-left'  => __( 'Pivot Bottom Left', 'plugin-domain' ),
					'imghvr-anim-pivot-in imghvr-anim-pivot-in-bottom-right'  => __( 'Pivot Bottom Right', 'plugin-domain' ),
					'imghvr-anim-throw-in imghvr-anim-throw-in-up' => __('Throw Up', 'plugin-domain'),
					'imghvr-anim-throw-in imghvr-anim-throw-in-down' => __('Throw Down', 'plugin-domain'),
					'imghvr-anim-throw-in imghvr-anim-throw-in-left' => __('Throw Left', 'plugin-domain'),
					'imghvr-anim-throw-in imghvr-anim-throw-in-right' => __('Throw Right', 'plugin-domain'),
					'imghvr-anim-cube-in imghvr-anim-cube-in-up|imghvr-perspective imghvr-overflow' => __('Cube Up', 'plugin-domain'),
					'imghvr-anim-cube-in imghvr-anim-cube-in-down|imghvr-perspective imghvr-overflow' => __('Cube Down', 'plugin-domain'),
					'imghvr-anim-cube-in imghvr-anim-cube-in-right|imghvr-perspective imghvr-overflow' => __('Cube Left', 'plugin-domain'),
					'imghvr-anim-cube-in imghvr-anim-cube-in-left|imghvr-perspective imghvr-overflow' => __('Cube Right', 'plugin-domain'),
					'imghvr-anim-lightspeed-in imghvr-anim-lightspeed-in-left' => __('Lightspeed In Left', 'plugin-domain'),
					'imghvr-anim-lightspeed-in imghvr-anim-lightspeed-in-right' => __('Lightspeed In Right', 'plugin-domain'),
					'imghvr-anim-bounce-in' => __('Bounce In', 'plugin-domain'),
					'imghvr-anim-bounce-in-up' => __('Bounce In Up', 'plugin-domain'),
					'imghvr-anim-bounce-in-down' => __('Bounce In Down', 'plugin-domain'),
					'imghvr-anim-bounce-in-left' => __('Bounce In Left', 'plugin-domain'),
					'imghvr-anim-bounce-in-right' => __('Bounce In Right', 'plugin-domain'),
					'imghvr-anim-shift imghvr-anim-shift-top-left|imghvr-overflow' => __('Shift Top Left', 'plugin-domain'),
					'imghvr-anim-shift imghvr-anim-shift-top-right|imghvr-overflow' => __('Shift Top Right', 'plugin-domain'),
					'imghvr-anim-shift imghvr-anim-shift-bottom-left|imghvr-overflow' => __('Shift Bottom Left', 'plugin-domain'),
					'imghvr-anim-shift imghvr-anim-shift-bottom-right|imghvr-overflow' => __('Shift Bottom Right', 'plugin-domain'),
				],
			]
		);

		$this->add_control(
			'content_duration',
			[
				'label' => __( 'Transition Duration', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3,
						'step' => 0.05,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0.35,
				],
				'selectors' => [
					'{{WRAPPER}} .imghvr .imghvr-content-wrapper' => 'transition-duration: {{SIZE}}s;',
					'{{WRAPPER}} .imghvr:hover .imghvr-content-wrapper' => 'animation-duration: {{SIZE}}s',
					'{{WRAPPER}} .imghvr-title, {{WRAPPER}} .imghvr-subtitle, {{WRAPPER}} .imghvr-content, {{WRAPPER}} .imghvr-button-wrapper' => 'transition-duration: {{SIZE}}s'
				]
			]
		);

		$this->add_control(
			'content_delay',
			[
				'label' => __( 'Transition Delay', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3,
						'step' => 0.05,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .imghvr .imghvr-content-wrapper' => 'transition-delay: {{SIZE}}s; animation-delay: {{SIZE}}s;',
					'{{WRAPPER}} .ih-delay-xs' => 'transition-delay: calc({{SIZE}}s * 1)',
					'{{WRAPPER}} .ih-delay-sm' => 'transition-delay: calc({{SIZE}}s * 2)',
					'{{WRAPPER}} .ih-delay-md' => 'transition-delay: calc({{SIZE}}s * 3)',
					'{{WRAPPER}} .ih-delay-lg' => 'transition-delay: calc({{SIZE}}s * 4)',
					'{{WRAPPER}} .ih-delay-xl' => 'transition-delay: calc({{SIZE}}s * 5)',
					'{{WRAPPER}} .ih-delay-xxl' => 'transition-delay: calc({{SIZE}}s * 6)',
				]
			]
		);

		$this->add_control(
			'content_hr2',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'content_appearance',
			[
				'label' => 'Content Appearance',
				'type' => 'repeatselect',
				'options' => [
					'imghvr-anim-none' => __('Show Always', 'plugin-domain'),
					'imghvr-anim-fade-content imghvr-anim-fade-content-up' => __( 'Fade Up', 'plugin-domain' ),
					'imghvr-anim-fade-content imghvr-anim-fade-content-down' => __( 'Fade Down', 'plugin-domain' ),
					'imghvr-anim-fade-content imghvr-anim-fade-content-left' => __( 'Fade Left', 'plugin-domain' ),
					'imghvr-anim-fade-content imghvr-anim-fade-content-right' => __( 'Fade Right', 'plugin-domain' ),
					'imghvr-anim-slide-content imghvr-anim-slide-content-up' => __( 'Slide Up', 'plugin-domain' ),
					'imghvr-anim-slide-content imghvr-anim-slide-content-down' => __( 'Slide Down', 'plugin-domain' ),
					'imghvr-anim-zoom-content imghvr-anim-zoom-content-in' => __( 'Zoom In', 'plugin-domain' ),
					'imghvr-anim-zoom-content imghvr-anim-zoom-content-out' => __( 'Zoom Out', 'plugin-domain' ),
					'imghvr-anim-flip-content imghvr-anim-flip-content-x' => __( 'Flip X', 'plugin-domain' ),
					'imghvr-anim-flip-content imghvr-anim-flip-content-y' => __( 'Flip Y', 'plugin-domain' ),
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'buttons_section',
			[
				'label' => __( 'Buttons', 'plugin-name' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'license!' => 'false'
				]
			]
		);

		$this->add_control(
			'buttons',
			[
				'label' => __('', 'prime-addons'),
				'type' => Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'text',
						'label' => __( 'Text', 'prime-addons'),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => 'Button',
						'dynamic' => [
							'active' => true,
							'categories' => [TagsModule::TEXT_CATEGORY],
						]
					],
					[
						'name' => 'selected_icon',
						'label' => __( 'Icon', 'prime-addons'),
						'type' => Controls_Manager::ICONS,
						'fa4compatibility' => 'icon',
						'label_block' => true
					],
					[
						'name' => 'link',
						'label' => __( 'Link', 'plugin-domain' ),
						'type' => Controls_Manager::URL,
						'placeholder' => __( 'https://your-link.com', 'plugin-domain' ),
						'default' => [
							'url' => '#',
						],
						'dynamic' => [
							'active' => true,
							'categories' => [TagsModule::URL_CATEGORY]
						]
					]
				],
				'prevent_empty' => false,
				'title_field' => '{{{ text }}}',
			]
		);

		$this->add_control(
			'buttons_divider',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'buttons_direction',
			[
				'label' => __( 'Stack', 'plugin-domain' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'row',
				'options' => [
					'row'  => __( 'Horizontal', 'plugin-domain' ),
					'column' => __( 'Vertical', 'plugin-domain' )
				]
			]
		);

		$this->add_control(
			'buttons_align',
			[
				'label' => __( 'Alignment', 'plugin-domain' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'right' => [
						'title' => __( 'Left', 'plugin-domain' ),
						'icon' => 'eicon-h-align-left',
					],
					'left' => [
						'title' => __( 'Right', 'plugin-domain' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .imghvr .imghvr-buttons' => 'margin-{{VALUE}}: auto;'
				]
			]
		);

		$this->add_control(
			'buttons_valign',
			[
				'label' => __( 'Vertical Alignment', 'plugin-domain' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'bottom' => [
						'title' => __( 'Top', 'plugin-domain' ),
						'icon' => 'eicon-v-align-top',
					],
					'top' => [
						'title' => __( 'Bottom', 'plugin-domain' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .imghvr .imghvr-buttons' => 'margin-{{VALUE}}: auto;'
				]
			]
		);

		$this->add_control(
			'buttons_icon_align',
			[
				'label' => __( 'Icon Position', 'plugin-domain' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'plugin-domain' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'plugin-domain' ),
						'icon' => 'eicon-h-align-right',
					]
				],
				'default' => 'left',
				'toggle' => false
			]
		);

		$this->end_controls_section();

	}

	protected function addstyle() {

		$this->start_controls_section(
			'image_style',
			[
				'label' => __( 'Image', 'plugin-name' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => __( 'Width', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .imghvr, {{WRAPPER}} .imghvr img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label' => __( 'Max Width', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .imghvr img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'match_height',
			[
				'label' => __( 'Match Height', 'plugin-domain' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
				'return_value' => '100%',
				'default' => '',
				'selectors' => [
                    '{{WRAPPER}}, {{WRAPPER}} .elementor-widget-container, {{WRAPPER}} .imghvr img' => 'height: {{VALUE}};'
                ]
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => __( 'Height', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
                    'unit' => 'px',
                    'size' => 400
				],
				'condition' => [
					'match_height' => ''
				],
				'selectors' => [
					'{{WRAPPER}} .imghvr' => 'max-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .imghvr-padding:hover' => 'padding-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'plugin-domain' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .imghvr' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'overlay_style',
			[
				'label' => __( 'Overlay', 'plugin-name' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'overlay_border',
				'label' => __( 'Border', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .imghvr-overlay',
			]
		);

		$this->add_responsive_control(
			'overlay_margin',
			[
				'label' => __( 'Margin', 'plugin-domain' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .imghvr .imghvr-overlay' => 'margin-top: {{TOP}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_background',
				'label' => __( 'Background', 'plugin-domain' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .imghvr-anim-single, {{WRAPPER}} .imghvr-anim-pseudo::before, {{WRAPPER}} .imghvr-anim-pseudo::after, {{WRAPPER}} .imghvr-anim-pseudo div::before, {{WRAPPER}} .imghvr-anim-pseudo div::after',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_style',
			[
				'label' => __( 'Content', 'plugin-name' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_heading',
			[
				'label' => __( 'Title', 'plugin-name' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
        );

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'plugin-domain' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .imghvr-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'plugin-domain' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .imghvr-title',
			]
		);

		$this->add_control(
			'subtitle_heading',
			[
				'label' => __( 'Sub Title', 'plugin-name' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => __( 'Color', 'plugin-domain' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .imghvr-subtitle' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => __( 'Typography', 'plugin-domain' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .imghvr-subtitle',
			]
		);

		$this->add_control(
			'content_heading',
			[
				'label' => __( 'Content', 'plugin-name' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __( 'Color', 'plugin-domain' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .imghvr-content' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'plugin-domain' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .imghvr-content',
			]
		);

		$this->add_control(
			'icon_heading',
			[
				'label' => __( 'Icon', 'plugin-name' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Color', 'plugin-domain' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .imghvr-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 25,
				],
				'selectors' => [
					'{{WRAPPER}} .imghvr-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .imghvr-icon svg' => 'max-width: {{SIZE}}{{UNIT}}; max-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hr',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_responsive_control(
			'content_margin',
			[
				'label' => __( 'Margin', 'plugin-domain' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .imghvr-content-wrapper' => 'top: {{TOP}}{{UNIT}}; right: {{RIGHT}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}}; left: {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => __( 'Padding', 'plugin-domain' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .imghvr-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => __( 'Background', 'plugin-domain' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .imghvr-content-wrapper',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'buttons_style',
			[
				'label' => __( 'Buttons', 'plugin-name' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'buttons_color',
			[
				'label' => __( 'Color', 'plugin-domain' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default' => '#222',
				'selectors' => [
					'{{WRAPPER}} .imghvr-button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'buttons_background',
			[
				'label' => __( 'Background', 'plugin-domain' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .imghvr-button' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'buttons_typography',
				'label' => __( 'Typography', 'plugin-domain' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .imghvr-button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'buttons_border',
				'label' => __( 'Border', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .imghvr-button',
			]
		);

		$this->add_control(
			'buttons_spacing',
			[
				'label' => __('Spacing', 'plugin-domain'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .imghvr-buttons-row .imghvr-button-wrapper' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .imghvr-buttons-row .imghvr-button-wrapper:last-child' => 'margin-right: 0;',
					'{{WRAPPER}} .imghvr-buttons-column .imghvr-button-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .imghvr-buttons-column .imghvr-button-wrapper:last-child' => 'margin-bottom: 0;',
				],
			]
		);

		$this->add_control(
			'buttons_icon_spacing',
			[
				'label' => __( 'Icon Spacing', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					]
				],
				'default' => [
					'unit' => 'em',
					'size' => 0.3,
				],
				'selectors' => [
					'{{WRAPPER}} .imghvr-buttons-icon-left .imghvr-button i, {{WRAPPER}} .imghvr-buttons-icon-left .imghvr-button svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .imghvr-buttons-icon-right .imghvr-button i, {{WRAPPER}} .imghvr-buttons-icon-right .imghvr-button svg' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'buttons_icon_size',
			[
				'label' => __( 'Icon Size', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 25,
				],
				'selectors' => [
					'{{WRAPPER}} .imghvr-button i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .imghvr-button svg' => 'max-width: {{SIZE}}{{UNIT}}; max-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'buttons_margin',
			[
				'label' => __( 'Margin', 'plugin-domain' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .imghvr-buttons' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'buttons_padding',
			[
				'label' => __( 'Padding', 'plugin-domain' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .imghvr-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'buttons_border_radius',
			[
				'label' => __( 'Border Radius', 'plugin-domain' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .imghvr-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	private function get_link_url( $settings ) {
		if ($settings['target'] === 'none') {
			return false;
		}

		if ($settings['target'] === 'link') {
			if (empty($settings['link']['url'])) {
				return false;
			}

			return $settings['link'];
		}

		return [
			'url' => $settings['image']['url'],
		];
	}

	protected function get_image_html($settings, $image_size, $image, $classes = '') {
		$image_html = Group_Control_Image_Size::get_attachment_image_html($settings, $image_size, $image);

		if (strpos($image_html, 'class="') !== false) {
			$image_html = str_replace('class="', 'class="' . $classes . ' ', $image_html);
		} else {
			$image_html = str_replace('src="', 'class="' . $classes . '" src="', $image_html);
		}
		
		return $image_html;
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		
		if (empty($settings['image']['url'])) {
			return;
		}
        
        if (is_admin() && $this->get_license('license') == 'false') {
            ?>

            <div class="imghvr-wrapper">
                <div class="imghvr">
                <img src="<?php echo EHE_URL . 'assets/placeholder.png'; ?>" alt="" class="imghvr-anim-none">
                </div>
            </div>

            <?php
        } else {

		$index = 0;
		$delay = 0;
		$delays = array('ih-delay-zero', 'ih-delay-xs', 'ih-delay-sm', 'ih-delay-md', 'ih-delay-lg', 'ih-delay-xl', 'ih-delay-xxl');
		$contents = array('title', 'subtitle', 'content');
		$types = array('image', 'overlay', 'content');
		$classes = array(
			'imghvr' => array('imghvr'), 
			'image' => array('imghvr-anim-none'), 
			'overlay' => array('imghvr-anim-none', 'imghvr-anim-single'), 
			'content' => array('imghvr-anim-none')
		);

		foreach ($types as $type) {
			$tmpclass = explode('|', $settings[$type . '_effect']);
			$classes[$type] = $tmpclass[0];
			if (isset($tmpclass[1])) {
				$classes['imghvr'][] = $tmpclass[1];
			}
		}

		array_unique($classes['imghvr']);

		?>

        <div class="imghvr-wrapper">

			<div class="<?php echo implode(' ', $classes['imghvr']); ?>">

				<?php if ($settings['overlay_show'] === 'yes') { ?>
				<div class="imghvr-overlay <?php echo $classes['overlay']; ?>"><div></div></div>
				<?php } ?>
				<div class="imghvr-content-wrapper imghvr-content-<?php echo $settings['align']; ?> <?php echo $classes['content']; ?>">

					<?php
						$link = $this->get_link_url($settings);

						if ($link) {

							// newer elementor version
							if (method_exists($this, 'add_link_attributes')) {

								$this->add_link_attributes('link', $link);

								if ($settings['target'] === 'lightbox') {
									$this->add_lightbox_data_attributes('link', $settings['image']['id'], $settings['target']);
								}

							} else {

								$this->add_render_attribute('link', [
									'href' => $link['url'],
									'data-elementor-open-lightbox' => ($settings['target'] === 'lightbox') ? 'yes' : 'no',
								]);

								if (!empty($link['is_external'])) {
									$this->add_render_attribute('link', 'target', '_blank');
								}
					
								if (!empty($link['nofollow'])) {
									$this->add_render_attribute('link', 'rel', 'nofollow');
								}

							}

							if (Plugin::$instance->editor->is_edit_mode()) {
								$this->add_render_attribute('link', [
									'class' => 'elementor-clickable',
								]);
							}

							$this->add_render_attribute( 'link', [
								'class' => 'imghvr-link',
							]);

							echo '<a ' . $this->get_render_attribute_string('link') . '></a>';
						}
					?>
					
					<?php

					if (isset($settings['content_icon']) && $settings['content_icon']['value'] !== '') {
						$anim = (isset($settings['content_appearance'][$index])) ? $settings['content_appearance'][$index] : 'imghvr-anim-none';
						echo '<div class="imghvr-icon ' . $anim . ' ' . $delays[$delay] . '">';
						Icons_Manager::render_icon($settings['content_icon']);
						echo '</div>';
						if ($anim !== 'imghvr-anim-none') {
							$delay++;
						}
						$index++;
					}

					?>

					<?php

					foreach($contents as $content) {
						if ($settings[$content] !== '') {
							$anim = (isset($settings['content_appearance'][$index])) ? $settings['content_appearance'][$index] : 'imghvr-anim-none';
							echo '<div class="imghvr-' . $content . ' ' . $anim . ' ' . $delays[$delay] . '">' . $settings[$content] . '</div>';
							if ($anim !== 'imghvr-anim-none') {
								$delay++;
							}
							$index++;
						}
					}

					?>

					<?php if (is_array($settings['buttons']) && sizeof($settings['buttons']) > 0) { ?>

					<div class="imghvr-buttons imghvr-buttons-<?php echo $settings['buttons_direction']; ?> imghvr-buttons-icon-<?php echo $settings['buttons_icon_align']; ?>">
					
					<?php
					
					foreach ($settings['buttons'] as $n => $button) {
						$anim = (isset($settings['content_appearance'][$index])) ? $settings['content_appearance'][$index] : 'imghvr-anim-none';
						$target = $button['link']['is_external'] ? ' target="_blank"' : '';
						$nofollow = $button['link']['nofollow'] ? ' rel="nofollow"' : '';
                        
                        echo '<div class="imghvr-button-wrapper ' . $anim . ' ' . $delays[$delay] . '">';
                        
                        echo '<a href="' . $button['link']['url'] . '"' . $target . $nofollow . ' class="imghvr-button imghvr-button-' . ($n + 1) . '">';
						if (isset($button['selected_icon']) && $button['selected_icon']['value'] !== '') {
						    Icons_Manager::render_icon( $button['selected_icon'], ['aria-hidden' => 'true']);
						}
						echo $button['text'];
                        echo '</a>';
                        
                        echo '</div>';

						if ($anim !== 'imghvr-anim-none') {
							$delay++;
						}
						$index++;
					}
						
					?>

					</div>

					<?php } ?>
				</div>
				<?php echo $this->get_image_html($settings, 'image', 'image', $classes['image']); ?>
			
			</div>

        </div>
		
		<?php
        }
	}

	protected function _content_template() {

		?>

		<#

        if (settings.license == 'false') {

        #>

        <div class="imghvr-wrapper">
            <div class="imghvr">
            <img src="<?php echo EHE_URL . 'assets/placeholder.png'; ?>" alt="" class="imghvr-anim-none">
            </div>
        </div>

        <#
        
        } else {
		
		var index = 0;
		var delay = 0;
		var delays = ['ih-delay-zero', 'ih-delay-xs', 'ih-delay-sm', 'ih-delay-md', 'ih-delay-lg', 'ih-delay-xl', 'ih-delay-xxl'];
		var contents = ['title', 'subtitle', 'content'];
		var types = [ 'image', 'overlay', 'content' ];
		var classes = {
			imghvr: ['imghvr'],
			image: ['imghvr-anim-none'],
			overlay: ['imghvr-anim-none imghvr-anim-single'],
			content: ['imghvr-anim-none']
		};

		_.each(types, function(type) {
			var tmpclass = settings[type + '_effect'] ? settings[type + '_effect'].split('|') : classes[type];
			classes[type] = tmpclass[0];
			if (tmpclass[1]) {
				classes['imghvr'].push(tmpclass[1]);
			}
		});

		_.uniq(classes['imghvr']);

		#>
        <# if (settings.image.id) {
            var image = {
				id: settings.image.id,
				url: settings.image.url,
				size: settings.image_size,
				dimension: settings.image_custom_dimension,
				model: view.getEditModel()
			};
			var image_url = elementor.imagesManager.getImageUrl( image );
        } else if (settings.image.url) {
            var image_url = settings.image.url;
        } else {
			var image_url = settings.image;
		} #>

		<div class="imghvr-wrapper">

			<div class="{{ classes['imghvr'].join(' ') }}">

				<# if (settings.overlay_show === 'yes') { #>
				<div class="imghvr-overlay {{ classes['overlay'] }}"><div></div></div>
				<# } #>
				<div class="imghvr-content-wrapper imghvr-content-{{ settings.align }} {{ classes['content'] }}">

                    <# if (settings.target === 'link') {
                        var target = settings.link.is_external ? ' target="_blank"' : '';
                        var nofollow = settings.link.nofollow ? ' rel="nofollow"' : '';
                    #>
                    <a href="{{ settings.link.url }}"{{ target }}{{ nofollow }} class="imghvr-link"></a>
                    <# } else if (settings.target === 'lightbox') { #>
                    <a href="{{ settings.image.url }}" class="imghvr-link"></a>
					<# } #>
					
					<# if (settings.content_icon && settings.content_icon.value) {
						var iconHTML = elementor.helpers.renderIcon(view, settings.content_icon, { 'aria-hidden': true }, 'i', 'object');
					#>
					<# var anim = (settings.content_appearance[index]) ? settings.content_appearance[index] : 'imghvr-anim-none'; #>
					<div class="imghvr-icon {{ anim }} {{ delays[delay] }}">{{{ iconHTML.value }}}</div>
					<# if (anim !== 'imghvr-anim-content') { delay++; } #>
					<# index++; #>
					<# } #>

					<# _.each(contents, function(content) { #>
					<# if (settings[content]) { #>
					<# var anim = (settings.content_appearance[index]) ? settings.content_appearance[index] : 'imghvr-anim-none'; #>
					<div class="imghvr-{{ content }} {{ anim }} {{ delays[delay] }}">{{{ settings[content] }}}</div>
					<# if (anim !== 'imghvr-anim-content') { delay++; } #>
					<# index++; #>
					<# } #>
					<# }); #>

					<# if (settings.buttons.length > 0) { #>

					<div class="imghvr-buttons imghvr-buttons-{{ settings.buttons_direction }} imghvr-buttons-icon-{{ settings.buttons_icon_align }}">

						<# _.each(settings.buttons, function(button) { #>
						<#
						var anim = (settings.content_appearance[index]) ? settings.content_appearance[index] : 'imghvr-anim-none';
						var target = button.link.is_external ? ' target="_blank"' : '';
						var nofollow = button.link.nofollow ? ' rel="nofollow"' : '';
						#>

						<div class="imghvr-button-wrapper {{ anim }} {{ delays[delay] }}">

						<a href="{{ button.link.url }}"{{ target }}{{ nofollow }} class="imghvr-button">
							<# if (button.selected_icon && button.selected_icon.value) {
                                var iconHTML = elementor.helpers.renderIcon( view, button.selected_icon, { 'aria-hidden': true }, 'i', 'object');
                            #>
							{{{ iconHTML.value }}}
							<# } #>
							{{ button.text }}
						</a>

						</div>

						<# if (anim !== 'imghvr-anim-content') { delay++; } #>
						<# index++; #>
						<# }); #>

					</div>

					<# } #>
				</div>

				<img src="{{{ image_url }}}" alt="" class="{{ classes['image'] }}">

			</div>

        </div>

		<# } #>

		<?php
	}

}
Plugin::instance()->widgets_manager->register_widget_type(new Emage_Hover());