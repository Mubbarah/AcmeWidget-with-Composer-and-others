<?php

namespace AcmeWidget;

class Product {
    public $code;
    public $name;
    public $price;

    public function __construct($code, $name, $price) {
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
    }
}

?>