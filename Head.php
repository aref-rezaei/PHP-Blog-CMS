<ul class="menu">
    <?php 
        $showCategory = selectAllCategory();
        foreach ($showCategory as $value) {
            echo "<li><a href='Categories.php?category_id={$value['category_id']}'>{$value['category_title']}</a></li>";
        }
    ?>
    <li><a href="admin\Login.php">ورود مدیریت</a></li>
</ul>