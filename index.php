<?php require_once 'includes/init.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>وبلاگ من</title>
</head>
<body>
    <div class="header"><!-- start header -->
        <div class="container"><!-- start container -->
            <ul class="menu">
                <?php 
                    $showCategory = selectAllCategory();
                    foreach ($showCategory as $value) {
                        echo "<li><a href='#'>{$value['category_title']}</a></li>";
                    }
                ?>
                <li><a href="admin">ورود مدیریت</a></li>
            </ul>
            <div class="clear"></div>
        </div><!-- end container -->

        <div class="HeaderImage"><!-- start HeaderImage -->
            <img src="https://picsum.photos/1500/470" alt="">
            <form action="">
                <div class="search">
                    <input type="text" class="inputSearch" placeholder="جستجو">
                    <button class="searchBtn">جستجو</button>
                    <div class="clear"></div>
                </div>
            </form>
        </div><!-- end HeaderImage -->


    </div><!-- end header -->
    <div class="clear"></div>
    <div class="body"><!-- start body -->
        <div class="container">
            <?php
                $Posts = selectAllPost();
                foreach($Posts as $post){

                
            ?>
            <div class="post"><!-- start post -->
                <div class="postHeader"><!-- start postHeader -->
                    <h1 class="postTitle"><?= $post->post_title ?></h1>
                    <span>تاریخ انتشار:<?= convertDateToJalali($post->post_created_at) ?></span>
                    <div class="clear"></div>
                </div><!-- end postHeader -->
                <div class="postBody"><!-- start postBody -->
                    <div class="postImage"><!-- start postImage -->
                        <img src="images/<?= $post->post_img?>" alt="">
                    </div><!-- end postImage -->
                    <div class="postDesc"><!-- start postDesc -->
                        <p><?= $post->post_body?></p>
                    </div><!-- end postDesc -->
                    <div class="clear"></div>
                </div><!-- end postBody -->
                <div class="postFooter"><!-- start postFooter -->
                    <span>نویسنده مطلب: <?= $post->post_author?></span>
                    <a href="" class="readMore">ادامه مطلب</a>
                    <div class="clear"></div>
                </div><!-- end postFooter -->
                <div class="clear"></div>
            </div><!-- end post -->
            <?php } ?>

            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div><!-- end body -->

    <div class="footer"><!-- start footer -->
        <p>blog.php</p>
    </div><!-- end footer-->
</body>
</html>