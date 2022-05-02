<?php require_once 'pages/head.php'  ?>
<body>
    <?php require_once 'pages/header.php'  ?>
    <div class="clear"></div>
    <div class="body"><!-- start body -->
        <?php require_once 'pages/sidebar.php'  ?>

        <?php   
            $CategoryForEdit = selectCategoryForFetch($_GET['edit']);
            if(isset($_GET['edit']) && isset($_POST['category_id'])){
                $updateCategory = updateCategory($_POST['category_id']);

                if($updateCategory){
                    $message = '<p class="alert alert-success">ویرایش با موفقیت انجام شد</p>';
                    header("refresh:1, url = Categories.php");
                } else {
                    $message = '<p class="alert alert-error">ویرایش با خطا مواجه شد</p>';
                }
            }

        ?>

        <div class="content"><!-- start content -->
            <form action="" method="post">
                <input type="text" class="textbox" value="<?= $CategoryForEdit->category_title;?>" name="category_title" placeholder="نام دسته بندی">
                <input type="hidden"  value="<?= $CategoryForEdit->category_id;?>" name="category_id">
                <br>
                <input type="submit" value="ویرایش دسته بندی" class="btn btn-success" name="editCategory">
                <input type="reset" value="انصراف" class="btn btn-error">
            </form>


            <?php if(isset($message)) echo $message ?>


        </div><!-- end content -->


        <div class="clear"></div>
    </div><!-- end body -->
    <?php require_once 'pages/footer.php'  ?>

</body>
</html>