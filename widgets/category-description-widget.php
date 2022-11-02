<?php

function get_current_category(){
    //$category = get_term_by("slug", "newcastle-united", "category");
    return get_queried_object();
}

class Elementor_Category_Description_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'category-description-widget';
	}

	public function get_title() {
		return esc_html__( 'Category Description Widget', '' );
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

	// public function register_controls(){

		

	// }

	protected function render() {

        $category = get_current_category();
		//echo "hello";
		echo "<pre>";
		print_r($category);
		echo "</pre>";
		//$cat_slug = $category->slug;
		//echo $cat_slug;

		//$file_url = wp_upload_dir()["url"] . "/" . $cat_slug . ".txt";
		//echo $file_url;
		//$text = file_get_contents($file_url);

        
		//echo "<pre>" . $text . "</pre>";
		//echo nl2br($text);
        ?>  
                
        <?php
	}
}