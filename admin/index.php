<?php require_once 'pages/head.php'  ?>
<body>
    <?php require_once 'pages/header.php'  ?>
    <div class="clear"></div>
    <div class="body"><!-- start body -->
        <?php require_once 'pages/sidebar.php'  ?>

        <div class="content"><!-- start content -->
            <input type="submit" class="btn btn-success">
            <input type="submit" class="btn btn-warning">
            <input type="submit" class="btn btn-error">
            <input type="submit" class="btn btn-info">
            <p class="alert alert-success">success</p>
            <p class="alert alert-error">error</p>
            <p class="alert alert-warning">warning</p>
            <p class="alert alert-info">info</p>
            <input type="text"  class="textbox" placeholder="">
            <input type="text"  class="textbox" placeholder="">
            <table>
                <thead>
                    <th>id</th>
                    <th>post</th>
                    <th>title</th>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>post</td>
                        <td>title</td>
                    </tr>
                </tbody>
            </table>
        </div><!-- end content -->
        <div class="clear"></div>
    </div><!-- end body -->
    <?php require_once 'pages/footer.php'  ?>

</body>
</html>