<?php

$category_colors = [
    [
        "regular" => "#93B8D2",
        "dark" => "#6791AF",
        "light" => "#bed4e2"
    ],
    [
        "regular" => "#ACCA5A",
        "light" => "#EAF2D6",
        "dark" => "#97b73e"
    ],[
        "regular" => "#93B8D2",
        "dark" => "#6791AF",
        "light" => "#bed4e2"
    ],[
        "regular" => "#93B8D2",
        "dark" => "#6791AF",
        "light" => "#bed4e2"
    ],
];

$legend_colors = [
    "#ACCA5A",
    "#93B8D2",
    "#93B8D2",
    "#93B8D2"
];

$category_labels = [
    "Category 1",
    "Category 2",
    "Category 3",
    "Category 4",
];

function render_info($icon_filename, $text){
    echo 
        "<div class='mts-info-single'>
            <img src='" . get_stylesheet_directory_uri() . "/icons/" . $icon_filename . "'/>&nbsp;&nbsp;" . $text .
        "</div>";
}

function render_category_button(WC_Product_Variation $category, $index){
    global $category_labels;
    global $category_colors;

    $label = $category_labels[$index];
    $colors = $category_colors[$index];
    $price = $category->get_regular_price();

    echo 
        "<div 
            id='mts-category-button-" . ($index + 1) . "'
            class='mts-category-button mts-cat" . ($index + 1) . "-button'
            onclick='select_category(" . ($index + 1) . ")'
        >
        <span class='mts-category-button-label'>" . $label . "</span>
        <span class='mts-category-button-price'>$" . $price . "</span>
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
    global $legend_colors;

    foreach($categories as $key => $category){
        if($category !== null){
            echo 
                "<div class='mts-legend-single'>
                    <div class='mts-legend-box' style='background-color: " . $legend_colors[$key] . "'>
                    </div>
                    &nbsp;
                    &nbsp;
                    <span class='mts-legend-label'>
                    Category " . $key + 1 . "
                    </span>
                </div>";
        }
    }
    
}

$product = wc_get_product();

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

class Elementor_Product_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'product-widget';
	}

	public function get_title() {
		return esc_html__( 'Custom Product Widget', '' );
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
		//wp_register_style( 'widget-style-2', plugins_url( 'assets/css/widget-style-2.css', __FILE__ ), [ 'external-framework' ] );
		//wp_register_style( 'external-framework', plugins_url( 'assets/css/libs/external-framework.css', __FILE__ ) );

		return ['mts-style'];

	}

	protected function render() {
        global $product;
        // global $match_date;
        // global $match_time;
        // global $match_location;
        // global $match_championship;
        global $team_1_img_url;
        global $team_2_img_url;
        global $categories;
        global $stadium_img_url;

        $match_date = date("l, j F", strtotime($product->get_meta("match-date")));
        $match_time = $product->get_meta("match-time");
        $match_location = $product->get_meta("match-location");
        $match_championship = $product->get_meta("championship-name");
            ?>
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
            
            <?php
	}
}