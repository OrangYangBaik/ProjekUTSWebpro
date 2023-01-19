<?php
session_start();
require_once('connect.php');
$id = $_GET['id_post'];

$sql =
"
DELETE FROM commentlikes
WHERE comment_id = ANY(
    SELECT id
    FROM comment
    WHERE post_id = '{$id}'
);
DELETE FROM postlikes WHERE post_id = '{$id}';
DELETE FROM comment WHERE post_id = '{$id}';
DELETE FROM post WHERE id = '{$id}'";

$db->query($sql);

header('location: index.php');
?>