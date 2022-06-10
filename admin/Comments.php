<?php require_once 'pages/head.php'  ?>
<body>
    <?php require_once 'pages/header.php'  ?>
    <div class="clear"></div>
    <div class="body"><!-- start body -->
        <?php require_once 'pages/sidebar.php'  ?>

        <?php 
            if(isset($_GET['delete'])){
                $deleteComment = deleteComment($_GET['delete']);
                if($deleteComment){
                    header('location:Comments.php?success=ok');
                } else {
                    header('location:Comments.php?error=ok');
                }
            }
        ?>

        <div class="content"><!-- start content -->


            <?php   
                if(isset($_GET['success'])){
                    echo '<p class="alert alert-success">حذف با موفقیت انجام شد </p>';
                } elseif(isset($_GET['error'])){
                    echo '<p class="alert alert-error">حذف انجام نشد </p>';
                }
            ?>

            <table>
            <thead>
                <tr>
                    <th>شناسه</th>
                    <th>برای پست</th>
                    <th>ارسال کننده</th>
                    <th>ایمیل</th>
                    <th>متن نظر</th>
                    <th>تاریخ</th>
                    <th>وضعیت</th>
                    <th width="13%">پاسخ</th>
                    <th width="13%">عملیات</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $selectAllComment = selectAllComment();
                if($selectAllComment){
                    foreach($selectAllComment as $index => $comment){
                ?>
                <tr>
                    <td><?php echo $index+1 ?></td>
                    <td><?php echo getPostTitle($comment['comment_post_id']) ?></td>
                    <td><?php echo $comment['comment_author'] ?></td>
                    <td><?php echo $comment['comment_email'] ?></td>
                    <td><?php echo $comment['comment_body'] ?></td>
                    <td><?php echo convertDateToJalali($comment['comment_created_at']) ?></td>
                    <td>
                        <?php
                            if(isset($_GET['confirm'])){
                               if( commentConfirm($_GET['confirm'])){
                                   header('location:Comments.php');
                               }
                            } 
                            if(isset($_GET['reject'])){
                                if(commentReject($_GET['reject'])){
                                    header('location:Comments.php');
                                }
                                
                            }
                            if($comment['comment_status']==0){
                                echo'<a class="status" href="Comments.php?confirm='.$comment['comment_id'].'"> تایید نظر</a>';
                            } else {
                                echo'<a class="delete" href="Comments.php?reject='.$comment['comment_id'].'"> رد نظر</a>';
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                        if($comment['comment_author']=='مدیر سایت'){
                            echo '<p>-</p>';
                        } else {
                            echo "<a class='answer' href='ReplyComment.php?comment_id=".$comment['comment_id']."'> پاسخ دادن</a>";
                        }
                        ?>
                        
                    </td>
                    <td>
                        <a class="delete" href="Comments.php?delete=<?php echo $comment['comment_id']?>">حذف</a>
                    </td>
                </tr>
                <?php }
                } else {
                    echo "<td colspan='9' class='alert alert-info'>دسته‌ای وجود ندارد</td>";
                }
                ?>
            </tbody>
        </table>


        </div><!-- end content -->


        <div class="clear"></div>
    </div><!-- end body -->
    <?php require_once 'pages/footer.php'  ?>

</body>
</html>