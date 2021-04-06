<?php
add_action('woocommerce_cart_calculate_fees', 'add_custom_discount_2nd_at_50', 10, 1 );
function add_custom_discount_2nd_at_50( $wc_cart ){
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
    $discount = 0;
    $items_prices = array();

    // Set HERE your targeted variable product ID
    // adding all products id to array
    $all_ids = get_posts( array(
     'post_type' => 'product',
     'numberposts' => -1,
     'post_status' => 'publish',
     'fields' => 'ids',
    ) );

    $targeted_product_id = 40; //products id when use specific product


    foreach ( $wc_cart->get_cart() as $key => $cart_item ) {
      //second foreach start here
      foreach ($all_ids as $id ) {
        // code...
          if( $cart_item['product_id'] == $id ){  //compare with each product id
              $qty = intval( $cart_item['quantity'] );
              for( $i = 0; $i < $qty; $i++ )
                  $items_prices[] = floatval( $cart_item['data']->get_price());
                }
        }
        //second foreach ends here
    }

    $count_items_prices = count($items_prices);
    if( $count_items_prices > 1 ) foreach( $items_prices as $key => $price )
        if( $key % 2 == 1 ) $discount -= number_format($price / 2, 2 );

    if( $discount != 0 ){
        // Displaying a custom notice (optional)
        wc_clear_notices();
        wc_add_notice( __("You get 50% of discount on the 2nd item"), 'notice');

        // The discount
        $wc_cart->add_fee( 'Discount 2nd at 50%', $discount, true  );
        # Note: Last argument in add_fee() method is related to applying the tax or not to the discount (true or false)
    }
}
 ?>
