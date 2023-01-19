<?php
session_start();
require_once('connect.php');
date_default_timezone_set("Asia/Jakarta");

if (!empty($_POST['like'])) {
  $stmt = $db->prepare("INSERT INTO postlikes(post_id, profile_id) VALUES(?,?)");
  $stmt->execute([$_POST['postid'], $_SESSION['id']]);

  $stmt = $db->prepare("
  UPDATE post 
  SET likes = (SELECT COUNT(*) FROM postlikes WHERE post_id = ?)
  WHERE id = ?
  ");
  $stmt->execute([$_POST['postid'], $_POST['postid']]);
}

if (!empty($_POST['unlike'])) {
  $stmt = $db->prepare("DELETE FROM postlikes WHERE post_id = ? AND profile_id = ?");
  $stmt->execute([$_POST['postid'], $_SESSION['id']]);

  $stmt = $db->prepare("
  UPDATE post 
  SET likes = (SELECT COUNT(*) FROM postlikes WHERE post_id = ?)
  WHERE id = ?
  ");
  $stmt->execute([$_POST['postid'], $_POST['postid']]);
}

if (!empty($_POST['commentadd'])) {
  $datetime = date("Y-m-d") . " " . date("H:i:s");
  $stmt = $db->prepare(
    "INSERT INTO comment(post_id, user_id, profile_id, time, content, likes) 
     VALUES(?,?,?,?,?,?)");
  $stmt->execute([$_POST['postid'], $_SESSION['userid'], $_SESSION['id'], $datetime, $_POST['commentadd'], 0]);

  $stmt = $db->prepare("
  UPDATE post 
  SET comments = (SELECT COUNT(*) FROM comment WHERE post_id = ?)
  WHERE id = ?
  ");
  $stmt->execute([$_POST['postid'], $_POST['postid']]);
}

if (!empty($_POST['commentdelete'])) {
  $stmt = $db->prepare("DELETE FROM commentlikes WHERE comment_id = ?");
  $stmt->execute([$_POST['commentid']]);
  
  $stmt = $db->prepare("DELETE FROM comment WHERE id = ?");
  $stmt->execute([$_POST['commentid']]);

  $stmt = $db->prepare("
  UPDATE post
  SET comments = (SELECT COUNT(*) FROM comment WHERE post_id = ?)
  WHERE id = ?
  ");
  $stmt->execute([$_POST['postid'], $_POST['postid']]);
}

if (!empty($_POST['commentlike'])) {
  $stmt = $db->prepare("INSERT INTO commentlikes(comment_id, profile_id) VALUES(?,?)");
  $stmt->execute([$_POST['commentid'], $_SESSION['id']]);

  $stmt = $db->prepare("
  UPDATE comment 
  SET likes = (SELECT COUNT(*) FROM commentlikes WHERE comment_id = ?)
  WHERE id = ?
  ");
  $stmt->execute([$_POST['commentid'], $_POST['commentid']]);
}

if (!empty($_POST['commentunlike'])) {
  $stmt = $db->prepare("DELETE FROM commentlikes WHERE comment_id = ? AND profile_id = ?");
  $stmt->execute([$_POST['commentid'], $_SESSION['id']]);

  $stmt = $db->prepare("
  UPDATE comment 
  SET likes = (SELECT COUNT(*) FROM commentlikes WHERE comment_id = ?)
  WHERE id = ?
  ");
  $stmt->execute([$_POST['commentid'], $_POST['commentid']]);
}

header("location: post.php?id={$_POST['postid']}");
require_once('close.php');