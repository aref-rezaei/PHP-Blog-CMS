<?php require_once 'pages/head.php'  ?>
<body>
    <?php require_once 'pages/header.php'  ?>
    <div class="clear"></div>
    <div class="body"><!-- start body -->
        <?php 
        require_once 'pages/sidebar.php';
        $post=selectPost($_GET['edit']);

        if(isset($_GET['edit']) && isset($_POST['post_id'])){
            
            $updatePost = updatePost($_POST['post_id']);

            if($updatePost){
                //remove post old image
                $post_img ="../images/".$post['post_img'];
                unlink($post_img);

                header('refresh:1, url = Posts.php');
            } else {

                header('location:Posts.php?error=true');
            }
        }
        ?>


        <div class="content"><!-- start content -->
            <form action="" method="post" enctype="multipart/form-data">
                <input type="text" class="textbox" value="<?= $post['post_title']?>" name="post_title" placeholder="عنوان مطلب" required>
                <select name="post_category_id"  class="textbox" required>
                    <?php 
                        $selectCategory = selectAllCategory();
                        foreach($selectCategory as $valueCategory){
                            if($post['post_category_id'] == $valueCategory['category_id']){
                                echo "<option selected='selected' value='{$valueCategory['category_id']}'>{$valueCategory['category_title']}</option>";
                            } else{
                                echo "<option value='{$valueCategory['category_id']}'>{$valueCategory['category_title']}</option>";
                            }
                            
                        }
                    ?>

                </select>
                <input type="text" name="post_author" value="<?= $post['post_author']?>" class="textbox" placeholder="نویسنده مطلب" required>

                <input type="file" name="post_img" class="textbox" required>
                <div>
                    <img width="200px" height="100px" src="../images/<?= $post['post_img']?>" alt="">
                </div>
                
                
                <textarea class="textbox"   name="post_body"style="height:230px; padding:15px;" placeholder="توضیحات مطلب" required>
                    <?= $post['post_body']?>
                </textarea>
                <input type="text"  value="<?= $post['post_tags']?>" name="post_tags" class="textbox" placeholder="برچسب‌ها" required>
                <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>" class="textbox" placeholder="">
                <br>
                <input type="submit" class="btn btn-success" name="updatePost" value="ویرایش مطلب">
                <input type="reset" class="btn btn-error" value="انصراف">

            </form>

 
        </div><!-- end content -->


        <div class="clear"></div>
    </div><!-- end body -->
    <?php require_once 'pages/footer.php'  ?>

</body>
</html>