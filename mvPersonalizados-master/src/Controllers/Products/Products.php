<?php

namespace Controllers\Products;

use Dao\Products\Products as ProductsDao;

class Products extends \Controllers\PublicController
{
    public function run() :void
    {
        $products = ProductsDao::getAll();
        
        $data = [
            "pageTitle" => "Catálogo de Productos",
            "products" => $products
        ];
        
        $this->render("products/products", $data);
    }
}
?>
