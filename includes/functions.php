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
    
    $sql = "SELECT * FROM `posts`";
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