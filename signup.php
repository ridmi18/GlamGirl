<?php
session_start();
require_once 'classes/User.php';
require_once 'classes/DatabaseConnector.php';

// Initialize variables
$name = $username = $password = $contactNumber = "";
$errors = [];
if(isset($_SESSION['userid'])){
  header("Location: products.php");
  exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['name'])) {
        $errors[] = "Name is required";
    } else {
        $name = htmlspecialchars(strip_tags($_POST['name']));
    }

    if (empty($_POST['username'])) {
        $errors[] = "Username is required";
    } else {
        $username = htmlspecialchars(strip_tags($_POST['username']));
    }

    if (empty($_POST['password'])) {
        $errors[] = "Password is required";
    } else {
        $password = $_POST['password'];
    }

    if (empty($_POST['contact'])) {
        $errors[] = "Contact number is required";
    } else {
        $contactNumber = htmlspecialchars(strip_tags($_POST['contact']));
    }

    if (empty($errors)) {
        $user = new User($name, $username, $password, $contactNumber, 'customer');

        if ($user->create()) {
            header("Location: login.php?signup=success");
            exit();
        } else {
            $errors[] = "Failed to create account. Please try again.";
        }
    }
}
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

  <title>GlamGirl | SignUp</title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

</head>
<body>

<?php include 'navbar.php'; ?>

  <div class="background-image"></div>
  <section>
    <?php

    if (!empty($errors)) {
        echo '<div class="alert alert-danger">';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</div>';
    }
    ?>
    <div class="signup-form">
      <h2>Sign Up</h2>
      <form action="signup.php" method="POST">
          <div class="form-group">
              <label for="name">Full Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
          </div>
          <div class="form-group">
              <label for="contact">Contact Number</label>
              <input type="contact" class="form-control" id="contact" name="contact" placeholder="Enter your contact number" required>
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="username" class="form-control" id="username" name="username" placeholder="Enter your username" required>
        </div>
          <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
          </div>
          <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
              <label class="form-check-label" for="terms">I agree to the terms and conditions</label>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
      </form>
      <p class="text-center mt-3">Already have an account? <a id="link" href="login.php">Login</a></p>
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