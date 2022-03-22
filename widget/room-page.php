<?php

class RoomPage extends \Elementor\Widget_Base
{

	public function __construct($data = [], $args = null) {



		parent::__construct($data, $args);
		
		// wp_register_script( 'room-page_js',  plugins_url( '/OBPress_RoomPage/widget/assets/js/room-page.js'), [ 'elementor-frontend' ], '1.0.0', true );

		// wp_register_script( 'searchbar_room_js',  plugins_url( '/OBPress_RoomPage/widget/assets/js/searchbar.js'), [], '1.0.0', true );

        // wp_register_script( 'room_bootstrap_js',  'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js', [], '1.0.0', true );

		// wp_register_script( 'basket_js',  plugins_url( '/OBPress_RoomPage/widget/assets/js/basket.js'), [], '1.0.0', true );

		// wp_register_style( 'room-page_css', plugins_url( '/OBPress_RoomPage/widget/assets/css/room-page.css') );  

        // wp_register_style( 'room_bootstrap_css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
        
        






		wp_register_script( 'moment_plugin_min_js', plugins_url( '/OBPress_RoomPage/widget/assets/js/vendor/moment.min.js'));

		wp_register_script( 'moment_plugin_tz_js', plugins_url( '/OBPress_RoomPage/widget/assets/js/vendor/moment.tz.js'));

        wp_register_script( 'room_bootstrap_js',  'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js', [], '1.0.0', true );

		wp_register_script( 'room-page_js',  plugins_url( '/OBPress_RoomPage/widget/assets/js/room-page.js'), [ 'elementor-frontend' ], '1.0.0', true );

		wp_register_script( 'searchbar_room_js',  plugins_url( '/OBPress_RoomPage/widget/assets/js/searchbar.js'), [], '1.0.0', true );

		wp_register_script( 'zcalendar_room_js',  plugins_url( '/OBPress_RoomPage/widget/assets/js/zcalendar.js'), [], '1.0.0', true ); 

		wp_register_script( 'basket_js',  plugins_url( '/OBPress_RoomPage/widget/assets/js/basket.js'), [], '1.0.0', true );

        wp_register_style( 'room_bootstrap_css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
		wp_register_style( 'room-page_css', plugins_url( '/OBPress_RoomPage/widget/assets/css/room-page.css'));  
		wp_register_style( 'zcalendar_special_css', plugins_url( '/OBPress_RoomPage/widget/assets/css/zcalendar.css') );
		wp_register_style( 'searchbar_special_css', plugins_url( '/OBPress_RoomPage/widget/assets/css/searchbar.css') );



        
        

		wp_localize_script('room-page_js', 'roomAjax', array(
			'ajaxurl' => admin_url('admin-ajax.php')
		));


	}

	public function get_script_depends()
	{
		return [ 'moment_plugin_min_js', 'moment_plugin_tz_js', 'room_bootstrap_js', 'room-page_js', 'basket_js' , 'zcalendar_room_js' , 'searchbar_room_js' ];
	}

	public function get_style_depends()
	{
		return ['room_bootstrap_css', 'room-page_css', 'zcalendar_special_css', 'searchbar_special_css'];
	}
	
	public function get_name()
	{
		return 'RoomPage';
	}

	public function get_title()
	{
		return __('Room Page', 'OBPress_RoomPage');
	}

	public function get_icon()
	{
		return 'fa fa-calendar';
	}

	public function get_categories()
	{
		return ['OBPress'];
	}
	
	protected function _register_controls()
	{
		$this->start_controls_section(
			'main_style_section',
			[
				'label' => __('Room Main Style', 'OBPress_RoomPage'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'room_image_margin',
			[
				'label' => __( 'Image Margin', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '28',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .single-room-img-holder' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'room_partial_payment_padding',
			[
				'label' => __( 'Payment Padding', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '11',
					'right' => '10.85',
					'bottom' => '10',
					'left' => '12',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .MaxPartialPaymentParcel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'room_partial_payment_color',
			[
				'label' => __('Partial Payment Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-room .MaxPartialPaymentParcel' => 'color: {{room_partial_payment_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'room_partial_payment_typography',
				'label' => __('Partial Payment Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .MaxPartialPaymentParcel',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '16',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '19',
						],
					],
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'room_partial_payment_typography_value',
				'label' => __('Partial Payment Value Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .MaxPartialPaymentParcel span',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '16',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '19',
						],
					],
				],
			]
		);

		$this->add_control(
			'room_partial_payment_bg_color',
			[
				'label' => __('Partial Payment Background Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-room .MaxPartialPaymentParcel' => 'background-color: {{room_partial_payment_bg_color}}'
				],
			]
		);

		$this->add_control(
			'room_partial_room_name_padding',
			[
				'label' => __( 'Room Name Padding', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '18.75',
					'right' => '35',
					'bottom' => '22.76',
					'left' => '35',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .single-room-name-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'room_partial_room_name_bg_color',
			[
				'label' => __('Room Name Background Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-room .single-room-name-holder' => 'background-color: {{room_partial_room_name_bg_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => esc_html__( 'Room Name Box Shadow', 'OBPress_RoomPage' ),
				'selector' => '{{WRAPPER}} .single-room .single-room-name-holder',
				'fields_options' => [
					'box_shadow_type' => [ 
						'default' =>'yes' 
					],
					'box_shadow' => [
						'default' =>[
							'horizontal' => 0,
							'vertical' => 3,
							'blur' => 6,
							'color' => '#00000029'
						]
					]
				]
			]
		);

		$this->add_control(
			'room_hotel_name_color',
			[
				'label' => __('Hotel Name Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#2C2F33',
				'selectors' => [
					'.single-room .single-room-hotel-name' => 'color: {{room_hotel_name_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'hotel_name_typography',
				'label' => __('Hotel Name Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .single-room-hotel-name',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
				],
			]
		);

		$this->add_control(
			'room_name_color',
			[
				'label' => __('Room Name Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-room .single-room-name' => 'color: {{room_name_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'room_name_typography',
				'label' => __('Room Name Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .single-room-name',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '24',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '29',
						],
					],
				],
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'room_info_section',
			[
				'label' => __('Room Info Style', 'OBPress_RoomPage'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'room_info_padding',
			[
				'label' => __( 'Info Padding', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '22',
					'right' => '42',
					'bottom' => '25',
					'left' => '26',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .single-room-info-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'room_info_bg_color',
			[
				'label' => __('Info Background Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-room .single-room-info-holder' => 'background-color: {{room_info_bg_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'room_info_box_shadows',
				'label' => esc_html__( 'Info Box Shadow', 'OBPress_RoomPage' ),
				'selector' => '{{WRAPPER}} .single-room .single-room-info-holder',
				'fields_options' => [
					'box_shadow_type' => [ 
						'default' =>'yes' 
					],
					'box_shadow' => [
						'default' =>[
							'horizontal' => 0,
							'vertical' => 3,
							'blur' => 6,
							'color' => '#00000024'
						]
					]
				]
			]
		);

		$this->add_control(
			'room_message_text_color',
			[
				'label' => __('Room Message Text Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-room .single-room-included-msg' => 'color: {{room_message_text_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'room_message_typography',
				'label' => __('Room Message Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .single-room-included-msg',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
				],
			]
		);

		$this->add_control(
			'room_message_text_align',
			[
				'label' => __( 'Room Message Text Align', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => __( 'Left', 'OBPress_RoomPage' ),
					'center'  => __( 'Center', 'OBPress_RoomPage' ),
					'right'  => __( 'Right', 'OBPress_RoomPage' ),
				],
				'selectors' => [
					'.single-room .single-room-included-msg' => 'text-align: {{room_message_text_align}}'
				],
			]
		);

		$this->add_control(
			'room_message_margin',
			[
				'label' => __( 'Room Message Margin', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '22.91',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .single-room-included-msg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'room_included_message_margin',
			[
				'label' => __( 'Room Included Message Margin', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '44',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .single-room-included-holder' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'room_included_text_color',
			[
				'label' => __('Room Included Text Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-room .single-room-included' => 'color: {{room_included_text_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'room_included_typography',
				'label' => __('Room Included Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .single-room-included',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
				],
			]
		);

		$this->add_control(
			'room_included_text_margin',
			[
				'label' => __( 'Room Included Text Margin', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '40',
					'bottom' => '0',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .single-room-included' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'room_included_margin',
			[
				'label' => __( 'Room Included Margin', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '41.5',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .single-room-included-holder' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'room_categories_text_color',
			[
				'label' => __('Room Categories Text Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#9C9C9C',
				'selectors' => [
					'.single-room .single-room-info-categories-bar' => 'color: {{room_categories_text_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'room_categories_typography',
				'label' => __('Room Categories Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .single-room-info-categories-bar',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
				],
			]
		);

		$this->add_control(
			'room_included_categories_active_text_color',
			[
				'label' => __('Room Categories Active Text Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000000',
				'selectors' => [
					'.single-room .single-room-info-categories-bar.active-bar' => 'color: {{room_included_categories_active_text_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'room_included_active_typography',
				'label' => __('Room Categories Active Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .single-room-info-categories-bar.active-bar',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
				],
			]
		);

		$this->add_control(
			'room_included_categories_text_margin',
			[
				'label' => __( 'Room Included Categories Text Margin', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '40',
					'bottom' => '0',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .single-room-info-categories-bar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'room_included_categories_margin',
			[
				'label' => __( 'Room Included Categories Margin', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '41.5',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .single-room-info-categories-bars' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'room_description_text_color',
			[
				'label' => __('Room Description Text Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#2C2F33',
				'selectors' => [
					'.single-room .room-description-short' => 'color: {{room_description_text_color}}',
					'.single-room .room-description-long' => 'color: {{room_description_text_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'room_description_typography',
				'label' => __('Room Description Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .room-description-short, .single-room .room-description-long',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '20',
						],
					],
				],
			]
		);

		$this->add_control(
			'room_description_text_align',
			[
				'label' => __( 'Room Description Text Align', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => __( 'Left', 'OBPress_RoomPage' ),
					'center'  => __( 'Center', 'OBPress_RoomPage' ),
					'right'  => __( 'Right', 'OBPress_RoomPage' ),
				],
				'selectors' => [
					'.single-room .single-room-info-category-section' => 'text-align: {{room_description_text_align}}'
				],
			]
		);

		$this->add_control(
			'room_see_more_text_color',
			[
				'label' => __('Room See More Text Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#4B8CF4',
				'selectors' => [
					'.single-room .room-more-description' => 'color: {{room_see_more_text_color}}',
					'.single-room .room-less-description' => 'color: {{room_see_more_text_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'room_see_more_typography',
				'label' => __('Room Description Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .room-more-description, .single-room .room-less-description',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '12',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '17',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'searchbar_color_section',
			[
				'label' => __('Room Searchbar Style', 'OBPress_RoomPage'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'room_searchbar_margin',
			[
				'label' => __( 'Searchbar Margin', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '20',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .room-form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'room_searchbar_padding',
			[
				'label' => __( 'Searchbar Padding', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '30',
					'bottom' => '0',
					'left' => '30',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .ob-searchbar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}!important;',
				],
			]
		);

		$this->add_control(
			'room_searchbar_justify_content',
			[
				'label' => __( 'Searchbar Justify Content', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'space-between',
				'options' => [
					'space-between'  => __( 'Space Between', 'OBPress_RoomPage' ),
					'space-around'  => __( 'Space Around', 'OBPress_RoomPage' ),
					'space-evenly'  => __( 'Space Evenly', 'OBPress_RoomPage' ),
					'center' => __( 'Center', 'OBPress_RoomPage' ),
					'flex-end'  => __( 'Flex End', 'OBPress_RoomPage' ),
					'flex-start'  => __( 'Flex Start', 'OBPress_RoomPage' ),
				],
				'selectors' => [
					'.single-room .ob-searchbar' => 'justify-content: {{room_searchbar_justify_content}}'
				],
			]
		);

		$this->add_control(
			'room_searchbar_elements_padding',
			[
				'label' => __( 'Searchbar Elements Padding', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '20',
					'right' => '10',
					'bottom' => '20',
					'left' => '10',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .ob-searchbar-hotel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.single-room .ob-searchbar-calendar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.single-room .ob-searchbar-guests' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.single-room .ob-searchbar-promo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'room_searchbar_title_text_color',
			[
				'label' => __('Searchbar Title Text Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-room .ob-searchbar-hotel > p' => 'color: {{room_searchbar_title_text_color}}',
					'.single-room .ob-searchbar-calendar > p' => 'color: {{room_searchbar_title_text_color}}',
					'.single-room .ob-searchbar-guests > p' => 'color: {{room_searchbar_title_text_color}}',
					'.single-room .ob-searchbar-promo > p' => 'color: {{room_searchbar_title_text_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'room_searchbar_title_text_typography',
				'label' => __('Searchbar Title Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .ob-searchbar-hotel > p, .single-room .ob-searchbar-calendar > p, .single-room .ob-searchbar-guests > p, .single-room .ob-searchbar-promo > p',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '16',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '19',
						],
					],
				],
			]
		);

		$this->add_control(
			'room_searchbar_inputs_text_color',
			[
				'label' => __('Searchbar Inputs Text Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-room .ob-searchbar-guests input' => 'color: {{room_searchbar_inputs_text_color}}',
					'.single-room .ob-searchbar-calendar input' => 'color: {{room_searchbar_inputs_text_color}}',
					'.single-room .ob-searchbar-promo input::placeholder' => 'color: {{room_searchbar_inputs_text_color}}',
					'.single-room .ob-searchbar-hotel input::placeholder' => 'color: {{room_searchbar_inputs_text_color}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'room_searchbar_inputs_text_typography',
				'label' => __('Searchbar Inputs Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .ob-searchbar-calendar input, .single-room .ob-searchbar-guests input, .single-room .ob-searchbar-promo input, .single-room .ob-searchbar-hotel input',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
				],
			]
		);

		$this->add_control(
			'room_searchbar_button_padding',
			[
				'label' => __( 'Searchbar Button Padding', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '30',
					'right' => '10',
					'bottom' => '30',
					'left' => '10',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .ob-searchbar-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'room_searchbar_buutton_text_color',
			[
				'label' => __('Searchbar Button Text Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-room .ob-searchbar-submit' => 'color: {{room_searchbar_buutton_text_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'room_searchbar_buutton_text_typography',
				'label' => __('Searchbar Button Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .ob-searchbar-submit',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '800',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
				],
			]
		);

		$this->add_control(
			'room_searchbar_buutton_bg_color',
			[
				'label' => __('Searchbar Button Background Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-room .ob-searchbar-submit' => 'background-color: {{room_searchbar_buutton_bg_color}}'
				],
			]
		);

		$this->add_control(
			'room_searchbar_buutton_border_color',
			[
				'label' => __('Searchbar Button Border Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-room .ob-searchbar-submit' => 'border-color: {{room_searchbar_buutton_border_color}}'
				],
			]
		);

		$this->add_control(
			'room_searchbar_buutton_border_width',
			[
				'label' => __( 'Searchbar Button Border Width', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max' => 10,
						'step' => 0.1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-room .ob-searchbar-submit' => 'border-width: {{SIZE}}px',
				],
			]
		);
		
		$this->add_control(
			'room_searchbar_buutton_text_hover_color',
			[
				'label' => __('Searchbar Button Text Hover Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-room .ob-searchbar-submit:hover' => 'color: {{room_searchbar_buutton_text_hover_color}}'
				],
			]
		);

		$this->add_control(
			'room_searchbar_buutton_hover_bg_color',
			[
				'label' => __('Searchbar Button Background Hover Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-room .ob-searchbar-submit:hover' => 'background-color: {{room_searchbar_buutton_hover_bg_color}}'
				],
			]
		);

		$this->add_control(
			'room_searchbar_buutton_hover_border_color',
			[
				'label' => __('Searchbar Button Border Hover Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-room .ob-searchbar-submit:hover' => 'border-color: {{room_searchbar_buutton_hover_border_color}}'
				],
			]
		);

		$this->add_control(
			'room_searchbar_buutton_width',
			[
				'label' => __( 'Button Width', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 200,
						'step' => 1,
					],
				],
				'devices' => [ 'desktop', 'mobile' ],
				'desktop_default' => [
					'size' => 148,
				],
				'mobile_default' => [
					'size' => 100,
					'unit' => '%',
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-room .ob-searchbar-submit' => 'width: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'room_searchbar_buutton_height',
			[
				'label' => __( 'Button Height', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 60,
				],
				'range' => [
					'px' => [
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-room .ob-searchbar-submit' => 'height: {{SIZE}}px',
				],
			]
		);


		$this->add_control(
			'room_searchbar_buutton_transition',
			[
				'label' => __( 'Button Transition Duration', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-room .ob-searchbar-submit' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_section(); 

		$this->start_controls_section(
			'related_rooms_style_section',
			[
				'label' => __('Related Rooms Title Style', 'OBPress_RoomPage'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'relate_rooms_title_color',
			[
				'label' => __('Title Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#222222',
				'selectors' => [
					'.single-room .rooms-message-header' => 'color: {{relate_rooms_title_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'relate_rooms_title_typography',
				'label' => __('Title Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .rooms-message-header',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '32',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '39',
						],
					],
				],
			]
		);

		$this->add_control(
			'relate_rooms_title_margin',
			[
				'label' => __( 'Title Margin', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '69.85',
					'right' => '0',
					'bottom' => '43.77',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .rooms-message-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'relate_rooms_text_align_title',
			[
				'label' => __( 'Title Align', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'left'  => __( 'Left', 'OBPress_RoomPage' ),
					'center'  => __( 'Center', 'OBPress_RoomPage' ),
					'right'  => __( 'Right', 'OBPress_RoomPage' ),
				],
				'selectors' => [
					'.single-room .rooms-message-header' => 'text-align: {{relate_rooms_text_align_title}}'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'related_rooms_cards_section',
			[
				'label' => __('Related Cards Style', 'OBPress_RoomPage'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'releted_rooms_cards_width',
			[
				'label' => __( 'Cards Width', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min' => 40,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-room .roomrateinfo' => 'width: {{SIZE}}%',
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_bg_color',
			[
				'label' => __('Cards Backgroung Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-room .single-room-rate-info' => 'background-color: {{releted_rooms_cards_bg_color}}'
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_padding',
			[
				'label' => __( 'Cards Padding', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '54',
					'right' => '32',
					'bottom' => '31',
					'left' => '32',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .single-room-rate-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'releted_rooms_cards_room_name_color',
			[
				'label' => __('Room Name Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#222222',
				'selectors' => [
					'.single-room .single-room-rate-name' => 'color: {{releted_rooms_cards_room_name_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_rooms_cards_room_name_typography',
				'label' => __('Room Name Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .single-room-rate-name',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '24',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '24',
						],
					],
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_room_name_text_align',
			[
				'label' => __( 'Room Name Text Align', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => __( 'Left', 'OBPress_RoomPage' ),
					'center'  => __( 'Center', 'OBPress_RoomPage' ),
					'right'  => __( 'Right', 'OBPress_RoomPage' ),
				],
				'selectors' => [
					'.single-room .single-room-rate-name' => 'text-align: {{releted_rooms_cards_room_name_text_align}}'
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_room_name_margin',
			[
				'label' => __( 'Room Name Margin', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '20',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .single-room-rate-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_policy_name_color',
			[
				'label' => __('Policy Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#82B789',
				'selectors' => [
					'.single-room .cancellation_policy' => 'color: {{releted_rooms_cards_policy_name_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_rooms_cards_policy_name_typography',
				'label' => __('Policy Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .cancellation_policy',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '12',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '15',
						],
					],
					'font_style' => [
						'default' => 'italic'
					],
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_policy_name_text_align',
			[
				'label' => __( 'Policy Text Align', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => __( 'Left', 'OBPress_RoomPage' ),
					'center'  => __( 'Center', 'OBPress_RoomPage' ),
					'right'  => __( 'Right', 'OBPress_RoomPage' ),
				],
				'selectors' => [
					'.single-room .cancellation_policy' => 'text-align: {{releted_rooms_cards_policy_name_text_align}}'
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_policy_name_margin',
			[
				'label' => __( 'Policy Name Margin', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '15',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .cancellation_policy' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_included_name_color',
			[
				'label' => __('Included Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000000',
				'selectors' => [
					'.single-room .meals_included, .single-room .service_included' => 'color: {{releted_rooms_cards_included_name_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_rooms_cards_included_name_typography',
				'label' => __('Included Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .meals_included, .single-room .service_included',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '12',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '15',
						],
					],
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_policy_name_margin',
			[
				'label' => __( 'Included Margin', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '7',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .meals_included, .single-room .service_included' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_included_name_dot_color',
			[
				'label' => __('Included Dot Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000000',
				'selectors' => [
					'.single-room .dot' => 'color: {{releted_rooms_cards_included_name_dot_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_rooms_cards_included_name_dot_typography',
				'label' => __('Included Dot Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .dot',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '5',
						],
					],
					'font_weight' => [
						'default' => '400',
					]
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_policy_name_dot_margin',
			[
				'label' => __( 'Included Dot Margin', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '5',
					'bottom' => '0',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .dot' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_room_full_price_color',
			[
				'label' => __('Full Price Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#9C9C9C',
				'selectors' => [
					'.single-room .price-before' => 'color: {{releted_rooms_cards_room_full_price_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_rooms_cards_full_price_typography',
				'label' => __('Full Price Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .price-before',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '12',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '15',
						],
					],
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_full_price_margin',
			[
				'label' => __( 'Full Price Margin', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '5',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .price-before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_full_price_text_align',
			[
				'label' => __( 'Full Price Text Align', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => __( 'Left', 'OBPress_RoomPage' ),
					'center'  => __( 'Center', 'OBPress_RoomPage' ),
					'right'  => __( 'Right', 'OBPress_RoomPage' ),
				],
				'selectors' => [
					'.single-room .price-before' => 'text-align: {{releted_rooms_cards_full_price_text_align}}'
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_room_price_button_justify_content',
			[
				'label' => __( 'Price Button Horizontal Align', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'space-between',
				'options' => [
					'space-between'  => __( 'Space Between', 'OBPress_RoomPage' ),
					'space-around'  => __( 'Space Around', 'OBPress_RoomPage' ),
					'space-evenly'  => __( 'Space Evenly', 'OBPress_RoomPage' ),
					'center' => __( 'Center', 'OBPress_RoomPage' ),
					'flex-end'  => __( 'Flex End', 'OBPress_RoomPage' ),
					'flex-start'  => __( 'Flex Start', 'OBPress_RoomPage' ),
				],
				'selectors' => [
					'.single-room .single-room-price-and-button' => 'justify-content: {{releted_rooms_cards_room_price_button_justify_content}}'
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_room_price_button_align_items',
			[
				'label' => __( 'Price Button Vertical Align', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'flex-end',
				'options' => [
					'flex-end'  => __( 'Bottom', 'OBPress_RoomPage' ),
					'flex-start'  => __( 'Top', 'OBPress_RoomPage' ),
					'center'  => __( 'Center', 'OBPress_RoomPage' ),
				],
				'selectors' => [
					'.single-room .single-room-price-and-button' => 'align-items: {{releted_rooms_cards_room_price_button_align_items}}'
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_room_lowest_price_color',
			[
				'label' => __('Lowest Price Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#82B789',
				'selectors' => [
					'.single-room .price-after.best-price' => 'color: {{releted_rooms_cards_room_lowest_price_color}}'
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_room_price_color',
			[
				'label' => __('Price Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#BEAD8E',
				'selectors' => [
					'.single-room .price-after' => 'color: {{releted_rooms_cards_room_price_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_rooms_cards_price_typography',
				'label' => __('Price Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .price-after',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '25',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '25',
						],
					],
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_rooms_cards_price_symbol_decimal_typography',
				'label' => __('Price Symbol Decimal Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .price-after .currency_symbol_price, .single-room .price-after .decimal_value_price',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '20',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '25',
						],
					],
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_room_tax_color',
			[
				'label' => __('Tax Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#2C2F33',
				'selectors' => [
					'.single-room .single-tax-msg' => 'color: {{releted_rooms_cards_room_tax_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_rooms_cards_tax_typography',
				'label' => __('Tax Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .single-tax-msg',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '12',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '15',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'related_rooms_cards_buttons_section',
			[
				'label' => __('Related Cards Buttons Style', 'OBPress_RoomPage'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'releted_rooms_cards_book_btn_padding',
			[
				'label' => __( 'Book Button Padding', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '16',
					'right' => '17',
					'bottom' => '16',
					'left' => '16',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .room-btn-add' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_book_btn_bg_color',
			[
				'label' => __('Book Button Background Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-room .room-btn-add' => 'background-color: {{releted_rooms_cards_book_btn_bg_color}}'
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_book_btn_color',
			[
				'label' => __('Book Button Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-room .room-btn-add' => 'color: {{releted_rooms_cards_book_btn_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_rooms_cards_book_btn_typography',
				'label' => __('Book Button Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .room-btn-add',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '500',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
					'letter_spacing' => [
						'default' => [
							'unit' => 'px',
							'size' => '0.7',
						],
					],
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_book_btn_bg_hover_color',
			[
				'label' => __('Book Button Hover Background Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-room .room-btn-add:hover' => 'background-color: {{releted_rooms_cards_book_btn_bg_hover_color}}'
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_book_btn_hover_color',
			[
				'label' => __('Book Button Hover Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-room .room-btn-add:hover' => 'color: {{releted_rooms_cards_book_btn_hover_color}}'
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_book_btn_transition',
			[
				'label' => __( 'Button Transition Duration', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-room .room-btn-add' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_number_rooms_color',
			[
				'label' => __('Number Rooms Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-room .text-number-of-rooms' => 'color: {{releted_rooms_cards_number_rooms_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_rooms_cards_number_rooms_typography',
				'label' => __('Number Rooms Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .text-number-of-rooms',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '500',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
					'letter_spacing' => [
						'default' => [
							'unit' => 'px',
							'size' => '0.7',
						],
					],
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_number_rooms_padding',
			[
				'label' => __( 'Number Rooms Padding', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '5',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .text-number-of-rooms' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_btn_minus_plus_justify_content',
			[
				'label' => __( 'Add Remove Buttons Justify Content', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'flex-start',
				'options' => [
					'flex-start'  => __( 'Flex Start', 'OBPress_RoomPage' ),
					'center' => __( 'Center', 'OBPress_RoomPage' ),
					'flex-end'  => __( 'Flex End', 'OBPress_RoomPage' ),
				],
				'selectors' => [
					'.single-room .obpress-hotel-results-button-bottom' => 'justify-content: {{releted_rooms_cards_btn_minus_plus_justify_content}}'
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_btn_minus_plus_bg_color',
			[
				'label' => __('Add Remove Buttons Background Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-room .room-btn-minus, .single-room .room-btn-plus' => 'background-color: {{releted_rooms_cards_btn_minus_plus_bg_color}}',
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_btn_minus_plus_hover_bg_color',
			[
				'label' => __('Add Remove Buttons Hover Background Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-room .room-btn-minus:hover, .single-room .room-btn-plus:hover' => 'background-color: {{releted_rooms_cards_btn_minus_plus_hover_bg_color}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'releted_rooms_cards_btn_minus_plus_border',
				'label' => __( 'Add Remove Buttons Border', 'OBPress_RoomPage' ),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1',
							'isLinked' => true,
						],
					],
					'color' => [
						'default' => '#000',
					],
				],
				'selector' => '.single-room .room-btn-minus, .single-room .room-btn-plus',
			]
		);

		$this->add_control(
			'releted_rooms_cards_btn_minus_plus_color',
			[
				'label' => __('Add Remove Buttons Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-room .room-btn-minus, .single-room .room-btn-plus' => 'color: {{releted_rooms_cards_btn_minus_plus_color}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'add_remove_buttons_typography',
				'label' => __('Add Remove Buttons Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .room-btn-minus, .single-room .room-btn-plus',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '24',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_btn_minus_plus_width',
			[
				'label' => __( 'Add Remove Buttons Width', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'max' => 50,
						'min' => 20,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-room .room-btn-minus, .single-room .room-btn-plus' => 'width: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_selected_rooms_value_width',
			[
				'label' => __( 'Selected Rooms Value Width', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'max' => 50,
						'min' => 20,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-room .room-btn-value' => 'width: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_btn_minus_plus_height',
			[
				'label' => __( 'Add Remove Buttons Height', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'max' => 50,
						'min' => 20,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-room .room-btn-minus, .single-room .room-btn-plus, .single-room .room-btn-value' => 'height: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_btn_minus_plus_transition',
			[
				'label' => __( 'Add Remove Buttons Transition Duration', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'min' => 0,
						'step' => 0.1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-room .room-btn-minus, .single-room .room-btn-plus' => 'transition: {{SIZE}}s',
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_selected_rooms_value_color',
			[
				'label' => __('Add Remove Buttons Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#2C2F33',
				'selectors' => [
					'.single-room .room-btn-value' => 'color: {{releted_rooms_cards_selected_rooms_value_color}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_rooms_cards_selected_rooms_value_typography',
				'label' => __('Add Remove Buttons Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .room-btn-value',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '16',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_restricted_color',
			[
				'label' => __('Restricted Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#FF0000',
				'selectors' => [
					'.single-room .restricted_text_holder' => 'color: {{releted_rooms_cards_restricted_color}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_rooms_cards_restricted_typography',
				'label' => __('Restricted Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .restricted_text_holder, .single-room .restricted_text_holder .restriction',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '12',
						],
					],
					'font_weight' => [
						'default' => '500',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
					
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_change_search_btn_padding',
			[
				'label' => __( 'Change Search Button Padding', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '10',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .restricted_modify_search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_change_search_btn_color',
			[
				'label' => __('Change Search Button Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#4B8CF4',
				'selectors' => [
					'.single-room .restricted_modify_search' => 'color: {{releted_rooms_cards_change_search_btn_color}}',
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_change_search_btn_hover_color',
			[
				'label' => __('Change Search Button Hover Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#4B8CF4',
				'selectors' => [
					'.single-room .restricted_modify_search:hover' => 'color: {{releted_rooms_cards_change_search_btn_hover_color}}',
				],
			]
		);

		$this->add_control(
			'releted_rooms_cards_change_search_btn_transition',
			[
				'label' => __( 'Change Search Button Transition Duration', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'min' => 0,
						'step' => 0.1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-room .restricted_modify_search' => 'transition: {{SIZE}}s',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_rooms_cards_restricted_typography',
				'label' => __('Change Search Button Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .restricted_modify_search',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '12',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '15',
						],
					],
					
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'related_rooms_error_section',
			[
				'label' => __('Error Section Style', 'OBPress_RoomPage'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'releted_rooms_error_margin',
			[
				'label' => __( 'Error Margin', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '25',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .error_message_holder' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'releted_rooms_error_padding',
			[
				'label' => __( 'Error Padding', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '20',
					'bottom' => '0',
					'left' => '20',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .error_message_holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_rooms_error_width',
			[
				'label' => __( 'Error Width', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'max' => 800,
						'min' => -350,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-room .error_message_holder' => 'width: calc(100% - {{SIZE}}px)',
				],
			]
		);

		$this->add_control(
			'releted_rooms_error_height',
			[
				'label' => __( 'Error Height', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 80,
				],
				'range' => [
					'px' => [
						'max' => 200,
						'min' => 40,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-room .error_message_holder' => 'height: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'releted_rooms_error_bg_color',
			[
				'label' => __('Error Background COlor', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#0C83D9',
				'selectors' => [
					'.single-room .error_message_holder' => 'background-color: {{releted_rooms_error_bg_color}}',
				],
			]
		);

		$this->add_control(
			'releted_rooms_error_border_radius',
			[
				'label' => __( 'Error Border Radius', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '4',
					'right' => '4',
					'bottom' => '4',
					'left' => '4',
					'isLinked' => true
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .error_message_holder' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_rooms_error_justify_content',
			[
				'label' => __( 'Error Horizontal Align', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'space-between',
				'options' => [
					'space-between'  => __( 'Space Between', 'OBPress_RoomPage' ),
					'space-around'  => __( 'Space Around', 'OBPress_RoomPage' ),
					'space-evenly'  => __( 'Space Evenly', 'OBPress_RoomPage' ),
					'center' => __( 'Center', 'OBPress_RoomPage' ),
					'flex-end'  => __( 'Flex End', 'OBPress_RoomPage' ),
					'flex-start'  => __( 'Flex Start', 'OBPress_RoomPage' ),
				],
				'selectors' => [
					'.single-room .error_message_holder' => 'justify-content: {{releted_rooms_error_justify_content}}'
				],
			]
		);

		$this->add_control(
			'releted_rooms_error_align_items',
			[
				'label' => __( 'Error Vertical Align', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'center'  => __( 'Center', 'OBPress_RoomPage' ),
					'flex-end'  => __( 'Bottom', 'OBPress_RoomPage' ),
					'flex-start'  => __( 'Top', 'OBPress_RoomPage' ),
				],
				'selectors' => [
					'.single-room .error_message_holder' => 'align-items: {{releted_rooms_error_align_items}}'
				],
			]
		);


		$this->add_control(
			'releted_rooms_error_icon_width',
			[
				'label' => __( 'Error Icon Width', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 24,
				],
				'range' => [
					'px' => [
						'max' => 150,
						'min' => 12,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-room .error_info_icon' => 'width: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'releted_rooms_error_icon_margin',
			[
				'label' => __( 'Error Icon Margin', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '15',
					'bottom' => '0',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .error_info_icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_rooms_error_message_color',
			[
				'label' => __('Error Message Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-room .error_message' => 'color: {{releted_rooms_error_message_color}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_rooms_error_message_typography',
				'label' => __('Error Message Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .error_message',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '21',
						],
					],
					
				],
			]
		);

		$this->add_control(
			'releted_rooms_error_button_bg_color',
			[
				'label' => __('Error Button Background Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-room .error_message_btn_calendar, .single-room .error_message_btn_occupancy' => 'background-color: {{releted_rooms_error_button_bg_color}}',
				],
			]
		);

		$this->add_control(
			'releted_rooms_error_button_hover_bg_color',
			[
				'label' => __('Error Button Hover Background Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-room .error_message_btn_calendar:hover, .single-room .error_message_btn_occupancy:hover' => 'background-color: {{releted_rooms_error_button_hover_bg_color}}',
				],
			]
		);

		$this->add_control(
			'releted_rooms_error_button_color',
			[
				'label' => __('Error Button Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#0C83D9',
				'selectors' => [
					'.single-room .error_message_btn_calendar, .single-room .error_message_btn_occupancy' => 'color: {{releted_rooms_error_button_color}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_rooms_error_button_typography',
				'label' => __('Error Button Typography', 'OBPress_RoomPage'),
				'selector' => '.single-room .error_message_btn_calendar, .single-room .error_message_btn_occupancy',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '21',
						],
					],
					
				],
			]
		);

		$this->add_control(
			'releted_rooms_error_button_hover_color',
			[
				'label' => __('Error Button Hover Color', 'OBPress_RoomPage'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#0C83D9',
				'selectors' => [
					'.single-room .error_message_btn_calendar:hover, .single-room .error_message_btn_occupancy:hover' => 'color: {{releted_rooms_error_button_hover_color}}',
				],
			]
		);

		$this->add_control(
			'releted_rooms_error_button_hover_transition',
			[
				'label' => __( 'Error Button Transition', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'min' => 0,
						'step' => 0.1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-room .error_message_btn_calendar, .single-room .error_message_btn_occupancy' => 'transition: {{SIZE}}s',
				],
			]
		);

		$this->add_control(
			'releted_rooms_error_btn_padding',
			[
				'label' => __( 'Error Button Padding', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '9',
					'right' => '20',
					'bottom' => '9',
					'left' => '20',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-room .error_message_btn_calendar, .single-room .error_message_btn_occupancy' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_rooms_error_btn_width',
			[
				'label' => __( 'Error Button Width', 'OBPress_RoomPage' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 115,
				],
				'range' => [
					'px' => [
						'max' => 500,
						'min' => 50,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-room .error_message_btn_calendar, .single-room .error_message_btn_occupancy' => 'min-width: {{SIZE}}px',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render()
	{

		//NEW CODE
		ini_set("xdebug.var_display_max_children", '-1');
		ini_set("xdebug.var_display_max_data", '-1');
		ini_set("xdebug.var_display_max_depth", '-1');

		require_once(WP_CONTENT_DIR . '/plugins/obpress_plugin_manager/BeApi/BeApi.php');
		require_once(WP_PLUGIN_DIR . '/obpress_plugin_manager/class-lang-curr-functions.php');
		require_once(WP_PLUGIN_DIR . '/obpress_plugin_manager/class-analyze-avail.php');
		require_once(WP_PLUGIN_DIR . '/obpress_plugin_manager/class-analyze-descriptive-infos-response.php');

		new Lang_Curr_Functions();

		Lang_Curr_Functions::chainOrHotel($id);

		if(isset($_GET["room_id"]) && $_GET["room_id"] != null) {
			$room_id = $_GET["room_id"];
			$redirect = false;
            $redirect_route = null;
		}
		else {
			$room_id = null;
			$redirect = true;
            $redirect_route = home_url()."/rooms";
		}

		$settings_so = $this->get_settings_for_display();
		$chain = get_option('chain_id');

		$languages = Lang_Curr_Functions::getLanguagesArray();
		$language = Lang_Curr_Functions::getLanguage();
		$language_object = Lang_Curr_Functions::getLanguageObject();        
		$currencies = Lang_Curr_Functions::getCurrenciesArray();
		$currency = Lang_Curr_Functions::getCurrency();

		foreach ($currencies as $currency_from_api) {
			if ($currency_from_api->UID == $currency) {
				$currency_string = $currency_from_api->CurrencySymbol;
				break;
			}
		}


        //get check in and out times or set default ones
        Lang_Curr_Functions::getCheckTimes($_GET['CheckIn'], $_GET['CheckOut']);
        $CheckIn = Lang_Curr_Functions::getCheckIn();
        $CheckOut = Lang_Curr_Functions::getCheckOut();

        $hotels_in_chain = [];
        $hotels = BeApi::ApiCache('hotel_search_chain_'.$chain.'_'.$language.'_true', BeApi::$cache_time['hotel_search_chain'], function() use ($chain, $language){
            return BeApi::getHotelSearchForChain($chain, "true",$language);
        });

        foreach($hotels->PropertiesType->Properties as $Property) {
            $hotels_in_chain[$Property->HotelRef->HotelCode]["HotelCode"] = $Property->HotelRef->HotelCode;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["HotelName"] = $Property->HotelRef->HotelName;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["ChainName"] = $Property->HotelRef->ChainName;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["Country"] = $Property->Address->CountryCode;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["City"] = $Property->Address->CityCode;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["StateProvCode"] = $Property->Address->StateProvCode;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["AddressLine"] = $Property->Address->AddressLine;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["Latitude"] = $Property->Position->Latitude;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["Longitude"] = $Property->Position->Longitude;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["MaxPartialPaymentParcel"] = $Property->MaxPartialPaymentParcel;
        }

        $descriptive_infos = BeApi::ApiCache('descriptive_infos_'.$chain.'_'.$language, BeApi::$cache_time['descriptive_infos'], function() use($hotels_in_chain, $language){
			return BeApi::getHotelDescriptiveInfos($hotels_in_chain, $language);
		});
        $descriptive_infos = new AnalyzeDescriptiveInfosRes($descriptive_infos);

        foreach($descriptive_infos->get()->HotelDescriptiveContentsType->HotelDescriptiveContents as $HotelDescriptiveContent) {
			foreach($HotelDescriptiveContent->FacilityInfo->GuestRoomsType->GuestRooms as $GuestRoom) {
                if($GuestRoom->ID == $room_id) {
                    $property = $HotelDescriptiveContent->HotelRef->HotelCode;
                    $room = $GuestRoom;
                    break;
                }
			}
		}

        if(!isset($room)) {
			$room_id = null;
			$redirect = true;
            $redirect_route = home_url()."/rooms";
        }

        $hotel_search = BeApi::ApiCache('hotel_search_property_'.$property.'_'.$language.'_true', BeApi::$cache_time['hotel_search_property'], function() use ($property, $language) {
            return BeApi::getHotelSearchForProperty($property, "true", $language);
        });

        if($_GET['ad'] == null) {
        	$adults = 1;
        }
        else {
            $adults = $_GET['ad'];
        }

        if($_GET['ch'] == null) {
        	$children = 0;
        }
        else {
            $children = $_GET['ch'];
        }

		if($_GET['ag'] == null) {
        	$children_ages = 0;
        }
        else {
            $children_ages = $_GET['ag'];
        }

        if($_GET["CheckIn"] == null || $_GET['CheckOut'] == null) {
            $CheckInUrlParam = date('dmY');
            $CheckOutUrlParam = date("dmY", strtotime('tomorrow'));

			$_GET['CheckIn'] = $CheckInUrlParam;
			$_GET['CheckOut'] = $CheckOutUrlParam;
			$_GET['ad'] = $adults;
			$_GET['ch'] = $children;
			$_GET['ag'] = $children_ages;
        }

       
        $promocode = "";
        if($_GET['Code'] != null && $_GET['Code'] != '') {
            $promocode = $_GET['Code'];
        }

        $groupcode = "";
        if ($_GET['group_code'] != null && $_GET['group_code'] != '') {
            $groupcode = $_GET['group_code'];
        }

        if(isset($_GET["mobile"]) && $_GET["mobile"] != null && $_GET["mobile"] == true) {
            $mobile = "true";
        }
        else {
            $mobile = "false";
        }

        $data = BeApi::getChainData($chain, $CheckIn, $CheckOut, $adults, ($_GET['ch'] != null && $_GET["ch"] > 0) ? $_GET['ch'] : 0, $_GET['ag'], $property, "false", $currency, $language, $promocode, $groupcode, $mobile);
        $data = new AnalyzeAvailRes($data);

        $style = BeApi::ApiCache('style_'.$property.'_'.$currency.'_'.$language, BeApi::$cache_time['omnibees.style'], function () use ($property, $currency, $language) {
            return BeApi::getPropertyStyle($property, $currency, $language);
        });

        $plugin_directory_path = plugins_url( '', __FILE__ );
        $plugins_directory = plugins_url();


		require_once(WP_PLUGIN_DIR . '/OBPress_RoomPage/widget/assets/templates/template.php');

	}
}
