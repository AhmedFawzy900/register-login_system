<?php 
    include 'connection.php';
    session_start();

    $user_id = $_SESSION['user_id'];
    $select = mysqli_query($conn , "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
    if(!isset($user_id)){
        header('location:login.php');
    }elseif(isset($_GET['logout'])){
        unset($user_id);
        session_destroy();
        header('location:login.php');
    }
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/home.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body>
    <div class="container">
        <div class="profile">
            <?php
                if (mysqli_num_rows($select) > 0) {
                    $fetch = mysqli_fetch_assoc($select);
                }
                if ($fetch['image'] == '') {
                    echo '<img src="uploded_img/default-avatar.jpg">';
                }else{
                    echo '<img src="uploded_img/'.$fetch['image'].'">';
                }
            
            ?>
            <h3><?php echo $fetch['name']; ?></h3>
            <div class="flex-btn">
                <a href="update_profile.php" class="btn">Update Profile</a>
                <a href="home.php?logout=<?php echo $user_id ?>" class="btn">Logout</a>
            </div>
            <p>new <a href="login.php">Login</a> or <a href="register.php">Register</a></p>
        </div>
    </div>



    <div class="day-night">
        <i class="fa-solid "></i>
    </div>
    <script type="text/javascript" src="js/script.js"></script>
</body>
</html>