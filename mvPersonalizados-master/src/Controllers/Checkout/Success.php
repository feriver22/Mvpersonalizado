<?php

namespace Controllers\Checkout;

use Dao\Cart\Cart as CartDao;

class Success extends \Controllers\PrivateController
{
    public function run() :void
    {
        $transaction_id = $_GET['transaction_id'] ?? 0;
        
        if (!$transaction_id) {
            \Utilities\Site::redirectTo("index.php?page=Checkout_History");
            return;
        }

        $transaction = CartDao::getTransactionById($transaction_id);
        
        if (!$transaction || $transaction->user_id != $this->userId) {
            \Utilities\Site::redirectToWithMsg("index.php?page=Checkout_History", "Transacción no encontrada");
            return;
        }

        $items = CartDao::getTransactionItems($transaction_id);

        $data = [
            "pageTitle" => "Pago Exitoso",
            "transaction" => $transaction,
            "items" => $items
        ];

        $this->render("checkout/success", $data);
    }
}
?>
