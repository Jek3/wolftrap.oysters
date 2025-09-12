<?php
namespace codexpert\Woolementor;

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class Tabs_Beauty extends Widget_Base {

	public $id;

	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

	    $this->id = woolementor_get_widget_id( __CLASS__ );
	    $this->widget = woolementor_get_widget( $this->id );
	    
		// Are we in debug mode?
		$min = defined( 'WOOLEMENTOR_DEBUG' ) && WOOLEMENTOR_DEBUG ? '' : '.min';
		wp_enqueue_script("jquery-ui-tabs");

		wp_register_style( "woolementor-{$this->id}", plugins_url( "assets/css/style{$min}.css", __FILE__ ), [], '1.1' );
	}

	public function get_script_depends() {
		return [ "woolementor-{$this->id}", 'fancybox' ];
	}

	public function get_style_depends() {
		return [ "woolementor-{$this->id}", 'fancybox' ];
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
		 * Settings controls
		 */
		$this->start_controls_section(
			'_section_settings_tabs',
			[
				'label' => __( 'Tabs', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tab_name', [
				'label' 		=> __( 'Title', 'woolementor' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Tab Title' , 'woolementor' ),
				'label_block' 	=> true,
			]
		);

        $repeater->add_control(
			'tab_text_color',
			[
				'label' 		=> __( 'Text Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'separator'		=> 'before',
			]
		);

        $repeater->add_control(
			'tab_bg_color',
			[
				'label' 		=> __( 'Tab Color', 'woolementor' ),
				'type' 			=> Controls_Manager::COLOR,
				'separator'		=> 'after',
				// 'default'		=> null,
			]
		);

		$repeater->add_control(
			'tab_content', [
				'label' 		=> __( 'Content', 'woolementor' ),
				'type' 			=> Controls_Manager::WYSIWYG,
				'default' 		=> __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' , 'woolementor' ),
				'show_label' 	=> false,
			]
		);

		$this->add_control(
			'tabs_list',
			[
				'label' 		=> __( 'Tabs List', 'woolementor' ),
				'type' 			=> Controls_Manager::REPEATER,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'tab_name' 		=> __( 'Tab #1', 'woolementor' ),
						'tab_bg_color' 	=> '#E9345F',
						'tab_content' 	=> __( 'Item content of Tab #1. Click the edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'woolementor' ),
					],
					[
						'tab_name' 		=> __( 'Tab #2', 'woolementor' ),
						'tab_bg_color' 	=> '#4139AA',
						'tab_content' 	=> __( 'Item content of Tab #2. Click the edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'woolementor' ),
					],
				],
				'title_field' => '{{{ tab_name }}}',
			]
		);

		$this->end_controls_section();

		/**
		*Tab items controll
		*/
		$this->start_controls_section(
			'_section_tabs_style',
			[
				'label' => __( 'Tabs', 'woolementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'tabs_title_typography',
				'label' 	=> __( 'Title Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1, 
				'selector' 	=> '{{WRAPPER}} .wl-tab-beauty .wl-tb-content .wl-tb-title',
			]
		);

		$this->add_control(
		    'tabs_title_alignment',
		    [
		        'label'     => __( 'Title Alignment', 'woolementor' ),
		        'type'      => Controls_Manager::CHOOSE,
		        'options'   => [
		            'left'      => [
		                'title'     => __( 'Left', 'woolementor' ),
		                'icon'      => 'fa fa-align-left',
		            ],
		            'center'    => [
		                'title'     => __( 'Center', 'woolementor' ),
		                'icon'      => 'fa fa-align-center',
		            ],
		            'right'     => [
		                'title'     => __( 'Right', 'woolementor' ),
		                'icon'      => 'fa fa-align-right',
		            ],
		        ],
		        'default'   => 'left',
		        'toggle'    => true,
		        'selectors' => [
		            '{{WRAPPER}} .wl-tab-beauty .wl-tb-content .wl-tb-title' => 'text-align: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'tabs_content_typography',
				'label' 	=> __( 'Content Typography', 'woolementor' ),
				'scheme' 	=> Typography::TYPOGRAPHY_1, 
				'selector' 	=> '{{WRAPPER}} .wl-tab-beauty .wl-tb-content .wl-tb-description',
			]
		);

		$this->add_control(
			'panel_height',
			[
				'label' => __( 'Height', 'woolementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1500,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 300,
				],
				'selectors' => [
					'{{WRAPPER}} .wl-tab-beauty' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
        extract( $settings );
        $style = '';
        $tabs = count( $tabs_list );
        $section_id = $this->get_raw_data()['id'];
        ?>

        <div class="wl-tab-beauty">
        	<?php $tab_count = 0; foreach ( $tabs_list as $key => $tab ): 
        		$checked 	= '';
	        	$top 		= $tab_count * ( 100 / (int)$tabs );
	        	$tab_height = $top;
	        	if ( $tab_count == 0 ) {
	        		$checked = 'checked';
	        		$tab_height = ( 100 / (int)$tabs );
	        	}

	        	if( $tab['tab_bg_color'] == '' ) {
	        		$tab['tab_bg_color'] = '#' . str_pad( dechex( mt_rand( 0, 0xFFFFFF ) ), 6, '0', STR_PAD_LEFT );
	        	}

	        	$style .= "
	        		.wl .wl-tab-beauty .wl-tb-content.wl-tb-{$tab['_id']}-content{background-color:{$tab['tab_bg_color']} !important}
	        		.wl .wl-tab-beauty .wl-tb-radio.wl-tb-{$tab['_id']}-radio{
	        			outline-color:{$tab['tab_bg_color']} !important;
	        			top: {$top}%;
	        			height: {$tab_height}%;
	        		}
	        		.wl .wl-tab-beauty .wl-tb-content.wl-tb-{$tab['_id']}-content .wl-tb-title{color:{$tab['tab_text_color']}}
	        		.wl .wl-tab-beauty .wl-tb-content.wl-tb-{$tab['_id']}-content .wl-tb-description{color:{$tab['tab_text_color']}}
	        		";
        	?>

    		<input class="wl-tb-radio wl-tb-<?php echo $tab['_id']; ?>-radio" type="radio" name="wl_tabs_beauty_<?php echo $section_id; ?>" <?php echo $checked; ?>>
    		<div class="wl-tb-content wl-tb-<?php echo $tab['_id']; ?>-content">
    			<h4 class="wl-tb-title"><?php echo $tab['tab_name']; ?></h4>
    			<div class="wl-tb-description">
    				<?php echo wpautop( $tab['tab_content'] ); ?>
    			</div>
    		</div>
        	<?php $tab_count++; endforeach; ?>
        </div>

    	<style>
	    	<?php echo $style; ?>
	    </style>
		<?php
	}
}