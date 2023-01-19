<?php
require_once('connect.php');
session_start();

$id = $_POST['id_profile'];

if(!$_SESSION['isAdmin']){
  header('location: index.php');
}

if($_SESSION['id'] != $id ){
  header('location: index.php');
}

$sql =
"
DELETE FROM commentlikes
WHERE comment_id = ANY(
    SELECT id
    FROM comment
    WHERE post_id = ANY(SELECT id FROM post WHERE user_id = '{$_SESSION['userid']}')
);
DELETE FROM postlikes WHERE post_id = ANY(SELECT id FROM post WHERE user_id = '{$_SESSION['userid']}');
DELETE FROM comment WHERE post_id = ANY(SELECT id FROM post WHERE user_id = '{$_SESSION['userid']}');
DELETE FROM post WHERE user_id = '{$_SESSION['userid']}';
DELETE FROM commentlikes
WHERE comment_id = ANY(
    SELECT id
    FROM comment
    WHERE user_id = '{$_SESSION['userid']}'
);
DELETE FROM comment WHERE user_id = '{$_SESSION['userid']}';
DELETE FROM postlikes WHERE profile_id = '{$id}';
DELETE FROM profile WHERE user_id = '{$_SESSION['userid']}';
DELETE FROM user WHERE id = '{$_SESSION['userid']}'
";    

$db->query($sql);

header('location: signout.php');
die();
?>