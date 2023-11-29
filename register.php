<?php 
    include 'connection.php';
    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $cpassword = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
        $image = $_FILES['image']['name']; // Get the name of the uploaded image
        $image_tmp_name = $_FILES['image']['tmp_name']; // Get the temporary file name of the uploaded image
        $image_size = $_FILES['image']['size']; // Get the size of the uploaded image
        $image_folder = 'uploded_img/'.$image; // Set the folder path where the image will be stored
        
        $select = mysqli_query($conn , "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$password' ") or die('query failed');
        if (mysqli_num_rows($select) > 0) {
            $massage[]='user already exist';
        }else{
            if($password != $cpassword){
                $massage[]='confirm password not matched';
            }elseif ($image_size > 200000) {
                $massage[]= 'image size is too large';
            }else{
                $insert=mysqli_query($conn,"INSERT INTO `user_form`(name,email,password,image)
                VALUES('$name','$email','$password','$image')") or die('query failed');

                if ($insert) {
                    move_uploaded_file($image_tmp_name,$image_folder);
                    $massage[]="Registered successfully";
                    header('location:login.php');
                }else{
                    $massage[]='Registered failed';
                }
        
            }
        }
    
    
    
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <div class="form-container">
        <form method="POST" action="" enctype="multipart/form-data">
            <h3>Register Now</h3>
            <?php
                if (isset($massage)) {
                    foreach ($massage as $massage) {
                         echo '<div class="massage">'.$massage.'</div>';
                    }
                }
            ?>
            <input type="text" class="box" name="name" placeholder="Enter Username" require>
            <input type="text" class="box" name="email" placeholder="Enter Email" require>
            <input type="password" class="box" name="password" placeholder="Enter Password" require>
            <input type="password" class="box" name="cpassword" placeholder="Confirm Password" require>
            <input type="file" name="image" class="box" accept="image/*" require>
            <input type="submit" name="submit" value="Register Now" class="btn">
            <p>Already have account ? <a href="login.php">Login now</a></p>
        </form>
    </div>
    <div class="day-night">
        <i class="fa-solid fa-moon"></i>
    </div>
    <script type="text/javascript" src="js/script.js"></script>
</body>
</html>