<?php

require 'src/Product.php';
require 'src/ProductCatalogue.php';
require 'src/Basket.php';
require 'src/DeliveryCalculator.php';
require 'src/OfferEngine.php';

// Start session
session_start();

// Initialize products 
$catalogue = new ProductCatalogue();
$catalogue->addProduct(new Product('R01', 'Red Widget', 32.95));
$catalogue->addProduct(new Product('G01', 'Green Widget', 24.95));
$catalogue->addProduct(new Product('B01', 'Blue Widget', 7.95));

// Delivery rules
$deliveryRules = new DeliveryCalculator([
    50 => 4.95,
    90 => 2.95,
]);

// Offers
$offers = new OfferEngine();

// Retrieve or initialize the basket
if (!isset($_SESSION['basket']) || !is_string($_SESSION['basket'])) {
    $basket = new Basket($catalogue, $deliveryRules, $offers);
    $_SESSION['basket'] = serialize($basket); // Initialize and serialize basket
} else {
    $basket = unserialize($_SESSION['basket']); // Unserialize basket
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_code'])) {
        try {
            $basket->add($_POST['product_code']); // Add product to basket
            $_SESSION['basket'] = serialize($basket); // Update session with modified basket
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    if (isset($_POST['clear_basket'])) {
        // Clear the basket
        $_SESSION['basket'] = serialize(new Basket($catalogue, $deliveryRules, $offers));
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}


// Calculate total
$total = $basket->total();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acme Widget Co</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Acme Widget Co</h1>
        <p class="text-center">Select products, view your basket, and see the total with delivery charges.</p>

        <!-- Products Section -->
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2>Available Products</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                <form method="POST">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (['R01', 'G01', 'B01'] as $code): 
                                $product = $catalogue->getProduct($code); ?>
                                <tr>
                                    <td><?= $product->code ?></td>
                                    <td><?= $product->name ?></td>
                                    <td>$<?= number_format($product->price, 2) ?></td>
                                    <td>
                                        <button type="submit" name="product_code" value="<?= $product->code ?>" class="btn btn-primary">Add to Basket</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>

        <!-- Basket Section -->
		<div class="row mt-4">
		    <div class="col-md-8 offset-md-2">
		        <h2>Your Basket</h2>
		        <ul class="list-group mb-3">
		            <?php if (count($basket->getItems()) > 0): ?>
		                <?php foreach ($basket->getItems() as $item): ?>
		                    <li class="list-group-item"><?= $item ?> - $<?= number_format($catalogue->getProduct($item)->price, 2) ?></li>
		                <?php endforeach; ?>
		            <?php else: ?>
		                <li class="list-group-item">Your basket is empty.</li>
		            <?php endif; ?>
		        </ul>
		        <h4>Subtotal: $<?= number_format($basket->subtotal(), 2) ?></h4>
		        <h4>Delivery Charge: $<?= number_format($basket->deliveryCharge(), 2) ?></h4>
		        <h3>Grand Total: $<?= number_format($total, 2) ?></h3>

		        <!-- Clear Basket Button -->
		        <form method="POST">
		            <button type="submit" name="clear_basket" class="btn btn-danger">Clear Basket</button>
		        </form>
		    </div>
		</div>


    </div>
</body>
</html>
