<?php
session_start();

if (!isset($_SESSION['userid']) || !isset($_SESSION['order']['orderID'])) {
    header("Location: login.php");
    exit();
}



require_once 'classes/Order.php';
require_once 'classes/OrderItem.php';
require_once 'classes/Product.php';
require_once 'classes/BillingInformation.php';


$orderId = $_SESSION['order']['orderID'];   

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $phone = $_POST['phone'];
    $total = $_POST['total'];
    $paymentMethod = $_POST['paymentMethod'];
    $orderDate = date('Y-m-d H:i:s');
    $billingInfo = new BillingInformation(
        $orderId,
        $fullName, 
        $email,
        $address,
        $city,
        $zip,
        $phone
    );

    if (Order::update($orderId, $paymentMethod, $orderDate, 'pending', $total)){
    } else {
        echo "Error updating order";
        exit();
    }

    if ($billingInfo->create()) {
            unset($_SESSION['order']);
            header("Location: order.php");
            exit();
    }
}
$subtotal = 0;
$shipping = 0;
$total = 0;

$orderItems = OrderItem::getOrderItemsByOrderID($orderId);

?>




<!DOCTYPE html>

    <html>

    <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="images/favicon.png" type="image/gif" />

    <title>GlamGirl | Checkout</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/responsive.css" rel="stylesheet" />

    </head>

    <body>

<?php include 'navbar.php'; ?>
    <div class="background-image"></div>
    <section class="checkout_section py-5">
        <div class="container">
            <h2 class="text-center mb-4">Checkout</h2>

            <div class="row">
                <div class="col-md-6">
                    <h4>Billing Information</h4>
                    <form action="checkout.php" method="POST">
                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input type="text" id="fullName" name="fullName" class="form-control" required />
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" required />
                        </div>

                        <div class="form-group">
                            <label for="address">Shipping Address</label>
                            <input type="text" id="address" name="address" class="form-control" required />
                        </div>

                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" class="form-control" required />
                        </div>

                        <div class="form-group">
                            <label for="zip">Postal Code</label>
                            <input type="text" id="zip" name="zip" class="form-control" required />
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" name="phone" class="form-control" required />
                        </div>
                </div>

                <!-- Order Summary -->
                <div class="col-md-6">
                    <h4>Order Summary</h4>
                    <table class="table table-bordered text-light">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <?php
                        if ($orderItems) {
                            foreach ($orderItems as $item) {
                                $product = Product::getProductByID($item['productID']);
                                if ($product) {
                                    $itemTotal = $product->getPrice() * $item['quantity'];
                                    $subtotal += $itemTotal;
                                    $shipping = ($subtotal < 10000) ? 399 : 899;
                                    $total = $subtotal + $shipping;
                                    ?>
                                    <tr>
                                        <td><?= $product->getName() ?></td>

                                        <td>LKR <?= number_format($product->getPrice(), 2) ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td>LKR <?= number_format($itemTotal, 2) ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </table>

                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-right">Subtotal: LKR <?= number_format($subtotal, 2) ?></h5>
                            <h5 class="text-right">Shipping: LKR <?= number_format($shipping, 2) ?></h5>
                            <h5 class="text-right">Total: LKR <?= number_format($total, 2) ?></h5>
                            <input type="hidden" name="total" value="<?= $total ?>">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="paymentMethod">Payment Method</label>
                        <select class="form-control bg-dark" id="paymentMethod" name="paymentMethod" required>
                            <option value="credit-card">Credit Card</option>
                            <option value="cash-on-delivery">Cash on Delivery</option>
                        </select>
                    </div>

                    <div class="form-group text-right">
                        <button class="btn btn-primary btn-lg">Place Order</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>

    <!-- jQery -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- bootstrap js -->
    <script src="js/bootstrap.js"></script>
    <!-- custom js -->
    <script src="js/custom.js"></script>

    </body>

    </html>