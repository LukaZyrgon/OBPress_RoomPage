<?php

add_action('wp_ajax_get_data_for_room', 'get_data_for_room');
add_action('wp_ajax_nopriv_get_data_for_room', 'get_data_for_room');






function get_data_for_room() {


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

    require_once(WP_PLUGIN_DIR . '/OBPress_RoomPage/widget/assets/templates/template-rooms.php'); 
    
    die();
}