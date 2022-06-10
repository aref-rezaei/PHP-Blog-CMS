<?php require_once 'pages/head.php'  ?>
<body>
    <?php require_once 'pages/header.php'  ?>
    <div class="clear"></div>
    <div class="body"><!-- start body -->
        <?php require_once 'pages/sidebar.php'  ?>

        <?php 
           $comment = selectComment($_GET['comment_id']);
           $replyStatus = sendReplyComment($comment["comment_id"],$comment["comment_post_id"]);
           if($replyStatus){
               header('location:Comments.php');
           }
           
        ?>
        <div class="content"><!-- start content -->
           <h1 style="padding: 20px; font-size: x-large;">ارسال پاسخ</h1>
            <form action="" method="post">
                <input type="hidden" class="textbox" name="comment_id" value="<?php echo $comment["comment_id"]?>">
                <p>نام نویسنده کامنت:</p>
                <input disabled type="text" class="textbox" value="<?php echo $comment["comment_author"]?>">
                <p>عنوان مطلب:</p>
                <input disabled type="text" class="textbox" value="<?php echo getPostTitle($comment["comment_post_id"])?>">
                <input disabled type="hidden" class="textbox" value="<?php echo $comment["comment_email"]?>">
                <p>متن کامنت:</p>
                <textarea disabled class="textbox" id="" style="height: 150px; padding: 12px;"><?php echo $comment['comment_body']; ?></textarea>
                <textarea class="textbox" name="comment_body" id="" style="height: 150px; padding: 12px;" placeholder="پاسخ خود را بنویسید"></textarea>
                <br>
                <input type="submit" class="btn btn-success" name="sendReplyComment" value="ارسال پاسخ">
                <input type="reset" class="btn btn-error" value="انصراف">
            </form>


        </div><!-- end content -->


        <div class="clear"></div>
    </div><!-- end body -->
    <?php require_once 'pages/footer.php'  ?>

</body>
</html>