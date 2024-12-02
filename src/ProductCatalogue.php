<?php

namespace AcmeWidget;

class ProductCatalogue {
    private $products = [];

    public function addProduct($product) {
        $this->products[$product->code] = $product;
    }

    public function getProduct($code) {
        return $this->products[$code] ?? null;
    }
}


?>