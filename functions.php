<?php

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	//remove sorting option drop down in product listing page
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	
	//add attribute label row before the loop
	add_action( 'woocommerce_before_shop_loop', 'woo_attribute_label', 50);
	if (!function_exists('woo_attribute_label')) {
		function woo_attribute_label() {
			echo '<div class="product_label">' .
				'<div class="column">OEM PART NO.</div>' . 
				'<div class="column">BRAND</div>' .
				'<div class="column">FILTER STYLE</div>' .
				'<div class="column">SIDCO PART NO.</div>' .
				'<div class="column">&nbsp;</div>' .
				'</div>';
		}
	}
	
	// Display 40 products per page.
	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 40;' ), 20 );
	
	//Display 1 product per row
	add_filter('loop_shop_columns', 'loop_columns');
	if (!function_exists('loop_columns')) {
		function loop_columns() {
			return 1; // 3 products per row
		}
	}

    // remove default woocommerce actions
    function woo_product_listing_modifications()
    {
        // hide product price on category page
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
		remove_action ( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
    }

    add_action( 'init', 'woo_product_listing_modifications' );
	
	//remove price from single product page
	remove_action ( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
	
	//remove related products from single product page
	remove_action ( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
	
}

 
?>