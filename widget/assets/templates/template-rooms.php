<?php 
	$canidates = $data->getAllRoomStayCandidates();

	$AllRoomRates = [];
	$AllRoomRatesCopy = [];
	$AllRoomRatesAvailableForSale = [];
	$AllRoomRatesLOS_Restricted = [];

	if($data->getRoomRatesByRoomAvailability($property, $room_id, ['AvailableForSale']) != null) {
		$AllRoomRatesAvailableForSale = $data->getRoomRatesByRoomAvailability($property, $room_id, ['AvailableForSale']);
	}
	if ($data->getRoomRatesByRoomAvailability($property, $room_id, ['LOS_Restricted']) !== null) {
		$AllRoomRatesLOS_Restricted = $data->getRoomRatesByRoomAvailability($property, $room_id, ['LOS_Restricted']);
	}

    if ($AllRoomRatesAvailableForSale != null && $AllRoomRatesLOS_Restricted != null ) {
          $AllRoomRates = array_merge($AllRoomRatesAvailableForSale, $AllRoomRatesLOS_Restricted);
    }


	$availableRooms =  count( $AllRoomRates );
	
	foreach($AllRoomRates as $RoomRate) {
		$AllRoomRatesCopy[$RoomRate->RoomID] = $RoomRate;
	}
	$AllRoomRates = [];
	$AllRoomRates = $AllRoomRatesCopy;
