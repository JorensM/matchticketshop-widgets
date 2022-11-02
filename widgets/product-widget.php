<?php

// $category_colors = [
//     [
//         "regular" => "#93B8D2",
//         "dark" => "#6791AF",
//         "light" => "#bed4e2"
//     ],
//     [
//         "regular" => "#ACCA5A",
//         "light" => "#EAF2D6",
//         "dark" => "#97b73e"
//     ],[
//         "regular" => "#93B8D2",
//         "dark" => "#6791AF",
//         "light" => "#bed4e2"
//     ],[
//         "regular" => "#93B8D2",
//         "dark" => "#6791AF",
//         "light" => "#bed4e2"
//     ],
// ];

// $legend_colors = [
//     "#ACCA5A",
//     "#93B8D2",
//     "#93B8D2",
//     "#93B8D2"
// ];

// $category_labels = [
//     "Category 1",
//     "Category 2",
//     "Category 3",
//     "Category 4",
// ];

function render_info($icon_filename, $text){
    echo 
        "<div class='mts-info-single'>
            <img src='" . plugins_url("icons/", __FILE__) . $icon_filename . "'/>&nbsp;&nbsp;" . $text .
        "</div>";
}

function render_category_button(WC_Product_Variation $category, $index){
    $category_labels = [
        "Category 1",
        "Category 2",
        "Category 3",
        "Category 4",
    ];

    $label = $category_labels[$index];
    //$colors = $category_colors[$index];
    $price = $category->get_regular_price();

    echo 
        "<div 
            id='mts-category-button-" . ($index + 1) . "'
            class='mts-category-button mts-cat" . ($index + 1) . "-button'
            onclick='select_category(" . ($index + 1) . ")'
        >
        <span class='mts-category-button-label'>" . $label . "</span>
        <span class='mts-category-button-price'>€" . $price . "</span>
        </div>";
}

function generate_match_title($match){
    return "Tickets " . $match["home_club"] . " vs. " . $match["away_club"];
}

function get_variation_by_name(WC_Product_Variable $product, $variation_name){
    $full_name = $product->get_name() . " - " . $variation_name;

    $variations = $product->get_available_variations("objects");
    foreach($variations as $variation){
        if($variation->get_name() === $full_name){
            return $variation;
        }
    }
    return null;
}

function render_legend($categories){
    $legend_colors = [
        "#ACCA5A",
        "#93B8D2",
        "#F8B65F",
        "#f78b8b"
    ];

    $legend_colors_dark = [
        "#6791AF",
        "#97b73e",
        "#e29631",
        "#db4e4e"
    ];

    foreach($categories as $key => $category){
        if($category !== null){
            echo 
                "<div 
                    class='mts-legend-single mts-legend-cat" . $key + 1 . "'
                    onclick='select_category(" . ($key + 1) . ")'
                >
                        <div class='mts-legend-box mts-legend-box-cat" . $key + 1 . "'>
                        </div>
                        <span style='width: 15px'></span>
                        <span class='mts-legend-label'>
                        Category " . $key + 1 . "
                        </span>
                </div>";
        }
    }
    
}

//$product = wc_get_product();

// $match_date = date("l, j F", strtotime($product->get_meta("match-date")));
// $match_time = $product->get_meta("match-time");
// $match_location = $product->get_meta("match-location");
// $match_championship = $product->get_meta("championship-name");

// $team_1_img_url = $product->get_meta("1st-team-image");
// $team_2_img_url = $product->get_meta("2nd-team-image");
// $stadium_img_url = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'single-post-thumbnail' )[0];

// $categories = [
//     get_variation_by_name($product, "Category 1"),
//     get_variation_by_name($product, "Category 2"),
//     get_variation_by_name($product, "Category 3"),
//     get_variation_by_name($product, "Category 4")
// ];

// $category_prices = [];

// foreach($categories as $key => $category){
//     if($category !== null){
//         $category_prices[$key] = $category->get_regular_price();
//     }else{
//         $category_prices[$key] = "null";
//     }
    
// }

function product_widget_attributes($tag, $handle) {
    global $product;
    //print_r($product);
    //echo $product->get_id();
    # add script handles to the array below
    $scripts_to_defer = array('product-widget');
    
    

    foreach($scripts_to_defer as $defer_script) {
       if ($defer_script === $handle) {
          return str_replace(' src', '  product-id="' . $product->get_id() . '" src', $tag);
       }
    }
    return $tag;
 }

function after_page_load(){
    add_filter('script_loader_tag', "product_widget_attributes", 10, 2);
}

add_action("wp_loaded", "after_page_load");


class Elementor_Product_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'product-widget';
	}

	public function get_title() {
		return esc_html__( 'Custom Product Widget', 'mts-widget' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'basic' ];
	}

	public function get_keywords() {
		return [ 'hello', 'world' ];
	}

    public function get_style_depends() {

		wp_register_style( 'mts-style', plugins_url( 'style.css', __FILE__ ) );

		return ['mts-style'];

	}

    public function get_script_depends() {
		wp_register_script( 'product-widget', plugins_url( 'js/product-widget.js', __FILE__ ) );

        //add_filter('script_loader_tag', "product_widget_attributes", 10, 2);

		return ["product-widget"];

	}

	protected function render() {
        global $product;

        $test = "123";

        $match_date = date("l, j F", strtotime($product->get_meta("match-date")));
        $match_time = $product->get_meta("match-time");
        $match_location = $product->get_meta("match-location");
        $match_championship = $product->get_meta("championship-name");

        $team_1_img_url = $product->get_meta("1st-team-image");
        $team_2_img_url = $product->get_meta("2nd-team-image");
        $stadium_img_url = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'single-post-thumbnail' )[0];

        $categories = [
            get_variation_by_name($product, "Category 1"),
            get_variation_by_name($product, "Category 2"),
            get_variation_by_name($product, "Category 3"),
            get_variation_by_name($product, "Category 4")
        ];

        foreach($categories as $key => $category){
            if($category !== null){
                $category_prices[$key] = $category->get_regular_price();
            }else{
                $category_prices[$key] = "null";
            }
            
        }
            setcookie("checkout_url", wc_get_checkout_url());
        ?>  
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
        <?php
	}
}