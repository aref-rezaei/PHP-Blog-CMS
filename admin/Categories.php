<?php require_once 'pages/head.php'  ?>
<body>
    <?php require_once 'pages/header.php'  ?>
    <div class="clear"></div>
    <div class="body"><!-- start body -->
        <?php require_once 'pages/sidebar.php'  ?>

        <?php
         addCategory();
         if (isset($_GET['delete'])) {
             $deleteCategory = deleteCategory($_GET['delete']);
             
             if($deleteCategory){
                 header('location:Categories.php?success=ok');
             } else {
                header('location:Categories.php?error=ok');
             }
         }

          ?>
        <div class="content"><!-- start content -->
            <form action="" method="post">
                <input type="text" class="textbox" name="category_title" placeholder="نام دسته بندی">
                <br>
                <input type="submit" value="درج دسته بندی" class="btn btn-success" name="insertCategory">
                <input type="reset" value="انصراف" class="btn btn-error">
            </form>

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
                    <th>نام دسته بندی</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <?php $selectCategory = selectAllCategory();
                  if($selectCategory){
                      foreach($selectCategory as $index => $value){
            ?> 
            <tbody>
                <tr>
                    <td><?php echo $index + 1 ?></td>
                    <td><?=  $value['category_title'] ?></td>
                    <td>
                        <a class="delete" href="Categories.php?delete=<?=  $value['category_id']; ?>">حذف</a>
                        <a class="edit" href="EditCategories.php?edit=<?=  $value['category_id']; ?>">ویرایش</a>
                    </td>
                </tr>
                <?php }} else{ ?>
                    <td colspan="3" class="alert alert-info">دسته‌ای وجود ندارد</td>
                <?php } ?>
            </tbody>
        </table>


        </div><!-- end content -->


        <div class="clear"></div>
    </div><!-- end body -->
    <?php require_once 'pages/footer.php'  ?>

</body>
</html>