?>
<div class="rateplans"> 

	<?php foreach($canidates as $canidate): ?>
		<?php
			$adults = 0;
			$children = 0;
			$children_ages = "";
			$counter = 0;
		?>

		<?php
		foreach($canidate->GuestCountsType->GuestCounts as $GuestCount) {
			if($GuestCount->AgeQualifyCode == 10) {
				$adults = $GuestCount->Count;
			}
			elseif($GuestCount->AgeQualifyCode == 8) {
				$children++;
				$children_ages.=$GuestCount->Age;
				$children_ages.=";";
			}
		}
		?>

		<?php if($data->get()->RoomStaysType != null ): ?>
			<?php


				$AllRoomsEmpty = false;

				$first_roomrate = true;

				$today = new \DateTime('now');
				$CheckInPolicy = \DateTime::createFromFormat('d.m.Y', $CheckIn);

			?>

			<?php if ($data->getRoomRatesByRoomAvailability($property, $room_id, ["AvailableForSale"]) != null): ?>
				<?php foreach ($data->getRoomRatesByRoomAvailability($property, $room_id, ["AvailableForSale"]) as $key => $roomrate): ?>
					<?php 
						if ($descriptive_infos->getAmenitiesByRoomV4($room_id) !== null) {
							$room_amenities = $descriptive_infos->getAmenitiesByRoomV4($room_id);
						}
						else {
							$room_amenities = [];
						}
						$rate_plan = $data->getRatePlan($roomrate->RatePlanID);
					?>

					<div class="single-room-rate-info roomrateinfo" 
					data-price="<?php echo $roomrate->Total->AmountBeforeTax; ?>" 
					data-quantity="0" 
					data-max-quantity="<?php echo $room->MaxOccupancy; ?>" 
					data-nights="1" 
					data-discount="<?= isset($roomrate->Total->TPA_Extensions->TotalDiscountValue) ? $roomrate->Total->TPA_Extensions->TotalDiscountValue : "" ?>"  
					data-price-before-discount="<?= isset($roomrate->Total->TPA_Extensions->TotalDiscountValue) ? (@$roomrate->Total->TPA_Extensions->TotalDiscountValue+@$roomrate->Total->AmountBeforeTax)/$nights : "" ?>" 
					data-tax-policy-name="Taxas de Servi??o e ISS" 
					data-total-price-after-tax="<?php echo $roomrate->Total->AmountAfterTax; ?>"
					data-children-ages="" 
					data-rate-id="<?= $roomrate->RatePlanID ?>"
					data-room-id="<?php echo $room->ID; ?>"

					        data-rph="<?= $roomrate->RoomStayCandidateRPH ?>" 
                            data-start="<?= $roomrate->EffectiveDate ?>" 
                            data-end="<?= $roomrate->ExpireDate ?>" 


                            data-name="<?= $roomtype->RoomName ?>"
                            data-rate-name="<?= $rate_plan->RatePlanName ?>"
                            data-adults="<?= $adults?>" 
                            data-children="<?= $children?>" 
                            data-children-ages="<?= $children_ages?>"


					data-currency-symbol="<?= $currencies[0]->CurrencySymbol ?>"  
					data-policy="<?php if($rate_plan->CancelPenalties != null): ?>
											<?php foreach($rate_plan->CancelPenalties as $cancellation): ?>
												<?php if($cancellation->NonRefundable == false && ($cancellation->AmountPercent->Amount == 0 && $cancellation->AmountPercent->Percent == 0 && $cancellation->AmountPercent->NmbrOfNights == 0)): ?>
													<?php if($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d >= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
														Cancelamento Gr??tis
													<?php elseif($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d < $cancellation->DeadLine->OffsetUnitMultiplier): ?>
														N??o Reembols??vel
													<?php else: ?>
														Cancelamento Gr??tis
													<?php endif; ?>
												<?php elseif($cancellation->NonRefundable == false && ($cancellation->AmountPercent->Amount != 0 || $cancellation->AmountPercent->Percent != 0 || $cancellation->AmountPercent->NmbrOfNights != 0)): ?>
													<?php if($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d >= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
														Permite Cancelamento    
													<?php elseif($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d <= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
														N??o Reembols??vel
													<?php else: ?>
														Permite Cancelamento
													<?php endif; ?>
												<?php elseif($cancellation->NonRefundable == true): ?>
													N??o Reembols??vel
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
								">
									
						<div class="single-room-rate-name">
							<?= substr($rate_plan->RatePlanName, 0, 36) ?>
							<?php if(strlen($rate_plan->RatePlanName) > 36): ?>
								...
							<?php endif; ?>
						</div>

						<?php if($rate_plan->CancelPenalties != null): ?>
							<?php foreach($rate_plan->CancelPenalties as $cancellation): ?>
								<?php if($cancellation->NonRefundable == false && ($cancellation->AmountPercent->Amount == 0 && $cancellation->AmountPercent->Percent == 0 && $cancellation->AmountPercent->NmbrOfNights == 0)): ?>
									<?php if($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d >= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
										<div class="cancellation_policy"><?php _e('Free Cancellation', 'OBPress_RoomPage') ?></div>
									<?php elseif($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d < $cancellation->DeadLine->OffsetUnitMultiplier): ?>
										<div class="cancellation_policy"><?php _e('Non Refundable', 'OBPress_RoomPage') ?></div>
									<?php else: ?>
										<div class="cancellation_policy"><?php _e('Free Cancellation', 'OBPress_RoomPage') ?></div>
									<?php endif; ?>
								<?php elseif($cancellation->NonRefundable == false && ($cancellation->AmountPercent->Amount != 0 || $cancellation->AmountPercent->Percent != 0 || $cancellation->AmountPercent->NmbrOfNights != 0)): ?>
									<?php if($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d >= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
										<div class="cancellation_policy"><?php _e('Allow Cancellation', 'OBPress_RoomPage') ?> </div>
									<?php elseif($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d <= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
										<div class="cancellation_policy"><?php _e('Non Refundable', 'OBPress_RoomPage') ?></div>
									<?php else: ?>
										<div class="cancellation_policy"><?php _e('Allow Cancellation', 'OBPress_RoomPage') ?></div>
									<?php endif; ?>
								<?php elseif($cancellation->NonRefundable == true): ?>
									<div class="cancellation_policy"><?php _e('Non Refundable', 'OBPress_RoomPage') ?></div>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>

						<div class="included">
							<?php if($rate_plan->MealsIncluded != null): ?>
								<span class="meals_included">
									<span class="dot">???</span> <?= $rate_plan->MealsIncluded->Name; ?>                                                                            
								</span>
							<?php endif; ?>


							<?php if($rate_plan->RatePlanInclusions != null): ?>
								<?php foreach($rate_plan->RatePlanInclusions as $included): ?>
									<span class="service_included">
										<span class="dot">???</span> <?= $included->RatePlanInclusionDesciption->Name ?>
									</span>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>

						<div class="single-room-rate-bottom">
							<?php if(isset($roomrate->Total->TPA_Extensions->TotalDiscountValue)): ?>
								<p class="price-before">
									<del>
										<?= Lang_Curr_Functions::ValueAndCurrencyCultureV4($roomrate->Total->TPA_Extensions->TotalDiscountValue+@$roomrate->Total->AmountBeforeTax, $currencies, $currency, $language) ?>
									</del>
								</p>
							<?php endif; ?>
							<div class="single-room-price-and-button">
								<div class="single-room-price">
									<p class="price-after <?php if($first_roomrate == true) echo 'best-price'; ?>">
										<?= Lang_Curr_Functions::ValueAndCurrencyCultureV4(@$roomrate->Total->AmountBeforeTax, $currencies, $currency, $language) ?>
									</p>
									<span class="single-tax-msg"><?php _e('Includes taxes and fees', 'OBPress_RoomPage') ?></span>
									<?php 
										if($first_roomrate == true) {
											$first_roomrate = false;
										}
									?>
								</div>

								<div class="single-room-button">
									<div class="text-number-of-rooms"><?php _e('N?? of rooms', 'OBPress_RoomPage') ?></div>
									<div class="obpress-hotel-results-button-bottom">
										<button class="room-btn-add btn-ic custom-action-border custom-action-text custom-action-bg"><?php _e('Book Now', 'OBPress_RoomPage') ?>  </button>   
										<button href="#" class="room-btn-minus btn-ic custom-action-border custom-action-text custom-action-bg">-</button><span class="room-btn-value custom-action-border-top custom-action-border-bottom">0</span><button href="#" class="room-btn-plus btn-ic custom-action-border custom-action-text custom-action-bg">+</button>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				<?php endforeach; ?>
			<?php endif; ?>

			
			<?php if ($data->getRoomRatesByRoomAvailability($property, $room_id, ["LOS_Restricted"]) != null): ?>
				<?php foreach ($data->getRoomRatesByRoomAvailability($property, $room_id, ["LOS_Restricted"]) as $key => $roomrate): ?>

					<?php 
						if ($descriptive_infos->getAmenitiesByRoomV4($room->RoomID) !== null) {
							$room_amenities = $descriptive_infos->getAmenitiesByRoomV4($room->RoomID);
						}
						else {
							$room_amenities = [];
						}
						$rate_plan = $data->getRatePlan($roomrate->RatePlanID);
					?>

					<div class="single-room-rate-info roomrateinfo" 
					data-price="<?php echo $roomrate->Total->AmountBeforeTax; ?>" 
					data-quantity="0" 
					data-max-quantity="<?php echo $room->MaxOccupancy; ?>" 
					data-nights="1" 
					data-discount="<?= isset($roomrate->Total->TPA_Extensions->TotalDiscountValue) ? $roomrate->Total->TPA_Extensions->TotalDiscountValue : "" ?>"  
					data-price-before-discount="<?= isset($roomrate->Total->TPA_Extensions->TotalDiscountValue) ? (@$roomrate->Total->TPA_Extensions->TotalDiscountValue+@$roomrate->Total->AmountBeforeTax)/$nights : "" ?>" 
					data-tax-policy-name="Taxas de Servi??o e ISS" 
					data-total-price-after-tax="<?php echo $roomrate->Total->AmountAfterTax; ?>"
					data-children-ages="" data-rate-id="<?= $roomrate->RatePlanID ?>"
					data-room-id="<?php echo $room->RoomID; ?>"
					data-currency-symbol="<?= $currencies[0]->CurrencySymbol ?>"  


					data-rph="<?= $roomrate->RoomStayCandidateRPH ?>" 
                            data-start="<?= $roomrate->EffectiveDate ?>" 
                            data-end="<?= $roomrate->ExpireDate ?>" 


                            data-name="<?= $roomtype->RoomName ?>"
                            data-rate-name="<?= $rate_plan->RatePlanName ?>"
                            data-adults="<?= $adults?>" 
                            data-children="<?= $children?>" 
                            data-children-ages="<?= $children_ages?>"


                            
					data-policy="<?php if($rate_plan->CancelPenalties != null): ?>
											<?php foreach($rate_plan->CancelPenalties as $cancellation): ?>
												<?php if($cancellation->NonRefundable == false && ($cancellation->AmountPercent->Amount == 0 && $cancellation->AmountPercent->Percent == 0 && $cancellation->AmountPercent->NmbrOfNights == 0)): ?>
													<?php if($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d >= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
														Cancelamento Gr??tis
													<?php elseif($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d < $cancellation->DeadLine->OffsetUnitMultiplier): ?>
														N??o Reembols??vel
													<?php else: ?>
														Cancelamento Gr??tis
													<?php endif; ?>
												<?php elseif($cancellation->NonRefundable == false && ($cancellation->AmountPercent->Amount != 0 || $cancellation->AmountPercent->Percent != 0 || $cancellation->AmountPercent->NmbrOfNights != 0)): ?>
													<?php if($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d >= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
														Permite Cancelamento    
													<?php elseif($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d <= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
														N??o Reembols??vel
													<?php else: ?>
														Permite Cancelamento
													<?php endif; ?>
												<?php elseif($cancellation->NonRefundable == true): ?>
													N??o Reembols??vel
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
								">
									
						<div class="single-room-rate-name">
							<?= substr($rate_plan->RatePlanName, 0, 20) ?>
							<?php if(strlen($rate_plan->RatePlanName) > 20): ?>
								...
							<?php endif; ?>
						</div>
						<?php if($rate_plan->CancelPenalties != null): ?>
							<?php foreach($rate_plan->CancelPenalties as $cancellation): ?>
								<?php if($cancellation->NonRefundable == false && ($cancellation->AmountPercent->Amount == 0 && $cancellation->AmountPercent->Percent == 0 && $cancellation->AmountPercent->NmbrOfNights == 0)): ?>
									<?php if($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d >= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
										<div class="cancellation_policy"><?php _e('Free Cancellation', 'OBPress_RoomPage') ?></div>
									<?php elseif($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d < $cancellation->DeadLine->OffsetUnitMultiplier): ?>
										<div class="cancellation_policy"><?php _e('Non Refundable', 'OBPress_RoomPage') ?></div>
									<?php else: ?>
										<div class="cancellation_policy"><?php _e('Free Cancellation', 'OBPress_RoomPage') ?></div>
									<?php endif; ?>
								<?php elseif($cancellation->NonRefundable == false && ($cancellation->AmountPercent->Amount != 0 || $cancellation->AmountPercent->Percent != 0 || $cancellation->AmountPercent->NmbrOfNights != 0)): ?>
									<?php if($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d >= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
										<div class="cancellation_policy"><?php _e('Allow Cancellation', 'OBPress_RoomPage') ?></div>
									<?php elseif($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d <= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
										<div class="cancellation_policy"><?php _e('Non Refundable', 'OBPress_RoomPage') ?></div>
									<?php else: ?>
										<div class="cancellation_policy"><?php _e('Allow Cancellation', 'OBPress_RoomPage') ?></div>
									<?php endif; ?>
								<?php elseif($cancellation->NonRefundable == true): ?>
									<div class="cancellation_policy"><?php _e('Non Refundable', 'OBPress_RoomPage') ?></div>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>

						<div class="included">
							<?php if($rate_plan->MealsIncluded != null): ?>
								<span class="meals_included">
									<span class="dot">???</span> <?= $rate_plan->MealsIncluded->Name; ?>                                                                            
								</span>
							<?php endif; ?>


							<?php if($rate_plan->RatePlanInclusions != null): ?>
								<?php foreach($rate_plan->RatePlanInclusions as $included): ?>
									<span class="service_included">
										<span class="dot">???</span> <?= $included->RatePlanInclusionDesciption->Name ?>
									</span>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>

						<div class="single-room-rate-bottom">
							<?php if(isset($roomrate->Total->TPA_Extensions->TotalDiscountValue)): ?>
								<p class="price-before">
									<del>
										<?= Lang_Curr_Functions::ValueAndCurrencyCultureV4($roomrate->Total->TPA_Extensions->TotalDiscountValue+@$roomrate->Total->AmountBeforeTax, $currencies, $currency, $language) ?>
									</del>
								</p>
							<?php endif; ?>
							<div class="single-room-price-and-button">
								<div class="single-room-price">
									<p class="price-after <?php if($first_roomrate == true) echo 'best-price'; ?>">
										<?= Lang_Curr_Functions::ValueAndCurrencyCultureV4(@$roomrate->Total->AmountBeforeTax, $currencies, $currency, $language) ?>
									</p>
									<span class="single-tax-msg"><?php _e('Includes taxes and fees', 'OBPress_RoomPage') ?></span>
									<?php 
										if($first_roomrate == true) {
											$first_roomrate = false;
										}
									?>
								</div>

								<div class="single-room-button">
									<?php require(WP_PLUGIN_DIR . '/OBPress_SpecialOffersPage/widget/assets/templates/restrictions.php'); ?>
								</div>

							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>


			



		<?php endif; ?>
	<?php endforeach; ?>


	<?php if($availableRooms == 0): ?>

		<?php
			$all_room_rates = $data->getHotelsRoomRates2($property, $style);
			if($all_room_rates != null) {

				foreach($all_room_rates as $roomrate) {
					if($roomrate->RatePlanID == $RatePlanID) {
						$unavail_room_rate = $roomrate;
						break;
					}
				}
				if(!isset($unavail_room_rate)) {
					$unavail_room_rate = null;
				}
			}
			else {
				$unavail_room_rate = null;
			}

		?>

		<!-- Rates without prices set for a certain period of time - Hotel -->
		<?php if(!is_null($unavail_room_rate) && $unavail_room_rate->Availability[0]->WarningRPH == 407 || $unavail_room_rate == null): ?>
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

		<!-- 4. Hotel with no room available for the selected occupancy -->
		<?php elseif(@$unavail_room_rate->Availability[0]->WarningRPH == 397 || @$unavail_room_rate->Availability[0]->WarningRPH == 138 || @$unavail_room_rate->Availability[0]->WarningRPH == 142): ?>
			<div class="error_message_holder">
				<div class="error_message_left">
					<img class="error_info_icon" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/information-button-white.svg" ?>">
					<div class="error_message">
						<div class="error_message_description">
						`	<?php _e('There are no rooms available for the dates indicated.', 'OBPress_RoomPage') ?>
						</div>
					</div>
				</div>
				<button class="error_message_btn_occupancy">
					<?php _e('Change your search', 'OBPress_RoomPage') ?>
				</button>
			</div>
		<?php endif; ?>

	<?php endif; ?>

</div>