<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();

}

require_once 'classes/Order.php';
require_once 'classes/OrderItem.php';
require_once 'classes/Product.php';
require_once 'classes/BillingInformation.php';
require_once 'classes/Feedback.php';

$customerID = $_SESSION['userid'];

// Get completed orders
$completedOrders = Order::getOrdersByCustomerIDAndStatus($customerID, 'completed');

// Get pending orders
$pendingOrders = Order::getOrdersByCustomerIDAndStatus($customerID, 'pending');

$allOrders = Order::getOrdersByCustomerID($customerID);

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'order_cancelled') {
    $orderID = $_POST['order_id'];
    if (Order::delete($orderID)) {
        echo "<script>alert('Order cancelled successfully');</script>";
    } else {
        echo "<script>alert('Failed to cancel order');</script>";
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'order_received') {
    $orderID = $_POST['order_id'];
    if (Order::updateStatus($orderID, 'completed')) {
        echo "<script>alert('Order received successfully');</script>";
    } else {
        echo "<script>alert('Failed to receive order');</script>";
    }
}

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] == "submit_feedback") {
    $orderID = $_POST['order_id'];
    $customerID = $_SESSION['userid'];
    $rating = $_POST['rating'];
    $feedbackMessage = $_POST['feedback_message'];
    $feedback = new Feedback();
    $feedback->setOrderID($orderID);
    $feedback->setCustomerID($customerID);
    $feedback->setRating($rating);
    $feedback->setFeedbackMessage($feedbackMessage);
    $feedback->save();
    echo "<script>alert('Feedback submitted successfully');</script>";
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="images/favicon.png" type="image/gif" />
    <title>GlamGirl | Order</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/responsive.css" rel="stylesheet" />
    <style>
        .rating .fa-star {
            cursor: pointer;
            color: grey;
        }

        .rating .fa-star.checked {
            color: gold;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="background-image"></div>
    <section class="manage_orders py-5">
        <div class="container">
            <h2 class="text-center mb-5">Your Orders</h2>

            <?php if (empty($pendingOrders)): ?>
                <div class="alert alert-info" role="alert">
                    You have no pending orders.
                </div>
            <?php else: ?>
                <h3>Pending Orders</h3>
                <table class="table table-striped text-light">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendingOrders as $order): ?>
                            <tr>
                                <td>#<?= $order->getOrderID() ?></td>
                                <td><?= $order->getOrderDate() ?></td>
                                <td>LKR <?= number_format($order->getTotalAmount(), 2) ?></td>
                                <td><?= $order->getStatus() ?></td>
                                <td>
                                    <button class="btn btn-primary" style="width: 80%;" data-toggle="modal" data-target="#orderModal<?php echo $order->getOrderID(); ?>">Details</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <hr>

            <?php if (empty($completedOrders)): ?>
                <div class="alert alert-info" role="alert">
                    You have no completed orders.
                </div>
            <?php else: ?>
                <h3>Completed Orders</h3>
                <table class="table table-striped text-light">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($completedOrders as $order): ?>
                            <tr>
                                <td>#<?= $order->getOrderID() ?></td>
                                <td><?= $order->getOrderDate() ?></td>
                                <td>LKR <?= number_format($order->getTotalAmount(), 2) ?></td>
                                <td><?= $order->getStatus() ?></td>
                                <td>
                                <button class="btn btn-primary" style="width: 80%;" data-toggle="modal" data-target="#orderModal<?php echo $order->getOrderID(); ?>">Details</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <?php foreach ($allOrders as $order): ?>
            <div class="modal fade" id="orderModal<?php echo $order->getOrderID(); ?>" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content text-light bg-dark">
                        <div class="modal-header">
                            <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                            <button type="button" class="close btn-danger" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <strong>Order ID:</strong> <span id="orderId">#<?= $order->getOrderID() ?></span>
                            </div>
                            <div class="mb-3">
                                <strong>Customer:</strong> <span id="customerName"><?= $_SESSION['username'] ?></span>
                            </div>
                            <h5>Products Ordered</h5>
                            <table class="table table-dark table-striped mb-3">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price (LKR)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $orderItems = OrderItem::getOrderItemsByOrderID($order->getOrderID());
                                    foreach ($orderItems as $item): ?>
                                    <?php $product = Product::getProductByID($item['productID']); ?>
                                        <tr>
                                            <td><?= $product->getName() ?></td>
                                            <td><?= $item['quantity'] ?></td>
                                            <td><?= number_format($item['price'], 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="mb-3">
                                <strong>Total Price:</strong> <span id="totalPrice">LKR <?= number_format($order->getTotalAmount(), 2) ?></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                            <?php if ($order->getStatus() === 'pending'): ?>
                                <button type="button" onclick="orderCancelled('<?= $order->getOrderID() ?>')" class="btn btn-danger">Cancel Order</button>
                                <button type="button" onclick="orderCompleted('<?= $order->getOrderID() ?>')" class="btn btn-success">Received Order</button>
                            <?php endif; ?>
                            <?php if ($order->getStatus() === 'completed'): ?>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#feedbackModal<?php echo $order->getOrderID(); ?>">Feedback</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php foreach ($completedOrders as $order): ?>
            <div class="modal fade" id="feedbackModal<?= $order->getOrderID() ?>" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content text-light bg-dark">
                        <div class="modal-header">
                            <h5 class="modal-title" id="feedbackModalLabel">Order Feedback</h5>
                            <button type="button" class="close btn-danger" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="order.php" method="POST">
                                <input type="hidden" name="order_id" value="<?= $order->getOrderID() ?>">
                                <input type="hidden" name="action" value="submit_feedback">
                                <div class="mb-3">
                                    <strong>Order ID:</strong> <span id="feedbackOrderId">#<?= $order->getOrderID() ?></span>
                                </div>
                                <div class="mb-3">
                                    <strong>Rating:</strong>
                                    <div class="rating">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span class="fa fa-star" data-value="<?= $i ?>"></span>
                                        <?php endfor; ?>
                                        <input type="hidden" name="rating" id="ratingValue" value="0">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <strong>Your Feedback:</strong>
                                    <textarea name="feedback_message" id="feedbackMessage" class="form-control" rows="4" placeholder="Write your feedback here..."></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

    <script>
        
        function orderCompleted(orderId) {
            if (confirm('Are you sure you want to mark this order as completed?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'order.php';

                const orderIdInput = document.createElement('input');
                orderIdInput.type = 'hidden';
                orderIdInput.name = 'order_id';
                orderIdInput.value = orderId;

                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = 'order_received';

                form.appendChild(orderIdInput);
                form.appendChild(actionInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
        function orderCancelled(orderId) {
            if (confirm('Are you sure you want to cancel this order?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'order.php';

                const orderIdInput = document.createElement('input');
                orderIdInput.type = 'hidden';
                orderIdInput.name = 'order_id';
                orderIdInput.value = orderId;

                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = 'order_cancelled';

                form.appendChild(orderIdInput);
                form.appendChild(actionInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        let ratingValue = 0;

        // Function to update the stars based on the rating value
        function updateStars(rating) {
            document.querySelectorAll('.fa-star').forEach(star => {
                if (parseInt(star.getAttribute('data-value')) <= rating) {
                    star.classList.add('checked');
                } else {
                    star.classList.remove('checked');
                }
            });
        }

        // Add event listener to each star for rating selection
        document.querySelectorAll('.fa-star').forEach(star => {
            star.addEventListener('click', function() {
                ratingValue = this.getAttribute('data-value');  // Get the value of the clicked star
                document.getElementById('ratingValue').value = ratingValue; // Set the hidden input value
                updateStars(ratingValue); // Update the star display based on the rating
            });
        });
    </script>

    <?php include 'footer.php'; ?>

    <!-- jQery -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- bootstrap js -->
    <script src="js/bootstrap.js"></script>
    <!-- custom js -->
    <script src="js/custom.js"></script>
</body>
</html>