<?php 
    include 'connection.php';
    session_start();

    $user_id = $_SESSION['user_id'];
    if(isset($_POST['update_profile'])){
        $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
        $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
        
        mysqli_query($conn , "UPDATE `user_form` SET name='$update_name' , email='$update_email' WHERE id = '$user_id'")
        or die('query failed');

        $old_password=$_POST['old_password'];
        $update_password = mysqli_real_escape_string($conn,md5($_POST['update_password']));
        $new_password = mysqli_real_escape_string($conn,md5($_POST['new_password']));
        $confirm_password = mysqli_real_escape_string($conn,md5($_POST['confirm_password']));
        
        if (!empty($update_password) || !empty($new_password) || !empty($confirm_password)) {
            if($update_password != $old_password){
                $message[]="old password not matched";
            }elseif($new_password != $confirm_password){
                $message[]="confirm password not matched";
            }else{
                mysqli_query($conn , "UPDATE `user_form` SET password = '$confirm_password' WHERE id = '$user_id'") or die('query failed');
                $message[]="password updated successfily";
            }
        }
        
        $update_image = $_FILES['update_image']['name'];
        $update_image_size = $_FILES['update_image']['size'];
        $update_image_tmp = $_FILES['update_image']['tmp_name'];
        $update_image_folder ='uploded_img/'.$update_image;

        if ($update_image_size > 2000000) {
            $message[]="image size is very large";
        }else{
            $update_image_query=mysqli_query($conn,"UPDATE `user_form` SET image='$update_image' WHERE id = '$user_id'") or die('query failed');
            if ($update_image_query) {
                move_uploaded_file($update_image_tmp,$update_image_folder);
            } 
            $message[]="image updated successfuly";
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="update-profile">
        <?php 
                $select = mysqli_query($conn , "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
                if(mysqli_num_rows($select) > 0){
                   $fetch = mysqli_fetch_assoc($select); 
                }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <?php 
                 if ($fetch['image'] == '') {
                    echo '<img src="uploded_img/default-avatar.jpg">';
                }else{
                    echo '<img src="uploded_img/'.$fetch['image'].'">';
                }if(isset($message)){
                    foreach ($message as $message) {
                        echo '<div class="massage">'.$message.'</div>';
                    }
                }
            
            ?>
             <?php
                if (isset($massage)) {
                    foreach ($massage as $massage) {
                         echo '<div class="massage">'.$massage.'</div>';
                    }
                }
            ?>
            <div class="flex">
                <div class="inputBox">
                    <span>user name : </span>
                    <input type="text" class="box" name="update_name" value="<?php echo $fetch['name'];?>">
                    <span>Your email : </span>
                    <input type="text" class="box" name="update_email" value="<?php echo $fetch['email'];?>">
                    <span>update your pic : </span>
                    <input type="file" class="box" name="update_image" accept="image/*">
                </div>
                <div class="inputBox">
                    <input type="hidden" name="old_password" value="<?php echo $fetch['password']?>" >
                    <span>old password : </span>
                    <input type="password" class="box" name="update_password" placeholder="Enter Old Password">
                    <span>new password : </span>
                    <input type="password" class="box" name="new_password" placeholder="Enter new Password">
                    <span>confirm your password : </span>
                    <input type="password" class="box" name="confirm_password" placeholder="confirm your Password">
                </div>
            </div>
            <div class="flex-btn">
               <input type="submit" class="btn" name="update_profile" value="update profile">
               <a href="home.php" class="btn">Go Back</a>
            </div>
        </form>
    </div>
    <div class="day-night">
        <i class="fa-solid fa-moon"></i>
    </div>
    <script type="text/javascript" src="js/script.js"></script>
</body>
</html>