<?php 
session_start();
require_once('connect.php');

if (!isset($_GET['id'])) {
  header('location: index.php');
}

$postid = $_GET['id'];

$sql = "
SELECT user.username AS username,
profile.photo AS photo,
profile.id AS profileid,
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
post.content AS content,
post.likes AS likes,
post.comments AS comments
FROM post INNER JOIN profile ON post.profile_id = profile.id
          INNER JOIN user ON post.user_id = user.id
WHERE post.id = '{$postid}'";

$hasil = $db->query($sql);
$postrow = $hasil->fetch(PDO::FETCH_ASSOC);

if ($postrow == NULL) header('location: index.php');

$sql = "
SELECT comment.id AS id, 
user.username AS username,
profile.photo AS photo,
comment.profile_id AS profileid,
CONCAT(
    CASE
        WHEN DAY(comment.time) < 10 THEN CONCAT('0', DAY(post.time))
        ELSE DAY(comment.time)
    END, ' ',
    CASE
        WHEN MONTH(comment.time) = 1 THEN 'Jan'
        WHEN MONTH(comment.time) = 2 THEN 'Feb'
        WHEN MONTH(comment.time) = 3 THEN 'Mar'
        WHEN MONTH(comment.time) = 4 THEN 'Apr'
        WHEN MONTH(comment.time) = 5 THEN 'May'
        WHEN MONTH(comment.time) = 6 THEN 'Jun'
        WHEN MONTH(comment.time) = 7 THEN 'Jul'
        WHEN MONTH(comment.time) = 8 THEN 'Aug'
        WHEN MONTH(comment.time) = 9 THEN 'Sep'
        WHEN MONTH(comment.time) = 10 THEN 'Oct'
        WHEN MONTH(comment.time) = 11 THEN 'Nov'
        ELSE 'Dec'
    END, ' ',
    YEAR(comment.time)
) AS commentdate,
CONCAT(
    CASE
        WHEN HOUR(comment.time) < 10 THEN CONCAT('0', HOUR(comment.time))
        ELSE HOUR(comment.time)
    END, ':',
    CASE
        WHEN MINUTE(comment.time) < 10 THEN CONCAT('0', MINUTE(comment.time))
        ELSE MINUTE(comment.time)
    END
) AS commenttime,
comment.content AS content,
comment.likes AS likes
FROM comment INNER JOIN post ON comment.post_id = post.id
             INNER JOIN profile ON comment.profile_id = profile.id
             INNER JOIN user ON comment.user_id = user.id
WHERE comment.post_id = '{$postid}'
ORDER BY comment.time ASC";

