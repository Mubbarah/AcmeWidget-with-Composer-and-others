<?php

class OfferEngine {
    public function apply($items, $total) {
        // Example for "Buy one red widget, get the second half price"
        $counts = array_count_values($items);
        if (isset($counts['R01']) && $counts['R01'] > 1) {
            $total -= (floor($counts['R01'] / 2) * 32.95 * 0.5);
        }
        return $total;
    }
}


?>