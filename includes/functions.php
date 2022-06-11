<?php

function addCategory(){

    global $con;

    if(isset($_POST['insertCategory'])){
        $sql = "insert into `categories` (`category_title`) values (:category_title)";
        $stmt = $con->prepare($sql);
        
        $stmt -> bindParam(':category_title',$_POST['category_title']);
        if ($stmt -> execute()){
            return $stmt;
        } else {
            return false;
        }
    }
}

function selectAllCategory(){

    global $con;
    $sql = "select * from `categories`";
    $stmt = $con -> prepare($sql);

    $stmt ->execute();
    if($stmt -> rowCount()){
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return false;
    }
}

function deleteCategory($category_id){

    global $con;

    if(isset($_GET['delete'])){

        $sql = "delete from `categories` where `category_id` = ?";
        $stmt = $con->prepare($sql);
        $stmt -> bindValue(1,$category_id);
        $stmt ->execute();
        if ($stmt -> rowCount()){
            return $stmt;
        } else {
            return false;
        }
    }
}

function selectCategory($category_id){

    global $con;

    if(isset($_GET['edit'])){
        $sql = "select * from `categories` where `category_id`= ? ";
        $stmt = $con->prepare($sql);
        $stmt -> bindvalue(1,$category_id);
        $stmt ->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}

function updateCategory($category_id){

    global $con;
    
    $sql = "update `categories` set `category_title` = ? where `category_id` = ?";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(1,$_POST['category_title']);
    $stmt->bindValue(2,$category_id);
    $stmt ->execute();

    if ($stmt -> rowCount()){
        return $stmt;
    } else {
        return false;
    }

}

function addPost(){
    
    global $con;

    if(isset($_POST['addPost'])){
        $post_title = $_POST['post_title'];
        $post_author = $_POST['post_author'];
        $post_body = $_POST['post_body'];
        $post_category_id = $_POST['post_category_id'];
        $post_tags = $_POST['post_tags'];
        $post_date = date('y-m-d');
        
        $file = $_FILES['post_img']['name'];
        $extension = explode('.',$file);
        $fileExt = strtolower(end($extension));
        $post_img = md5(microtime().$file);
        $post_img .= ".".$fileExt;
        $error = $_FILES['post_img']['error'];
        $tmp_name = $_FILES['post_img']['tmp_name'];

        switch($error){
            case UPLOAD_ERR_OK;

                $valid = true;
                
                if(!in_array($fileExt,array('png','jpg','gif','jpeg'))){
                    $valid = false;
                    echo '<p class="alert alert-error">فرمت فایل صحیح نیست</p>';
                }
                
                if($error > 200000){
                    $valid = false;
                    echo'<p class="alert alert-error"> حجم عکس بزرگ است </p>';

                }

                if($valid){
                    $valid = true;
                
                    move_uploaded_file($tmp_name,'../images/'.$post_img);
                    echo'<p class="alert alert-success"> عکس با موفقیت آپلود شد </p>';

                    $sql = 'INSERT INTO `posts` (`post_category_id`,`post_title`,`post_author`,
                                                 `post_created_at`,`post_img`,`post_body`,`post_tags`) 
                            values(:post_category_id, :post_title, :post_author, :post_created_at,
                                   :post_img, :post_body, :post_tags)';
                    
                    $stmt = $con ->prepare($sql);
                    $stmt->bindParam(':post_category_id',$post_category_id);
                    $stmt->bindParam(':post_title',$post_title);
                    $stmt->bindParam(':post_author',$post_author);
                    $stmt->bindParam(':post_created_at',$post_date);
                    $stmt->bindParam(':post_img',$post_img);
                    $stmt->bindParam(':post_body',$post_body);
                    $stmt->bindParam(':post_tags',$post_tags);
                    $stmt->execute();
                    
                    if($stmt->rowCount()){

                        return $stmt;
                        
                    }else{

                        return false;
                    }



                }
                break;
        }
        

    }
}

function selectAllPost(){
   
    global $con;
    global $TotalPageNum;
    
    if(!isset($_GET['page'])){
        $offset = 0;
    } else {
        $offset = ($_GET['page']-1)*4;
    }

    $sql = "SELECT * FROM `posts`";
    $stmt = $con->prepare($sql);
    $stmt -> execute();
    $TotalPageNum = ceil($stmt->rowCount()/4);

    $sql = "SELECT * FROM `posts` limit {$offset},4";
    $stmt = $con->prepare($sql);
    $stmt -> execute();
    if ($stmt->rowCount()){
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    } else{
        return false;
    }
}

function convertDateToJalali($date){

    $date = explode('-',$date);
    return gregorian_to_jalali($date[0],$date[1],$date[2],'/');
}

function showCategoryName($category_id){
    
    global $con;
    $sql = 'SELECT * FROM `categories` WHERE `category_id`=?';
    $stmt = $con->prepare($sql);
    $stmt -> bindValue(1,$category_id);
    $stmt -> execute();

    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($row as $value){
        return $value['category_title'];
    }
}

