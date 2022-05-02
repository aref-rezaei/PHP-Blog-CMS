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

function selectCategory(){

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

function selectCategoryForFetch($category_id){

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