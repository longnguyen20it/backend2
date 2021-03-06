<?php
session_start();
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($className) {
    require_once './app/models/' . $className . '.php';
});

$notification = "";
if (!empty($_POST["username"]) && !empty($_POST["fullname"]) && !empty($_POST
    ["password"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['fullname'] = $fullname;
    $userModel = new Users();
    
    $sql = "SELECT * FROM users WHERE user_name = '$username'";
    
    $conn = mysqli_connect('localhost', 'id11468814_tulong', 'longtu', 'id11468814_database1') or die ('Lỗi kết nối');

    mysqli_set_charset($conn, "utf8mb4");
    // Thực thi câu truy vấn
    $result = mysqli_query($conn, $sql);
      
    // Nếu kết quả trả về lớn hơn 1 thì nghĩa là username hoặc email đã tồn tại trong CSDL
    if (mysqli_num_rows($result) > 0)
    {
        // Sử dụng javascript để thông báo
        echo '<script language="javascript">alert("The username already exists. Please use a different username."); window.location="signup.php";</script>';
          
        // Dừng chương trình
        die ();
    }
    else {
    if ($userModel->createUser($username, $password, $fullname)) {
        $notification = "Sign up Successfully";
      } else {
          $notification = "Sign up Failed";
      }
     }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SIGN UP MEMBER</title>
<style>
@import url(https://fonts.googleapis.com/css?family=Roboto:300);

.login-page {
  width: 360px;
  padding: 8% 0 0;
  margin: auto;
}
.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #4CAF50;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form button:hover,.form button:active,.form button:focus {
  background: #43A047;
}
.form .message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.form .message a {
  color: #4CAF50;
  text-decoration: none;
}
.form .register-form {
  display: none;
}
.container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}
.container:before, .container:after {
  content: "";
  display: block;
  clear: both;
}
.container .info {
  margin: 50px auto;
  text-align: center;
}
.container .info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #1a1a1a;
}
.container .info span {
  color: #4d4d4d;
  font-size: 12px;
}
.container .info span a {
  color: #000000;
  text-decoration: none;
}
.container .info span .fa {
  color: #EF3B3A;
}
body {
  background: #76b852; /* fallback for old browsers */
  background: -webkit-linear-gradient(right, #76b852, #8DC26F);
  background: -moz-linear-gradient(right, #76b852, #8DC26F);
  background: -o-linear-gradient(right, #76b852, #8DC26F);
  background: linear-gradient(to left, #76b852, #8DC26F);
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;      
}
</style>
</head>
<body>
    <form action="signup.php" method="post">
      <div class="form">
        <h1>SIGN UP MEMBER</h1>
        <form class="register-form">
          <input type="text" name="username" class="form-control" placeholder="Username" required="required">
          <input type="password" name="password" class="form-control" placeholder="Password" required="required">
          <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full name" required="required">
          <button type="submit" class="btn btn-primary btn-block btn-lg" value="Login">Sign Up</button>
        </form>
        <form class="login-form">
          <div class="message">Already have an account? <a href="login.php">Login here</a></div>
          <br>
          <?php echo $notification; ?>
        </form>
      </div>
	</form>
</div>
</body>
</html>                            