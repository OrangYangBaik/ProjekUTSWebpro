<?php
$error = false;
if($error = false) {
    //the beautifully styled content, everything looks good
    echo '<div id="content">some text</div>';
}
else {
    //bad looking, unstyled error :-( 
} 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="A short description." />
    <meta name="keywords" content="put, keywords, here" />
    <title>PHP-MySQL forum</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<h1>My forum</h1>
    <div id="wrapper">
    <div id="menu">
        <a class="item" href="index.php">Home</a> -
        <a class="item" href="/temp/create_topic.php">Create a topic</a> -
        <a class="item" href="/temp/create_cat.php">Create a category</a>
         
        <div id="userbar">
        <div id="userbar">Hello Example. Not you? Log out.</div>
    </div>
        <div id="content">
        </div>
    </div>
<div id="footer">Created for Nettuts+</div>
</body>
</html>