<?php require_once 'pages/head.php'  ?>
<body>
    <?php require_once 'pages/header.php'  ?>
    <div class="clear"></div>
    <div class="body"><!-- start body -->
        <?php 
        require_once 'pages/sidebar.php';
        addPost();
        ?>


        <div class="content"><!-- start content -->
            <form action="" method="post" enctype="multipart/form-data">
                <input type="text" class="textbox" name="post_title" placeholder="عنوان مطلب">
                <select name="post_category_id"  class="textbox">
                    <?php 
                        $selectCategory = selectCategory();
                        foreach($selectCategory as $valueCategory){
                            echo "<option value='{$valueCategory['category_id']}'>{$valueCategory['category_title']}</option>";
                        }
                    ?>

                </select>
                <input type="text" name="post_author" class="textbox" placeholder="نویسنده مطلب">

                <input type="file" name="post_img" class="textbox">
                
                <textarea class="textbox" name="post_body"style="height:230px; padding:15px;" placeholder="توضیحات مطلب"></textarea>
                <input type="text" name="post_tags" class="textbox" placeholder="برچسب‌ها">
                <br>
                <input type="submit" class="btn btn-success" name="addPost" value="درج مطلب">
                <input type="reset" class="btn btn-error" value="انصراف">

            </form>

 
        </div><!-- end content -->


        <div class="clear"></div>
    </div><!-- end body -->
    <?php require_once 'pages/footer.php'  ?>

</body>
</html>