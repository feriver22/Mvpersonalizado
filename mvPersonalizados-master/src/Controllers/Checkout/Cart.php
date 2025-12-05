<?php

namespace Controllers\Checkout;

use Dao\Cart\Cart as CartDao;
use Dao\Products\Products as ProductsDao;

class Cart extends \Controllers\PrivateController
{
    public function run() :void
    {
        $cart = $_SESSION['cart'] ?? [];
        $total = 0;
        $items = [];

        foreach ($cart as $product_id => $quantity) {
            $product = ProductsDao::getById($product_id);
            if ($product) {
                $item_total = $product->price * $quantity;
                $total += $item_total;
                $items[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'total' => $item_total,
                    'image_url' => $product->image_url
                ];
            }
        }

        $data = [
            "pageTitle" => "Mi Carrito de Compras",
            "items" => $items,
            "total" => $total
        ];

        $this->render("checkout/cart", $data);
    }
}
?>
