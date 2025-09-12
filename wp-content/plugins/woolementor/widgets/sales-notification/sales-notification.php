<?php
namespace codexpert\Woolementor;

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use codexpert\Woolementor\Controls\Group_Control_Gradient_Text;

class Sales_Notification extends Widget_Base {

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
			 * Product Title
			 */
			$this->start_controls_section(
				'sectio_cat',
				[
					'label' 		=> __( 'Content', 'woolementor' ),
					'tab' 			=> Controls_Manager::TAB_CONTENT,
				]
			);

	        $this->add_control(
				'notification_from',
				[
					'label' 		=> __( 'Content Source', 'woolementor' ),
					'type' 			=> Controls_Manager::SELECT2,
					'options' 		=> [
						'this_site'  	=> __( 'From This Site', 'woolementor' ),
						'from_api' 		=> __( 'From API', 'woolementor' ),
					],
					'default' 		=> 'this_site',
					'label_block' 	=> true,
				]
			);

			$this->add_control(
				'api_url',
				[
					'label' 		=> __( 'API URL', 'woolementor' ),
					'type' 			=> Controls_Manager::URL,
					'placeholder' 	=> 'https://your-link.com/api',
					'default' 		=> [
						'url' => '',
					],
					'label_block' 	=> true,
					'description' 	=> __( 'REST API URL to fetch order data from.', 'woolementor' ),
	                'condition' => [
	            		'notification_from' => 'from_api'
	                ],
				]
			);

