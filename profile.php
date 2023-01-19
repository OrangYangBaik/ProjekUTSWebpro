<?php 
session_start();

require_once('connect.php');

if (!empty($_GET['section'])) {
  $section = $_GET['section'];
  
  switch ($section) {
    case 1: $bgsc1 = "color: rgb(114, 137, 218);"; break;
    case 2: $bgsc2 = "color: rgb(114, 137, 218);"; break;
    case 3: $bgsc3 = "color: rgb(114, 137, 218);"; break;
  }
}

if (!isset($_GET['id'])) {
  header('location: index.php');
}

$profileid = $_GET['id'];

$sql = "
SELECT profile.id AS id,
profile.photo AS photo,
user.username AS username,
user.email AS email,
CONCAT(profile.first_name, ' ', profile.last_name) AS fullname,
(SELECT COUNT(id) FROM post WHERE profile_id = '{$profileid}') AS total
FROM profile INNER JOIN user ON profile.user_id = user.id
WHERE profile.id = '{$profileid}'";

$hasil = $db->query($sql);
$profilerow = $hasil->fetch(PDO::FETCH_ASSOC);

require_once('close.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" 
        crossorigin="anonymous">
  <link rel="icon" href="src/assets/disform.png">
</head>
<body>
    <div class="container-fluid justify-content-center px-0">
        <?php 
        include('navbar.php');
        ?>
        <div class="mx-md-5 mt-3 mb-5 p-3 border rounded-5 shadow" style="background-color: white;">
            <div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-xl-4">
                                <img class="border rounded-circle" src="<?= $profilerow['photo'] ?>" width="205px">
                            </div>
                            <div class="col-xl-8 ps-xl-5 ps-4">
                                <h3 class="pt-3" style="color: rgb(114, 137, 218);"><?= $profilerow['username'] ?></h3>
                                <h6 class="mb-3" style="color: rgb(114, 137, 218);">User ID: #<?= $profilerow['id'] ?></h6>
                                <p class="mb-1">Name: <?= $profilerow['fullname'] ?></p>
                                <p class="mb-1">Email: <?= $profilerow['email'] ?></p>
                                <p>Total Post: <?= $profilerow['total'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 pe-5 text-lg-end">
                        <?php     
                        if ($_SESSION['id'] == $profileid) {
                        ?>
                        <form action="edit_profile.php" class="pt-3" method="get">
                            <button type="submit" class="mb-3 btn btn-outline-success rounded-5" style="width: 100px;">Edit</button>
                            <input type="hidden" name="id" value="<?= $profileid ?>">
                        </form>
                         <?php
                        }
                        ?>
                      <?php     
                        if ($_SESSION['isAdmin'] == true) {
                      ?>
                           <form action="delete_profile.php" method="post">
                              <input type="hidden" name="id_profile" value="<?= $profileid ?>">
                              <button type="submit" class="mb-3 btn btn-outline-danger rounded-5" style="width: 100px;">Delete</button>
                            </form>
                          <form action="ban.php" method="POST">
                            <button type="submit" class="mb-3 btn btn-outline-dark rounded-5" style="width: 100px;">Ban</button>
                            <input type="hidden" name="id_profile" value="<?= $profileid ?>">
                          </form>
                          <form action="unban.php" method="post">
                            <button type="submit" class="mb-3 btn btn-outline-dark rounded-5" style="width: 100px;">Unban</button>
                             <input type="hidden" name="id_profile" value="<?= $profileid ?>">
                          </form>
                      <?php
                        }
                      ?>
                    </div>
                </div>
            </div>

            <a href="post_statistics.php">User Post Statistics</a>
            
            <nav class="navbar navbar-expand-lg no_padding justify-content-center">
                <div class="row">
                    <div class="col hover-underline-animation px-5">
                        <a class="text-decoration-none text-reset" href="profile.php?id=<?= $profilerow['id'] ?>&section=1"><h3 style="<?= $bgsc1 ?>">Posts</h3></a>
                    </div>
                    <div class="col hover-underline-animation px-5">
                        <a class="text-decoration-none text-reset" href="profile.php?id=<?= $profilerow['id'] ?>&section=2"><h3 style="<?= $bgsc2 ?>">Likes</h3></a>
                    </div>
                    <div class="col hover-underline-animation px-5">
                        <a class="text-decoration-none text-reset" href="profile.php?id=<?= $profilerow['id'] ?>&section=3"><h3 style="<?= $bgsc3 ?>">Comments</h3></a>
                    </div>
                </div>
            </nav>
      
            <hr>    

            
        </div>
    </div>
</body>
</html>