<?php

session_start();

if(isset($_SESSION['login'])) {
  header("Location: php/dashboard.php");
}

require 'php/functions.php';

if(isset($_POST['register']) && isset($_POST['agree'])) {
  if(register($_POST) > 0) {
    echo "<script>
      alert('Your Account is created.);
    </script>";
  } else {
    echo "<script>
      alert('Account not created.');
    </script>";
  }
}

if(isset($_POST['login'])) {
  $username = $_POST['usernameLogin'];
  $password = $_POST['passwordLogin'];


  $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

  if(mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    if(password_verify($password, $row['password'])) {
      $_SESSION['login'] = true;
      header("Location: php/dashboard.php");
    } else {
      echo "<script>
      alert('Wrong Password');
      </script>";
    }
  }

}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Login or Register</title>
  </head>
  <body class="container mt-5">
    <h1 class="text-uppercase text-info text-center mb-5">student data management platform</h1>
    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
      <li class="nav-item mr-5">
        <a class="nav-link text-info pl-5 pr-5 active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
      </li>
      <li class="nav-item ml-5">
        <a class="nav-link text-info pl-5 pr-5" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade border border-top-0 show active p-5" id="login" role="tabpanel" aria-labelledby="login-tab">
        <form action="" method="POST">
          <div class="form-group">
            <label for="usernameLogin">Username</label>
            <input type="text" class="form-control" name="usernameLogin" id="usernameLogin" placeholder="Enter Username" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="passwordLogin">Password</label>
            <input type="password" class="form-control" name="passwordLogin" id="passwordLogin" placeholder="Enter Password" required autocomplete="off">
          </div>
          <button type="submit" class="btn btn-info pl-5 pr-5 mt-3" name="login">Login</button>
        </form>
      </div>
      <div class="tab-pane fade border border-top-0 p-5" id="register" role="tabpanel" aria-labelledby="register-tab">
        <form action="" method="POST">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username" aria-describedby="usernameHelp" placeholder="Enter Username" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="password1">Password</label>
            <input type="password" class="form-control" name="password1" id="password1" placeholder="Password" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="password2">Password Confirmation</label>
            <input type="password" class="form-control" name="password2" id="password2" placeholder="Confirm Password" required autocomplete="off">
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" name="agree" id="agree" required>
            <label class="form-check-label" for="agree">Agree With Terms and Conditions</label>
          </div>
          <button type="submit" class="btn btn-info pl-5 pr-5 mt-3" name="register">Register</button>
        </form>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>