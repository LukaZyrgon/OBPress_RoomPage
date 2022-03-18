<?php

class RoomPage extends \Elementor\Widget_Base
{

	public function __construct($data = [], $args = null) {

		$rpom_page = true;

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
			'color_section',
			[
				'label' => __('Package Main Image Style', 'OBPress_RoomPage'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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


        if($_GET["CheckIn"] == null) {
            $redirect = true;
            $CheckInUrlParam = date('dmY');
            $CheckOutUrlParam = date("dmY", strtotime('tomorrow'));
            $host  = $_SERVER['HTTP_HOST'];
            $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $page = 'room';
            $params = $_SERVER['QUERY_STRING'];
            $params.= "&CheckIn=".$CheckInUrlParam."&CheckOut=".$CheckOutUrlParam;
            if(!isset($_GET["ad"])) {
                $params.= "&ad=".$adults;
            }
            if(!isset($_GET["ch"])) {
                $params.= "&ch=".$children;
            }
            wp_redirect("https://$host$uri/$page?$params");
            exit;
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
