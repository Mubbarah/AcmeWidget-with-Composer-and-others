<?php

namespace AcmeWidget;

class Basket {
    private $catalogue;
	private $deliveryCalculator;
    private $items = [];
    private $deliveryRules;
    private $offers;

    public function __construct(ProductCatalogue $catalogue, DeliveryCalculator $deliveryCalculator, $offers = null, $deliveryRules = null) {
        $this->catalogue = $catalogue;
        $this->deliveryCalculator = $deliveryCalculator;
        $this->offers = $offers; // Handle offers logic if needed
		$this->deliveryRules = $deliveryRules;
    }

    public function getItems() {
        return $this->items;
    }

    public function add($productCode) {
	    $product = $this->catalogue->getProduct($productCode);

	    if ($product) {
	        $this->items[] = $productCode;
	    } else {
	        // Store invalid product codes in a static property or a temporary array
	        if (!isset($this->invalidProducts)) {
	            $this->invalidProducts = [];
	        }
	        $this->invalidProducts[] = $productCode;
	    }
	}

	public function checkInvalidProducts() {
	    if (!empty($this->invalidProducts)) {
	        $invalidCodes = implode(', ', $this->invalidProducts);
	        throw new Exception("The following product codes are not available: {$invalidCodes}");
	    }
	}

	public function subtotal() {
	    if (empty($this->items)) {
	        return 0; // Return 0 if no items in the basket
	    }

	    $subtotal = 0;
	    foreach ($this->items as $item) {
	        $product = $this->catalogue->getProduct($item);
	        $subtotal += $product->price;
	    }
	    return $subtotal;
	}

    public function deliveryCharge() {
	    $subtotal = $this->subtotal();

	    if ($subtotal === 0) {
	        return 0; // No delivery charge for an empty basket
	    }

	    if ($subtotal < 50) {
	        return 4.95;
	    } elseif ($subtotal < 90) {
	        return 2.95;
	    }
	    return 0; // Free delivery for $90 or more
	}

    public function total() {
        // Calculate base total

    	if (empty($this->items)) {
	        return 0; // Return 0 if no items in the basket
	    }

        $total = 0;
        foreach ($this->items as $code) {
            $product = $this->catalogue->getProduct($code);
            $total += $product ? $product->price : 0;
        }

        // Apply offers
        if ($this->offers) {
            $total = $this->offers->apply($this->items, $total);
        }

        // Calculate delivery cost
        $deliveryCost = $this->deliveryRules->getDeliveryCost($total);
        return $total + $deliveryCost;
    }
}


?>