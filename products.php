<?php
require_once 'classes/Product.php';
require_once 'classes/DatabaseConnector.php';
session_start();
$products = Product::getAllProducts();

// Filter for jewelry products
$jewelryProducts = array_filter($products, function($product) {
    return $product->getType() === 'accessories';
});

// Get first 4 products
$initialProducts = array_slice($jewelryProducts, 0, 4);
$remainingProducts = array_slice($jewelryProducts, 4);


$cosmeticsProducts = array_filter($products, function($product) {
    return $product->getType() === 'cosmetics';
});

// Get first 4 products
$initialCosmetics = array_slice($cosmeticsProducts, 0, 4);
$remainingCosmetics = array_slice($cosmeticsProducts, 4);
?>

<!DOCTYPE html>
<html>

<head>
<!-- Basic -->
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<!-- Mobile Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<!-- Site Metas -->
<link rel="icon" href="images/favicon.png" type="image/gif" />

<title>GlamGirl | Products</title>

<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link href="css/font-awesome.min.css" rel="stylesheet" />
<link href="css/responsive.css" rel="stylesheet" />
<style>
    .product-title {
        font-size: 15px !important;
        font-weight: bold;
        color: #ffffff;
    }
    .row{
        margin-bottom: 30px !important;
    }
</style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="background-image"></div>

    <section>
        <div class="container text-light">
            <div class="row mt-5">
                <div class="col-md-6">
                    <input type="text" class="form-control" id="search-bar" placeholder="Search for products...">
                </div>
                <div class="col-md-6 text-right">
                    <select class="form-control" id="sort-bar" style="color:rgb(255, 255, 255); background-color: #000000;">
                        <option value="default">Sort by: Default</option>
                        <option value="price-asc">Price: Low to High</option>
                        <option value="price-desc">Price: High to Low</option>
                    </select>
                </div>
            </div>

            <!-- Jewelry Section -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="my-5">Accessories</h1>
                    </div>
                </div>
                <div class="row initial-accessories">
                    <?php foreach($initialProducts as $product): ?>
                    <div class="col-md-3">
                        <div class="product-card mt-5">
                            <img src="data:image/jpeg;base64,<?php echo $product->getImageBase64(); ?>" class="product-img" alt="<?php echo $product->getName(); ?>">
                            <div class="card-body">
                                <div class="product-title"><?php echo $product->getName(); ?></div>

                                <div class="product-price">LKR <?php echo number_format($product->getPrice(), 2); ?></div>
                                <div class="product-data" style="display: none;">
                                    <div class="product-description"><?php echo $product->getDescription(); ?></div>
                                    <div class="product-name"><?php echo $product->getName(); ?></div>
                                    <div class="product-price-value"><?php echo number_format($product->getPrice(), 2); ?></div>
                                    <div class="product-id"><?php echo $product->getProductID(); ?></div>
                                </div>
                                <a href="cart.php?productID=<?php echo $product->getProductID(); ?>" id="cartBtn">
                                    <button class="btn btn-cart">Add to Cart</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="row remaining-accessories" style="display: none;">
                    <?php foreach($remainingProducts as $product): ?>
                    <div class="col-md-3">
                        <div class="product-card mt-5">
                            <img src="data:image/jpeg;base64,<?php echo $product->getImageBase64(); ?>" class="product-img" alt="<?php echo $product->getName(); ?>">
                            <div class="card-body">
                                <div class="product-title"><?php echo $product->getName(); ?></div>

                                <div class="product-price">LKR <?php echo number_format($product->getPrice(), 2); ?></div>
                                <!-- Hidden Product Data for Modal -->
                                <div class="product-data" style="display: none;">
                                    <div class="product-description"><?php echo $product->getDescription(); ?></div>
                                    <div class="product-name"><?php echo $product->getName(); ?></div>
                                    <div class="product-price-value"><?php echo number_format($product->getPrice(), 2); ?></div>
                                    <div class="product-id"><?php echo $product->getProductID(); ?></div>
                                </div>
                                <a href="cart.php?productID=<?php echo $product->getProductID(); ?>" id="cartBtn">
                                    <button class="btn btn-cart">Add to Cart</button>
                                </a>
                            </div>


                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>    
                
                
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-dark mb-5 view-more-accessories">View More</button>
                    </div>
                </div>
            </div>


            <!-- Cosmetics Section -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="my-5">Cosmetics</h1>
                    </div>
                </div>

                <div class="row initial-cosmetics">
                    <?php foreach($initialCosmetics as $product): ?>
                    <div class="col-md-3">
                        <div class="product-card mt-5">
                            <img src="data:image/jpeg;base64,<?php echo $product->getImageBase64(); ?>" class="product-img" alt="<?php echo $product->getName(); ?>">
                            <div class="card-body">
                                <div class="product-title"><?php echo $product->getName(); ?></div>

                                <div class="product-price">LKR <?php echo number_format($product->getPrice(), 2); ?></div>
                                <!-- Hidden Product Data for Modal -->
                                <div class="product-data" style="display: none;">
                                    <div class="product-description"><?php echo $product->getDescription(); ?></div>
                                    <div class="product-name"><?php echo $product->getName(); ?></div>
                                    <div class="product-price-value"><?php echo number_format($product->getPrice(), 2); ?></div>
                                    <div class="product-id"><?php echo $product->getProductID(); ?></div>
                                </div>
                                <!-- Add to Cart Button with Product ID -->
                                <a href="cart.php?productID=<?php echo $product->getProductID(); ?>" id="cartBtn">
                                    <button class="btn btn-cart">Add to Cart</button>
                                </a>
                            </div>


                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="row remaining-cosmetics" style="display: none;">
                    <?php foreach($remainingCosmetics as $product): ?>
                    <div class="col-md-3">
                        <div class="product-card mt-5">
                            <img src="data:image/jpeg;base64,<?php echo $product->getImageBase64(); ?>" class="product-img" alt="<?php echo $product->getName(); ?>">
                            <div class="card-body">
                                <div class="product-title"><?php echo $product->getName(); ?></div>

                                <div class="product-price">LKR <?php echo number_format($product->getPrice(), 2); ?></div>
                                <!-- Hidden Product Data for Modal -->
                                <div class="product-data" style="display: none;">
                                    <div class="product-description"><?php echo $product->getDescription(); ?></div>
                                    <div class="product-name"><?php echo $product->getName(); ?></div>
                                    <div class="product-price-value"><?php echo number_format($product->getPrice(), 2); ?></div>
                                    <div class="product-id"><?php echo $product->getProductID(); ?></div>
                                </div>
                                <!-- Add to Cart Button with Product ID -->
                                <a href="cart.php?productID=<?php echo $product->getProductID(); ?>" id="cartBtn">
                                    <button class="btn btn-cart">Add to Cart</button>
                                </a>

                            </div>

                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-dark mb-5 view-more-cosmetics">View More</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Modal -->
        <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content text-light bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                        <button type="button" class="close btn-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <div class="modal-body text-center">
                        <img id="productImage" src="" alt="Product Image" class="img-fluid rounded mb-3" style="max-height: 200px;">
                        <h4 id="productTitle" class="mb-3"></h4>
                        <p id="productDescription" class="mb-3"></p>
                        <input type="hidden" id="productID" name="productID" value="">
                        <div id="productPrice" class="text-success font-weight-bold"></div>
                    </div>
                    <div class="modal-footer text-center" style="display:block;">
                        <a id="virtualFitBtn" class="btn btn-dark">Try Virtual Fitting</a>
                        <a id="modalCartBtn" href="">
                            <button type="button" class="btn btn-primary">Add to Cart</button>
                        </a>
                    </div>


                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script>
        document.getElementById('search-bar').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const products = document.querySelectorAll('.product-card');

            products.forEach(product => {
                const title = product.querySelector('.product-title').textContent.toLowerCase();
                if (title.includes(searchTerm)) {
                    product.style.display = '';
                } else {
                    product.style.display = 'none';
                }
            });
        });

        document.querySelectorAll('.product-card').forEach(card => {
            const priceText = card.querySelector('.product-price').textContent;
            card.dataset.price = parseFloat(priceText.replace('LKR ', '').replace(',', ''));
        });

        document.getElementById('sort-bar').addEventListener('change', function() {
            const sortValue = this.value;
            const productContainers = [
                document.querySelector('.initial-accessories'),
                document.querySelector('.remaining-accessories'),
                document.querySelector('.initial-cosmetics'),
                document.querySelector('.remaining-cosmetics')
            ];

            productContainers.forEach(container => {
                if (!container) return;

                const products = Array.from(container.querySelectorAll('.col-md-3'));
                
                products.sort((a, b) => {
                    const priceA = parseFloat(a.querySelector('.product-card').dataset.price);
                    const priceB = parseFloat(b.querySelector('.product-card').dataset.price);

                    if (sortValue === 'price-asc') {
                        return priceA - priceB;
                    } else if (sortValue === 'price-desc') {
                        return priceB - priceA;
                    }
                    return 0;
                });

                container.innerHTML = '';
                products.forEach(product => container.appendChild(product));
            });
        });
        document.querySelector('.view-more-cosmetics').addEventListener('click', function() {
            const remainingCosmetics = document.querySelector('.remaining-cosmetics');
            remainingCosmetics.style.display = 'flex';
            this.style.display = 'none';
        });

        document.querySelector('.view-more-accessories').addEventListener('click', function() {
            const remainingAccessories = document.querySelector('.remaining-accessories');
            remainingAccessories.style.display = 'flex';
            this.style.display = 'none';
        });
        
        document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('click', function() {
            const imgSrc = this.querySelector('.product-img').src;
            const title = this.querySelector('.product-title').textContent;
            const price = this.querySelector('.product-price').textContent;
            const description = this.querySelector('.product-description').textContent;
            const productId = this.querySelector('.product-id').textContent;
            document.getElementById('productImage').src = imgSrc;
            document.getElementById('productTitle').textContent = title;
            document.getElementById('productDescription').textContent = description;
            document.getElementById('productPrice').textContent = `Price: LKR ${price}`;
            document.getElementById('productID').value = productId;

            const virtualFitForm = document.createElement('form');
            virtualFitForm.method = 'POST';
            virtualFitForm.action = 'virtual-fitting.php';
            virtualFitForm.style.display = 'none';

            const productImageInput = document.createElement('input');
            productImageInput.type = 'hidden';
            productImageInput.name = 'product_image';
            productImageInput.value = imgSrc;
            virtualFitForm.appendChild(productImageInput);
            document.body.appendChild(virtualFitForm);

            // Submit the form when the Virtual Fitting button is clicked
            document.getElementById('virtualFitBtn').onclick = () => {
                virtualFitForm.submit();
            };

            document.getElementById('modalCartBtn').addEventListener('click', function(e) {
                                e.preventDefault();
                                const productID = document.getElementById('productID').value;
                                window.location.href = 'cart.php?productID=' + productID;
                            });
            $('#productModal').modal('show');
        });
    });
    
    
    </script>



<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/custom.js"></script>


</body>

</html>