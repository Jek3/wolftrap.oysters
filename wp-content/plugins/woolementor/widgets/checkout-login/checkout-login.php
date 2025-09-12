<?php
namespace codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Checkout_Login extends Widget_Base {

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
			'form-content',
			[
				'label' => __( 'Form Content', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'form_collapse',
			[
				'label' => __( 'Show Toggle Text', 'plugin-domain' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'form_collapse_label',
			[
				'label' => __( 'Instruction Text', 'plugin-domain' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Already have an account? Click to login.' ),
				'condition' => [
                    'form_collapse' => 'yes'
                ],
			]
		);

		$this->end_controls_section();


		//section title style
		$this->start_controls_section(
			'form_label_style',
			[
				'label' => __( 'Toggle Text', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'form_label_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .wl-form-collapse',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'form_label_color',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .wl-form-collapse',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'form_label_background',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .wl-form-collapse',
			]
		);

		$this->add_control(
			'form_label_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-checkout-login .wl-form-collapse' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'form_label_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .wl-form-collapse',
			]
		);

		$this->add_control(
			'form_label_border_raidus',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors'	 	=> [
					'{{WRAPPER}} .wl-checkout-login .wl-form-collapse' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		*Form styling
		*/
		$this->start_controls_section(
			'login_form',
			[
				'label' => __( 'Form', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'login_form_background',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login  form',
			]
		);

		$this->add_control(
			'form_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors'	 	=> [
					'{{WRAPPER}} .wl-checkout-login  form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'form_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form',
			]
		);

		$this->add_control(
			'form_border_raidus',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors'	 	=> [
					'{{WRAPPER}} .wl-checkout-login form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		*Input fields Labels
		*/
		$this->start_controls_section(
			'form_input_labels',
			[
				'label' => __( 'Form Input Labels', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'form_input_labels_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form label',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'form_input_labels_text_color',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form label',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'input_labels_background',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form label',
			]
		);

		$this->add_control(
			'form_input_labels_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'separator' 	=> 'before',
				'selectors' 	=> [
					'{{WRAPPER}} .wl-checkout-login form label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'form_input_labels_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-checkout-login form label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'active_menu_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form label',
			]
		);

		$this->end_controls_section();

		/*
		*Input fields
		*/
		$this->start_controls_section(
			'form_input_fields',
			[
				'label' => __( 'Form Input Fields', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'form_input_fields_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form input',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'form_input_fields_text_color',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form input',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'input_fields_background',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form input',
			]
		);

		$this->add_control(
			'form_input_fields_margin',
			[
				'label' 		=> __( 'Margin', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'separator' 	=> 'before',
				'selectors' 	=> [
					'{{WRAPPER}} .wl-checkout-login form input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'form_input_fields_padding',
			[
				'label' 		=> __( 'Padding', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors' 	=> [
					'{{WRAPPER}} .wl-checkout-login form input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'input_fields_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login form input',
			]
		);

		$this->add_control(
			'input_fields_border_raidus',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors'	 	=> [
					'{{WRAPPER}} .wl-checkout-login form input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		*Button 
		*/
		$this->start_controls_section(
			'button_style',
			[
				'label' => __( 'Button', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'form_button_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .button.woocommerce-form-login__submit',
			]
		);

		$this->start_controls_tabs(
			'form-button',
			[
				'separator' => 'before',
			]
		);

		$this->start_controls_tab(
			'form-button-normal',
			[
				'label' => __( 'Normal', 'woolementor' )
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'form_button_color',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login button.woocommerce-form-login__submit',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'form_button_background',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .button.woocommerce-form-login__submit',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'form_button_border',
				'label' 	=> __( 'Border', 'woolementor' ),
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .button.woocommerce-form-login__submit',
			]
		);

		$this->add_control(
			'form_button_border_raidus',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors'	 	=> [
					'{{WRAPPER}} .wl-checkout-login .button.woocommerce-form-login__submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'form-button-hover',
			[
				'label' => __( 'Hover', 'woolementor' )
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'form_button_color_hover',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login button.woocommerce-form-login__submit:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' 		=> 'form_button_background_hover',
				'label' 	=> __( 'Background', 'woolementor' ),
				'types' 	=> [ 'classic', 'gradient' ],
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .button.woocommerce-form-login__submit:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' 		=> 'form_button_border_hover',
				'label' 	=> __( 'Border', 'woolementor' ),
				'separator' => 'before',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .button.woocommerce-form-login__submit:hover',
			]
		);

		$this->add_control(
			'form_button_border_raidus_hover',
			[
				'label' 		=> __( 'Border Radius', 'woolementor' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%', 'em' ],
				'selectors'	 	=> [
					'{{WRAPPER}} .wl-checkout-login .button.woocommerce-form-login__submit:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_tab();

		$this->end_controls_tabs();
		
		$this->end_controls_section();

		/*
		*Lost Password
		*/
		$this->start_controls_section(
			'lost_pass_style',
			[
				'label' => __( 'Lost Password Link', 'woolementor' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'lost_pass_typography',
				'label' 	=> __( 'Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1,
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .lost_password a',
			]
		);

		$this->add_group_control(
			Group_Control_Gradient_Text::get_type(),
			[
				'name' 		=> 'lost_pass_color',
				'selector' 	=> '{{WRAPPER}} .wl-checkout-login .lost_password a',
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
}

