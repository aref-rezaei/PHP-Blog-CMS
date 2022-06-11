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
        <?php require_once 'Head.php' ?>
            <div class="clear"></div>
        </div><!-- end container -->

        <div class="HeaderImage"><!-- start HeaderImage -->
            <img src="https://picsum.photos/1500/470" alt="">
            <form action="Search.php" method="post">
                <div class="search">
                    <input type="text" name="search" class="inputSearch" placeholder="جستجو">
                    <button class="searchBtn">جستجو</button>
                    <div class="clear"></div>
                </div>
            </form>
        </div><!-- end HeaderImage -->


    </div><!-- end header -->
    <div class="clear"></div>
    <div class="body"><!-- start body -->
        <div class="container" style="display:flex; flex-direction:column">
            <?php
                if(isset($_GET['post_id'])){
                    $SinglePost = showSinglePost($_GET['post_id']);
                }

                foreach($SinglePost as $post){
            ?>
            <div class="post" style="width: 70%; align-self: center;"><!-- start post -->
                <div class="postHeader"><!-- start postHeader -->
                    <h1 class="postTitle"><a href="PostPage.php?post_id=<?= $post->post_id ?>"><?= $post->post_title ?></a></h1>
                    <span>تاریخ انتشار:<?= convertDateToJalali($post->post_created_at) ?></span>
                    <div class="clear"></div>
                </div><!-- end postHeader -->
                <div class="postBody"><!-- start postBody -->
                    <div class="postImage" style="height: auto;"><!-- start postImage -->
                        <img src="images/<?= $post->post_img?>" alt="">
                    </div><!-- end postImage -->
                    <div class="postDesc"><!-- start postDesc -->
                        <p><?= $post->post_body?></p>
                    </div><!-- end postDesc -->
                    <div class="clear"></div>
                </div><!-- end postBody -->
                <div class="postFooter"><!-- start postFooter -->
                    <span>نویسنده مطلب: <?= $post->post_author?></span>
                    
                    <div style="float: left ;">
                    <?php
                        $tags = explode(',',$post->post_tags);
                        foreach ($tags as $tag){
                            echo"<span class='tags'>$tag</span>";
                        }
                    ?>
                    </div>
                    <div class="clear"></div>
                </div><!-- end postFooter -->
                <div class="clear"></div>
            </div><!-- end post -->
            <div class="clear"></div>

            <?php sendComment();?>
            <div class="sendComment">
                <div class="commentHeader">
                    <h1>ارسال نظر</h1>
                </div>
                <div class="commentBody">
                    <form action="" method="post">
                        <input type="text" name="comment_author" required class="textbox" placeholder="نام">
                        <input type="text" name="comment_email" required class="textbox" placeholder="ایمیل">
                        <textarea class="textbox" name="comment_body" style="height: 150px;" required placeholder="نظر خود را بنویسید"></textarea>
                        <br>
                        <input type="submit" name="sendComment" class="btn btn-success" value="ارسال نظر">
                        <input type="reset" class="btn btn-error" value="انصراف">
                    </form>
                </div>

            <div class="commentFooter">
                <?php 
                    $showComments = showUserComments($_GET['post_id']);
                    
                    if($showComments){
                        foreach ($showComments as $Comment){

                ?>
                        <div class="answerComment">
                            <div class="info">
                                <span class="commentAuthor">کاربر : <?php echo $Comment['comment_author']?> گفته : </span>
                                <span class="commentDate"> تاریخ  : <?php echo convertDateToJalali($Comment['comment_created_at'])?> </span>
                                <div class="clear"></div>
                            </div>
                            <div class="">
                                <p class="commentQuestion">
                                    <?php echo $Comment['comment_body']?>
                                </p>
                            </div>

                            <?php 
                                    $ReplyComments = showReplyComment($Comment['comment_id']);
                                    if($ReplyComments){
                                        foreach($ReplyComments as $ReplyComment){
                                ?>
                                        <div class="divAdminReply">
                                            <div class="info">
                                                <span class="commentAuthor" style="color: blue">مدیر سایت گفته : </span>
                                                <span class="commentDate"> تاریخ  : <?php echo convertDateToJalali($ReplyComment['comment_created_at']); ?> </span>
                                                <div class="clear"></div>
                                            </div>

                                                <p class="AdminReply">
                                                <?php echo $ReplyComment['comment_body']; ?>
                                                </p>
                                            <?php
                                     }
                                  }
                                ?>

                            </div>
                        </div>
                    </div>
            <?php 
                      }
                } else {
                    echo "<p>کامنتی وجود ندارد</p>";
                }
            
            ?>
            <div class="clear"></div>
            </div>          
        </div>
            <?php } ?>


        <div class="clear"></div>
    </div><!-- end body -->

    <div class="footer"><!-- start footer -->
        <p>blog.php</p>
    </div><!-- end footer-->
</body>
</html>