function deletePost($post_id){

    global $con;

    $postImageName = getPostImageName($post_id);

    if(isset($_GET['delete'])){

        $sql = "DELETE FROM `posts` WHERE `post_id`=?";
        $stmt = $con->prepare($sql);
        $stmt ->bindValue(1,$post_id);
        $stmt ->execute();
        
        if($stmt->rowCount()){
            unlink('../images/'.$postImageName);
            return $stmt;
        } else{
            return false;
        }

    }
}

function getPostImageName($post_id){

    global $con;
    
    $sql = "SELECT `post_img` FROM `posts` WHERE `post_id`= ? ";
    $stmt = $con->prepare($sql);
    $stmt -> bindvalue(1,$post_id);
    $stmt ->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result->post_img;
}

function selectPost($post_id){

    global $con;

    if(isset($post_id)){
        $sql ="SELECT * FROM `posts` WHERE `post_id`=?";
        $stmt = $con->prepare($sql);
        $stmt -> bindvalue(1,$post_id);
        $stmt ->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }
}

function updatePost($post_id){

    global $con;

    if(isset($_POST['updatePost'])){
        $post_title = $_POST['post_title'];
        $post_author = $_POST['post_author'];
        $post_body = $_POST['post_body'];
        $post_category_id = $_POST['post_category_id'];
        $post_tags = $_POST['post_tags'];
        $post_date = date('y-m-d');
        
        $file = $_FILES['post_img']['name'];
        $extension = explode('.',$file);
        $fileExt = strtolower(end($extension));
        $post_img = md5(microtime().$file);
        $post_img .= ".".$fileExt;
        $error = $_FILES['post_img']['error'];
        $tmp_name = $_FILES['post_img']['tmp_name'];

        switch($error){
            case UPLOAD_ERR_OK;

                $valid = true;
                
                if(!in_array($fileExt,array('png','jpg','gif','jpeg'))){
                    $valid = false;
                    echo '<p class="alert alert-error">فرمت فایل صحیح نیست</p>';
                }
                
                if($error > 200000){
                    $valid = false;
                    echo'<p class="alert alert-error"> حجم عکس بزرگ است </p>';

                }

                if($valid){
                    $valid = true;
                
                    move_uploaded_file($tmp_name,'../images/'.$post_img);
                    echo'<p class="alert alert-success"> عکس با موفقیت آپلود شد </p>';

                    $sql = 'UPDATE `posts`
                            SET `post_category_id`=:post_category_id,`post_title`=:post_title,
                            `post_author`=:post_author, `post_created_at`=:post_created_at,
                            `post_img`=:post_img ,`post_body`=:post_body,`post_tags`=:post_tags
                            WHERE `post_id`=:post_id';
                    
                    $stmt = $con ->prepare($sql);
                    $stmt->bindParam(':post_category_id',$post_category_id);
                    $stmt->bindParam(':post_title',$post_title);
                    $stmt->bindParam(':post_author',$post_author);
                    $stmt->bindParam(':post_created_at',$post_date);
                    $stmt->bindParam(':post_img',$post_img);
                    $stmt->bindParam(':post_body',$post_body);
                    $stmt->bindParam(':post_tags',$post_tags);
                    $stmt->bindParam(':post_id',$post_id);
                    $stmt->execute();
        
                    if($stmt->rowCount()){

                        return $stmt;
                        
                    }else{

                        return false;
                    }



                }
                break;
        }
        

    }
}

function searchPost($value){

    global $con;
    
    $sql = "SELECT * FROM `posts` WHERE `post_tags` LIKE ?";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(1,"%$value%");
    $stmt->execute();

    if($stmt->rowCount() >= 1){
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    } else {
        return false;
    }
}

function showSinglePost($post_id){
    
    global $con;

    if(isset($post_id)){
        $sql ="SELECT * FROM `posts` WHERE `post_id`=?";
        $stmt = $con->prepare($sql);
        $stmt -> bindvalue(1,$post_id);
        $stmt ->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }
}

function textSummary($value){

    return mb_substr($value, 0, 100, 'utf-8').' ...';
}

function selectCategoryByPost($category_id){

    global $con;
    if(isset($category_id)){
        $sql = 'SELECT * FROM `posts` WHERE `post_category_id`=?';
        $stmt = $con ->prepare($sql);
        $stmt -> bindValue(1,$category_id);
        $stmt -> execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }
}

function sendComment(){

    global $con;

    if(isset($_POST['sendComment'])){
        $comment_created_at = date('y-m-d');
        $comment_status = 0;
        $comment_reply = 0;
        
        $sql = 'INSERT INTO `comments`(`comment_post_id`,`comment_author`,`comment_body`,`comment_status`,`comment_email`,`comment_created_at`,`comment_reply`) values (:comment_post_id, :comment_author, :comment_body, :comment_status, :comment_email, :comment_created_at, :comment_reply)';
        $stmt = $con->prepare($sql);
        $stmt ->bindParam(':comment_post_id',intval($_GET['post_id']));
        $stmt ->bindParam(':comment_author',$_POST['comment_author']);
        $stmt ->bindParam(':comment_body',$_POST['comment_body']);
        $stmt ->bindParam(':comment_status',$comment_status);
        $stmt ->bindParam(':comment_email',$_POST['comment_email']);
        $stmt ->bindParam(':comment_created_at',$comment_created_at);
        $stmt ->bindParam(':comment_reply',$comment_reply);
      
        $stmt->execute();

        if($stmt->rowCount()){
            return true;
        } else {
            return false;
        }

    }
}

