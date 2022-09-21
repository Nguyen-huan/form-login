<?php
  session_start();
  include "connect.php";
  $error = "";
  if(isset($_POST["username"]) && isset($_POST["password"])){
    function validate($data){
      $data = trim($data);
      $data = stripcslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    $username = validate($_POST["username"]);
    $password = validate($_POST["password"]);
    if(empty($username)){
      header("Location: login.php?error=User Name is required");
      $GLOBALS['error'] = "Username Error";
      exit();
    }
    else if(empty($password)){
      header("Location: login.php?error=Password is required");
      $GLOBALS['error'] = "Password Error";
      exit();
    }
    else{
      $saltPassword = md5($password);
      $sql = "SELECT * FROM users WHERE user_name = '$username' AND password = '$saltPassword'";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result)===1){
        $row = mysqli_fetch_assoc($result);
        if($row["user_name"]=== $username && $row['password']=== $saltPassword){
          $_SESSION['id'] = $row['id'];
          $_SESSION['user_name'] = $row['user_name'];
          $_SESSION['password'] = $row['password'];
          $_SESSION['name'] = $row['name'];
          $_SESSION['admin'] = $row['is_Admin'];
          // var_dump($row['is_Admin']);
          if($row['is_Admin']==1){
            header("Location: CRUD_employee/employeeList.php");
          }
          else{
            header("Location: home.php");
          }
          // var_dump($_SESSION);
        }
      }
      else{
        header("Location: login.php?error=Incorect Username or Password");
        exit();
      }
    }
    mysqli_close($conn);
  }
?>
<style>
  .error {
    color: #fbceb5 !important; margin-bottom: 20px; margin-top: -10px; margin-left: 20px;
  }
</style>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login 10</title>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <link
      href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    />

    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body class="img js-fullheight" style="background-image: url(images/bg.jpg)">
    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6 col-lg-4">
            <div class="login-wrap p-0">
              <h3 class="mb-4 text-center">Have an account?</h3>
              <form action="" class="signin-form" method="POST">
              <?php
                  if(isset($_GET['error'] )&& $error = "User error"){ ?>
                    <div class="error"> 
                    <li><?php echo $_GET['error']; ?></li>
                    </div> 
                  <?php } 
                ?>
                <div class="form-group">
                  <input
                    name="username"
                    type="text"
                    class="form-control"
                    placeholder="Username"
                    
                  />
                </div>
                <div class="form-group">
                  <input
                    name="password"
                    id="password-field"
                    type="password"
                    class="form-control"
                    placeholder="Password"
                    
                  />
                  <span
                    toggle="#password-field"
                    class="fa fa-fw fa-eye field-icon toggle-password"
                  ></span>
                </div>

                <div class="form-group">
                  <button
                    type="submit"
                    class="form-control btn btn-primary submit px-3"
                  >
                    Login
                  </button>
                </div>

                <div class="form-group d-md-flex">
                  <div class="w-50">
                    <label class="checkbox-wrap checkbox-primary"
                      >Remember Me
                      <input type="checkbox" checked />
                      <span class="checkmark"></span>
                    </label>
                  </div>
                  <div class="w-50 text-md-right">
                    <a href="register.php" style="color: #fff">Register</a>
                  </div>
                </div>
              </form>
              <p class="w-100 text-center">&mdash; Or Sign In With &mdash;</p>
              
            </div>
          </div>
        </div>
      </div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
