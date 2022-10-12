<?php

    //echo json_encode("hello");    

    require_once("wp_init.php");
    require_once("get_variation_by_name.php");

    $_POST = json_decode(file_get_contents("php://input"), true);

    //echo json_encode($_POST);



    $category = $_POST["category"];
    $qty = $_POST["qty"];
    $product_id = $_POST["product_id"];

    

    $product = new WC_Product_Variable($product_id);

    $variation = get_variation_by_name($product, "Category " . $category);

    $variation_id = $variation->get_id();

    WC()->cart->empty_cart();

    WC()->cart->add_to_cart($product_id, $qty, $variation_id);

    echo json_encode("success");