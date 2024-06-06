<?php

namespace App\Models;

class Cart
{
    public static function add(Product $product)
    {
        // add the product to cart
        \Cart::session(userID())->add(
            array(
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->sale_price,
                'quantity' => 1,
                'attributes' => array(),
                'associatedModel' => $product
            )

        );
    }

    // Get cart items
    public static function getCart()
    {
        $cart = \Cart::session(userID())->getContent();

        return $cart->sort();
    }

    //Return charts total
    public static function getTotal()
    {
        return \Cart::session(userId())->getTotal();
    }

    public static function decrement($id)
    {
        \Cart::session(userId())->update($id, [
            'quantity' => -1
        ]);
    }

    public static function increment($id)
    {
        \Cart::session(userId())->update($id, [
            'quantity' => +1
        ]);
    }

    public static function removeItem($id)
    {
        \Cart::session(userId())->remove($id);
    }

    public static function clear()
    {
        \Cart::session(userId())->clear();
    }

    public static function totalItems()
    {
        return \Cart::session(userId())->getTotalQuantity();
    }


}
