<?php
session_start();
require_once('connect.php');

$id = $_POST['id_post'];
$title = $_POST['title'];
$category = $_POST['category'];
$content = $_POST['content'];

if(!empty($title)){
    $sql = 
    "UPDATE post SET title = '$title' WHERE id = $id";
    $db->query($sql);
}

if(!empty($category)){
    $sql = 
    "UPDATE post SET category = '$category' WHERE id = $id";
    $db->query($sql);
}

if(!empty($content)){
    $sql = 
    "UPDATE post SET content = '$content' WHERE id = $id";
    $db->query($sql);
}

header("Location: post.php?id={$id}");
?>