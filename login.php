<?php 
    include 'connection.php';
    session_start();
    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        
        $select = mysqli_query($conn , "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$password' ") or die('query failed');
        if (mysqli_num_rows($select) > 0) {
           $row = mysqli_fetch_assoc($select);
           $_SESSION['user_id'] = $row['id'];
           header('location:home.php');
        }else{
            $massage[]="incorrect email or password";
        }
    
    
    
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <div class="form-container">
        <form method="POST" action="" enctype="multipart/form-data">
            <h3>Login Now</h3>
            <?php
                if (isset($massage)) {
                    foreach ($massage as $massage) {
                         echo '<div class="massage">'.$massage.'</div>';
                    }
                }
            ?>
            <input type="text" class="box" name="email" placeholder="Enter Email" require>
            <input type="password" class="box" name="password" placeholder="Enter Password" require>
            <input type="submit" name="submit" value="Login Now" class="btn">
            <p>Do not have account ? <a href="register.php">Register now</a></p>
        </form>
    </div>

    
    <div class="day-night">
      <i class="fa-solid fa-moon"></i>
    </div>
    <script type="text/javascript" src="js/script.js"></script>
</body>
</html>