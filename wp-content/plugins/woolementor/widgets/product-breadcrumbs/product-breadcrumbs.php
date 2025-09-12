<?php
namespace codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Control_Icon;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Product_Breadcrumbs extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = woolementor_get_widget_id( __CLASS__ );
	    $this->widget = woolementor_get_widget( $this->id );
	}

	public function get_script_depends() {
		return [];
	}

	public function get_style_depends() {
		return [];
	}

	public function get_name() {
		return $this->id;
	}

	public function get_title() {
		return $this->widget['title'];
	}

	public function get_icon() {
		return $this->widget['icon'];
	}

	public function get_categories() {
		return $this->widget['categories'];
	}

	protected function _register_controls() {

		/**
		 * Breadcrumbs
		 */
		$this->start_controls_section(
			'section_content_Breadcrumbs',
			[
				'label' => __( 'Breadcrumbs', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'breadcrumbs_align',
			[
				'label' 		=> __( 'Alignment', 'plugin-domain' ),
				'type' 			=> Controls_Manager::CHOOSE,
				'options' 		=> [
					'left' 		=> [
						'title' 	=> __( 'Left', 'plugin-domain' ),
						'icon' 		=> 'fa fa-align-left',
					],
					'center' 	=> [
						'title' 	=> __( 'Center', 'plugin-domain' ),
						'icon' 		=> 'fa fa-align-center',
					],
					'right' 	=> [
						'title' 	=> __( 'Right', 'plugin-domain' ),
						'icon' 		=> 'fa fa-align-right',
					],
				],
				'default' 		=> 'left',
				'toggle' 		=> true,
				'selectors' => [
					'{{WRAPPER}} .wl-bc .woocommerce-breadcrumb' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'breadcrump_indicator_show_hide',
			[
				'label'         => __( 'Use Custom Separator', 'woolementor' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'Show', 'woolementor' ),
				'label_off'     => __( 'Hide', 'woolementor' ),
				'return_value'  => 'yes',
				'default'       => 'no',
			]
		);

        $this->add_control(
			'breadcrump_indicator',
			[
				'label' => __( 'Select Separator Icon', 'woolementor' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-angle-right',
					'library' => 'solid',
				],
				'condition' => [
                    'breadcrump_indicator_show_hide' => 'yes'
                ],
			]
		);

		$this->end_controls_section();

		/**
		 * Breadcrumbs
		 */
		$this->start_controls_section(
			'_breadcrumbs',
			[
				'label' 	=> __( 'Breadcrumbs Color', 'woolementor' ),
				'tab'   	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'breadcrumbs_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-bc .woocommerce-breadcrumb',
			]
		);

		$this->add_responsive_control(
			'breadcrumbs_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-bc .woocommerce-breadcrumb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'		=> 'before',
			]
		);

		$this->add_responsive_control(
			'breadcrumbs_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-bc .woocommerce-breadcrumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'breadcrumbs_tabs',
			[
				'separator' => 'before'
			]
		);

		$this->start_controls_tab(
			'breadcrumbs_home',
			[
				'label' 	=> __( 'Home', 'woolementor' ),
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' 		=> 'breadcrumbs_home_color',
                'selector' 	=> '{{WRAPPER}} .wl-bc .woocommerce-breadcrumb a:first-child',
            ]
        );

		$this->end_controls_tab();

		$this->start_controls_tab( 
			'breadcrumbs_category',
			[
				'label' 	=> __( 'Categories', 'woolementor' ),
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' 		=> 'breadcrumbs_category_color',
                'selector' 	=> '{{WRAPPER}} .wl-bc .woocommerce-breadcrumb a',
            ]
        );

		$this->end_controls_tab();

		$this->start_controls_tab( 
			'breadcrumbs_product_name',
			[
				'label' 	=> __( 'Product', 'woolementor' ),
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' 		=> 'breadcrumbs_product_name_color',
                'selector' 	=> '{{WRAPPER}} .wl-bc .woocommerce-breadcrumb',
            ]
        );

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/*
		*Separator Color
		*/
		$this->start_controls_section(
			'breadcrumbs_Separa',
			[
				'label' 	=> __( 'Breadcrumbs Separator', 'woolementor' ),
				'tab'   	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
            Group_Control_Gradient_Text::get_type(),
            [
                'name' 		=> 'breadcrumbs_separatot_color',
                'selector' 	=> '{{WRAPPER}} .wl-bc .woocommerce-breadcrumb i',
            ]
        );
		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		extract( $settings );
		
		if ( 'yes' == $breadcrump_indicator_show_hide ) {
			add_filter( 'woocommerce_breadcrumb_defaults', function( $defaults ) use ( $breadcrump_indicator ) {
				$defaults['delimiter'] = ' <i class="' . esc_attr( $breadcrump_indicator['value'] ) . '"></i> ';
				return $defaults;
			} );
		}

		?>

		<div class="wl-bc">
			<?php woocommerce_breadcrumb(); ?>
		</div>

		<?php 
	}
}
