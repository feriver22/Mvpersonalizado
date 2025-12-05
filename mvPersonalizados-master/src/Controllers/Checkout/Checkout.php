<?php

namespace Controllers\Checkout;

use Dao\Cart\Cart as CartDao;

class Checkout extends \Controllers\PrivateController
{
    public function run() :void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processCheckout();
            return;
        }

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            \Utilities\Site::redirectTo("index.php?page=Checkout_Cart");
            return;
        }

        $total = 0;
        foreach ($cart as $product_id => $quantity) {
            $product = \Dao\Products\Products::getById($product_id);
            if ($product) {
                $total += $product->price * $quantity;
            }
        }

        $data = [
            "pageTitle" => "Proceder al Pago",
            "total" => $total,
            "cart" => $cart
        ];

        $this->render("checkout/checkout", $data);
    }

    private function processCheckout()
    {
        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            \Utilities\Site::redirectToWithMsg("index.php?page=Checkout_Cart", "El carrito está vacío");
            return;
        }

        $total = 0;
        foreach ($cart as $product_id => $quantity) {
            $product = \Dao\Products\Products::getById($product_id);
            if ($product) {
                $total += $product->price * $quantity;
            }
        }

        // Crear transacción
        $transaction_id = CartDao::createTransaction($this->userId, $total, 'PENDING');
        
        if (!$transaction_id) {
            \Utilities\Site::redirectToWithMsg("index.php?page=Checkout_Checkout", "Error al crear la transacción");
            return;
        }

        // Agregar items a la transacción
        foreach ($cart as $product_id => $quantity) {
            $product = \Dao\Products\Products::getById($product_id);
            if ($product) {
                CartDao::addTransactionItem($transaction_id, $product_id, $quantity, $product->price);
            }
        }

        // Simular procesamiento de pago PayPal
        $this->simulatePayment($transaction_id);
    }

    private function simulatePayment($transaction_id)
    {
        // Simular respuesta exitosa de PayPal
        $paypal_order_id = "PP_" . uniqid();
        
        CartDao::updateTransactionStatus($transaction_id, 'COMPLETED', $paypal_order_id);

        // Limpiar carrito de sesión
        unset($_SESSION['cart']);

        \Utilities\Site::redirectToWithMsg(
            "index.php?page=Checkout_Success&transaction_id=" . $transaction_id,
            "¡Pago realizado exitosamente!"
        );
    }
}
?>
