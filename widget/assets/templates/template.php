<?php
	$elementor_edit_active = \Elementor\Plugin::$instance->editor->is_edit_mode();
	$CheckInFormated = str_replace(".","",$CheckIn);
	$CheckOutFormated = str_replace(".","",$CheckOut);

    $CheckInT = strtotime($CheckIn);
    $CheckOutT = strtotime($CheckOut);

    $nights =  ( $CheckOutT - $CheckInT ) / 86400 ;
    $amenity_categories = [];
?>

<?php if(!is_null($room_id)): ?>
	<div class="single-room" data-redirect="<?= $redirect ?>" data-redirect-url="<?= $redirect_route ?>" data-room-id="<?= $room_id ?>">

        <div class="see_more_room_photos" data-bs-toggle="modal" data-bs-target="#room-gallery-modal"> <?php _e('More', 'OBPress_RoomPage') ?> <?= count($room->MultimediaDescriptionsType->MultimediaDescriptions[1]->ImageItemsType->ImageItems); ?> <?php _e('photos', 'OBPress_RoomPage') ?></div>

        <div class="modal room-gallery-modal fade" id="room-gallery-modal" tabindex="-1" aria-hidden="true" data-backdrop="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="obpress-room-gallery-holder">
                        <?php foreach ($descriptive_infos->getImagesForRoom($room_id) as $image) : ?>
                            <div class="obpress-room-gallery-image-holder">
                                <img src="<?= $image ?>" alt="">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="single-room-img-holder">
            <?php if(@$hotels_in_chain[$property]["MaxPartialPaymentParcel"] != null): ?>
                <div class="MaxPartialPaymentParcel" data-toggle="modal" data-target="#partial-modal-payment">
                <?php _e('Pay up to', 'OBPress_RoomPage') ?> <span><?= @$hotels_in_chain[$property]["MaxPartialPaymentParcel"] ?>x</span>
                </div>
            <?php endif; ?>

            <div class="single-room-images">
                <?php if(isset($room->MultimediaDescriptionsType->MultimediaDescriptions[1]->ImageItemsType->ImageItems[0]->URL->Address)): ?>
                    <img class="single-room-img" src="<?= $room->MultimediaDescriptionsType->MultimediaDescriptions[1]->ImageItemsType->ImageItems[0]->URL->Address?>" onError="this.onerror=null;this.src='/img/placeholderNewWhite.svg';" alt="<?= $room->DescriptiveText; ?>" data-bs-toggle="modal" data-bs-target="#room-gallery-modal">
                <?php else: ?>
                    <img class="single-room-img" src="<?= $plugin_directory_path . '/assets/icons/placeholderNewWhite.svg' ?>" alt="promotion">
                <?php endif; ?>

                <div class="smaller-room-imgages">
                    <?php if(isset($room->MultimediaDescriptionsType->MultimediaDescriptions[1]->ImageItemsType->ImageItems[1]->URL->Address)): ?>
                        <img class="single-room-img smaller-room-img first" src="<?= $room->MultimediaDescriptionsType->MultimediaDescriptions[1]->ImageItemsType->ImageItems[1]->URL->Address?>" onError="this.onerror=null;this.src='/img/placeholderNewWhite.svg';" alt="<?= $room->DescriptiveText; ?>" data-bs-toggle="modal" data-bs-target="#room-gallery-modal">
                    <?php else: ?>
                        <img class="single-room-img smaller-room-img first" src="<?= $plugin_directory_path . '/assets/icons/placeholderNewWhite.svg' ?>" alt="promotion">
                    <?php endif; ?>

                    <?php if(isset($room->MultimediaDescriptionsType->MultimediaDescriptions[1]->ImageItemsType->ImageItems[2]->URL->Address)): ?>
                        <img class="single-room-img smaller-room-img second" src="<?= $room->MultimediaDescriptionsType->MultimediaDescriptions[1]->ImageItemsType->ImageItems[2]->URL->Address?>" onError="this.onerror=null;this.src='/img/placeholderNewWhite.svg';" alt="<?= $room->DescriptiveText; ?>" data-bs-toggle="modal" data-bs-target="#room-gallery-modal">
                    <?php else: ?>
                        <img class="single-room-img smaller-room-img second" src="<?= $plugin_directory_path . '/assets/icons/placeholderNewWhite.svg' ?>" alt="promotion">
                    <?php endif; ?>
                </div>
            </div>

            <div class="single-room-image-mobile">
                <?php if(@$hotels_in_chain[$property]["MaxPartialPaymentParcel"] != null): ?>
                    <div class="MaxPartialPaymentParcel">
                    <?php _e('Pay up to', 'OBPress_RoomPage') ?> <span><?= @$hotels_in_chain[$property]["MaxPartialPaymentParcel"] ?>x</span>
                    </div>
                <?php endif; ?>
                <?php if(isset($room->MultimediaDescriptionsType->MultimediaDescriptions[1]->ImageItemsType->ImageItems[0]->URL->Address)): ?>
                    <img class="single-room-img" src="<?= $room->MultimediaDescriptionsType->MultimediaDescriptions[1]->ImageItemsType->ImageItems[0]->URL->Address?>" alt="<?= $room->DescriptiveText; ?>">
                <?php else: ?>
                    <img class="single-room-img" src="<?= $plugin_directory_path . '/assets/icons/placeholderNewWhite.svg' ?>" alt="promotion">
                <?php endif; ?>
            </div>

            <div class="single-room-name-holder">
                <div class="single-room-hotel-name"><?= @$hotels_in_chain[$property]["HotelName"] ?></div>
                <div class="single-room-name"><?= $room->DescriptiveText ?></div>
            </div>

        </div>

        <div class="single-room-info-holder">

            <p class="single-room-included-msg"><?php _e('The superior apartment offers:', 'OBPress_RoomPage') ?></p>
            <div class="single-room-included-holder">
                <?php if(isset($descriptive_infos->getRoomsViewTypes()[$property][$room_id]) && isset($descriptive_infos->getRoomsViewTypes()[$property][$room_id][0]->URL)): ?>
                    <span class="single-room-included">
                        <img class="single-room-included-icon" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/".$descriptive_infos->getRoomsViewTypes()[$property][$room_id][0]->URL ?>"> 
                        <span class="single-room-included-icon-name">
                            <?php _e('View', 'OBPress_RoomPage') ?>:  <span><?= $descriptive_infos->getRoomsViewTypes()[$property][$room_id][0]->RoomAmenity ?></span>
                        </span>
                    </span>
                <?php endif; ?>

                <?php if(isset($room->MaxOccupancy)): ?>
                    <span class="single-room-included">
                        <img class="single-room-included-icon" src="<?= $plugin_directory_path."/assets/icons/ocup-max.svg" ?>"> 
                        <span class="single-room-included-icon-name">
                            <?php _e('Occupancy max', 'OBPress_RoomPage') ?>: <span><?= $room->MaxOccupancy ?> <?php _e('People', 'OBPress_RoomPage') ?></span>
                        </span>
                    </span>
                <?php endif; ?>
                
                <?php if($descriptive_infos->getRoomArea($property, $room_id, $language) != null): ?>
                    <span class="single-room-included">
                        <img class="single-room-included-icon" src="<?= $plugin_directory_path. "/assets/icons/area.svg" ?>">
                        <span class="single-room-included-icon-name">
                            <?php _e('Area', 'OBPress_RoomPage') ?>:<span><?= $descriptive_infos->getRoomArea($property, $room_id, $language) ?></span>
                        </span>
                    </span>
                <?php endif; ?>
            </div>

            <?php
                if(isset($room->AmenitiesType->RoomAmenities)) {
                    foreach($room->AmenitiesType->RoomAmenities as $RoomAmenity) {
                        $amenity_categories[$RoomAmenity->RoomAmenityCategory][] = $RoomAmenity;
                    }
                }
            ?>

            <div class="single-room-info-categories desktop">
                <div class="single-room-info-categories-bars">
                    <span class="single-room-info-categories-bar active-bar" data-category="room-description"><?php _e('Description', 'OBPress_RoomPage') ?></span>
                    <?php if(!empty($amenity_categories)): ?>
                        <?php foreach($amenity_categories as $key => $amenity_category): ?>
                            <span class="single-room-info-categories-bar" data-category="<?= $key ?>"><?= $key ?></span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="single-room-info-category-section active-section" data-category="room-description">
                    <span class="room-description-short">
                        <?= substr(nl2br($room->MultimediaDescriptionsType->MultimediaDescriptions[0]->TextItemsType->TextItems[0]->Description),0, 200) ?>
                        <?php if(strlen($room->MultimediaDescriptionsType->MultimediaDescriptions[0]->TextItemsType->TextItems[0]->Description) > 200): ?>
                            <span>...</span>
                        <?php endif; ?>
                    </span>
                    <?php if(strlen($room->MultimediaDescriptionsType->MultimediaDescriptions[0]->TextItemsType->TextItems[0]->Description) > 200): ?>
                        <span class="room-description-long"><?= nl2br($room->MultimediaDescriptionsType->MultimediaDescriptions[0]->TextItemsType->TextItems[0]->Description) ?></span>
                    
                        <span class="room-more-description"><?php _e('read more', 'OBPress_RoomPage') ?></span>
                        <span class="room-less-description"><?php _e('read less', 'OBPress_RoomPage') ?></span>
                    <?php endif; ?>
                </div>
                <?php if(!empty($amenity_categories)): ?>
                    <?php foreach($amenity_categories as $key => $amenity_category): ?>
                        <div class="single-room-info-category-section" data-category="<?= $key ?>">
                            <?php foreach($amenity_category as $amenity): ?>
                                <div><?= $amenity->RoomAmenity ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="single-room-info-amenities-holder">
                <p class="single-room-included-msg"><?php _e('Amenities', 'OBPress_RoomPage') ?></p>
                <div class="single-room-info-amenities">
                    <?php foreach($descriptive_infos->getAmenitiesByRoomV4($room_id) as $key=>$amenity) : ?>
                        <?php if($amenity->Image != null) : ?>
                            <div>
                                <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/amenities/<?= $amenity->Image; ?>" alt="">
                                <span><?= $amenity->RoomAmenity; ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="single-room-info-categories mobile">
                <div class="single-room-info-category-holder">
                    <div class="single-room-info-category-title"><?php _e('Description', 'OBPress_RoomPage') ?></div>
                    <div class="single-room-info-description-holder">
                        <?= nl2br($room->MultimediaDescriptionsType->MultimediaDescriptions[0]->TextItemsType->TextItems[0]->Description); ?>
                    </div>
                    <img class="single-room-info-description-arrow" src="<?= get_template_directory_uri() ?>/templates/assets/icons/arrow_down.svg" alt="">
                </div>
                <?php if(!empty($amenity_categories)): ?>
                    <?php foreach($amenity_categories as $key => $amenity_category): ?>
                        <div class="single-room-info-category-holder">
                            <div class="single-room-info-category-title"><?= $key; ?></div>
                            <div class="single-room-info-description-holder">
                                <div>
                                    <?php foreach($amenity_category as $amenity): ?>
                                        <div>
                                            <img class="" src="<?= get_template_directory_uri() ?>/templates/assets/icons/check_dark.svg" alt="">
                                            <?= $amenity->RoomAmenity ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <img class="single-room-info-description-arrow" src="<?= get_template_directory_uri() ?>/templates/assets/icons/arrow_down.svg" alt="">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <?php echo $hotelFolders ; ?>

        <form type="POST" action="" class="room-form">
            <div class="ob-searchbar obpress-hotel-searchbar-custom container" id="index" data-hotel-folders="<?php echo htmlspecialchars(json_encode($hotelFolders), ENT_QUOTES, 'UTF-8'); ?>">
                <div class="ob-searchbar-hotel">
                    <p>
                    <?php
                        printf(
                            _n(
                                'Hotel',
                                'Destination or Hotel',
                                $counter_for_hotel,
                                'OBPress_RoomPage'
                            ),
                            number_format_i18n( $counter_for_hotel )
                        );                
                    ?>
                    </p>

                    <input type="text" value="" readonly placeholder="<?php if ( $data->getHotels()[$property]['HotelName'] ) {
                            echo $data->getHotels()[$property]['HotelName'];
                            } else {
                            _e('All Hotels', 'OBPress_RoomPage');
                            }  ?>" id="hotels" class="<?php if (!empty(get_option('hotel_id'))) {
                                                    echo 'single-hotel';
                                                } ?>" spellcheck="false" autocomplete="off">



                    <input type="hidden" name="c" value="<?php echo get_option('chain_id') ?>">
                    <input type="hidden" name="q" id="hotel_code" value="<?php echo $data->getHotels()[$property]['HotelCode'] ?>">
                    <input type="hidden" name="currencyId" value="<?= (isset($_GET['currencyId'])) ? $_GET['currencyId'] : get_option('default_currency_id') ?>">
                    <input type="hidden" name="lang" value="<?= (isset($_GET['lang'])) ? $_GET['lang'] : get_option('default_language_id') ?>">
                    <input type="hidden" name="hotel_folder" id="hotel_folder">
                    <input type="hidden" name="NRooms" id="NRooms" value="<?php echo $_GET['NRooms'] ?>">
                    <div class="hotels_dropdown">
                        <div class="obpress-mobile-close-hotels-dropdown-holder">
                            <span><?php _e('Select destination or hotel', 'OBPress_RoomPage') ?></span>
                            <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/cross_medium.svg" alt="">
                        </div>
                        <div class="obpress-mobile-search-hotels-input-holder">
                            <input class="obpress-mobile-search-hotels-input" type="text" placeholder="<?php _e('Enter hotel name or city', 'OBPress_RoomPage') ?>" id="search-hotels-input">
                        </div>
                    <!--  <div class="hotels_all custom-bg custom-text" data-id="0"><?php _e('All Hotels', 'OBPress_RoomPage'); ?></div> -->
                        <div class="hotels_folder custom-bg custom-text" hidden></div>
                        <div class="hotels_hotel custom-bg custom-text" data-id="" hidden></div>
                    </div>

                </div>
                <div class="ob-searchbar-calendar">
                    <p><?php _e('Dates of stay', 'OBPress_RoomPage'); ?></p>
                    <input class="calendarToggle" type="text" id="calendar_dates" value="<?php echo $CheckInShow ?? date("d/m/Y") ?> - <?php echo $CheckOutShow ?? date("d/m/Y", strtotime("+1 day")) ?>"  readonly>
                    <div class="ob-mobile-searchbar-calendar-holder">
                        <div class="ob-mobile-searchbar-calendar">
                            <p><?php _e('Check-in', 'OBPress_RoomPage') ?></p>
                            <input class="calendarToggle" type="text" id="check_in_mobile" value="<?php echo $CheckInShowMobile ?? date("d M Y") ?>"  readonly>
                        </div>
                        <div class="ob-mobile-searchbar-calendar">
                            <p><?php _e('Check-out', 'OBPress_RoomPage') ?></p>
                            <input class="calendarToggle" type="text" id="check_out_mobile" value="<?php echo $CheckOutShowMobile ?? date("d M Y", strtotime("+1 day")) ?>"  readonly>
                        </div>
                    </div>
                    <input class="calendarToggle" type="hidden" id="date_from" name="CheckIn" value="<?php echo $CheckIn ?? date("dmY") ?>">
                    <input class="calendarToggle" type="hidden" id="date_to" name="CheckOut" value="<?php echo $CheckOut ?? date("dmy", strtotime("+1 day")) ?>">            
                </div>
                <div class="ob-searchbar-guests">
                    <p><?php _e('Rooms and guests', 'OBPress_RoomPage'); ?></p>
                    <input type="text" id="guests" data-room="<?php _e('Room', 'OBPress_RoomPage'); ?>" data-rooms="<?php _e('Rooms', 'OBPress_RoomPage'); ?>" data-guest="<?php _e('Guest', 'OBPress_RoomPage'); ?>" data-guests="<?php _e('Guests', 'OBPress_RoomPage'); ?>" data-remove-room="<?php _e('Remove room', 'OBPress_RoomPage'); ?>" readonly>
                    <input type="hidden" id="ad" name="ad" value="<?= get_option('calendar_adults') ?>">
                    <input type="hidden" id="ch" name="ch" value="">
                    <input type="hidden" id="ag" name="ag" value="">

                    <div id="occupancy_dropdown" class="position-absolute custom-bg custom-text" data-default-currency="<?= (isset($_GET['currencyId'])) ? $_GET['currencyId'] : get_option('default_currency_id') ?>">
                        <div class="add-room-holder">
                            <p class="add-room-title select-room-title custom-text"><?php _e('NUMBER OF ROOMS', 'OBPress_RoomPage') ?></p>
                            <div class="select-room-buttons">
                                <button class="select-button select-button-minus select-room-minus" type="button" disabled>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                    
                                </button>
                                <span class="select-value select-room-value">1</span>
                                <button class="select-button select-button-plus select-room-plus" type="button">

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    
                                </button>
                            </div>
                        </div>
                        <div class="select-room-holder">
                            <div class="select-room" data-room-counter="0">
                                <p class="select-room-title custom-text"><?php _e('Room', 'OBPress_RoomPage');?> <span class="select-room-counter">1</span></p>

                                <div class="remove-room-mobile"><?php _e('Remove room', 'OBPress_RoomPage') ?></div>

                                <div class="select-guests-holder">
                                    <div class="select-adults-holder">
                                        <div class="select-adults-title">
                                            <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/adults.svg" alt="">
                                            <?php _e('Adults', 'OBPress_RoomPage'); ?>
                                        </div>
                                        <div class="select-adults-buttons">
                                            <button class="select-button select-button-minus select-adult-minus" type="button" disabled>
                                                
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>

                                            </button>
                                            <span class="select-value select-adults-value">1</span>
                                            <button class="select-button select-button-plus select-adult-plus" type="button">

                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>

                                            </button>
                                        </div>
                                    </div>
                                    <div class="select-child-holder">
                                        <div class="select-child-title">
                                            <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/children.svg" alt="">
                                            <div>
                                                <span><?php _e('Children', 'OBPress_RoomPage') ?></span>
                                                <span class="select-child-title-max-age">
                                                    0 <?php 
                                                    _e('to the', 'OBPress_RoomPage') ; 
                                                    echo " " ; 
                                                    ?>
                                                    <span class='child-max-age'> <?php echo $childrenMaxAge ; ?> </span>
                                                </span> 
                                            </div>
                                        </div>
                                        <div class="select-child-buttons">
                                            <button class="select-button select-button-minus select-child-minus" type="button" disabled>
                                                
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>

                                            </button>
                                            <span class="select-value select-child-value">0</span>
                                            <button class="select-button select-button-plus select-child-plus" type="button">

                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                                
                                            </button>
                                        </div>
                                    </div>
                                    <div class="select-child-ages-holder">
                                        <div class="select-child-ages-clone">
                                            <p class="select-child-ages-title custom-text"><?php _e('Age', 'OBPress_RoomPage'); ?> <span class="select-child-ages-number"></span></p>

                                            <div class="age-picker"> 
                                                <span class="age-picker-value">0</span> 

                                                <div class="age-picker-options">
                                                    <?php for ($i = 0; $i < 18; $i++) : ?>
                                                        <div data-age="<?= $i; ?>"> <?= $i; ?> <?php _e('years old', 'OBPress_RoomPage') ?></div>
                                                    <?php endfor; ?>

                                                </div>

                                                <select class="select-child-ages-input-clone">
                                                        <?php for ($i = 0; $i < 18; $i++) : ?>
                                                            <option data-value="<?= $i; ?>" <?php if ($i == 0) { echo "selected";} ?>><?= $i; ?></option>
                                                        <?php endfor; ?>
                                                </select>

                                            </div>
                                            <div class="child-ages-input">
                                            </div>
                                            <p class="incorect-age custom-text"><?php _e('Incorrect Age', 'OBPress_RoomPage') ?></p>

                                        </div>
                                    </div>
                                </div>

                                <div class="add-room-mobile">+ <?php _e('Ddd another room', 'OBPress_RoomPage') ?></div>
                                
                            </div>
                        </div>

                        <button class="btn-ic custom-action-bg custom-action-border custom-action-text select-occupancy-apply" type="button">
                                <?php _e('Apply', 'OBPress_RoomPage') ?>

                                <span class="select-occupancy-apply-info">
                                        <span class="select-occupancy-apply-info-rooms" data-rooms="1">1</span>
                                        <span class="select-occupancy-apply-info-rooms-string"><?php _e('Room', 'OBPress_RoomPage') ?></span>
                                        ,
                                        <span class="select-occupancy-apply-info-guests" data-guests="<?= get_option('calendar_adults') ?>"><?= get_option('calendar_adults') ?></span>
                                        <span class="select-occupancy-apply-info-guests-string"><?php _e('Guest', 'OBPress_RoomPage') ?></span>
                                </span>
                        </button>

                    </div>
                </div>

                <div class="ob-searchbar-promo">
                    <p><?php _e('I have a code', 'OBPress_RoomPage'); ?></p>
                    <input type="text" id="promo_code" value="" placeholder="<?php _e('Choose type', 'OBPress_RoomPage') ?>" readonly>
                    <div class="material-check custom-checkbox-holde ob-mobile-i-have-a-code">
                        <div class="mdc-touch-target-wrapper">
                            <div class="mdc-checkbox mdc-checkbox--touch">
                                <input class="board_check mdc-checkbox__native-control checkbox-custom checkbox-custom ob-mobile-i-have-a-code-input" type="checkbox" name="1" id="i_have_a_code">
                                <div class="mdc-checkbox__background">
                                    <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                        <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                                    </svg>
                                    <div class="mdc-checkbox__mixedmark"></div>
                                </div>
                            </div>
                        </div>
                        <label class="form-check-label" for="i_have_a_code">
                            <span class="checkbox-custom-label"><?php _e('I HAVE A CODE', 'OBPress_RoomPage'); ?></span>
                        </label>
                    </div>
                    <div id="promo_code_dropdown" class="position-absolute custom-bg custom-text">
                        <div class="mb-3 mt-2">
                            <p class="input-title"><?php _e('GROUP CODE', 'OBPress_RoomPage') ?></p>
                            <div class="material-textfield">
                                <input type="text" id="group_code" name="group_code" placeholder="<?php _e('Enter your code', 'OBPress_RoomPage') ?>">
                                <span class="label-title"><?php _e('GROUP CODE', 'OBPress_RoomPage') ?></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <p class="input-title"><?php _e('PROMO CODE', 'OBPress_RoomPage'); ?></p>
                            <div class="material-textfield">
                                <input type="text" id="Code" name="Code" placeholder="<?php _e('Enter your code', 'OBPress_RoomPage') ?>">
                                <span class="label-title"><?php _e('PROMO CODE', 'OBPress_RoomPage'); ?></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <p class="input-title"><?php _e('LOYALTY CODE', 'OBPress_RoomPage') ?></p>
                            <div class="material-textfield">
                                <input type="text" id="loyalty_code" name="loyalty_code" placeholder="<?php _e('Enter your code', 'OBPress_RoomPage') ?>">
                                <span class="label-title"><?php _e('LOYALTY CODE', 'OBPress_RoomPage') ?></span>
                            </div>
                        </div>

                        <div class="text-right">
                            <button id="promo_code_apply" class="custom-action-bg custom-action-text custom-action-border btn-ic"><?php _e('Apply', 'OBPress_RoomPage'); ?></button>
                        </div>
                    </div>
                </div>
                
                <div class="ob-searchbar-button">
                    <button class="ob-searchbar-submit" type="button"><?php _e('Search', 'OBPress_RoomPage'); ?></button>
                </div> 

            </div>
            <div class="zcalendar-wrap">

                <div class="ob-zcalendar-top">
                    <div class="ob-zcalendar-title">
                        <?php _e('Select date of stay', 'OBPress_RoomPage') ?>
                        <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/cross_medium.svg" alt="">
                    </div>
                    <div class="ob-mobile-weekdays">
                        <div>
                            <span><?php _e('sun', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('mon', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('tue', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('wed', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('thu', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('fri', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('sat', 'OBPress_SpecialOffersPage') ?></span>
                        </div>
                    </div>
                </div>
                <div class="zcalendar-holder" id="calendar-holder">
                    <div class="zcalendar data-allow-unavail="<?= get_option('allow_unavail_dates') ?> data-allow-unavail="<?= get_option('allow_unavail_dates') ?>" data-promotional="<?php _e('Offers for you', 'OBPress_RoomPage'); ?>" data-promo="<?php _e('Special Offer', 'OBPress_RoomPage'); ?>" data-lang="{{$lang->Code}}"  data-night="<?php _e('Night', 'OBPress_RoomPage') ?>" data-nights="<?php _e('Nights', 'OBPress_RoomPage') ?>" data-price-for="<?php _e('*Price for', 'OBPress_RoomPage') ?>" data-adult="<?php _e('adult', 'OBPress_RoomPage') ?>" data-adults="<?php _e('adults', 'OBPress_RoomPage') ?>" data-restriction="<?php _e('Restricted Days', 'OBPress_RoomPage') ?>" data-notavailable="<?php _e('index_no_availability_v4', 'OBPress_RoomPage') ?>" data-closedonarrival="<?php _e('calendar_closed_on_arrival', 'OBPress_RoomPage') ?>"  data-closedondeparture="<?php _e('calendar_closed_on_departure', 'OBPress_RoomPage') ?>" data-minimum-string="<?php _e('system_min', 'OBPress_RoomPage') ?>" data-maximum-string="<?php _e('system_max', 'OBPress_RoomPage') ?>" ></div>
                </div>
                
                <div class="ob-zcalendar-bottom">
                    <div> <span class='mobile-accept-dates-from-to'>Seg, 14 Nov - Sex, 18 Nov</span> <span class="number_of_nights-mobile-span"> ( <span class="number_of_nights-mobile"> 4 <?php _e('NIghts', 'OBPress_RoomPage'); ?></span> )</span> </div>
                    <div id="mobile-accept-date"> <?php _e('Apply', 'OBPress_RoomPage') ?> </div>
                </div>
            </div>     

        </form>

        <?php
            $calendar_string = '';

            $AllRoomRates = [];
            $AllRoomRatesAvailableForSale = [];
			$AllRoomRatesLOS_Restricted = [];
            if($data->getRoomRatesByRoomAvailability($property, $room_id, ['AvailableForSale']) != null) {
                $AllRoomRatesAvailableForSale = $data->getRoomRatesByRoomAvailability($property, $room_id, ['AvailableForSale']);
            }
            if ($data->getRoomRatesByRoomAvailability($property, $room_id, ['LOS_Restricted']) !== null) {
                $AllRoomRatesLOS_Restricted = $data->getRoomRatesByRoomAvailability($property, $room_id, ['LOS_Restricted']);
            }
            $AllRoomRates = array_merge($AllRoomRatesAvailableForSale, $AllRoomRatesLOS_Restricted);

            $availableRooms =  count( $AllRoomRates );
        ?>

        <?php if($availableRooms > 0): ?>
            <p class="rooms-message-header"><?php _e('Related rooms', 'OBPress_RoomPage') ?></p>
        <?php endif; ?>



        <div class="obpress-room-rooms-basket"> 
            <div id="room-results" data-max-rooms="<?php if ( isset( $style->Result->MaxRooms) ) { echo $style->Result->MaxRooms; }?>">
                <?php require_once(WP_PLUGIN_DIR . '/OBPress_RoomPage/widget/assets/templates/template-rooms.php'); ?>
            </div>

            <div class="next-step-loader">
                <div class="gooey">
                    <span class="dot"></span>
                    <div class="dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>

            <!--  Get basket html -->
            <?php require_once( WP_PLUGIN_DIR . '/OBPress_RoomPage/widget/assets/templates/basket.php'); ?>
        </div>

	</div>
<?php elseif($elementor_edit_active == true): ?>
	<div class="single-room" data-redirect="<?= $redirect ?>" data-redirect-url="<?= $redirect_route ?>">

		<div class="single-room-img-holder">
            <div class="MaxPartialPaymentParcel" data-toggle="modal" data-target="#partial-modal-payment">
                Pay up to <span>10x</span>
            </div>


            <div class="single-room-images">
                    <img class="single-room-img" src="<?= $plugin_directory_path . '/assets/images/package_photo.png' ?>" onError="this.onerror=null;this.src='/img/placeholderNewWhite.svg';" alt="<?= $room->DescriptiveText; ?>" data-bs-toggle="modal" data-bs-target="#room-gallery-modal">

                <div class="smaller-room-imgages">
                    <img class="single-room-img smaller-room-img first" src="<?= $plugin_directory_path . '/assets/images/package_photo.png' ?>" onError="this.onerror=null;this.src='/img/placeholderNewWhite.svg';" alt="<?= $room->DescriptiveText; ?>" data-bs-toggle="modal" data-bs-target="#room-gallery-modal">
                    
                    <img class="single-room-img smaller-room-img second" src="<?= $plugin_directory_path . '/assets/images/package_photo.png' ?>" onError="this.onerror=null;this.src='/img/placeholderNewWhite.svg';" alt="<?= $room->DescriptiveText; ?>" data-bs-toggle="modal" data-bs-target="#room-gallery-modal">
                </div>
            </div>

            <div class="single-room-name-holder">
    	        <div class="single-room-hotel-name">Hilton Rio de Janeiro Copacabana</div>
                <div class="single-room-name">Spring Season</div>
            </div>

		</div>

		<div class="single-room-info-holder">

        	<p class="single-room-included-msg">Esse pacote especial oferece:</p>
        	<div class="single-room-included-holder">
                <span class="single-room-included">Free wifi all hotel</span>
                <span class="single-room-included">Bike Rental</span>
                <span class="single-room-included">Shopping nearby</span>
                <span class="single-room-included">Free wifi all hotel</span>
                <span class="single-room-included">Free Coffee</span>
                <span class="single-room-included">24 Hour reception</span>
                <span class="single-room-included">Great little-lunch</span>
            </div>




            <div class="single-room-info-categories">
            	<div class="single-room-info-categories-bars">
            		<span class="single-room-info-categories-bar active-bar" data-category="room-description">Descrição</span>
            		<span class="single-room-info-categories-bar" data-category="Serviços Gerais">Serviços Gerais</span>
            		<span class="single-room-info-categories-bar" data-category="Restaurantes e Bares">Restaurantes e Bares</span>
            		<span class="single-room-info-categories-bar" data-category="Bem-estar e Desporto">Bem-estar e Desporto</span>
            		<span class="single-room-info-categories-bar" data-category="Produtos de casa e banho">Produtos de casa e banho</span>
            		<span class="single-room-info-categories-bar" data-category="Atrações">Atrações</span>
            	</div>

            	<div class="single-room-info-category-section active-section" data-category="room-description">
            		<span class="room-description-short">
            			<?= nl2br("O Hilton Copacabana Rio De Janeiro, De 5 Estrelas, Está Idealmente Localizado Em Frente Às Águas Azuis Da Praia De Copacabana. Disponibiliza Um Spa Elegante E Uma Piscina No Último Piso, Ambos Com Vistas Mar Magníficas.

            			O Hilton Copacabana Rio De Janeiro Possui Quartos Luminosos E Sofisticados Com Ar Condicionado, Uma Televisão E Um Minibar. Todos Os Quartos Apresentam Um Estilo Elegante Com Mobiliário Em Madeira, Uma Decoração Contemporânea E Acolhedores Tons Naturais. A Maioria Dos Quartos Oferece Vistas Fantásticas Para O Oceano.") ?>
            			
            				<span>...</span>
            		</span>
                	<span class="room-description-long">
						<?= nl2br("O Hilton Copacabana Rio De Janeiro, De 5 Estrelas, Está Idealmente Localizado Em Frente Às Águas Azuis Da Praia De Copacabana. Disponibiliza Um Spa Elegante E Uma Piscina No Último Piso, Ambos Com Vistas Mar Magníficas.

            			O Hilton Copacabana Rio De Janeiro Possui Quartos Luminosos E Sofisticados Com Ar Condicionado, Uma Televisão E Um Minibar. Todos Os Quartos Apresentam Um Estilo Elegante Com Mobiliário Em Madeira, Uma Decoração Contemporânea E Acolhedores Tons Naturais. A Maioria Dos Quartos Oferece Vistas Fantásticas Para O Oceano.

            			O Hilton Copacabana Rio De Janeiro Possui Quartos Luminosos E Sofisticados Com Ar Condicionado, Uma Televisão E Um Minibar. Todos Os Quartos Apresentam Um Estilo Elegante Com Mobiliário Em Madeira, Uma Decoração Contemporânea E Acolhedores Tons Naturais. A Maioria Dos Quartos Oferece Vistas Fantásticas Para O Oceano.

            			O Hilton Copacabana Rio De Janeiro Possui Quartos Luminosos E Sofisticados Com Ar Condicionado, Uma Televisão E Um Minibar. Todos Os Quartos Apresentam Um Estilo Elegante Com Mobiliário Em Madeira, Uma Decoração Contemporânea E Acolhedores Tons Naturais. A Maioria Dos Quartos Oferece Vistas Fantásticas Para O Oceano.

            			O Hilton Copacabana Rio De Janeiro Possui Quartos Luminosos E Sofisticados Com Ar Condicionado, Uma Televisão E Um Minibar. Todos Os Quartos Apresentam Um Estilo Elegante Com Mobiliário Em Madeira, Uma Decoração Contemporânea E Acolhedores Tons Naturais. A Maioria Dos Quartos Oferece Vistas Fantásticas Para O Oceano.") ?>                		
                	</span>
        		
            		<span class="room-more-description">ler mais</span>
            		<span class="room-less-description">ler menos</span>
            	</div>
            	
    			<div class="single-room-info-category-section" data-category="Serviços Gerais">
    				<div>Lorem</div>
    				<div>ipsum</div>
    				<div>dolor</div>
    				<div>consectetur</div>
    			</div>
    			<div class="single-room-info-category-section" data-category="Restaurantes e Bares">
    				<div>Lorem</div>
    				<div>ipsum</div>
    				<div>dolor</div>
    				<div>consectetur</div>
    			</div>
    			<div class="single-room-info-category-section" data-category="Bem-estar e Desporto">
    				<div>Lorem</div>
    				<div>ipsum</div>
    				<div>dolor</div>
    				<div>consectetur</div>
    			</div>
    			<div class="single-room-info-category-section" data-category="Produtos de casa e banho">
    				<div>Lorem</div>
    				<div>ipsum</div>
    				<div>dolor</div>
    				<div>consectetur</div>
    			</div>
    			<div class="single-room-info-category-section" data-category="Atrações">
    				<div>Lorem</div>
    				<div>ipsum</div>
    				<div>dolor</div>
    				<div>consectetur</div>
    			</div>
            </div>
		</div>
        <form type="POST" action="" class="package-form">

            <div class="ob-searchbar obpress-hotel-searchbar-custom container" id="index" data-hotel-folders="<?php echo htmlspecialchars(json_encode($hotelFolders), ENT_QUOTES, 'UTF-8'); ?>">
                <div class="ob-searchbar-hotel">
                    <p>
                    <?php
                        printf(
                            _n(
                                'Hotel',
                                'Destination or Hotel',
                                $counter_for_hotel,
                                'OBPress_SpecialOffersPage'
                            ),
                            number_format_i18n( $counter_for_hotel )
                        );                
                    ?>
                    </p>
                    <input type="text" value="" readonly placeholder="<?php if ( $data->getHotels()[$property]['HotelName'] ) {
                            echo $data->getHotels()[$property]['HotelName'];
                            } else {
                            _e('All Hotels', 'OBPress_SpecialOffersPage');
                            }  ?>" id="hotels" class="<?php if (!empty(get_option('hotel_id'))) {
                                                    echo 'single-hotel';
                                                } ?>" spellcheck="false" autocomplete="off">

                    <input type="hidden" name="c" value="<?php echo get_option('chain_id') ?>">
                    <input type="hidden" name="q" id="hotel_code" value="<?php echo $data->getHotels()[$property]['HotelCode'] ?>">
                    <input type="hidden" name="currencyId" value="<?= (isset($_GET['currencyId'])) ? $_GET['currencyId'] : get_option('default_currency_id') ?>">
                    <input type="hidden" name="lang" value="<?= (isset($_GET['lang'])) ? $_GET['lang'] : get_option('default_language_id') ?>">
                    <input type="hidden" name="hotel_folder" id="hotel_folder">
                    <input type="hidden" name="NRooms" id="NRooms" value="<?php echo $_GET['NRooms'] ?>">
                    <div class="hotels_dropdown">
                        <div class="obpress-mobile-close-hotels-dropdown-holder">
                            <span>Selecione destino ou hotel</span>
                            <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/cross_medium.svg" alt="">
                        </div>
                        <div class="obpress-mobile-search-hotels-input-holder">
                            <input class="obpress-mobile-search-hotels-input" type="text" placeholder="Digite o nome ou cidade do hotel" id="search-hotels-input">
                        </div>
                        <div class="hotels_folder custom-bg custom-text" hidden></div>
                        <div class="hotels_hotel custom-bg custom-text" data-id="" hidden></div>
                    </div>

                </div>
                <div class="ob-searchbar-calendar">
                    <p><?php _e('Dates of stay', 'OBPress_SpecialOffersPage'); ?></p>
                    <input class="calendarToggle" type="text" id="calendar_dates" value="<?php echo $CheckInShow ?? date("d/m/Y") ?> - <?php echo $CheckOutShow ?? date("d/m/Y", strtotime("+1 day")) ?>"  readonly>
                    <div class="ob-mobile-searchbar-calendar-holder">
                        <div class="ob-mobile-searchbar-calendar">
                            <p>Check-in</p>
                            <input class="calendarToggle" type="text" id="check_in_mobile" value="<?php echo $CheckInShowMobile ?? date("d M Y") ?>"  readonly>
                        </div>
                        <div class="ob-mobile-searchbar-calendar">
                            <p>Check-out</p>
                            <input class="calendarToggle" type="text" id="check_out_mobile" value="<?php echo $CheckOutShowMobile ?? date("d M Y", strtotime("+1 day")) ?>"  readonly>
                        </div>
                    </div>
                    <input class="calendarToggle" type="hidden" id="date_from" name="CheckIn" value="<?php echo $CheckIn ?? date("dmY") ?>">
                    <input class="calendarToggle" type="hidden" id="date_to" name="CheckOut" value="<?php echo $CheckOut ?? date("dmy", strtotime("+1 day")) ?>">            
                </div>
                <div class="ob-searchbar-guests">
                    <p><?php _e('Rooms and guests', 'OBPress_SpecialOffersPage'); ?></p>
                    <input type="text" id="guests" data-room="<?php _e('Room', 'OBPress_SpecialOffersPage'); ?>" data-rooms="<?php _e('Rooms', 'OBPress_SpecialOffersPage'); ?>" data-guest="<?php _e('Guest', 'OBPress_SpecialOffersPage'); ?>" data-guests="<?php _e('Guests', 'OBPress_SpecialOffersPage'); ?>" data-remove-room="<?php _e('Remove room', 'OBPress_SpecialOffersPage'); ?>" readonly value="1 Room, 1 Guest">
                    <input type="hidden" id="ad" name="ad" value="<?= get_option('calendar_adults') ?>">
                    <input type="hidden" id="ch" name="ch" value="">
                    <input type="hidden" id="ag" name="ag" value="">
                    <div id="occupancy_dropdown" class="position-absolute custom-bg custom-text" data-default-currency="<?= (isset($_GET['currencyId'])) ? $_GET['currencyId'] : get_option('default_currency_id') ?>">
                        <div class="add-room-holder">
                            <p class="add-room-title select-room-title custom-text"><?php _e('NUMBER OF ROOMS', 'OBPress_SpecialOffersPage') ?></p>
                            <div class="select-room-buttons">
                                <button class="select-button select-button-minus select-room-minus" type="button" disabled>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                </button>
                                <span class="select-value select-room-value">1</span>
                                <button class="select-button select-button-plus select-room-plus" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                </button>
                            </div>
                        </div>
                        <div class="select-room-holder">
                            <div class="select-room" data-room-counter="0">
                                <p class="select-room-title custom-text"><?php _e('Room', 'OBPress_SpecialOffersPage');?> <span class="select-room-counter">1</span></p>
                                <div class="remove-room-mobile">Remover quarto</div>
                                <div class="select-guests-holder">
                                    <div class="select-adults-holder">
                                        <div class="select-adults-title">
                                            <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/adults.svg" alt="">
                                            <?php _e('Adults', 'OBPress_SpecialOffersPage'); ?>
                                        </div>
                                        <div class="select-adults-buttons">
                                            <button class="select-button select-button-minus select-adult-minus" type="button" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>
                                            </button>
                                            <span class="select-value select-adults-value">1</span>
                                            <button class="select-button select-button-plus select-adult-plus" type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="select-child-holder">
                                        <div class="select-child-title">
                                            <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/children.svg" alt="">
                                            <div>
                                                <span><?php _e('Children', 'OBPress_SpecialOffersPage') ?></span>
                                                <span class="select-child-title-max-age">
                                                    0 <?php 
                                                    _e('to the', 'OBPress_SpecialOffersPage') ; 
                                                    echo " " ; 
                                                    ?>
                                                    <span class='child-max-age'> <?php echo $childrenMaxAge ; ?> </span>
                                                </span> 
                                            </div>
                                        </div>
                                        <div class="select-child-buttons">
                                            <button class="select-button select-button-minus select-child-minus" type="button" disabled>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>
                                            </button>
                                            <span class="select-value select-child-value">0</span>
                                            <button class="select-button select-button-plus select-child-plus" type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="select-child-ages-holder">
                                        <div class="select-child-ages-clone">
                                            <p class="select-child-ages-title custom-text"><?php _e('Age', 'OBPress_SpecialOffersPage'); ?> <span class="select-child-ages-number"></span></p>
                                            <div class="age-picker"> 
                                                <span class="age-picker-value">0</span> 
                                                <div class="age-picker-options">
                                                    <?php for ($i = 0; $i < 18; $i++) : ?>
                                                        <div data-age="<?= $i; ?>"> <?= $i; ?> anos de idade</div>
                                                    <?php endfor; ?>
                                                </div>
                                                <select class="select-child-ages-input-clone">
                                                        <?php for ($i = 0; $i < 18; $i++) : ?>
                                                            <option data-value="<?= $i; ?>" <?php if ($i == 0) { echo "selected";} ?>><?= $i; ?></option>
                                                        <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="child-ages-input"></div>
                                            <p class="incorect-age custom-text"><?php _e('Incorrect Age', 'OBPress_SpecialOffersPage') ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-room-mobile">+ Adicionar outro quarto</div>
                            </div>
                        </div>
                        <button class="btn-ic custom-action-bg custom-action-border custom-action-text select-occupancy-apply" type="button">
                            <?php _e('Apply', 'OBPress_SpecialOffersPage') ?>
                            <span class="select-occupancy-apply-info">
                                    <span class="select-occupancy-apply-info-rooms" data-rooms="1">1</span>
                                    <span class="select-occupancy-apply-info-rooms-string">Room</span>
                                    ,
                                    <span class="select-occupancy-apply-info-guests" data-guests="<?= get_option('calendar_adults') ?>"><?= get_option('calendar_adults') ?></span>
                                    <span class="select-occupancy-apply-info-guests-string">Guest</span>
                            </span>
                        </button>

                    </div>
                </div>
                <div class="ob-searchbar-promo">
                    <p><?php _e('I have a code', 'OBPress_SpecialOffersPage'); ?></p>
                    <input type="text" id="promo_code" value="" placeholder="Escolha o tipo" readonly>
                    <div class="material-check custom-checkbox-holde ob-mobile-i-have-a-code">
                        <div class="mdc-touch-target-wrapper">
                            <div class="mdc-checkbox mdc-checkbox--touch">
                                <input class="board_check mdc-checkbox__native-control checkbox-custom checkbox-custom ob-mobile-i-have-a-code-input" type="checkbox" name="1" id="i_have_a_code">
                                <div class="mdc-checkbox__background">
                                    <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                        <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                                    </svg>
                                    <div class="mdc-checkbox__mixedmark"></div>
                                </div>
                            </div>
                        </div>
                        <label class="form-check-label" for="i_have_a_code">
                            <span class="checkbox-custom-label"><?php _e('I HAVE A CODE', 'OBPress_SpecialOffersPage'); ?></span>
                        </label>
                    </div>
                    <div id="promo_code_dropdown" class="position-absolute custom-bg custom-text">
                        <div class="mb-3 mt-2">
                            <p class="input-title"><?php _e('GROUP CODE', 'OBPress_SpecialOffersPage') ?></p>
                            <!-- <input type="text" id="group_code" name="group_code" placeholder="Digite seu código"> -->
                            <div class="material-textfield">
                                <input type="text" id="group_code" name="group_code" placeholder="Digite seu código">
                                <span class="label-title"><?php _e('GROUP CODE', 'OBPress_SpecialOffersPage') ?></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <p class="input-title"><?php _e('PROMO CODE', 'OBPress_SpecialOffersPage'); ?></p>
                            <!-- <input type="text" id="Code" name="Code" placeholder="Digite seu código"> -->
                            <div class="material-textfield">
                                <input type="text" id="Code" name="Code" placeholder="Digite seu código">
                                <span class="label-title"><?php _e('PROMO CODE', 'OBPress_SpecialOffersPage'); ?></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <p class="input-title"><?php _e('LOYALTY CODE', 'OBPress_SpecialOffersPage') ?></p>
                            <!-- <input type="text" id="loyalty_code" name="loyalty_code" placeholder="Digite seu código"> -->
                            <div class="material-textfield">
                                <input type="text" id="loyalty_code" name="loyalty_code" placeholder="Digite seu código">
                                <span class="label-title"><?php _e('LOYALTY CODE', 'OBPress_SpecialOffersPage') ?></span>
                            </div>
                        </div>
                        <div class="text-right">
                            <button id="promo_code_apply" class="custom-action-bg custom-action-text custom-action-border btn-ic"><?php _e('Apply', 'OBPress_SpecialOffersPage'); ?></button>
                        </div>
                    </div>
                </div>
                <div class="ob-searchbar-button">
                    <button class="ob-searchbar-submit" type="button"><?php _e('Search', 'OBPress_SpecialOffersPage'); ?></button>
                </div> 
            </div>
            <div class="zcalendar-wrap">
                <div class="ob-zcalendar-top">
                    <div class="ob-zcalendar-title">
                        <?php _e('Select date of stay', 'OBPress_SpecialOffersPage') ?>
                        <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/cross_medium.svg" alt="">
                    </div>
                    <div class="ob-mobile-weekdays">
                        <div>
                            <span><?php _e('sun', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('mon', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('tue', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('wed', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('thu', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('fri', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('sat', 'OBPress_SpecialOffersPage') ?></span>
                        </div>
                    </div>
                </div>
                <div class="zcalendar-holder" id="calendar-holder">
                    <div class="zcalendar data-allow-unavail="<?= get_option('allow_unavail_dates') ?> data-allow-unavail="<?= get_option('allow_unavail_dates') ?>" data-promotional="<?php _e('Offers for you', 'OBPress_SpecialOffersPage'); ?>" data-promo="<?php _e('Special Offer', 'OBPress_SpecialOffersPage'); ?>" data-lang="{{$lang->Code}}"  data-night="<?php _e('Night', 'OBPress_SpecialOffersPage') ?>" data-nights="<?php _e('Nights', 'OBPress_SpecialOffersPage') ?>" data-price-for="<?php _e('*Price for', 'OBPress_SpecialOffersPage') ?>" data-adult="<?php _e('adult', 'OBPress_SpecialOffersPage') ?>" data-adults="<?php _e('adults', 'OBPress_SpecialOffersPage') ?>" data-restriction="<?php _e('Restricted Days', 'OBPress_SpecialOffersPage') ?>" data-notavailable="<?php _e('index_no_availability_v4', 'OBPress_SpecialOffersPage') ?>" data-closedonarrival="<?php _e('calendar_closed_on_arrival', 'OBPress_SpecialOffersPage') ?>"  data-closedondeparture="<?php _e('calendar_closed_on_departure', 'OBPress_SpecialOffersPage') ?>" data-minimum-string="<?php _e('system_min', 'OBPress_SpecialOffersPage') ?>" data-maximum-string="<?php _e('system_max', 'OBPress_SpecialOffersPage') ?>" ></div>
                </div>
                <div class="ob-zcalendar-bottom">
                    <div> <span class='mobile-accept-dates-from-to'>Seg, 14 Nov - Sex, 18 Nov</span> <span class="number_of_nights-mobile-span"> ( <span class="number_of_nights-mobile"> 4 Noites</span> )</span> </div>
                    <div id="mobile-accept-date"> Aplicar </div>
                </div>
            </div>     
        </form>
        <p class="rooms-message-header"><?php _e('Related rooms', 'OBPress_RoomPage') ?></p>
        <div class="obpress-room-rooms-basket"> 
            <div id="room-results">
                <div class="rateplans"> 
                    <div class="single-room-rate-info roomrateinfo">
						<div class="single-room-rate-name">
                            Best Available Rate - AI													
						</div>
                        <div class="cancellation_policy"><?php _e('Non Refundable', 'OBPress_RoomPage') ?></div>

						<div class="included">
                            <span class="meals_included">
                                <span class="dot">⬤</span> All Inclusive               
                            </span>
                            <span class="service_included">
                                <span class="dot">⬤</span> Breakfast Extra
                            </span>
						</div>
						<div class="single-room-rate-bottom">
                            <p class="price-before">
                                <del>
                                    <span class="currency_symbol_price">R$</span> 600.<span class="decimal_value_price">00</span>
                                </del>
                            </p>
							<div class="single-room-price-and-button">
								<div class="single-room-price">
                                    <p class="price-after best-price">
                                        <span class="currency_symbol_price">R$</span> 460.<span class="decimal_value_price">00</span>
									</p>
									<span class="single-tax-msg"><?php _e('Includes taxes and fees', 'OBPress_RoomPage') ?></span>
								</div>
								<div class="single-room-button">
                                    <div class="text-number-of-rooms"><?php _e('Nº of rooms', 'OBPress_RoomPage') ?></div>
									<div class="obpress-hotel-results-button-bottom">
                                        <button class="room-btn-add btn-ic custom-action-border custom-action-text custom-action-bg"><?php _e('Book Now', 'OBPress_RoomPage') ?>  </button>  
										<button href="#" class="room-btn-minus btn-ic custom-action-border custom-action-text custom-action-bg">-</button>
                                        <span class="room-btn-value custom-action-border-top custom-action-border-bottom">0</span>
                                        <button href="#" class="room-btn-plus btn-ic custom-action-border custom-action-text custom-action-bg">+</button>
									</div>
								</div>
							</div>
						</div>
					</div>
                    <div class="single-room-rate-info roomrateinfo">
						<div class="single-room-rate-name">
                            Best Available Rate - AI													
						</div>
                        <div class="cancellation_policy"><?php _e('Free Cancellation', 'OBPress_RoomPage') ?></div>

						<div class="included">
                            <span class="meals_included">
                                <span class="dot">⬤</span> All Inclusive               
                            </span>
                            <span class="service_included">
                                <span class="dot">⬤</span> Wi-Fi
                            </span>
						</div>
						<div class="single-room-rate-bottom">
                            <p class="price-before">
                                <del>
                                    <span class="currency_symbol_price">R$</span> 600.<span class="decimal_value_price">00</span>
                                </del>
                            </p>
							<div class="single-room-price-and-button">
								<div class="single-room-price">
									<p class="price-after">
                                        <span class="currency_symbol_price">R$</span> 460.<span class="decimal_value_price">00</span>
									</p>
									<span class="single-tax-msg"><?php _e('Includes taxes and fees', 'OBPress_RoomPage') ?></span>
								</div>
								<div class="single-room-button">
                                    <div class="text-number-of-rooms" style="display: block;">Nº de quartos</div>
									<div class="obpress-hotel-results-button-bottom"> 
                                        <button href="#" class="room-btn-minus btn-ic custom-action-border custom-action-text custom-action-bg" style="display: flex;">-</button>
                                        <span class="room-btn-value custom-action-border-top custom-action-border-bottom" style="display: flex;">1</span>
                                        <button href="#" class="room-btn-plus btn-ic custom-action-border custom-action-text custom-action-bg" style="display: flex;">+</button>
									</div>
								</div>
							</div>
						</div>
					</div>
                    <div class="single-room-rate-info roomrateinfo">
						<div class="single-room-rate-name">
                            Best Available Rate - AI													
						</div>
                        <div class="cancellation_policy"><?php _e('Allow Cancellation', 'OBPress_RoomPage') ?> </div>

						<div class="included">
                            <span class="meals_included">
                                <span class="dot">⬤</span> All Inclusive               
                            </span>
                            <span class="service_included">
                                <span class="dot">⬤</span> Breakfast Extra
                            </span>
						</div>
						<div class="single-room-rate-bottom">
                            <p class="price-before">
                                <del>
                                    <span class="currency_symbol_price">R$</span> 600.<span class="decimal_value_price">00</span>
                                </del>
                            </p>
							<div class="single-room-price-and-button">
								<div class="single-room-price">
									<p class="price-after <?php if($first_roomrate == true) echo 'best-price'; ?>">
                                        <span class="currency_symbol_price">R$</span> 460.<span class="decimal_value_price">00</span>
									</p>
									<span class="single-tax-msg"><?php _e('Includes taxes and fees', 'OBPress_RoomPage') ?></span>
								</div>

								<div class="single-room-button">
                                    <div class="restricted_text_holder">
                                        <div class="los_restricted red-text t-tip__in">
                                            <div class="restriction">
                                                <span>- Stay a minimum of 3 nights</span>
                                            </div>
                                            <div class="restriction days-in-advance">
                                                <span>- Book 2 nights in advance</span>
                                            </div>
                                        </div>
                                        <span class="restricted_modify_search">Change Search</span>
                                    </div>
								</div>

							</div>
						</div>
					</div>
                </div>
                <div class="error_message_holder">
                    <div class="error_message_left">
                        <img class="error_info_icon" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/information-button-white.svg" ?>">
                        <div class="error_message">
                            <div class="error_message_description">
                                <?php _e('There are no rooms available for the dates indicated.', 'OBPress_RoomPage') ?>
                            </div>
                        </div>
                    </div>
                    <button class="error_message_btn_calendar">
                        <?php _e('Change your search', 'OBPress_RoomPage') ?>
                    </button>
                </div>
            </div>

            <div class="obpress-hotel-results-basket-holder">
                <div class="obpress-hotel-results-basket <?php if(is_admin_bar_showing() == true){echo 'obpress-admin-bar-shown-basket';} ?>"  id="basket">
                    <div class="obpress-hotel-results-basket-info-holder">
                        <div class="obpress-hotel-results-basket-info">
                            <div class="obpress-hotel-stars-holder">
                                <div class="hotel-stars">
                                    <?php for ($i = 0; $i < 5; $i++) : ?>
                                        <?php if ($i < 3) : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="23.001" height="21.231" viewBox="0 0 23.001 21.231" class="star-full">
                                                <defs>
                                                    <style>
                                                        .a {
                                                            fill: #ffc70e;
                                                        }
                                                    </style>
                                                </defs>
                                                <path class="a" d="M11.5,0l4.025,6.359L23,8.11,18.013,13.79l.595,7.441L11.5,18.383,4.393,21.232l.595-7.441L0,8.11l7.475-1.75Z" />
                                            </svg>
                                        <?php else : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="23.001" height="21.231" viewBox="0 0 23.001 21.231" class="star-lines">
                                                <defs>
                                                    <style>
                                                        .a {
                                                            fill: none;
                                                        }

                                                        .b,
                                                        .c {
                                                            stroke: none;
                                                        }

                                                        .c {
                                                            fill: #ffc70e;
                                                        }
                                                    </style>
                                                </defs>
                                                <g class="a">
                                                    <path class="b" d="M11.5,0l4.025,6.359L23,8.11,18.013,13.79l.595,7.441L11.5,18.383,4.393,21.232l.595-7.441L0,8.11l7.475-1.75Z" />
                                                    <path class="c" d="M 11.50043106079102 1.869796752929688 L 8.10150146484375 7.239782333374023 L 1.851781845092773 8.703174591064453 L 6.018121719360352 13.44847297668457 L 5.518131256103516 19.7032413482666 L 11.50043106079102 17.30573272705078 L 17.48273086547852 19.7032413482666 L 16.98274040222168 13.44847297668457 L 21.14908027648926 8.703174591064453 L 14.89936065673828 7.239782333374023 L 11.50043106079102 1.869796752929688 M 11.50043106079102 1.9073486328125e-06 L 15.52558135986328 6.359362602233887 L 23.0008602142334 8.109732627868652 L 18.01325988769531 13.79041290283203 L 18.60809135437012 21.23156356811523 L 11.50043106079102 18.38305282592773 L 4.392770767211914 21.23156356811523 L 4.987600326538086 13.79041290283203 L 1.9073486328125e-06 8.109732627868652 L 7.47528076171875 6.359362602233887 L 11.50043106079102 1.9073486328125e-06 Z" />
                                                </g>
                                            </svg>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                            </div> 
                            <p class="obpress-hotel-basket-title">Windsor Florida Hotel</p>
                            <div class="obpress-hotel-basket-stay-info">
                                <div class="obpress-hotel-basket-stay-dates">
                                    <span class="obpress-hotel-basket-stay-checkin">
                                        <span class="obpress-hotel-basket-stay-checkin-string">Check-in</span>
                                        <span class="obpress-hotel-basket-stay-checkin-date"><?php  $CheckInBasket = date("d M", strtotime($CheckIn)); echo $CheckInBasket; ?></span>
                                    </span>
                                    <span class="obpress-hotel-searchbar-arrow">
                                        <svg class="arrow-right-dates_v4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                            <defs>
                                                <style>
                                                    .a {
                                                        fill: #fff;
                                                    }

                                                    .b,
                                                    .c {
                                                        fill: none;
                                                        stroke: #000000;
                                                        stroke-linecap: round;
                                                        stroke-width: 1.5px;
                                                    }

                                                    .b {
                                                        stroke-linejoin: round;
                                                    }
                                                </style>
                                            </defs>
                                            <g transform="translate(151 262) rotate(180)">
                                                <rect class="a" width="16" height="16" transform="translate(135 246)" />
                                                <g transform="translate(150 259) rotate(180)">
                                                    <path class="b" d="M4312.563,10990.207l4.563,4.828-4.562,4.172" transform="translate(-4304.125 -10990.207)" />
                                                    <path class="c" d="M4315.25,10994.979h-11" transform="translate(-4303.25 -10990.295)" />
                                                </g>
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="obpress-hotel-basket-stay-checkout">
                                        <span class="obpress-hotel-basket-stay-checkout-string">Check-out</span>
                                        <span class="obpress-hotel-basket-stay-checkout-date"><?php  $CheckOutBasket = date("d M", strtotime($CheckOut)); echo $CheckOutBasket; ?></span>                            
                                    </span>
                                </div>
                                <div class="obpress-hotel-basket-stay-room-info">
                                    <span class="obpress-hotel-basket-stay-rooms">
                                        <span class="obpress-hotel-basket-stay-rooms-string">Quartos</span>
                                        <span class="obpress-hotel-basket-stay-rooms-num"> 1 </span>
                                    </span>
                                    <span class="obpress-hotel-basket-stay-nights">
                                        <span class="obpress-hotel-basket-stay-nights-string">Noites</span>
                                        <span class="obpress-hotel-basket-stay-nights-num"> <?php echo $nights; ?> </span>                            
                                    </span>
                                    <span class="obpress-hotel-basket-stay-guests">
                                        <span class="obpress-hotel-basket-stay-guests-string">Hóspedes</span>
                                        <span class="obpress-hotel-basket-stay-guests-num"> <?= (isset($_GET['ad'])) ? $_GET['ad'] : "1" ?> </span>                               
                                    </span>
                                </div>
                                <div class="obpress-hotel-searchbar-button-holder">
                                    <button class="obpress-hotel-searchbar-button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <svg class="obpress-hotel-searchbar-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><defs><style>.a{fill:#fff;opacity:0;}.b{fill:none;stroke:#273240;stroke-linecap:round;stroke-width:1.5px;}</style></defs><g transform="translate(12030 20724)"><rect class="a" width="24" height="24" transform="translate(-12030 -20724)"></rect><g transform="translate(-12026 -20720)"><circle class="b" cx="6.5" cy="6.5" r="6.5"></circle></g><line class="b" x2="5.5" y2="5" transform="translate(-12014 -20709.5)"></line></g></svg>
                                        Modificar
                                    </button>
                                </div>
                            </div>   
                        </div>
                        <div class="obpress-hotel-results-basket-cart">
                            <div class="obpress-hotel-results-item-holder">
                                <div class="obpress-hotel-results-item-top">
                                    <div class="basket-room-div" rate-id="291171" room-id="38692">
                                        <div class="obpress-hotel-results-item-title-price">
                                            <span class="obpress-hotel-results-item-title">SUPERIOR DOUBLE</span>
                                            <span class="obpress-hotel-results-total-room-selected">
                                                x
                                                <span class="obpress-hotel-results-total-room-counter">1</span>
                                            </span>
                                            <span class="obpress-hotel-results-item-price">
                                                <span class="obpress-hotel-results-item-curr">R$</span>
                                                <span class="obpress-hotel-results-item-value">600.00</span>
                                            </span>
                                        </div>
                                        <div class="obpress-hotel-results-item-promo-edit">
                                            <span class="obpress-hotel-results-item-promo">Não Reembolsável</span>
                                            <span class="obpress-hotel-results-item-edit" style="pointer-events: none;">Remover</span>
                                        </div>
                                        <div class="obpress-hotel-results-discount-holder">
                                            <div class="obpress-hotel-results-discount-message">Discount <span class="obpress-hotel-results-discount-percent"></span></div>
                                            <div class="obpress-hotel-results-discount-total">
                                                <span class="obpress-hotel-results-discount-currency">-R$</span>    
                                                <span class="obpress-hotel-results-discount-price">120.00</span>
                                            </div>
                                        </div>
                                        <div class="obpress-hotel-results-tax-holder">
                                            <p class="obpress-hotel-results-tax-title">
                                                Taxas
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14.545" height="14.545" viewBox="0 0 20.545 20.545"><path d="M12.245,18.409H14.3V12.245H12.245ZM13.272,3A10.272,10.272,0,1,0,23.545,13.272,10.276,10.276,0,0,0,13.272,3Zm0,18.49a8.218,8.218,0,1,1,8.218-8.218A8.229,8.229,0,0,1,13.272,21.49Zm-1.027-11.3H14.3V8.136H12.245Z" transform="translate(-3 -3)"></path></svg>
                                            </p>
                                            <div class="obpress-hotel-results-tax-bottom">
                                                <div class="obpress-hotel-results-tax-message">Taxas de Serviço e ISS</div>
                                                <div class="obpress-hotel-results-tax-total">
                                                    <span class="obpress-hotel-results-tax-currency">R$</span>
                                                    <span class="obpress-hotel-results-tax-price">86.78</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="obpress-hotel-results-basket-price">
                        <div class="obpress-hotel-total-price-holder">
                            <span class="obpress-hotel-total-price-string">Total</span>
                            <span class="obpress-hotel-total-price">
                                <span class="font-weight-regular obpress-hotel-total-price-currency">R$</span> 
                                <span class="obpress-hotel-total-price-value">566,78</span>
                            </span>
                            <?php if(isset($hotel['MaxPartialPaymentParcel'])) : ?>
                                <!-- <span class="obpress-hotel-results-pay-up-to">Pay up to <?= $hotel['MaxPartialPaymentParcel']; ?>x</span> -->
                            <?php endif; ?>
                        </div>
                        <button class="obpress-hotel-submit" id="basket-send" type="button" disabled="">Proximo Passo</button>
                    </div>
                </div>
            </div>
        </div>
	</div>
<?php endif; ?>


<div class="next-step-loader-next-page">
    <div class="gooey">
        <span class="dot"></span>
        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="search-loading-message">
        <?php _e("Please wait...", 'OBPressTheme') ?>
    </div>
</div>

<script type="text/javascript">
    var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
</script>