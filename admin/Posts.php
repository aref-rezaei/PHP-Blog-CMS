<?php require_once 'pages/head.php'  ?>
<body>
    <?php require_once 'pages/header.php'  ?>
    <div class="clear"></div>
    <div class="body"><!-- start body -->
        <?php require_once 'pages/sidebar.php'; ?>


        <div class="content"><!-- start content -->
            <p>مشاهده پست ها</p>
            <?php 
            if(isset($_GET['delete'])){
                $delete = deletePost($_GET['delete']);
                if($delete){
                    header('location:Posts.php?success=true');
                } else{
                    header('location:Posts.php?error=true');
                }
            }

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
                        <th>عنوان</th>
                        <th>دسته بندی</th>
                        <th>نویسنده</th>
                        <th>تاریخ</th>
                        <th>تصویر</th>
                        <th>برچسب</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                
                    <?php 
                    $selectAllPost = selectAllPost();
                    if($selectAllPost){
                        foreach($selectAllPost as $index=>$value){
                        
                        ?>
                        <tbody>
                            <td><?= $index + 1 ?></td>
                            <td><?= $value -> post_title ?></td>
                            <td><?= showCategoryName($value -> post_category_id) ?></td>
                            <td><?= $value -> post_author ?></td>
                            <td style="direction: ltr;"><?= convertDateToJalali($value -> post_created_at) ?></td>
                            <td><img width="160" height="80" src="../images/<?= $value -> post_img ?>" ></td>
                            <td><?= $value -> post_tags ?></td>
                            <td>
                                <a class="delete" href="Posts.php?delete=<?= $value -> post_id ?>">حذف</a>
                                <a class="edit" href="EditPost.php?edit=<?= $value -> post_id ?>">ویرایش</a>
                            </td>
                        </tbody>
                        <?php }
                        } else{
                            echo '<tbody><td colspan="8"><p>مطلبی وجود ندارد</p></td></tbody>';
                        }?>
                
            </table>

            <?php 
                    for($i=1; $i <= $TotalPageNum; $i++){
                        if(isset($_GET['page'])){
                            if($i == $_GET['page']){
                                echo'<a class="paginationNum active" href="Posts.php?page='.$i.'">'.$i.'</a>';
                            } else {
                                echo'<a class="paginationNum" href="Posts.php?page='.$i.'">'.$i.'</a>';
                            }
                        }else{
                            echo'<a class="paginationNum active" href="Posts.php?page=1">1</a>';
                        }

                    }
            ?>


        </div><!-- end content -->


        <div class="clear"></div>
    </div><!-- end body -->
    <?php require_once 'pages/footer.php'  ?>

</body>
</html>