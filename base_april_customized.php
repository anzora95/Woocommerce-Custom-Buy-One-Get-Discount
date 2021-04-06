<?php
add_action('woocommerce_cart_calculate_fees', 'add_custom_discount_2nd_at_50', 10, 1 );
function add_custom_discount_2nd_at_50( $wc_cart ){
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
    $discount = 0;
    $items_prices = array();
    $a=0;

    // Set HERE your targeted variable product ID
    $targeted_product_id = "834"; //producto targeted

    foreach ( $wc_cart->get_cart() as $key => $cart_item ) {                      //for each de cada producto
        //if( $cart_item['product_id'] == $targeted_product_id ){                   //cada uno de los elementos del carro evaluados si el id es igual al del targeted
            $qty = intval( $cart_item['quantity'] );                              //transforma la cantidad de elementos en el carro en enteros
            for( $i = 0; $i < $qty; $i++ )                                        //recorre los elementos en el carro
                $items_prices[] = floatval( $cart_item['data']->get_price());     //agrega cada uno de los precios del carro a un arreglo
        //}
    }
    $count_items_prices = count($items_prices);                                   //cuenta cuantos elementos hay en el arreglo de precios
    if( $count_items_prices > 1 ){                                                 // si hay algun elemento en el arreglo (osea > 1)
      foreach( $items_prices as $key => $price ) {                                   // $items_prices en el for each
          $a++;                                                                     //contador para cada itereacion
          if ($a == 2) {                                                            // evalua si es la segunda iteracion
            $discount -= number_format($price / 2, 2 );                             //si es la segunda itereacion que divida el precio entre 2 y que le de formato de dos decimales
            break;                                                                  // que haga el break
          }
        }
    }



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
