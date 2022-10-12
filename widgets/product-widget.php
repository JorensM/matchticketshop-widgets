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
    $legend_colors = [
        "#ACCA5A",
        "#93B8D2",
        "#93B8D2",
        "#93B8D2"
    ];

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

		return ['mts-style'];

	}

	protected function render() {
        global $product;

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

        // foreach($categories as $key => $category){
        //     if($category !== null){
        //         $category_prices[$key] = $category->get_regular_price();
        //     }else{
        //         $category_prices[$key] = "null";
        //     }
            
        // }
            //echo $product->get_id();

            //$product_id = $product->get_id();
            ?>  
                <span>Hello</span>
            <?php
	}
}