$comments = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Post | <?= $postrow['title'] ?></title>
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" 
        crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="container-fluid justify-content-center">
        <form action="index.php" class="mx-md-5" method="post">
            <button type="submit" class="mt-5 btn btn-primary rounded-5" style="width: 100px; color:white !important;">
                <b>Back</b> 
            </button>
        </form>

        <div 
            class="mx-md-5 mt-3 mb-5 p-3 border rounded-5 shadow" 
            style="background-color: white;">
            <div class="p-1" style="color: rgb(78, 93, 148);">
                <a href="profile.php?id=<?= $postrow['profileid'] ?>&section=1" class="text-decoration-none text-reset">
                    <img class="d-inline align-middle border rounded-circle" src="<?= $postrow['photo'] ?>" width="48px" height="48px">
                    <h5 class="d-inline mx-3 align-middle"><?= $postrow['username'] ?></h5>
                </a>
            </div>

            <div class="p-1">
                <p class="d-inline ms-1 align-middle" style="color: rgb(78, 93, 148);">Posted on:</p>
                <p class="d-inline ms-1 align-middle"><?= $postrow['postdate'] ?></p>
                <p class="d-inline mx-1 align-middle">•</p>
                <p class="d-inline align-middle"><?= $postrow['posttime'] ?></p>
            </div>

            <div class="p-1 mb-3">
                <p class="d-inline ms-1 align-middle" style="color: rgb(78, 93, 148);">Category:</p>
                <a href="category.php?cat=<?= $postrow['category'] ?>" class="text-decoration-none text-reset">
                    <img class="d-inline mx-1 align-middle" src="src/<?= $postrow['category'] ?>.png" width="24px" height="24px">
                    <p class="d-inline align-middle"><?= $postrow['category'] ?></p>
                </a>
            </div>

            <?php 
            if (!empty($_SESSION['loggedIn'])) {
            ?>
              <?php 
              if ($postrow['profileid'] == $_SESSION['id']) {
              ?>
              <form action="edit.php" class="p-2 d-inline" method="get">
                <button type="submit" class="mb-1 btn btn-outline-success rounded-5" style="width: 100px;">Edit</button>
                <input type="hidden" name="id_post" value="<?= $postid ?>">
              </form>

              <form action="delete.php" class="p-2 d-inline" method="get">
                  <button type="submit" class="mb-1 btn btn-outline-danger rounded-5" style="width: 100px;">Delete</button>
                <input type="hidden" name="id_post" value="<?= $postid ?>">
              </form>
              <?php 
              }
              ?>
            <?php 
            }
            ?>

            <hr>

            <div class="p-1">
                <h3 class="ps-1" style="color: rgb(114, 137, 218);"><?= $postrow['title'] ?></h3>
            </div>

            <div class="p-1 mb-3">
                <p class="ps-1"><?= $postrow['content'] ?></p>
            </div>

            <?php 
            if (!empty($_SESSION['loggedIn'])) {
            ?>
            <div class="p-1 mb-3">
                <p class="ms-1">Do you find this useful?</p>
                <?php 
                $sql = "
                SELECT *
                FROM postlikes
                WHERE post_id = '{$postid}' AND profile_id = '{$_SESSION['id']}';";
                
                $hasil = $db->query($sql);
                if ($hasil->fetch(PDO::FETCH_ASSOC) == NULL) {
                ?>
                <form action="post_process.php" method="post">
                  <button type="submit" id="like" class="ms-1 btn btn-outline-primary rounded-3" style="width: 80px;" name="like" value="1">
                    <img class="d-inline align-middle" src="src/like.png" width="24px">
                  </button>
                  <input type="hidden" name="postid" value="<?= $postid ?>">
                </form>
                <?php 
                } else {
                ?>
                <form action="post_process.php" method="post">
                  <button type="submit" id="unlike" class="ms-1 btn btn-primary rounded-3" style="width: 80px;" name="unlike" value="1">
                    <img class="d-inline align-middle" src="src/like.png" style="filter: invert(100%);" width="24px">
                  </button>
                  <input type="hidden" name="postid" value="<?= $postid ?>">
                </form>
                <?php 
                }
                ?>
            </div>
            <?php 
            }
            ?>

            <div class="p-1 mb-3">
                <img class="d-inline mx-1 align-middle" src="src/like.png" width="32px" height="32px">
                <h5 class="ms-1 d-inline align-middle"><?= $postrow['likes'] ?> People Liked This Post</h5>
            </div>

            <div class="p-1">
                <h3 class="d-inline ms-1 align-middle">Comments</h3>
                <h3 class="d-inline mx-2 align-middle">•</h3>
                <h3 class="d-inline align-middle fw-light"><?= $postrow['comments'] ?></h3>
            </div>

            <?php 
            if (!empty($_SESSION['loggedIn'])) {
            ?>
            <div class="p-1 mt-3">
                <form action="post_process.php" class="mx-1" method="post">
                    <div class="mb-1">
                        <textarea class="form-control mb-3" rows="3" placeholder="Add your comment here..." name="commentadd"></textarea>
                        <button type="submit" class="btn btn-primary rounded-3" style="width: 100px;">Post</button>
                        <input type="hidden" name="postid" value="<?= $postid ?>">
                    </div>
                </form>
            </div>
            <?php 
            }
            ?>

            <hr>
          
            <?php
            while ($commentrow = $comments->fetch(PDO::FETCH_ASSOC)) {
            ?>
              <div 
                class="mx-2 mt-3 mb-5 p-3 border rounded-5" 
                style="background-color: rgb(114, 137, 218);
                       color: white">
                
                <div class="p-1 mb-3">
                    <a href="profile.php?id=<?= $commentrow['profileid'] ?>&section=1" class="text-decoration-none text-reset">
                        <img class="d-inline align-middle rounded-circle" src="<?= $commentrow['photo'] ?>" width="48px" height="48px">
                        <h5 class="d-inline mx-2 align-middle"><?= $commentrow['username'] ?></h5>
                    </a>
                    <p class="d-inline mx-1 align-middle">•</p>
                    <p class="d-inline ms-1 align-middle"><?= $commentrow['commentdate'] ?></p>
                    <p class="d-inline ms-1 align-middle"><?= $commentrow['commenttime'] ?></p>
                </div>

                <div class="p-1 mb-3">
                    <p class="ps-1"><?= $commentrow['content'] ?></p>
                </div>

                <div class="p-1 mb-3" style="color: white;">
                    <img class="d-inline mx-1 align-middle" src="src/like.png" style="filter: invert(100%);" width="32px" height="32px">
                    <p class="d-inline me-3 align-middle"><?= $commentrow['likes'] ?></p>
                </div>

                <?php 
                if (!empty($_SESSION['loggedIn'])) {
                ?>
                  <?php 
                  $sql = "
                  SELECT *
                  FROM commentlikes
                  WHERE comment_id = '{$commentrow['id']}' AND profile_id = '{$_SESSION['id']}';";
                
                  $hasil = $db->query($sql);
                  if ($hasil->fetch(PDO::FETCH_ASSOC) == NULL) {
                  ?>
                  <form action="post_process.php" class="p-2 d-inline" method="post">
                    <button type="submit" class="mb-3 btn btn-primary rounded-5" style="width: 100px;" name="commentlike" value="1">Like</button>
                    <input type="hidden" name="commentid" value="<?= $commentrow['id'] ?>">
                    <input type="hidden" name="postid" value="<?= $postid ?>">
                  </form>
                  <?php 
                  } else {
                  ?>
                  <form action="post_process.php" class="p-2 d-inline" method="post">
                    <button type="submit" class="mb-3 btn btn-success rounded-5" style="width: 100px;" name="commentunlike" value="1">Unlike</button>
                    <input type="hidden" name="commentid" value="<?= $commentrow['id'] ?>">
                    <input type="hidden" name="postid" value="<?= $postid ?>">
                  </form>
                  <?php 
                  }
                  ?>
                    
                  <form action="post_process.php" class="p-2 d-inline" method="post">
                    <button type="submit" class="mb-3 btn btn-danger rounded-5" style="width: 100px;" name="commentdelete" value="1">Delete</button>
                    <input type="hidden" name="commentid" value="<?= $commentrow['id'] ?>">
                    <input type="hidden" name="postid" value="<?= $postid ?>">
                  </form>
                <?php 
                }
                ?>
              </div>
            <?php
            }
            require_once('close.php');
            ?>
        </div>
    </div>
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" 
        crossorigin="anonymous">
    </script>
  </body>
</html>