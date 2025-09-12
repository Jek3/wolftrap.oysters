<?php
namespace codexpert\Woolementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

class Shop_Table extends Widget_Base {

    public $id;

    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );

        $this->id       = woolementor_get_widget_id( __CLASS__ );
        $this->widget   = woolementor_get_widget( $this->id );
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
         * Settings controls
         */
        $this->start_controls_section(
            '_section_settings',
            [
                'label'     => __( 'Columns', 'woolementor-pro' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'id_section',
            [
                'label'         => __( 'ID', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'id_text',
            [
                'label'         => __( 'Label', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'ID', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'label_block'   => true,           
            ]
        );

        $this->add_control(
            'id_visibility',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => [
                    'visible-md'    => __( 'Desktop', 'woolementor-pro' ),
                    'visible-sm'    => __( 'Tablet', 'woolementor-pro' ),
                    'visible-xs'    => __( 'Mobile', 'woolementor-pro' ),
                ],
                'default'       => [ 'visible-md', 'visible-sm', 'visible-xs' ],
                'label_block'   => true,
                'separator'     => 'after',
            ]
        );

        $this->add_control(
            'sale_ribbon_section',
            [
                'label'         => __( 'Sale Ribbon', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(

            'show_sale_ribbon',
            [
                'label'         => __( 'Show/Hide', 'woolementor-pro' ),
                'type'          => Controls_Manager::SWITCHER,
               'label_on'      => __( 'Show', 'woolementor-pro' ),
                'label_off'     => __( 'Hide', 'woolementor-pro' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->add_control(
            'sale_ribbon_text',
            [
                'label'         => __( 'Text', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'condition' => [
                   'show_sale_ribbon' => 'yes'
                ],
                'default'   => __( 'Sale', 'woolementor-pro' ),
            ]
        );

        $this->add_control(
            'image_section',
            [
                'label'         => __( 'Image', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before',
            ]
        );

        $this->add_control(
            'image_text',
            [
                'label'         => __( 'Label', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Image', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'image_visibility',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => [
                    'visible-md'    => __( 'Desktop', 'woolementor-pro' ),
                    'visible-sm'    => __( 'Tablet', 'woolementor-pro' ),
                    'visible-xs'    => __( 'Mobile', 'woolementor-pro' ),
                ],
                'default'       => [ 'visible-md', 'visible-sm', 'visible-xs' ],
                'label_block'   => true,
                'separator'     => 'after',
            ]
        );

        $this->add_control(
            'title_section',
            [
                'label'         => __( 'Title', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'title_text',
            [
                'label'         => __( 'Label', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Name', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'title_visibility',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => [
                    'visible-md'    => __( 'Desktop', 'woolementor-pro' ),
                    'visible-sm'    => __( 'Tablet', 'woolementor-pro' ),
                    'visible-xs'    => __( 'Mobile', 'woolementor-pro' ),
                ],
                'default'       => [ 'visible-md', 'visible-sm', 'visible-xs' ],
                'label_block'   => true,
                'separator'     => 'after',
            ]
        );

        $this->add_control(
            'category_section',
            [
                'label'         => __( 'Category', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'category_text',
            [
                'label'         => __( 'Label', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Category', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'category_visibility',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => [
                    'visible-md'    => __( 'Desktop', 'woolementor-pro' ),
                    'visible-sm'    => __( 'Tablet', 'woolementor-pro' ),
                    'visible-xs'    => __( 'Mobile', 'woolementor-pro' ),
                ],
                'default'       => [ 'visible-md', 'visible-sm', 'visible-xs' ],
                'label_block'   => true,
                'separator'     => 'after',
            ]
        );

        $this->add_control(
            'short_desc_section',
            [
                'label'         => __( 'Short Description', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'short_desc_text',
            [
                'label'         => __( 'Label', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Short Description', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'short_desc_visibility',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => [
                    'visible-md'    => __( 'Desktop', 'woolementor-pro' ),
                    'visible-sm'    => __( 'Tablet', 'woolementor-pro' ),
                    'visible-xs'    => __( 'Mobile', 'woolementor-pro' ),
                ],
                'default'       => [ 'visible-md', 'visible-sm', 'visible-xs' ],
                'label_block'   => true,
                'separator'     => 'after',
            ]
        );

        $this->add_control(
            'price_section',
            [
                'label'         => __( 'Price', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'price_text',
            [
                'label'         => __( 'Label', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Price', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'price_visibility',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => [
                    'visible-md'    => __( 'Desktop', 'woolementor-pro' ),
                    'visible-sm'    => __( 'Tablet', 'woolementor-pro' ),
                    'visible-xs'    => __( 'Mobile', 'woolementor-pro' ),
                ],
                'default'       => [ 'visible-md', 'visible-sm', 'visible-xs' ],
                'label_block'   => true,
                'separator'     => 'after',
            ]
        );

        $this->add_control(
            'action_section',
            [
                'label'         => __( 'Action', 'woolementor-pro' ),
                'type'          => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'action_text',
            [
                'label'         => __( 'Label', 'woolementor-pro' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Action', 'woolementor-pro' ),
                'placeholder'   => __( 'Type your title here', 'woolementor-pro' ),
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'action_visibility',
            [
                'label'         => __( 'Show on these devices', 'woolementor-pro' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'options'       => [
                    'visible-md'    => __( 'Desktop', 'woolementor-pro' ),
                    'visible-sm'    => __( 'Tablet', 'woolementor-pro' ),
                    'visible-xs'    => __( 'Mobile', 'woolementor-pro' ),
                ],
                'default'       => [ 'visible-md', 'visible-sm', 'visible-xs' ],
                'label_block'   => true,
                'separator'     => 'after',
            ]
        );

        $this->add_control(
            'multiselect_visibility',
            [
                'label'         => __( 'Multiple Product Selection', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'woolementor' ),
                'label_off'     => __( 'No', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => '',
                'separator'     => 'before'
            ]
        );

        $this->add_control(
            'multiselect_text',
            [
                'label'         => __( 'Heading', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Purchase', 'woolementor' ),
                'placeholder'   => __( 'Type your title here', 'woolementor' ),
                'condition' => [
                    'multiselect_visibility' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'multiselect_submit_text',
            [
                'label'         => __( 'Button Text', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => __( 'Add Selected To Cart', 'woolementor' ),
                'placeholder'   => __( 'Type your text here', 'woolementor' ),
                'condition' => [
                    'multiselect_visibility' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'table_header',
            [
                'label'     => __( 'Table Header', 'woolementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'top-header'        => __( 'Top Header', 'woolementor' ),
                    'top-btm-header'    => __( 'Top & Bottom Headers', 'woolementor' ),
                    'no-header'         => __( 'No Headers', 'woolementor' ),
                ],
                'separator'         => 'before',
                'default'           => 'top-header',
                'style_transfer'    => true,
            ]
        );       

        $this->end_controls_section();

        /**
         * Query controls
         */
        $this->start_controls_section(
            '_query_settings',
            [
                'label' => __( 'Query', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'custom_query',
            [
                'label'         => __( 'Custom Query', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'woolementor' ),
                'label_off'     => __( 'No', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'no',
            ]
        );

        $this->add_control(
            'number',
            [
                'label'     => __( 'Products per page', 'woolementor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 6,
            ]
        );

        $this->add_control(
            'order',
            [
                'label'         => __( 'Order', 'woolementor' ),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'ASC',
                'options'       => [
                    'ASC'       => __( 'ASC', 'woolementor' ),
                    'DESC'      => __( 'DESC', 'woolementor' ),
                ],
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'         => __( 'Order By', 'woolementor' ),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'ID',
                'options'       => woolementor_order_options(),
            ]
        );

        $this->start_controls_tabs(
            'custom_query_section_separator',
            [
                'separator' => 'before',
                'condition' => [
                    'custom_query' => 'yes'
                ],
            ]
        );

        $this->start_controls_tab(
            'custom_query_section_normal',
            [
                'label'     => __( 'Custom Query', 'woolementor' ),
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'     => __( 'Include Category', 'woolementor' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => woolementor_get_terms(),
                'multiple'  => true,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'exclude_categories',
            [
                'label'     => __( 'Exclude Categories', 'woolementor' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => woolementor_get_terms(),
                'multiple'  => true,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'include_products',
            [
                'label'         => __( 'Include Products', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => 'block',
                'description'   => __( 'Separate values with comma delimiter', 'woolementor' ),
            ]
        );

        $this->add_control(
            'exclude_products',
            [
                'label'         => __( 'Exclude Products', 'woolementor' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => 'block',
                'description'   => __( 'Separate values with comma delimiter', 'woolementor' ),
            ]
        );

        $this->add_control(
            'sale_products_show_hide',
            [
                'label'         => __( "'On Sale' Products Only", 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'woolementor' ),
                'label_off'     => __( 'No', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'no',
            ]
        );

        $this->add_control(
            'out_of_stock',
            [
                'label'         => __( "Hide Stock out products", 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'woolementor' ),
                'label_off'     => __( 'No', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => '',
            ]
        );

        $this->add_control(
            'offset',
            [
                'label'         => __( 'Offset', 'woolementor' ),
                'type'          => Controls_Manager::NUMBER,
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * Data table controll
         */
        $this->start_controls_section(
            'section_content_data_table',
            [
                'label'     => __( 'DataTables', 'woolementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'data_table_show_hide',
            [
                'label'         => __( 'Enable DataTables', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => '',
                'description'   => sprintf( __( 'Check this to enable <a href="%s" target="_blank">DataTables</a> jQuery library', 'woolementor' ), 'https://datatables.net/' ),
            ]
        );

        $this->end_controls_section();

        /**
         * Wishlist controls
         */
        $this->start_controls_section(
            'section_content_product_image',
            [
                'label'     => __( 'Product Image', 'woolementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'image_on_click',
            [
                'label'     => __( 'On Click', 'woolementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'none'          => __( 'None', 'woolementor' ),
                    'zoom'          => __( 'Zoom', 'woolementor' ),
                    'product_page'  => __( 'Product Page', 'woolementor' ),
                ],
                'default'   => 'none',
            ]
        );

        $this->end_controls_section();

        /**
         * Quantity controls
         */
        $this->start_controls_section(
            'section_content_qty',
            [
                'label'     => __( 'Quantity Input', 'woolementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'qty_show_hide',
            [
                'label'         => __( 'Show/Hide', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         * Wishlist controls
         */
        $this->start_controls_section(
            'section_content_wishlist',
            [
                'label'     => __( 'Wishlist', 'woolementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'wishlist_show_hide',
            [
                'label'         => __( 'Show/Hide', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         * Cart controls
         */
        $this->start_controls_section(
            'section_content_cart',
            [
                'label'     => __( 'Cart', 'woolementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'cart_show_hide',
            [
                'label'         => __( 'Show/Hide', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         * Pagination controls
         */
        $this->start_controls_section(
            'section_content_pagination',
            [
                'label'         => __( 'Pagination', 'woolementor' ),
                'tab'           => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pagination_show_hide',
            [
                'label'         => __( 'Show/Hide', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         * Table Header
         */
        $this->start_controls_section(
            'tbl_header',
            [
                'label' => __( 'Table Header', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tbl_header_alignment',
            [
                'label'     => __( 'Alignment', 'woolementor' ),
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
                'default'   => 'center',
                'toggle'    => true,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-main_table th' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label'     => __( 'Background Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-main_table th' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'th_text_color',
            [
                'label'     => __( 'Text Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-main_table th' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'label'     => __( 'Typography', 'woolementor' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '{{WRAPPER}} .wl-st-main_table th',
            ]
        );

        $this->end_controls_section();

        /**
         * Table Row
         */

        $this->start_controls_section(
            'section_row_design',
            [
                'label' => __( 'Table Row', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tbl_row_alignment',
            [
                'label'     => __( 'Alignment', 'woolementor' ),
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
                'default'   => 'center',
                'toggle'    => true,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-main_table td' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .wl-st-info-icons' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'short_tbl_row_typography',
                'label'     => __( 'Typography', 'woolementor' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '{{WRAPPER}} .wl-st-main_table .wl-st-td,
                                {{WRAPPER}} .wl-st-main_table .wl-st-td a',
            ]
        ); 


        $this->add_control(
            'short_row_color_odd',
            [
                'label'     => __( 'Odd Row Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-main_table tr:nth-child(odd) td' => 'background-color: {{VALUE}}',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'short_row_text_color_odd',
            [
                'label'     => __( 'Odd Row Text Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-main_table tr:nth-child(odd) .wl-st-td,
                     {{WRAPPER}} .wl-st-main_table tr:nth-child(odd) .wl-st-td a' => 'color: {{VALUE}}',
                     '{{WRAPPER}} .wl-st-main_table tr:nth-child(odd) .wl-st-td .amount' => 'color: {{VALUE}}',
                     '{{WRAPPER}} .wl-st-main_table tr:nth-child(odd) .wl-st-td del .amount' => 'color: {{VALUE}}',
                     '{{WRAPPER}} .wl-st-main_table tr:nth-child(odd) .wl-st-td ins .amount' => 'color: {{VALUE}}',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'short_row_color_even',
            [
                'label'     => __( 'Even Row Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-main_table tr:nth-child(even) td' => 'background-color: {{VALUE}}',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'short_row_text_color_even',
            [
                'label'     => __( 'Even Row Text Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-main_table tr:nth-child(even) .wl-st-td,
                     {{WRAPPER}} .wl-st-main_table tr:nth-child(even) .wl-st-td a' => 'color: {{VALUE}}',
                     '{{WRAPPER}} .wl-st-main_table tr:nth-child(even) .wl-st-td .amount' => 'color: {{VALUE}}',
                     '{{WRAPPER}} .wl-st-main_table tr:nth-child(even) .wl-st-td del .amount' => 'color: {{VALUE}}',
                     '{{WRAPPER}} .wl-st-main_table tr:nth-child(even) .wl-st-td ins .amount' => 'color: {{VALUE}}',
                ],
                'separator' => 'after',
            ]
        );

        $this->end_controls_section();

        /**
         * Table border
         */
        $this->start_controls_section(
            'section_tbl_border',
            [
                'label' => __( 'Table Border', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'table_border_type',
                'label'     => __( 'Border', 'woolementor' ),
                'selector'  => '{{WRAPPER}} .wl-st-main_table td, {{WRAPPER}} .wl-st-table-div .wl-st-main_table th',
            ]
        );

        $this->end_controls_section();

        /**
         * Sale Ribbon section Style
         */
        $this->start_controls_section(
            'style_section_sale_ribbon',
            [
                'label' => __( 'Sale Ribbon', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,             
                'condition' => [
                    'show_sale_ribbon' => 'yes'
                ],

            ]
        );

        $this->add_control(
            'sale_ribbon_color',
            [
                'label' => __( 'Text Color', 'woolementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-st-sale' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'sale_ribbon_typography',
                'label'     => __( 'Typography', 'woolementor' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '{{WRAPPER}} .wl-st-sale',
                'separator' => 'after',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'sale_ribbon_bg_color',
                'label' => __( 'Front Side', 'woolementor' ),
                'types' => [ 'classic', 'gradient'],
                'selector' => '{{WRAPPER}} .wl-st-sale',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'sale_border_type',
                'label'     => __( 'Border', 'woolementor' ),
                'selector'  => '{{WRAPPER}} .wl-st-sale',
            ]
        );

        $this->add_control(
            'sale_ribbon_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'separator'     => 'after',
                'selectors'     => [
                    '{{WRAPPER}} .wl-st-sale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'Sale_ribbon_width',
            [
                'label' => __( 'Width', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-st-sale' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'Sale_ribbon_height',
            [
                'label' => __( 'Height', 'woolementor' ),
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
                'selectors' => [
                    '{{WRAPPER}} .wl-st-sale' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'sale_ribbon_padding',
            [
                'label'         => __( 'Padding', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'separator'     => 'after',
                'selectors'     => [
                    '{{WRAPPER}} .wl-st-sale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'Sale_ribbon_rotation',
            [
                'label' => __( 'Rotation', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'deg' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 360,
                        'step' => 1,
                    ],                      
                ],
                'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .wl-st-sale' => 'transform: rotate({{SIZE}}deg);',
                ],
            ]
        );

        $this->add_control(
            'Sale_ribbon_x_position',
            [
                'label' => __( 'Position X', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -80,
                        'max' => 300,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-st-sale' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'Sale_ribbon_y_position',
            [
                'label' => __( 'Position Y', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -180,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-st-sale' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Product Price
         */
        $this->start_controls_section(
            'section_style_price',
            [
                'label' => __( 'Product Price', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sale_price_show_hide',
            [
                'label'         => __( 'Show Sale Price', 'woolementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'woolementor' ),
                'label_off'     => __( 'Hide', 'woolementor' ),
                'return_value'  => 'block',
                'default'       => 'none',
                'separator'     => 'before',
                'selectors'     => [
                    '{{WRAPPER}} .wl-st-main_table td del' => 'display: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Product Currency Symbol
         */
        $this->start_controls_section(
            'section_style_currency',
            [
                'label' => __( 'Currency Symbol', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'price_currency',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Product Image controls
         */
        $this->start_controls_section(
            'section_style_image',
            [
                'label' => __( 'Product Image', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'image_show' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image_thumbnail',
                'exclude'   => [ 'custom' ],
                'include'   => [],
                'default'   => 'large',
            ]
        );

        $this->end_controls_section();

        /**
         * Quantity Field
         */
        $this->start_controls_section(
            'section_style_qty',
            [
                'label' => __( 'Quantity Input', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'qty_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'qty_typography',
                'label'     => __( 'Typography', 'woolementor' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '{{WRAPPER}} .wl-st-info-icons .wl-st-qty',
            ]
        );

        $this->add_control(
            'qty_width',
            [
                'label' => __( 'Width', 'woolementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 300,
                        'step'  => 1,
                    ],
                    '%' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-st-info-icons .wl-st-qty' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'qty_color',
            [
                'label'     => __( 'Text Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-info-icons .wl-st-qty' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'qty_bg',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-info-icons .wl-st-qty' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'qty_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .wl-st-info-icons .wl-st-qty',
            ]
        );

        $this->add_responsive_control(
            'qty_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-st-info-icons .wl-st-qty' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'qty_padding',
            [
                'label'         => __( 'Padding', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'separator'     => 'before',
                'selectors'     => [
                    '{{WRAPPER}} .wl-st-info-icons .wl-st-qty' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'qty_margin',
            [
                'label'         => __( 'Margin', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-st-info-icons .wl-st-qty' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Wishlist Button
         */
        $this->start_controls_section(
            'section_style_wishlist',
            [
                'label' => __( 'Wishlist Button', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'wishlist_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon',
            [
                'label'         => __( 'Icon', 'woolementor' ),
                'type'          => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'       => [
                    'value'     => 'fa fa-heart',
                    'library'   => 'fa-solid',
                ],
                'recommended'   => [
                    'fa-regular' => [
                        'heart',
                    ],
                    'fa-solid'  => [
                        'heart',
                        'heart-broken',
                        'heartbeat',
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'wishlist_icon_size',
            [
                'label'     => __( 'Icon Size', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-fav i' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_area',
            [
                'label' => __( 'Area', 'woolementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 300,
                        'step'  => 0.5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 35,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-fav i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

         $this->add_control(
            'wishlist_icon_line_height',
            [
                'label' => __( 'Line Height', 'woolementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 300,
                        'step'  => 0.5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 35,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-fav i' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wishlist_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-st-product-fav i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'wishlist_normal_separator',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab(
            'wishlist_normal',
            [
                'label'     => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_control(
            'wishlist_icon_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-fav i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-fav i' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .wl-st-product-fav i',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'wishlist_hover',
            [
                'label'     => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_control(
            'wishlist_icon_color_hover',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-fav i:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-fav i:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border_hover',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .wl-st-product-fav i:hover',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'wishlist_active',
            [
                'label'     => __( 'Active', 'woolementor' ),
            ]
        );

        $this->add_control(
            'wishlist_icon_color_active',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-fav.button.ajax_add_to_wish.fav-item i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_icon_bg_active',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-fav.button.ajax_add_to_wish.fav-item i' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'wishlist_border_active',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .wl-st-product-fav.button.ajax_add_to_wish.fav-item i',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /**
         * Cart Button
         */
        $this->start_controls_section(
            'section_style_cart',
            [
                'label' => __( 'Cart Button', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'cart_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'cart_icon',
            [
                'label'         => __( 'Icon', 'woolementor' ),
                'type'          => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'       => [
                    'value'     => 'fa fa-shopping-cart',
                    'library'   => 'fa-solid',
                ],
                'recommended'   => [
                    'fa-regular' => [
                        'luggage-cart',
                        'opencart',
                    ],
                    'fa-solid'  => [
                        'shopping-cart',
                        'cart-arrow-down',
                        'cart-plus',
                        'luggage-cart',
                    ]
                ]
            ]
        );

        $this->add_responsive_control(
            'cart_icon_size',
            [
                'label'     => __( 'Icon Size', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-cart i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .wl-st-info-icons .added_to_cart.wc-forward::after' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_area',
            [
                'label' => __( 'Area', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 0.5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 35,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-cart i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wl-st-info-icons .added_to_cart.wc-forward::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_line_hight',
            [
                'label' => __( 'Line Height', 'woolementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 0.5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 35,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-cart i' => 'line-height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wl-st-info-icons .added_to_cart.wc-forward::after' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-st-product-cart i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .added_to_cart.wc-forward::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'cart_normal_separator',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab(
            'cart_normal',
            [
                'label'     => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_control(
            'cart_icon_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-cart i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-cart i' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .wl-st-product-cart i',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'cart_hover',
            [
                'label'     => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_control(
            'cart_icon_color_hover',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-cart i:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-cart i:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border_hover',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .wl-st-product-cart i:hover',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'cart_view_cart',
            [
                'label'     => __( 'View Cart', 'woolementor' ),
            ]
        );

        $this->add_control(
            'cart_icon_color_view_cart',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-cart .added_to_cart.wc-forward::after' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_bg_view_cart',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-cart .added_to_cart.wc-forward::after' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_icon_view_cart_top',
            [
                'label'     => __( 'Margin Top', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-cart .added_to_cart.wc-forward::after' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_icon_view_cart_left',
            [
                'label'     => __( 'Margin Left', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-st-product-cart .added_to_cart.wc-forward::after' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'cart_border_view_cart',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .wl-st-product-cart .added_to_cart.wc-forward::after',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * Multiselect cart Button
         */
        $this->start_controls_section(
            'section_style_miltiple_cart_btn',
            [
                'label' => __( 'Multiselect cart Button', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'multiselect_visibility' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'miltiple_cart_btn_alignment',
            [
                'label'     => __( 'Alignment', 'woolementor' ),
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
                'default'   => 'right',
                'toggle'    => true,
                'selectors' => [
                    '{{WRAPPER}} .multiselect-submit-div' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'miltiple_cart_btn_typography',
                'label'     => __( 'Typography', 'woolementor' ),
                'scheme'    => Typography::TYPOGRAPHY_1,
                'selector'  => '{{WRAPPER}} .multiselect-submit-div .multiselect-submit',
            ]
        );

        $this->add_responsive_control(
            'miltiple_cart_btn_margin',
            [
                'label'         => __( 'Margin', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .multiselect-submit-div' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'miltiple_cart_btn_padding',
            [
                'label'         => __( 'Padding', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .multiselect-submit-div .multiselect-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'miltiple_cart_btn_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .multiselect-submit-div .multiselect-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'miltiple_cart_btn_separator',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab(
            'miltiple_cart_btn_normal',
            [
                'label'     => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_control(
            'miltiple_cart_btn_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .multiselect-submit-div .multiselect-submit' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'miltiple_cart_btn_bg',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .multiselect-submit-div .multiselect-submit' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'miltiple_cart_btn_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .multiselect-submit-div .multiselect-submit',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'miltiple_cart_btn_hover',
            [
                'label'     => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_control(
            'miltiple_cart_btn_color_hover',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .multiselect-submit-div .multiselect-submit:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'miltiple_cart_btn_bg_hover',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .multiselect-submit-div .multiselect-submit:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'miltiple_cart_btn_border_hover',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .multiselect-submit-div .multiselect-submit:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Pagination Controll
         */
        $this->start_controls_section(
            'section_style_pagination',
            [
                'label' => __( 'Pagination', 'woolementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'pagination_show_hide' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'pagination_alignment',
            [
                'label'        => __( 'Alignment', 'woolementor' ),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
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
                'default'   => 'center',
                'toggle'    => true,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-pagination' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_left_icon',
            [
                'label'     => __( 'Left Icon', 'woolementor' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'     => 'fa fa-arrow-left',
                    'library'   => 'solid',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'pagination_right_icon',
            [
                'label'     => __( 'Right Icon', 'woolementor' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'     => 'fa fa-arrow-right',
                    'library'   => 'solid',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_icon_size',
            [
                'label'     => __( 'Font Size', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'size_units'=> [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .wl-st-pagination .page-numbers' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_item_padding',
            [
                'label'         => __( 'Padding', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-st-pagination .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'pagination_separator',
            [
                'separator' => 'before'
            ]
        );

        $this->start_controls_tab(
            'pagination_normal_item',
            [
                'label'     => __( 'Normal', 'woolementor' ),
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-pagination .page-numbers' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_icon_bg',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-pagination .page-numbers' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'pagination_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .wl-st-pagination .page-numbers',
            ]
        );

        $this->add_responsive_control(
            'pagination_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-st-pagination .page-numbers' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pagination_current_item',
            [
                'label'     => __( 'Active', 'woolementor' ),
            ]
        );

        $this->add_control(
            'pagination_current_item_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-pagination .page-numbers.current' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_current_item_bg',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-pagination .page-numbers.current' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'pagination_current_item_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .wl-st-pagination .page-numbers.current',
            ]
        );

        $this->add_responsive_control(
            'pagination_current_item_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-st-pagination .page-numbers.current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'pagination_hover',
            [
                'label'     => __( 'Hover', 'woolementor' ),
            ]
        );

        $this->add_control(
            'pagination_hover_item_color',
            [
                'label'     => __( 'Color', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-pagination .page-numbers:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_hover_item_bg',
            [
                'label'     => __( 'Background', 'woolementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wl-st-pagination .page-numbers:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'pagination_hover_item_border',
                'label'         => __( 'Border', 'woolementor' ),
                'selector'      => '{{WRAPPER}} .wl-st-pagination .page-numbers:hover',
            ]
        );

        $this->add_responsive_control(
            'pagination_hover_item_border_radius',
            [
                'label'         => __( 'Border Radius', 'woolementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .wl-st-pagination .page-numbers:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_hover_transition',
            [
                'label'     => __( 'Transition Duration', 'woolementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'max'   => 3,
                        'step'  => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wl-st-pagination .page-numbers:hover' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
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