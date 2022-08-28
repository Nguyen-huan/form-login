  <?php
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
    echo $_POST["username"], "<br>",$_POST["password"];
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
      $sql = "SELECT * FROM users WHERE user_name = '$username' AND password = '$password'";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result)){
        echo "Successful";
      }
      else{
        header("Location: login.php?error=Incorect Username or Password");
        exit();
      }
    }
  }
  else{
  
  }