<?php 
    require_once '../includes/init.php';
    if(isset($_SESSION['AdminId'])){
        header('location:index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>ورود مدیریت</title>
</head>
<body style="background: #eee;">
    <div class="container" style="width: 40%; background: #fff; padding: 50px; margin: 120px auto; box-shadow:0 0 3px #ccc;">
        <?php 
            loginCheck();
            if(isset($_GET['login'])){
                if($_GET['login']=='error'){
                    echo '<p class="alert alert-error"> نام کاربری و رمز عبور اشتباه است</p>';
                }
            }
        
        ?>
        <form action="" method="post">
            <input type="text" class="textbox" name="admin_username" id="" placeholder="نام کاربری">
            <input type="password" class="textbox" name="admin_password" placeholder="رمز عبور">
            <br>
            <input type="submit" name="login" class="btn btn-success" value="ورود">
        </form>
    </div>
    
</body>
</html>