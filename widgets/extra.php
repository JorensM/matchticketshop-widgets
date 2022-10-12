<div class='mts-product-info'>
                    <div class='mts-product-info-left'>
                        <div class='mts-tickets'>
                            <div class='mts-tickets-top'>
                                <div class='mts-tickets-title'>
                                    CHOOSE A CATEGORY OF SEATS
                                </div>
                                <img class='mts-tickets-club' src='<?php echo $team_1_img_url; ?>'>
                                <img class='mts-tickets-club' src='<?php echo $team_2_img_url; ?>'>
                            </div>
                            <div class='mts-tickets-middle'>
                                <div class='mts-tickets-middle-wrap'>
                                    <?php
                                        foreach($categories as $index => $category){
                                            if($category !== null){
                                                render_category_button($category, $index);
                                            }
                                        }
                                    ?>
                                    <div class='mts-tickets-select'>
                                        <div class='mts-tickets-select-left'>
                                            <div class='mts-tickets-qty'>
                                                <div id='mts-tickets-qty-subtract' class='mts-tickets-qty-subtract' onclick='subtract_ticket()'>
                                                    -
                                                </div>
                                                <div id='mts-tickets-qty' class='mts-tickets-qty-middle'>
                                                    1 ticket
                                                </div>
                                                <div id='mts-tickets-qty-add' class='mts-tickets-qty-add' onclick='add_ticket()'>
                                                    +
                                                </div>
                                            </div>
                                        </div>
                                        <div class='mts-tickets-select-right'>
                                            <div class='mts-buy-tickets' onclick='goto_checkout()'>
                                                BUY TICKETS
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span id='mts-error'></span>
                            <div class='mts-tickets-bottom'>
                                Total: $<span id='mts-total-price'></span>
                            </div>
                        </div>
                    </div>
                    <div class='mts-product-info-right'>
                        <div class="mts-product-info-img">
                            <img src="<?php echo $stadium_img_url ?>">
                        </div>
                        <br>
                        <div class='mts-product-info-legend'>
                            <?php render_legend($categories) ?>
                        </div>
                    </div>
                </div>