
<header class="header_section innerpage_header">
    <div class="container-fluid">
    <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand" href="index.php">
        <span>
            <img src="images/logo.png" alt="" srcset="" class="logo my-1">
        </span>
        </a>
        <div class="" id="">

        <div class="custom_menu-btn">
            <button onclick="openNav()">
            <span class="s-1"> </span>
            <span class="s-2"> </span>
            <span class="s-3"> </span>
            </button>
            <div id="myNav" class="overlay" style="background-color:rgba(0, 0, 0, 0.72) ;">
            <div class="overlay-content">
                <a href="index.php">Home</a>
                <a href="products.php">Products</a>
                    <a href="cart.php">My Cart</a>
                    <a href="order.php">My Orders</a>
                    <?php
                    if(isset($_SESSION['userid'])){
                        echo "<a href='logout.php'>Logout</a>";
                    }else{
                        echo "<a href='signup.php'>Signup</a>";
                        echo "<a href='login.php'>Login</a>";
                    }
                    ?>
            </div>
            </div>
        </div>


        </div>
    </nav>
    </div>
</header>

<script>
    // to get current year
function getYear() {
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    document.querySelector("#displayYear").innerHTML = currentYear;
}

getYear();

// overlay menu
function openNav() {
    document.getElementById("myNav").classList.toggle("menu_width");
    document.querySelector(".custom_menu-btn").classList.toggle("menu_btn-style");
}
</script>