<?php

namespace AcmeWidget;

class DeliveryCalculator {
    private $rules;

    public function __construct(array $rules) {
        $this->rules = $rules;
    }

    public function getDeliveryCost(float $subtotal): float {
        foreach ($this->rules as $threshold => $cost) {
            if ($subtotal < $threshold) {
                return $cost;
            }
        }
        return 0; // Free delivery for higher values
    }
}



?>