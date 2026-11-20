<?php
session_start();

require_once('classes/DatabaseConnector.php');
require_once('classes/Order.php');
require_once('classes/OrderItem.php');
require_once('classes/Product.php');

if(isset($_SESSION['userid'])){
    $customerID = $_SESSION['userid'];
}else{
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['order']) || $_SESSION['order']['status'] != 'null') {
    $order = new Order();
    $order->setStatus('null');
    $order->setCustomerID($customerID);


    try {
        $order->save();

        $_SESSION['order'] = [
            'orderID' => $order->getOrderID(),
            'status' => 'null'
        ];

    } catch (Exception $e) {
        die("Error creating order: " . $e->getMessage());
    }
}
if (isset($_GET['productID']) ) {
    $productID = (int)$_GET['productID'];

    $existingItems = OrderItem::getOrderItemsByOrderID($_SESSION['order']['orderID']);
    $productExists = false;
    
    if ($existingItems) {
        foreach ($existingItems as $item) {
            if ($item['productID'] == $productID) {
                $productExists = true;
                $orderItem = OrderItem::getOrderItemByID($item['orderItemID']);
                if ($orderItem) {
                    $newQuantity = $orderItem->getQuantity() + 1;
                    if ($newQuantity <= 10) {
                        $orderItem->setQuantity($newQuantity);
                        $orderItem->update();
                    }
                }
                break;
            }
        }
    }

    if ($productExists) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }


    $product = Product::getProductByID($productID);


    if ($product && $product->getStockQuantity() > 0) {
        $orderItem = new OrderItem($_SESSION['order']['orderID'], $productID, 1);

        $orderItem->save();
    } else {
        echo "<p class='text-danger'>Product is out of stock.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
    $itemID = (int)$_POST['item_id'];
    $quantity = (int)$_POST['quantity'];

    // Validate the quantity
    if ($quantity < 1 || $quantity > 10) {
        echo "<p class='text-danger'>Invalid quantity. Quantity must be between 1 and 10.</p>";
    } else {
        // Fetch the order item
        $orderItem = OrderItem::getOrderItemByID($itemID);

        // Update the quantity if the order item exists
        if ($orderItem) {
            $orderItem->setQuantity($quantity);
            $orderItem->update();
        }
    }
}

// Handle removing items
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item'])) {
    $itemID = (int)$_POST['item_id'];
    $orderItem = OrderItem::getOrderItemByID($itemID);
    if ($orderItem) {
        $orderItem->delete();
    }
}

$orderItems = OrderItem::getOrderItemsByOrderID($_SESSION['order']['orderID']);
$cartItems = [];
$subtotal = 0;

if ($orderItems) {
    foreach ($orderItems as $item) {
        $product = Product::getProductByID($item['productID']);
        if ($product) {
            $cartItems[] = [
                'item_id' => $item['orderItemID'],
                'product_id' => $product->getProductID(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'quantity' => $item['quantity'],
                'image' => $product->getImageBase64() ? "data:image/jpeg;base64," . $product->getImageBase64() : "images/default-product-image.jpg",
                'total' => $product->getPrice() * $item['quantity']
            ];
            $subtotal += $product->getPrice() * $item['quantity'];
        }
    }
}

// Calculate shipping and total
$shipping = ($subtotal < 10000) ? 399 : 899; 
$total = $subtotal + $shipping;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlamGirl | Cart</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>
<?php include 'navbar.php'; ?>

    <div class="background-image"></div>
    <section class="cart_section py-5 text-light">
        <div class="container">
            <h2 class="text-center mb-4">Your Cart</h2>
            <?php if (empty($cartItems)): ?>
                <p class="text-center">Your cart is empty. <a href="products.php" style="color: #ed247c;">Continue shopping</a>.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered text-light">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                    <td>
                                        <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="img-fluid" width="100">
                                        <p><?= $item['name'] ?></p>
                                    </td>
                                    <td>LKR <?= number_format($item['price'], 2) ?></td>
                                    <td>
                                        <form method="POST" action="">
                                            <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
                                            <input type="number" name="quantity" class="form-control" value="<?= $item['quantity'] ?>" min="1" max="10">
                                            <button type="submit" name="update_quantity" class="btn btn-sm btn-primary mt-2" style="width: 100%;">Update</button>
                                        </form>
                                    </td>
                                    <td>LKR <?= number_format($item['total'], 2) ?></td>
                                    <td>
                                        <form method="POST" action="">
                                            <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
                                            <button type="submit" name="remove_item" class="btn btn-danger">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Cart Summary -->
                <div class="cart_summary mt-4">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>Cart Total</h4>
                            <table class="table text-light">
                                <tr>
                                    <td>Subtotal</td>
                                    <td>LKR <?= number_format($subtotal, 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td>LKR <?= number_format($shipping, 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>LKR <?= number_format($total, 2) ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="checkout.php" class="btn btn-primary btn-lg" style="width: 200px;" <?= empty($cartItems) ? 'disabled' : '' ?>>Checkout</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>