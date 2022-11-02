<span class='mts-product-title'><?php echo $product->get_name()?></span>
<div class='mts-info'>
                    <?php render_info("calendar.svg", $match_date) ?>
                    <span class='mts-info-spacer'></span>
                    <?php render_info("clock.svg", $match_time) ?>
                    <span class='mts-info-spacer'></span>
                    <?php render_info("location.svg", $match_location) ?>
                    <span class='mts-info-spacer'></span>
                    <?php render_info("trophy.svg", $match_championship) ?>
                    <span class='mts-info-spacer'></span>
                </div>
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

                <script>
                    const error_element = document.getElementById("mts-error");

                    const product_id = <?php echo $product->get_id() ?>

                    let total_price = 0;

                    const category_prices = [
                        <?php echo $category_prices[0] ?>,
                        <?php echo $category_prices[1] ?>,
                        <?php echo $category_prices[2] ?>,
                        <?php echo $category_prices[3] ?>,
                    ];

                    let tickets_qty = 1;
                    const tickets_qty_middle_element = document.getElementById("mts-tickets-qty");
                    const tickets_qty_subtract_element = document.getElementById("mts-tickets-qty-subtract");
                    render_tickets_subtract();

                    let selected_category = 1;
                    select_category(1);
                    

                    render_total_price();

                    function subtract_ticket(){
                        console.log("123");
                        if(tickets_qty > 1){
                            tickets_qty--;
                        }
                        render_tickets_select();
                        console.log("aaa");
                        render_total_price();
                    }

                    function add_ticket(){
                        
                        tickets_qty++;
                        render_tickets_select();
                        render_total_price();
                    }

                    function render_tickets_qty(){
                        tickets_qty_middle_element.innerHTML = tickets_qty + (tickets_qty > 1 ? " tickets" : " ticket");
                    }

                    function render_tickets_subtract(){
                        if(tickets_qty <= 1){
                            tickets_qty_subtract_element.classList.add("mts-tickets-qty-subtract-disabled");
                        }else{
                            tickets_qty_subtract_element.classList.remove("mts-tickets-qty-subtract-disabled");
                        }
                    }

                    function render_tickets_select(){
                        render_tickets_qty();
                        render_tickets_subtract();
                    }

                    function select_category(category_number){
                        selected_category = category_number;

                        const category_button_element = document.getElementById("mts-category-button-" + category_number);

                        deselect_all_categories();
                        
                        category_button_element.classList.add("mts-category-button-selected");
                        category_button_element.classList.add("mts-cat" + category_number + "-button-selected");

                        render_total_price();
                    }

                    function deselect_all_categories(){
                        for(let i = 1; i < 4; i++){
                            const category_button_element = document.getElementById("mts-category-button-" + i);

                            if(category_button_element !== null){
                                category_button_element.classList.remove("mts-category-button-selected");
                                category_button_element.classList.remove("mts-cat" + i + "-button-selected");
                            }
                        }
                    }

                    function render_total_price(){
                        console.log(category_prices);
                        console.log(tickets_qty);
                        total_price = category_prices[selected_category - 1] * tickets_qty;
                        console.log(total_price);
                        
                        const total_price_element = document.getElementById("mts-total-price");

                        total_price_element.innerHTML = total_price;
                    }

                    function goto_checkout(){
                        error_element.innerHTML = "";
                        const add_to_cart_url = "<?php echo plugins_url("add_to_cart.php", __FILE__) ?>";

                        const data = {
                            product_id: product_id,
                            category: selected_category,
                            qty: tickets_qty
                        }

                        const request = new Request(add_to_cart_url, {
                            method: "POST",
                            body: JSON.stringify(data)
                        })

                        fetch(request)
                        .then(response => response.text())
                        .then(data => {
                            console.log("success");
                            console.log(data);
                            if(data === '"success"'){
                                console.log("aaa");
                                window.location.href = "<?php echo wc_get_checkout_url(); ?>";
                            }
                        })
                        .catch(err => {
                            console.log("error");
                            console.log(err);
                            error_element.innerHTML = "Error: <br>" + err;
                        });
                    }

                </script>




