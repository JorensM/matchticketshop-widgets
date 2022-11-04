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
            class='mts-category-button'
            onclick='select_category(" . ($index + 1) . ")'
        >
        <div class='mts-cat-box mts-cat" . ($index + 1) . "-box'></div>
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

function css_hook(){
    echo "
            <link
            rel='stylesheet'
            href='https://unpkg.com/tippy.js@6/themes/light.css'
        />
    ";
}

add_action("wp_head", "css_hook");

function team_names_from_product($product_name){
    $name = str_replace("Tickets ", "", $product_name);
    $output = explode("vs.", $name);
    return $output;
}


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

        $match_date = null;
        $match_time = null;
        $match_location = null;
        $match_championship = null;
        $team_1_img_url = null;
        $team_2_img_url = null;
        $stadium_img_url = null;
        $categories = null;

        if(!\Elementor\Plugin::$instance->editor->is_edit_mode()){
            $match_date = date("l, j F", strtotime($product->get_meta("match-date")));
            $match_date_new = date("j F o", strtotime($product->get_meta("match-date")));
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

            $team_names = team_names_from_product($product->get_name());
        }
        

            if(\Elementor\Plugin::$instance->editor->is_edit_mode()){
                echo "Product Widget";
            }else{
                ?>
                <script src="https://unpkg.com/@popperjs/core@2"></script>
                <script src="https://unpkg.com/tippy.js@6"></script>
                <div class='mts-product-header'>
                    <div class="mts-product-header-overlay">
                        
                    </div>
                    <div class="mts-product-header-left">
                        <img class='mts-tickets-club' src='<?php echo $team_1_img_url; ?>'>
                        <?php echo $team_names[0]; ?>
                    </div>
                    <div class="mts-product-header-middle">
                        <div class='mts-product-header-middle-top'>
                            <img class='mts-product-header-stadium-img' src='<?php echo $team_1_img_url; ?>'>
                        </div>
                        <span class='mts-product-header-vs'>VS</span>
                        <div class='mts-product-header-middle-spacer'></div>
                        <div class='mts-product-header-middle-bottom'>
                            <span class='mts-product-header-stadium'><?php echo $match_location ?></span>
                            <span class='mts-product-header-date'><?php echo $match_date_new ?> <?php echo $match_time ?></span>
                        </div>
                    </div>
                    <div class="mts-product-header-right">
                        <img class='mts-tickets-club' src='<?php echo $team_2_img_url; ?>'>
                        <?php echo $team_names[1]; ?>
                    </div>
                </div>
                <div class='mts-product-info' id="mts-product-info">
                    <div class='mts-product-info-left'>
                        <div class="mts-tickets-cats" id="mts-tickets-cats">
                            <div class='mts-tickets-title'>
                                CHOOSE A CATEGORY OF SEATS
                            </div>
                            <div class='mts-tickets-top'>
                                <div class='mts-tickets-top-wrap'>
                                    <span>Category</span>
                                    <span>Price</span>
                                </div>
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
                                </div>
                            </div>
                        </div>
                        
                        <div class='mts-tickets'>
                            
                            <div class='mts-choose-qty'>Choose Quantity</div>
                            <div class='mts-tickets-select'>
                                <div class='mts-tickets-select-left'>
                                    <div class='mts-tickets-qty'>
                                        <div id='mts-tickets-qty-subtract' class='mts-tickets-qty-subtract' onclick='subtract_ticket()'>
                                            ─
                                        </div>
                                        <div id='mts-tickets-qty' class='mts-tickets-qty-middle'>
                                            1 ticket
                                        </div>
                                        <div id='mts-tickets-qty-add' class='mts-tickets-qty-add' onclick='add_ticket()'>
                                            +
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span id='mts-error'></span>
                            <div class='mts-tickets-bottom'>
                                <div class="mts-tickets-total">
                                    <div class='mts-tickets-total-left'>Total: &nbsp;</div>
                                    <div class='mts-tickets-total-right'>€<span id='mts-total-price'></span></div>
                                </div>
                                <div class='mts-buy-tickets' onclick='goto_checkout()'>
                                    BUY TICKETS
                                </div>
                                <!-- <div class='mts-tickets-total'>
                                    Total €<span id='mts-total-price'></span>
                                </div>
                                <div class='mts-buy-tickets' onclick='goto_checkout()'>
                                    BUY TICKETS
                                </div> -->
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
                    const vp_width = document.documentElement.clientWidth;

                    const tooltip = tippy("#mts-tickets-qty-add", {
                        placement: (() => {
                            if(vp_width < 1000){
                                return "top";
                            }else{
                                return "right";
                            }
                        })(),
                        theme: "light",
                        maxWidth: "180px",
                        onHide: () => {
                            if(tickets_qty > 1){
                                return false;
                            }
                            return true;
                        }
                    })[0];
                    tooltip.disable();

                    const cats_element = document.getElementById("mts-tickets-cats");
                    const info_element = document.getElementById("mts-product-info");

                    if(vp_width < 1000){
                        info_element.appendChild(cats_element);
                    }

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

                        if(tickets_qty > 1){
                            tooltip.show();
                        }else{
                            tooltip.hide();
                        }
                        
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

                        if(tickets_qty === 1){
                            console.log("one");
                            tooltip.disable();
                        }
                        if(tickets_qty === 2){
                            console.log("two");
                            tooltip.enable();
                            tooltip.setContent("We guarantee that you will be seated together");
                            //tooltip.show();
                        }else if(tickets_qty > 2){
                            console.log("three");
                            tooltip.setContent("You will likely be seated together, please reach out through chat so our team can confirm");
                            tooltip.enable();
                            //tooltip.show();
                        }
                    }

                    function select_category(category_number){
                        selected_category = category_number;

                        const category_button_element = document.getElementById("mts-category-button-" + category_number);

                        deselect_all_categories();
                        
                        category_button_element.classList.add("mts-category-button-selected");
                        //category_button_element.classList.add("mts-cat" + category_number + "-button-selected");

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
        ?>      

                
                
        <?php
	}
}