function selectAllComment(){
    
    global $con;

    $sql = "SELECT * FROM `comments`";
    $stmt = $con->prepare($sql);
    $stmt -> execute();
    if($stmt -> rowCount()){
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return false;
    }
}

function getPostTitle($post_id){

    global $con;
    
    $sql = "SELECT `post_title` FROM `posts` WHERE `post_id`= ? ";
    $stmt = $con->prepare($sql);
    $stmt -> bindvalue(1,$post_id);
    $stmt ->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result->post_title;
}


function commentConfirm($comment_id){
    
    global $con;
    
    $sql = "UPDATE `comments` SET `comment_status`= ? WHERE comment_id = ?";
    $stmt = $con->prepare($sql);
    $stmt -> bindValue(1,1);
    $stmt -> bindValue(2,$comment_id);
    $stmt -> execute();
    if($stmt -> rowCount()){
        return true;
    } else {
        return false;
    }

}

function commentReject($comment_id){

    global $con;

    $sql = "UPDATE `comments` SET `comment_status`= ? WHERE comment_id = ?";
    $stmt = $con->prepare($sql);
    $stmt -> bindValue(1,0);
    $stmt -> bindValue(2,$comment_id);
    $stmt -> execute();
    if($stmt -> rowCount()){
        return true;
    } else {
        return false;
    }
}

function selectComment($comment_id){

    global $con;

    if(isset($comment_id)){

        $sql = "SELECT * FROM `comments` WHERE `comment_id`=?";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(1,$comment_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

function sendReplyComment($comment_id,$comment_post_id){

    global $con;

    if(isset($_POST['sendReplyComment'])){
        $comment_created_at = date('y-m-d');
        $comment_author = 'مدیر سایت';
        $comment_email = 'admin@admin.com';
        $comment_status = 1;
        $comment_reply = $comment_id;
        
        $sql = 'INSERT INTO `comments`(`comment_post_id`,`comment_author`,`comment_body`,`comment_status`,`comment_email`,`comment_created_at`,`comment_reply`) values (:comment_post_id, :comment_author, :comment_body, :comment_status, :comment_email, :comment_created_at, :comment_reply)';
        $stmt = $con->prepare($sql);
        $stmt ->bindParam(':comment_post_id',$comment_post_id);
        $stmt ->bindParam(':comment_author',$comment_author);
        $stmt ->bindParam(':comment_body',$_POST['comment_body']);
        $stmt ->bindParam(':comment_status',$comment_status);
        $stmt ->bindParam(':comment_email',$comment_email);
        $stmt ->bindParam(':comment_created_at',$comment_created_at);
        $stmt ->bindParam(':comment_reply',$comment_reply);
      
        $stmt->execute();

        if($stmt->rowCount()){
            return true;
        } else {
            return false;
        }
    }
}

function deleteComment($comment_id){

    global $con;

    $sql = "DELETE FROM `comments` WHERE `comment_id`=?";
    $stmt = $con->prepare($sql);
    $stmt -> bindValue(1,$comment_id);
    $stmt -> execute();
    
    if($stmt->rowCount()){
        return $stmt;
    } else {
        return false;
    }
}

function showUserComments($post_id){

    global $con;

    $sql = "SELECT * FROM `comments` WHERE `comment_status` =? and `comment_post_id`=? and `comment_reply`=?";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(1,1);
    $stmt->bindValue(2,$post_id);
    $stmt->bindValue(3,0);
    $stmt->execute();

    if($stmt->rowCount()){
        return $stmt->fetchAll();
    } else {
        return false;
    }
}

function showReplyComment($comment_id){

        global $con;

        $sql = "SELECT * FROM `comments` WHERE `comment_reply`=?";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(1,$comment_id);
        $stmt->execute();

        if($stmt->rowCount()){
            return $stmt->fetchAll();
        } else {
            return false;
        }

}

function loginCheck(){

    global $con;

    if(isset($_POST['login'])){

        
        $sql ="SELECT * FROM `admins` WHERE `admin_username` =? AND `admin_password` =?";
        $stmt = $con ->prepare($sql);
        $stmt -> bindValue(1,$_POST['admin_username']);
        $stmt -> bindValue(2,md5($_POST['admin_password']));
        $stmt -> execute();

        if($stmt->rowCount()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            session_start();
            $_SESSION['AdminId'] = ['admin_id'=>$row['admin_id'],'admin_username' => $row['admin_username']];
            header('location:index.php');
        } else {
            header('location:Login.php?login=error');
        }

    }
}