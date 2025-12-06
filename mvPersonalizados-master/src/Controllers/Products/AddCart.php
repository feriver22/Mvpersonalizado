<?php

namespace Controllers\Products;

class AddCart extends \Controllers\PublicController
{
    public function run() :void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $product_id = $data['product_id'] ?? 0;
        $quantity = $data['quantity'] ?? 1;

        if (!$product_id || $quantity < 1) {
            http_response_code(400);
            echo json_encode(['error' => 'Parámetros inválidos']);
            return;
        }

        $product = \Dao\Products\Products::getById($product_id);
        if (!$product || $product->quantity < $quantity) {
            http_response_code(400);
            echo json_encode(['error' => 'Producto no disponible o cantidad insuficiente']);
            return;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $quantity_int = (int)$quantity;
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity_int;
        } else {
            $_SESSION['cart'][$product_id] = $quantity_int;
        }

        $cartCount = array_sum($_SESSION['cart']);

        echo json_encode([
            'success' => true,
            'cartCount' => $cartCount,
            'message' => 'Producto agregado al carrito'
        ]);
    }
}
?>