<script>
                    const error_element = document.getElementById("mts-error");

                    const product_id = <?php echo $product->get_id() ?>

                    let total_price = 0;

                    const category_prices = [
                        <?php echo $category_prices[0] ?>,
                        <?php echo $category_prices[1] ?>,
                        <?php echo $category_prices[2] ?>,
                        <?php echo $category_prices[3] ?>,
                    ];

                    let tickets_qty = 1;
                    const tickets_qty_middle_element = document.getElementById("mts-tickets-qty");
                    const tickets_qty_subtract_element = document.getElementById("mts-tickets-qty-subtract");
                    render_tickets_subtract();

                    let selected_category = 1;
                    select_category(1);
                    select_cheapest_category();
                    

                    render_total_price();

                    function subtract_ticket(){
                        console.log("123");
                        if(tickets_qty > 1){
                            tickets_qty--;
                        }
                        render_tickets_select();
                        console.log("aaa");
                        render_total_price();
                    }

                    function add_ticket(){
                        
                        tickets_qty++;
                        render_tickets_select();
                        render_total_price();
                    }

                    function render_tickets_qty(){
                        tickets_qty_middle_element.innerHTML = tickets_qty + (tickets_qty > 1 ? " tickets" : " ticket");
                    }

                    function render_tickets_subtract(){
                        if(tickets_qty <= 1){
                            tickets_qty_subtract_element.classList.add("mts-tickets-qty-subtract-disabled");
                        }else{
                            tickets_qty_subtract_element.classList.remove("mts-tickets-qty-subtract-disabled");
                        }
                    }

                    function render_tickets_select(){
                        render_tickets_qty();
                        render_tickets_subtract();
                    }

                    function select_category(category_number){
                        selected_category = category_number;

                        const category_button_element = document.getElementById("mts-category-button-" + category_number);

                        deselect_all_categories();
                        
                        category_button_element.classList.add("mts-category-button-selected");
                        category_button_element.classList.add("mts-cat" + category_number + "-button-selected");

                        render_total_price();
                    }

                    function deselect_all_categories(){
                        for(let i = 1; i < 4; i++){
                            const category_button_element = document.getElementById("mts-category-button-" + i);

                            if(category_button_element !== null){
                                category_button_element.classList.remove("mts-category-button-selected");
                                category_button_element.classList.remove("mts-cat" + i + "-button-selected");
                            }
                        }
                    }

                    function render_total_price(){
                        console.log(category_prices);
                        console.log(tickets_qty);
                        total_price = category_prices[selected_category - 1] * tickets_qty;
                        console.log(total_price);
                        
                        const total_price_element = document.getElementById("mts-total-price");

                        total_price_element.innerHTML = total_price;
                    }

                    function select_cheapest_category(){
                        let min = 99999;
                        let min_index = -1;
                        category_prices.forEach((price, index) => {
                            if(price !== null && price < min){
                                min = price;
                                min_index = index;
                            }
                        })
                        console.log("prices: ");
                        console.log(category_prices);
                        console.log("cheapest category: ");
                        console.log(min);
                        console.log(min_index);
                        select_category(min_index + 1);
                    }

                    function goto_checkout(){
                        error_element.innerHTML = "";
                        const add_to_cart_url = "<?php echo plugins_url("add_to_cart.php", __FILE__) ?>";

                        const data = {
                            product_id: product_id,
                            category: selected_category,
                            qty: tickets_qty
                        }

                        const request = new Request(add_to_cart_url, {
                            method: "POST",
                            body: JSON.stringify(data)
                        })

                        fetch(request)
                        .then(response => response.text())
                        .then(data => {
                            console.log("success");
                            console.log(data);
                            if(data === '"success"'){
                                console.log("aaa");
                                window.location.href = "<?php echo wc_get_checkout_url(); ?>";
                            }
                        })
                        .catch(err => {
                            console.log("error");
                            console.log(err);
                            error_element.innerHTML = "Error: <br>" + err;
                        });
                    }

                </script>

<!-- NEW -->

