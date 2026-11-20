<?php
session_start();

require_once 'classes/Product.php';

$products = Product::getAllProducts();

usort($products, function($a, $b) {
    return $b->getProductID() - $a->getProductID(); 
});

$newestProducts = array_slice($products, 0, 4);

?>
<!DOCTYPE html>
<html>


<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="images/favicon.png" type="image/gif" />

  <title>GlamGirl | Home</title>

  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />

</head>

<body>

<?php include 'navbar.php'; ?>

  <section class="slider_section position-relative">
    <div class="slider_bg_box">
      <img src="images/slider-bg.png" alt="">
    </div>
    <div class="slider_bg"></div>
    <div class="container">
      <div class="col-md-9 col-lg-8">
        <div class="detail-box">
          <h1>
            Discover Your Glam with
            <br> GlamGirl
          </h1>
          <p>
            The ultimate destination for teenage and young adult girls. Shop accessories, cosmetics, and more
          </p>
          <div>
            <a href="products.php" class="slider-link">
              Start Shopping
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="background-image"></div>

  <section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2 class="my-5" id="latest">
          Latest Products
        </h2>
      </div>

      <div class="row">
        <?php foreach($newestProducts as $product): ?>
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

        
      </div>
      
      <div class="btn-box my-5">
        <a href="products.php">
          View All Products
        </a>
      </div>
    </div>
  </section>

  <section class="offer_section layout_padding">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-7 px-0">
          <div class="box offer-box1 bg-dark">
            <img src="images/o1.png" alt="">
            <div class="detail-box">
              <h2>
                Upto 15% Off
              </h2>
              <a href="login.php">
                Shop Now
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-5 px-0">
          <div class="box offer-box2 bg-dark">
            <img src="images/o2.png" alt="">
            <div class="detail-box">
              <h2>
                Upto 10% Off
              </h2>
              <a href="login.php">
                Shop Now
              </a>
            </div>
          </div>
          <div class="box offer-box3 bg-dark">
            <img src="images/o3.png" alt="">
            <div class="detail-box">
              <h2>
                Upto 20% Off
              </h2>
              <a href="login.php">
                Shop Now
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="about_section my-5">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="img-box">
            <img src="images/about-img.jpg" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                About Us
              </h2>
            </div>
            <p>
              At GlamGirl, we believe every girl deserves to feel confident and beautiful. We're dedicated to providing trendy fashion products tailored to teenage and young adult girls.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

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
  </div>

  <section class="client_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Testimonial
        </h2>
      </div>
      <div id="carouselExample2Controls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="row">
              <div class="col-md-11 col-lg-10 mx-auto">
                <div class="box">
                  <div class="img-box">
                    <img src="images/g1.png" alt="Glam Girl" />
                  </div>
                  <div class="detail-box">
                    <div class="name">
                      <h6>
                        Priyanka Perera
                      </h6>
                    </div>
                    <p>
                      "I have always felt beautiful and confident, and my experience with GlamGirl has made me shine even more. Their styling tips have been absolutely amazing!"
                    </p>
                    <i class="fa fa-quote-left" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="row">
              <div class="col-md-11 col-lg-10 mx-auto">
                <div class="box">
                  <div class="img-box">
                    <img src="images/g2.png" alt="Glam Girl" />
                  </div>
                  <div class="detail-box">
                    <div class="name">
                      <h6>
                        Anusha Fernando
                      </h6>
                    </div>
                    <p>
                      "GlamGirl is the ultimate destination for all things beauty. I’m beyond thrilled with the results, and I’m always excited to try new looks."
                    </p>
                    <i class="fa fa-quote-left" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="row">
              <div class="col-md-11 col-lg-10 mx-auto">
                <div class="box">
                  <div class="img-box">
                    <img src="images/g3.png" alt="Glam Girl" />
                  </div>
                  <div class="detail-box">
                    <div class="name">
                      <h6>
                        Tharushi Jayasinghe
                      </h6>
                    </div>
                    <p>
                      "I've been working with GlamGirl for several months now, and I’ve never felt more glamorous. Their personalized service is exceptional!"
                    </p>
                    <i class="fa fa-quote-left" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel_btn-container">
          <a class="carousel-control-prev" href="#carouselExample2Controls" role="button" data-slide="prev">
            <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExample2Controls" role="button" data-slide="next">
            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
  </section>
  

<?php include 'footer.php'; ?>

<script>
          
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