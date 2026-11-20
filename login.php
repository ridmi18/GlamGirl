<?php
session_start();
require_once 'classes/User.php';
require_once 'classes/DatabaseConnector.php';

if(isset($_SESSION['userid'])){
    header("Location: products.php");
    exit();
}
// Initialize variables
$username = $password = "";
$errors = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    if (empty($errors)) {
        $result = User::login($username, $password);
        if ($result == false) {
            $errors[] = "Invalid username or password";
        } else {
            header("Location: products.php");
            exit();
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

  <title>GlamGirl | Login</title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body>
<?php include 'navbar.php'; ?>

  <div class="background-image"></div>
  <section>
    <div class="login-form">
      <h2>Login</h2>
      <?php
      if (isset($_GET['signup']) && $_GET['signup'] == 'success') {
          echo '<div class="alert alert-success">Account created successfully! Please login.</div>';
      }
      if (!empty($errors)) {
          echo '<div class="alert alert-danger">';
          foreach ($errors as $error) {
              echo $error . '<br>';
          }
          echo '</div>';
      }
      ?>
      <form action="login.php" method="POST">
          <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
          </div>
          <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
          </div>
          <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="remember" name="remember">
              <label class="form-check-label" for="remember">Remember me</label>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Login</button>
      </form>
      <p class="text-center mt-3">Don't have an account? <a id="link" href="signup.php">Sign Up</a></p>
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