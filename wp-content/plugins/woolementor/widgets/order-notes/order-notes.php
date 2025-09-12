<?php
namespace codexpert\Woolementor;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Order_Notes extends Widget_Base {

	public $id;
	protected $form_close='';

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

		$this->start_controls_section(
			'order_notes_title',
			[
				'label' => __( 'Section Title', 'woolementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'order_notes_title_show',
            [
                'label'         => __( 'Show/Hide Title', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );
		//order_button_text
		$this->add_control(
		    'order_notes_title_text',
		    [
		        'label' 		=> __( 'Text', 'woolementor' ),
		        'type' 			=> Controls_Manager::TEXT,
		        'default' 		=> __( 'Order Notes', 'woolementor' ) ,
                'condition' => [
                    'order_notes_title_show' => 'yes'
                ],
		        'dynamic' 		=> [
		            'active' 		=> true,
		        ]
		    ]
		);

		$this->add_control(
			'order_notes_title_tag',
			[
				'label' 	=> __( 'HTML Tag', 'woolementor' ),
				'type' 		=> Controls_Manager::SELECT,
				'default' 	=> 'h3',
				'options' 	=> [
					'h1'  => __( 'H1', 'woolementor' ),
					'h2'  => __( 'H2', 'woolementor' ),
					'h3'  => __( 'H3', 'woolementor' ),
					'h4'  => __( 'H4', 'woolementor' ),
					'h5'  => __( 'H5', 'woolementor' ),
					'h6'  => __( 'H6', 'woolementor' ),
				],
                'condition' => [
                    'order_notes_title_show' => 'yes'
                ],
			]
		);

		$this->add_control(
            'order_notes_title_alignment',
            [
                'label' 	   => __( 'Alignment', 'woolementor' ),
                'type' 		   => Controls_Manager::CHOOSE,
                'options' 	   => [
                    'left' 		=> [
                        'title' 	=> __( 'Left', 'woolementor' ),
                        'icon' 		=> 'fa fa-align-left',
                    ],
                    'center' 	=> [
                        'title' 	=> __( 'Center', 'woolementor' ),
                        'icon' 		=> 'fa fa-align-center',
                    ],
                    'right' 	=> [
                        'title' 	=> __( 'Right', 'woolementor' ),
                        'icon' 		=> 'fa fa-align-right',
                    ],
                ],
                'default' 	=> 'left',
                'toggle' 	=> true,
                'condition' => [
                    'order_notes_title_show' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-pm-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Order Fields', 'woolementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'order_input_label', [
				'label' => __( 'Input Label', 'woolementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'New Section' , 'woolementor' ),
				'label_block' => true,
				'separator' => 'after',
			]
		);

		$repeater->add_control(
			'order_input_class', [
				'label' => __( 'Class Name', 'woolementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'form-row-wide',
				'options' => [
					'form-row-first' => 'form-row-first',
					'form-row-last' => 'form-row-last',
					'form-row-wide' => 'form-row-wide',
				],
			]
		);

		$repeater->add_control(
			'order_input_type', [
				'label' => __( 'Input Type', 'woolementor' ),
				'type' => Controls_Manager::SELECT2,
				'default' => 'text',
				'options' => [
					// 'country'			=> __( 'Country', 'woolementor' ),
					// 'state'				=> __( 'State', 'woolementor' ),
					'textarea'			=> __( 'Textarea', 'woolementor' ),
					'checkbox'			=> __( 'Checkbox', 'woolementor' ),
					'text'				=> __( 'Text', 'woolementor' ),
					'password'			=> __( 'Password', 'woolementor' ),
					'date'				=> __( 'Date', 'woolementor' ),
					'number'			=> __( 'Number', 'woolementor' ),
					'email'				=> __( 'Email', 'woolementor' ),
					'url'				=> __( 'Url', 'woolementor' ),
					'tel'				=> __( 'Tel', 'woolementor' ),
					'select'			=> __( 'Select', 'woolementor' ),
					'radio'				=> __( 'Radio', 'woolementor' ),
				],
			]
		);

		$repeater->add_control(
			'order_input_options', [
				'label' => __( 'Options', 'woolementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => implode( PHP_EOL, [ __( 'Option 1', 'woolementor' ), __( 'Option 2', 'woolementor' ), __( 'Option 3', 'woolementor' ) ] ),
				'label_block' => true,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'order_input_type',
							'operator' => '==',
							'value' => 'select',
						],
						[
							'name' => 'order_input_type',
							'operator' => '==',
							'value' => 'radio',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'order_input_name', [
				'label' => __( 'Field Name', 'woolementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'name_' . rand( 111, 999 ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'order_input_placeholder', [
				'label' => __( 'Placeholder', 'woolementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Placeholder' , 'woolementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'order_input_autocomplete', [
				'label' => __( 'Autocomplete Value', 'woolementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Given value' , 'woolementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'order_input_required',
			[
				'label'         => __( 'Required', 'woolementor' ),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __( 'yes', 'woolementor' ),
				'label_off'     => __( 'no', 'woolementor' ),
				'return_value'  => true,
				'default'       => true,
			]
		);

		$this->add_control(
			'order_form_items',
			[
				'label' => __( '', 'woolementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => woolementor_checkout_fields( 'order' ),
				'title_field' => '{{{ order_input_label }}}',
			]
		);

		$this->end_controls_section();

		//section title style
		$this->start_controls_section(
			'order_notes_title_style',
			[
				'label' => __( 'Title', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'order_notes_title_show' => 'yes'
                ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_notes_title_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-pm-title',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' => 'order_notes_title_color',
				'selector' => '{{WRAPPER}} .wl-pm-title',
			]
		);

		$this->end_controls_section();

		/**
		 * Input Label Color
		 */
		$this->start_controls_section(
			'order_style',
			[
				'label' => __( 'Labels', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_label_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' 	=> '{{WRAPPER}} .wl-order-notes label',
			]
		);


        $this->add_control(
			'order_label_color',
			[
				'label'     => __( 'Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-notes label' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
        	'order_label_padding',
        	[
        		'label' => __( 'Padding', 'woolementor' ),
        		'type' => Controls_Manager::DIMENSIONS,
        		'size_units' => [ 'px', '%', 'em' ],
        		'selectors' => [
        			'{{WRAPPER}} .wl-order-notes label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        		],
        	]
        );

		$this->add_control(
			'order_label_line_hight',
			[
				'label' => __( 'Line Height', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 25,
				],
				'selectors' => [
					'{{WRAPPER}} .wl-order-notes label' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Input Color
		 */
		$this->start_controls_section(
			'order_input_style',
			[
				'label' => __( 'Input Fields', 'woolementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'order_input_typographyrs',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .wl-order-notes input, 
								{{WRAPPER}} .wl-order-notes select, 
								{{WRAPPER}} .wl-order-notes option,
								{{WRAPPER}} .wl-order-notes textarea',
			]
		);

		$this->add_control(
			'order_input_color',
			[
				'label'     => __( 'Input Text Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-notes input, 
					 {{WRAPPER}} .wl-order-notes select, 
					 {{WRAPPER}} .wl-order-notes option,
					 {{WRAPPER}} .wl-order-notes textarea' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'order_input_background_color',
			[
				'label'     => __( 'Background Color', 'woolementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wl-order-notes input, 
					 {{WRAPPER}} .wl-order-notes select, 
					 {{WRAPPER}} .wl-order-notes option,
					 {{WRAPPER}} .wl-order-notes textarea' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'order_input_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'separator' => 'before',
				'selector' => '{{WRAPPER}} .wl-order-notes input, 
								{{WRAPPER}} .wl-order-notes select,
								{{WRAPPER}} .wl-order-notes textarea',
			]
		);

        $this->add_control(
			'order_input_border_radius',
			[
				'label' => __( 'Border Redius', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-order-notes input, 
					 {{WRAPPER}} .wl-order-notes select,
					 {{WRAPPER}} .wl-order-notes textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'order_input_padding',
			[
				'label' => __( 'Padding', 'woolementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wl-order-notes input, 
					 {{WRAPPER}} .wl-order-notes select,
					 {{WRAPPER}} .wl-order-notes textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
        if( !current_user_can( 'edit_pages' ) ) return;

        echo woolementor_notice( sprintf( __( 'This beautiful widget, <strong>%s</strong> is a premium widget. Please upgrade to <strong>%s</strong> or activate your license if you already have upgraded!' ), $this->get_title(), '<a href="https://woolementor.com" target="_blank">Woolementor Pro</a>' ) );

        if( file_exists( dirname( __FILE__ ) . '/assets/img/screenshot.png' ) ) {
            echo "<img src='" . plugins_url( 'assets/img/screenshot.png', __FILE__ ) . "' />";
        }
    }

	/**
	 * Adds the starting form tag <form>
	 */
	public function start_form( $start ) {
		return '<form name="checkout" method="post" class="checkout woocommerce-checkout" action="" enctype="multipart/form-data" novalidate="novalidate">';
	}

	/**
	 * Adds the closing form tag </form>
	 */
	public function close_form( $close ) {
		return '</form>';
	}
}

