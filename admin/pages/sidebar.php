<div class="sidebar"><!-- start sidebar -->
    <div class="accordion">
        <ul>
            <li><a href="./">داشبورد</a></li>
            <li class="has-sub"><a href="">مدیریت دسته بندی</a>
                <ul>
                    <li><a href="./Categories.php">افزودن دسته‌ها</a></li>
                </ul>
            </li>

            <li class="has-sub"><a href="">مدیریت  مطلب</a>
                <ul>
                    <li><a href="Posts.php">مشاهده مطلب</a></li>
                    <li><a href="addPosts.php">افزودن مطلب</a></li>
                </ul>
            </li>

            <li class="has-sub"><a href="">مدیریت نظرات</a>
                <ul>
                    <li><a href="Comments.php">مشاهده نظرات</a></li>
                </ul>
            </li>

            <li><a href="Logout.php">خروج</a></li>

        </ul>
    </div>
    <div class="clear"></div>
</div><!-- end sidebar -->
<script>
    $(document).ready(function () {
        $('.accordion ul li.active').addClass('open').children('ul').show();
        $('.accordion ul li.has-sub > a').click(function () {
            $(this).removeAttr('href');
            var accordion = $(this).parent('li');
            if (accordion.hasClass('open')){
                accordion.removeClass('open');
                accordion.find('ul').slideUp(500);
            } else {
                accordion.addClass('open');
                accordion.find('ul').slideDown(500);
            }
        });
    });
</script>