<span class='mts-product-title'><?php echo $product->get_name()?></span>
                <div class='mts-v-spacer-s-mobile'></div>
                <div class='mts-info'>
                    <?php render_info("calendar.svg", $match_date) ?>
                    <span class='mts-info-spacer'></span>
                    <?php render_info("clock.svg", $match_time) ?>
                    <span class='mts-info-spacer'></span>
                    <?php render_info("location.svg", $match_location) ?>
                    <span class='mts-info-spacer'></span>
                    <?php render_info("trophy.svg", $match_championship) ?>
                    <span class='mts-info-spacer'></span>
                </div>
                <div class='mts-v-spacer-s-mobile'></div>
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
                                Total €<span id='mts-total-price'></span>
                            </div>
                        </div>
                    </div>
                    <div class='mts-v-spacer-s-mobile'></div>
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
                <div class='mts-v-spacer-s-mobile'></div>
                <script>
                    const error_element = document.getElementById("mts-error");

                    const product_id = <?php echo $product->get_id(); ?>

                    let total_price = 0;

                    const category_prices = [
                        <?php echo $category_prices[0]; ?>,
                        <?php echo $category_prices[1]; ?>,
                        <?php echo $category_prices[2]; ?>,
                        <?php echo $category_prices[3]; ?>,
                    ];

                    let tickets_qty = 1;
                    const tickets_qty_middle_element = document.getElementById("mts-tickets-qty");
                    const tickets_qty_subtract_element = document.getElementById("mts-tickets-qty-subtract");
                    render_tickets_subtract();

                    let selected_category = 1;
                    select_category(1);
                    select_cheapest_category();
                    

                    render_total_price();

                    function subtract_ticket(){
                        console.log("123");
                        if(tickets_qty > 1){
                            tickets_qty--;
                        }
                        render_tickets_select();
                        console.log("aaa");
                        render_total_price();
                    }

                    function add_ticket(){
                        
                        tickets_qty++;
                        render_tickets_select();
                        render_total_price();
                    }

                    function render_tickets_qty(){
                        tickets_qty_middle_element.innerHTML = tickets_qty + (tickets_qty > 1 ? " tickets" : " ticket");
                    }

                    function render_tickets_subtract(){
                        if(tickets_qty <= 1){
                            tickets_qty_subtract_element.classList.add("mts-tickets-qty-subtract-disabled");
                        }else{
                            tickets_qty_subtract_element.classList.remove("mts-tickets-qty-subtract-disabled");
                        }
                    }

                    function render_tickets_select(){
                        render_tickets_qty();
                        render_tickets_subtract();
                    }

                    function select_category(category_number){
                        selected_category = category_number;

                        const category_button_element = document.getElementById("mts-category-button-" + category_number);

                        deselect_all_categories();
                        
                        category_button_element.classList.add("mts-category-button-selected");
                        category_button_element.classList.add("mts-cat" + category_number + "-button-selected");

                        render_total_price();
                    }

                    function deselect_all_categories(){
                        for(let i = 1; i < 4; i++){
                            const category_button_element = document.getElementById("mts-category-button-" + i);

                            if(category_button_element !== null){
                                category_button_element.classList.remove("mts-category-button-selected");
                                category_button_element.classList.remove("mts-cat" + i + "-button-selected");
                            }
                        }
                    }

                    function render_total_price(){
                        console.log(category_prices);
                        console.log(tickets_qty);
                        total_price = category_prices[selected_category - 1] * tickets_qty;
                        console.log(total_price);
                        
                        const total_price_element = document.getElementById("mts-total-price");

                        total_price_element.innerHTML = total_price;
                    }

                    function select_cheapest_category(){
                        let min = 99999;
                        let min_index = -1;
                        category_prices.forEach((price, index) => {
                            if(price !== null && price < min){
                                min = price;
                                min_index = index;
                            }
                        })
                        console.log("prices: ");
                        console.log(category_prices);
                        console.log("cheapest category: ");
                        console.log(min);
                        console.log(min_index);
                        select_category(min_index + 1);
                    }

                    function goto_checkout(){
                        error_element.innerHTML = "";
                        const add_to_cart_url = "<?php echo plugins_url("add_to_cart.php", __FILE__) ?>";

                        const data = {
                            product_id: product_id,
                            category: selected_category,
                            qty: tickets_qty
                        }

                        const request = new Request(add_to_cart_url, {
                            method: "POST",
                            body: JSON.stringify(data)
                        })

                        fetch(request)
                        .then(response => response.text())
                        .then(data => {
                            console.log("success");
                            console.log(data);
                            if(data === '"success"'){
                                console.log("aaa");
                                window.location.href = "<?php echo wc_get_checkout_url(); ?>";
                            }
                        })
                        .catch(err => {
                            console.log("error");
                            console.log(err);
                            error_element.innerHTML = "Error: <br>" + err;
                        });
                    }

                </script>