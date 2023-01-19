<?php
require_once('connect.php');
session_start();

if($_SESSION['isAdmin'] == TRUE){
  $id = $_POST['id_profile'];
  $sql = "UPDATE post SET state = 'banned' WHERE id = $id";
  $db->query($sql);
  header("location: index.php");
}
?>