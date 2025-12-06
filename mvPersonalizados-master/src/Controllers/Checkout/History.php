<?php

namespace Controllers\Checkout;

use Dao\Cart\Cart as CartDao;

class History extends \Controllers\PrivateController
{
    public function run() :void
    {
        $transactions = CartDao::getTransactionsByUser($this->userId);

        $data = [
            "pageTitle" => "Histórco de Mis Compras",
            "transactions" => $transactions
        ];

        $this->render("checkout/history", $data);
    }
}
?>
