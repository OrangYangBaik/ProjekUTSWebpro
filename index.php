<?php
session_start();
require_once('connect.php');

$sql = "
SELECT post.id AS id, 
user.username AS username,
profile.photo AS photo,
CONCAT(
    CASE
        WHEN DAY(post.time) < 10 THEN CONCAT('0', DAY(post.time))
        ELSE DAY(post.time)
    END, ' ',
    CASE
        WHEN MONTH(post.time) = 1 THEN 'Jan'
        WHEN MONTH(post.time) = 2 THEN 'Feb'
        WHEN MONTH(post.time) = 3 THEN 'Mar'
        WHEN MONTH(post.time) = 4 THEN 'Apr'
        WHEN MONTH(post.time) = 5 THEN 'May'
        WHEN MONTH(post.time) = 6 THEN 'Jun'
        WHEN MONTH(post.time) = 7 THEN 'Jul'
        WHEN MONTH(post.time) = 8 THEN 'Aug'
        WHEN MONTH(post.time) = 9 THEN 'Sep'
        WHEN MONTH(post.time) = 10 THEN 'Oct'
        WHEN MONTH(post.time) = 11 THEN 'Nov'
        ELSE 'Dec'
    END, ' ',
    YEAR(post.time)
) AS postdate,
CONCAT(
    CASE
        WHEN HOUR(post.time) < 10 THEN CONCAT('0', HOUR(post.time))
        ELSE HOUR(post.time)
    END, ':',
    CASE
        WHEN MINUTE(post.time) < 10 THEN CONCAT('0', MINUTE(post.time))
        ELSE MINUTE(post.time)
    END
) AS posttime,
post.category AS category,
post.title AS title,
post.likes AS likes,
post.comments AS comments
FROM post INNER JOIN profile ON post.profile_id = profile.id
          INNER JOIN user ON post.user_id = user.id
ORDER BY (post.likes * 0.3 + post.comments * 0.7) DESC";

$hasil = $db->query($sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link rel="icon" href="src/assets/disform.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>
          <?php 
        include('navbar.php');
        ?>
    <div class="container-fluid justify-content-center">
        <?php
        if (!isset($_SESSION['loggedIn'])) {
        ?>
            <h1 class="text-center my-5 fw-bold" style="font-size: 48pt; color: rgb(114, 137, 218);" data-aos="fade-down">Hello!</h1>
            <h2 class="text-center mb-1">Welcome To Disform</h2>
            <p class="text-center" style="color: rgb(78, 93, 148);">
                <a href="signin.php" class="text-decoration-none text-reset"><b>Login</b></a>
                or
                <a href="signup.php" class="text-decoration-none text-reset"><b>Register</b></a>
                to participate in this forum.
            </p>
        <?php
        } else { ?>
            <h1 class="text-center my-5 fw-bold" style="font-size: 48pt; color: rgb(114, 137, 218);" data-aos="fade-down">Hello, <?= $_SESSION['username'] ?></h1>
            <h2 class="text-center mb-1">Welcome To Disform</h2>
            <form action="add_post.php" class="mx-5 p-3 text-center" method="post">
            <button type="submit" class="p-3 btn btn-primary rounded-5" style="width: 200px;">
                <b>Add Post</b>
            </button>
        </form>
        <?php
        } ?>

        <?php
        while ($row = $hasil->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="user-post mx-md-5 mt-3 mb-5 p-3 border rounded-5 shadow" style="background-color: white;">
                <a href="post.php?id=<?= $row['id'] ?>" class="text-decoration-none text-reset">
                    <div class="p-1" style="color: rgb(78, 93, 148);">
                        <img class="d-inline align-middle border rounded-circle" src="<?= $row['photo'] ?>" width="48px" height="48px">
                        <h5 class="d-inline mx-3 align-middle"><?= $row['username'] ?></h5>
                        <img class="d-inline mx-1 align-middle" src="src/<?= $row['category'] ?>.png" width="32px">
                        <p class="d-inline mx-2 align-middle">•</p>
                        <p class="d-inline ms-1 align-middle"><?= $row['postdate'] ?></p>
                        <p class="d-inline ms-1 align-middle"><?= $row['posttime'] ?></p>
                    </div>

                    <div class="p-1">
                        <h3 class="ps-1" style="color: rgb(114, 137, 218);"><?= $row['title'] ?></h3>
                    </div>

                    <div class="p-1 mb-3">
                        <img class="d-inline mx-1 align-middle" src="src/like.png" width="24px" height="24px">
                        <p class="d-inline me-3 align-middle"><?= $row['likes'] ?></p>
                        <img class="d-inline mx-1 align-middle" src="src/comment.png" width="24px" height="24px">
                        <p class="d-inline align-middle"><?= $row['comments'] ?></p>
                    </div>
                </a>
            </div>
        <?php
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>