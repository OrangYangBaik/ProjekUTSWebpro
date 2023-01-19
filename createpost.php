<?php
session_start();
require_once 'connect.php';

if(isset($_POST['title'])) {
  date_default_timezone_set("Asia/Jakarta");

  $title = $_POST['title'];
  $category = $_POST['category'];
  $content = $_POST['content'];
  $datetime = date("Y-m-d") . " " . date("H:i:s");
  $like = 0;
  $comment = 0;
  $profile_id = $_SESSION['id'];
  $user_id = $_SESSION['userid'];

  $query = "INSERT INTO post(title, category, content, time, likes, comments, profile_id, user_id) 
            VALUES(?,?,?,?,?,?,?,?)";

  $error = "";
  try {
    $stmt = $db->prepare($query);
    $stmt->execute([$title, $category, $content, $datetime, $like, $comment, $profile_id, $user_id]);
    header('Location: index.php');
    die();
  } catch(Exception $ex) {
      $error = $ex->getMessage();
      echo $error;
  }
}   
?>