			$this->add_control(
				'enable_url',
				[
					'label' => __( 'Link To Product', 'woolementor' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'ON', 'woolementor' ),
					'label_off' => __( 'OFF', 'woolementor' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);

	        $this->add_control(
				'notification_type',
				[
					'label' 		=> __( 'Content Type', 'woolementor' ),
					'type' 			=> Controls_Manager::SELECT2,
					'options' 		=> [
						'real_data'  	=> __( 'Real Data', 'woolementor' ),
						'fake_data' 	=> __( 'Fake Data', 'woolementor' ),
						'both_data' 	=> __( 'Both ', 'woolementor' ),
					],
					'default' 		=> 'fake_data',
					'label_block' 	=> true,
					'condition' 	=> [
						'notification_from' => 'this_site'
					],
				]
			);

			$this->add_control(
				'orders_limit',
				[
					'label' 		=> __( 'Number of Orders', 'woolementor' ),
					'type' 			=> Controls_Manager::NUMBER,
					'default' 		=> 5,
					'label_block' 	=> true,
	                'conditions' => [
	            		'relation' => 'and',
	            		'terms' => [
	            			[
	            				'name' => 'notification_type',
	            				'operator' => 'in',
	            				'value' => [ 'real_data', 'both_data' ],
	            			],
	            			[
	            				'name' => 'notification_from',
	            				'operator' => '==',
	            				'value' => 'this_site',
	            			],
	            		],
	                ],
				]
			);

			$this->add_control(
			    'orders_statuses',
			    [
			        'label'         => __( 'Order Statuses', 'woolementor' ),
			        'type'          => Controls_Manager::SELECT2,
			        'multiple'       => true,
			        'separator'      => 'after',
			        'options'       => [
			            'completed'    => __( 'Completed', 'woolementor' ),
			            'processing'   => __( 'Processing', 'woolementor' ),
			            'on-hold'      => __( 'On Hold', 'woolementor' ),
			        ],
			        'default'       => [ 'completed', 'processing', 'on-hold' ],
	                'conditions' => [
	                	'relation' => 'and',
	            		'terms' => [
	            			[
	            				'name' => 'notification_type',
	            				'operator' => 'in',
	            				'value' => [ 'real_data', 'both_data' ],
	            			],
	            			[
	            				'name' => 'notification_from',
	            				'operator' => '==',
	            				'value' => 'this_site',
	            			],
	            		],
	                ],
			    ]
			);

			$this->add_control(
				'product_ids', [
					'label' => __( 'Product IDs', 'woolementor' ),
					'type' => Controls_Manager::TEXT,
					'placeholder' => __( 'Ex: 21,56,89' , 'woolementor' ),
					'description' => __( 'Input the product IDs you want to show' , 'woolementor' ),
					'label_block' => true,
					'conditions' => [
						'relation' => 'and',
	            		'terms' => [
	            			[
	            				'name' => 'notification_type',
	            				'operator' => 'in',
	            				'value' => [ 'real_data', 'both_data' ],
	            			],
	            			[
	            				'name' => 'notification_from',
	            				'operator' => '==',
	            				'value' => 'this_site',
	            			],
	            		],
					],
				]
			);

	        $repeater = new Repeater();

			$repeater->add_control(
				'customer', [
					'label' => __( 'Client Name', 'woolementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( 'John Doe' , 'woolementor' ),
					'label_block' => true,
				]
			);

			$repeater->add_control(
				'address', [
					'label' => __( 'Client Address', 'woolementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( 'Neywork, USA' , 'woolementor' ),
					'label_block' => true,
				]
			);

			$repeater->add_control(
				'product_name', [
					'label' => __( 'Product Name', 'woolementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( 'Item' , 'woolementor' ),
					'label_block' => true,
				]
			);

			$repeater->add_control(
				'product_url', [
					'label' => __( 'Product URL', 'woolementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( 'https://example.com' , 'woolementor' ),
					'label_block' => true,
				]
			);

			$repeater->add_control(
				'product_image',
				[
					'label' => __( 'Choose Image', 'woolementor' ),
					'type' => Controls_Manager::MEDIA,
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
				]
			);

			$repeater->add_control(
				'time', [
					'label' => __( 'Notification Time', 'woolementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( '1 hours' , 'woolementor' ),
					'label_block' => true,
				]
			);

			$this->add_control(
				'notifications',
				[
					'label' => __( 'Notification List', 'woolementor' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'client_name' => __( 'John Doe', 'woolementor' ),
							'client_address' => __( 'Newyork, USA', 'woolementor' ),
							'product_name' => __( 't-shirt', 'woolementor' ),
							'sell_time' => '1 hours'
						],
						[
							'client_name' => __( 'John Max', 'woolementor' ),
							'client_address' => __( 'Newyork, USA', 'woolementor' ),
							'product_name' => __( 't-shirt with logo', 'woolementor' ),
							'sell_time' => '30 minutes'
						],
						[
							'client_name' => __( 'Piter Jakson', 'woolementor' ),
							'client_address' => __( 'Newyork, USA', 'woolementor' ),
							'product_name' => __( 'album', 'woolementor' ),
							'sell_time' => '40 minutes'
						],
						[
							'client_name' => __( 'Alen Jakson', 'woolementor' ),
							'client_address' => __( 'Newyork, USA', 'woolementor' ),
							'product_name' => __( 'caset', 'woolementor' ),
							'sell_time' => '20 minutes'
						],
					],
	                'conditions' => [
	                	'relation' => 'and',
	            		'terms' => [
	            			[
	            				'name' => 'notification_type',
	            				'operator' => 'in',
	            				'value' => [ 'fake_data', 'both_data' ],
	            			],
	            			[
	            				'name' => 'notification_from',
	            				'operator' => '==',
	            				'value' => 'this_site',
	            			],
	            		],
	                ],
					'title_field' => '{{{ client_name }}}',
				]
			);

			$this->add_control(
				'notification_duration',
				[
					'label' => __( 'Interval (millisecond)', 'woolementor' ),
					'type' => Controls_Manager::SLIDER,
					'separator' 	=> 'before',
					'size_units' => [ 'ms' ],
					'range' => [
						'ms' => [
							'min' => 0,
							'max' => 60000,
							'step' => 10,
						],
					],
					'default' => [
						'unit' => 'ms',
						'size' => 3000,
					],
				]
			);

			$this->add_control(
				'notification_delay',
				[
					'label' => __( 'Delay (millisecond)', 'woolementor' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'ms' ],
					'range' => [
						'ms' => [
							'min' => 0,
							'max' => 60000,
							'step' => 10,
						],
					],
					'default' => [
						'unit' => 'ms',
						'size' => 1000,
					],
				]
			);


	        $this->add_responsive_control(
	            'alignment',
	            [
	                'label' 		=> __( 'Alignment', 'woolementor' ),
	                'type' 			=> Controls_Manager::CHOOSE,
	                'options' 		=> [
	                    'left' 		=> [
	                        'title' 	=> __( 'Left', 'woolementor' ),
	                        'icon' 		=> 'fa fa-align-left',
	                    ],
	                    'right' 	=> [
	                        'title' 	=> __( 'Right', 'woolementor' ),
	                        'icon' 		=> 'fa fa-align-right',
	                    ],
	                ],
	                'toggle' 		=> true,
	                'default' 		=> 'left',
	            ]
	        );

	        $this->end_controls_section();

			/**
			 * Notification area
			 */
			$this->start_controls_section(
				'notification_style',
				[
					'label' => __( 'Card', 'woolementor' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'nt_background',
					'label' => __( 'Background', 'woolementor' ),
					'types' => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .wl-sales-notification .notification',
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'border',
					'label' => __( 'Border', 'woolementor' ),
					'selector' => '{{WRAPPER}} .wl-sales-notification .notification',
				]
			);

			$this->add_responsive_control(
				'card_border_radius',
				[
					'label' 		=> __( 'Border Radius', 'woolementor' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em' ],
					'selectors' 	=> [
						'{{WRAPPER}} .wl-sales-notification .notification' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'		=> 'after',
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'box_shadow',
					'label' => __( 'Box Shadow', 'woolementor' ),
					'selector' => '{{WRAPPER}} .wl-sales-notification .notification',
				]
			);

			$this->add_responsive_control(
				'card_padding',
				[
					'label' 		=> __( 'Padding', 'woolementor' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em' ],
					'selectors' 	=> [
						'{{WRAPPER}} .wl-sales-notification' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'		=> 'before',
				]
			);

			$this->add_responsive_control(
				'position_x',
				[
					'label' => __( 'Position X', 'woolementor' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 500,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 15,
					],
					'selectors' 	=> [
						'{{WRAPPER}} .wl-sales-notification' => 'bottom: {{SIZE}}{{UNIT}};',
					],
					'separator'		=> 'before',
				]
			);

			$this->add_responsive_control(
				'position_l_y',
				[
					'label' => __( 'Position Y', 'woolementor' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 500,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 15,
					],
					'condition' 	=> [
	                    'alignment' => 'left'
	                ],
					'selectors' 	=> [
						'{{WRAPPER}} .wl-sales-notification.left' => 'left: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'position_r_y',
				[
					'label' => __( 'Position Y', 'woolementor' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 500,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'condition' 	=> [
	                    'alignment' => 'right'
	                ],
					'selectors' 	=> [
						'{{WRAPPER}} .wl-sales-notification.right' => 'right: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section(); 

			/**
			 * Notification area		 
			 */
			$this->start_controls_section(
				'image_style',
				[
					'label' => __( 'Image', 'woolementor' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_responsive_control(
	            'image_width',
	            [
	                'label' 	=> __( 'Image Width', 'woolementor' ),
	                'type' 		=> Controls_Manager::SLIDER,
					'size_units'=> [ 'px', '%', 'em' ],
	                'selectors' => [
	                    '{{WRAPPER}} .wl-sales-notification .notification .image' => 'width: {{SIZE}}{{UNIT}}',
	                ],
	                'range'     => [
	                    'px'    => [
	                        'min'   => 1,
	                        'max'   => 500
	                    ],
	                    'em'    => [
	                        'min'   => 1,
	                        'max'   => 30
	                    ],
	                ],
	            ]
	        );

	        $this->add_responsive_control(
	            'image_height',
	            [
	                'label' 	=> __( 'Image Height', 'woolementor' ),
	                'type' 		=> Controls_Manager::SLIDER,
					'size_units'=> [ 'px', '%', 'em' ],
	                'selectors' => [
	                    '{{WRAPPER}} .wl-sales-notification .notification .image' => 'height: {{SIZE}}{{UNIT}}',
	                ],
	                'range'     => [
	                    'px'    => [
	                        'min'   => 1,
	                        'max'   => 500
	                    ],
	                    'em'    => [
	                        'min'   => 1,
	                        'max'   => 30
	                    ],
	                ],
	            ]
	        );

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'img_border',
					'label' => __( 'Border', 'woolementor' ),
					'selector' => '{{WRAPPER}} .wl-sales-notification .notification .image',
				]
			);

			$this->add_responsive_control(
				'img_border_radius',
				[
					'label' 		=> __( 'Border Radius', 'woolementor' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em' ],
					'selectors' 	=> [
						'{{WRAPPER}} .wl-sales-notification .notification .image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'img_box_shadow',
					'label' => __( 'Box Shadow', 'woolementor' ),
					'selector' => '{{WRAPPER}} .wl-sales-notification .notification .image',
				]
			);

			$this->add_responsive_control(
				'img_padding',
				[
					'label' 		=> __( 'Padding', 'woolementor' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em' ],
					'selectors' 	=> [
						'{{WRAPPER}} .wl-sales-notification .notification .image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'		=> 'before',
				]
			);

			$this->add_responsive_control(
				'img_margin',
				[
					'label' 		=> __( 'Margin', 'woolementor' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em' ],
					'selectors' 	=> [
						'{{WRAPPER}} .wl-sales-notification .notification .image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'		=> 'after',
				]
			);

			$this->end_controls_section(); 

			/**
			 * Notification content area		 
			 */
			$this->start_controls_section(
				'content_style',
				[
					'label' => __( 'Content', 'woolementor' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

	        $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> '_typography',
					'label' 	=> __( 'Typography', 'woolementor' ),
					'scheme' 	=> Typography::TYPOGRAPHY_3,
					'selector' 	=> '{{WRAPPER}} .wl-sales-notification .notification .item_details',
				]
			);

			 $this->add_group_control(
	            Group_Control_Gradient_Text::get_type(),
	            [
	                'name' => 'pricing_table_header_color',
	                'selector' => '{{WRAPPER}} .wl-sales-notification .notification .item_details',
	            ]
	        );

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'content_border',
					'label' => __( 'Border', 'woolementor' ),
					'selector' => '{{WRAPPER}} .wl-sales-notification .notification .item_details',
				]
			);

			$this->add_responsive_control(
				'content_border_radius',
				[
					'label' 		=> __( 'Border Radius', 'woolementor' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em' ],
					'selectors' 	=> [
						'{{WRAPPER}} .wl-sales-notification .notification .item_details' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'content_padding',
				[
					'label' 		=> __( 'Padding', 'woolementor' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em' ],
					'selectors' 	=> [
						'{{WRAPPER}} .wl-sales-notification .notification .item_details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'		=> 'before',
				]
			);

			$this->add_responsive_control(
				'content_margin',
				[
					'label' 		=> __( 'Margin', 'woolementor' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em' ],
					'selectors' 	=> [
						'{{WRAPPER}} .wl-sales-notification .notification .item_details' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'		=> 'after',
				]
			);

			$this->end_controls_section(); 
		}

	public function time_elapsed_string($datetime, $full = false) {
	    $now = new \DateTime;
	    $ago = new \DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) : 'few seconds';
	}

	public function woolementor_get_orders( $limit, $status ){
		if( !function_exists( 'WC' ) ) return false;

		$query = new \WC_Order_Query( array(
		    'limit' => $limit,
		    'order' => 'DESC',
		    'status' => $status,
		    'return' => 'ids',
		) );

		$orders = $query->get_orders();

		if ( count( $orders ) > 0 ) {
			return $orders;
		}

		return false;
	}

	protected function render() {
        if( !current_user_can( 'edit_pages' ) ) return;

        echo woolementor_notice( sprintf( __( 'This beautiful widget, <strong>%s</strong> is a premium widget. Please upgrade to <strong>%s</strong> or activate your license if you already have upgraded!' ), $this->get_title(), '<a href="https://woolementor.com" target="_blank">Woolementor Pro</a>' ) );

        if( woolementor_is_edit_mode() ){
        	_e( 'The actual sales notification shows at the bottom left/right of this page!', 'woolementor' );
        }

		$settings = $this->get_settings_for_display();
        extract( $settings );

        $notifications = [
        	[
				'client_name' 		=> __( 'Someone', 'woolementor' ),
				'client_address' 	=> __( 'somewhere else', 'woolementor' ),
				'product_name' 		=> __( 'something', 'woolementor' ),
				'product_image' 	=> [ 'url' => plugins_url( 'assets/img/icon-128.png', WOOLEMENTOR ) ],
				'sell_time' 		=> __( 'Some time', 'woolementor' )
			],
        	[
				'client_name' 		=> __( 'Someone else', 'woolementor' ),
				'client_address' 	=> __( 'somewhere', 'woolementor' ),
				'product_name' 		=> __( 'anything', 'woolementor' ),
				'product_image' 	=> [ 'url' => plugins_url( 'assets/img/icon-128.png', WOOLEMENTOR ) ],
				'sell_time' 		=> __( 'Long time', 'woolementor' )
			],
        ];
        ?>
        <div class="wl-sales-notification left">

        	<?php do_action( 'woolementor_product_cat_start' ); ?>

        	<div class="notifications-wrapper">
        		<div class="notifications">
				<?php 
				foreach ( $notifications as $key => $notification ) : ?>
					<div class="notification notific-<?php echo $key; ?>">
						<div class="notific-inner">
							<div class="image">
								<img src='<?php echo $notification["product_image"]["url"]; ?>' />
							</div>
							<div class="item_details">
								<p><strong><?php echo $notification['client_name']; ?></strong> <?php _e( 'from', 'woolementor' ); ?> 
									<strong><?php echo $notification['client_address']; ?></strong></p>
								<p><?php _e( 'Purchased ', 'woolementor' ); ?> <strong><?php echo $notification['product_name']; ?></strong></p>
								<p><?php echo $notification['sell_time']; ?> <?php _e( 'ago', 'woolementor' ); ?></p>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
        		</div>
        	</div>
        	
        	<?php 
        	/**
			 * Load Script
			 */
			$this->render_script();

        	do_action( 'woolementor_product_cat_end' ); ?>

        </div>
        <?php
    }

    protected function render_script() {
    	$settings = $this->get_settings_for_display();
        extract( $settings );
    	?>
    	<script type="text/javascript">
    		jQuery(function($){
    			var duration = <?php echo $notification_duration['size']; ?>;
    			var delay = <?php echo $notification_delay['size']; ?>;
    			InitialFlip();
    			function InitialFlip() {
    			    setTimeout(SecondFlip, duration);
    			}
    			function SecondFlip() {
    				let total = <?php echo count($notifications); ?>;
    				let rand = Math.floor(Math.random() * total);
    			    $(".notification").hide();
    			    setTimeout(function() {
    			        $(".notific-"+rand).toggle();
    			        InitialFlip();
    			    }, delay);
    			}
    		})
    	</script>
    	<?php
    }
}

