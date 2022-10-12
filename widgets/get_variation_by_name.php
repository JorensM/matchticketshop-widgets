<?php

    require_once("wp_init.php");

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