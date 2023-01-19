<?php
    session_start();
    require_once 'connect.php';
    if (!empty($_GET)) {
        $id = $_GET['id'];
        $sql = 
          "SELECT id, first_name, last_name, photo
          FROM profile 
          WHERE id='{$id}'";
        $result = $db->query($sql);
        $profilerow = $result->fetch(PDO::FETCH_ASSOC);

        $sql = 
          "SELECT username, email
          FROM user
          WHERE id='{$_SESSION['userid']}'";
        $result = $db->query($sql);
        $userrow = $result->fetch(PDO::FETCH_ASSOC);
    } else if(!empty($_POST)) {
        $id = $_POST['id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];

        $_SESSION['username'] = $username;

        $stmt = $db->prepare("
          UPDATE profile 
          SET first_name = ?, last_name = ? 
          WHERE id = ?;
          UPDATE user
          SET username = ?, email = ?
          WHERE id = ?
          ");
        $stmt->execute([$first_name, $last_name, $id, $username, $email, $_SESSION['userid']]);
      
        if($_FILES['photo']['name'] != "") {
          $filename = $_FILES['photo']['name'];
          $temp_file = $_FILES['photo']['tmp_name'];

          $file_ext = explode(".", $filename);
          $file_ext = end($file_ext);
          $file_ext = strtolower($file_ext);
          $filepath = "src/uploads/{$filename}";

          move_uploaded_file($temp_file, $filepath);
          $stmt = $db->prepare("
          UPDATE profile 
          SET photo = ?
          WHERE id = ?
          ");
          $stmt->execute([$filepath, $id]);
        }

        header("location: profile.php?id={$id}&section=1");
        die();
    }

    require_once 'close.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="icon" href="src/assets/disform.png">
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" 
        crossorigin="anonymous">
</head>

<body>
    <?php 
        include('navbar.php');
        ?>
      <div class="mx-md-5 mt-3 mb-5 p-3 border rounded-5 shadow" style="background-color: white;">
        <form class="col-md-4 offset-md-4" action="edit_profile.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <center><h1 style="color:black">Edit Profile</h1></center>
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" 
                name="first_name" placeholder="<?= $profilerow['first_name'] ?>" value="<?= $profilerow['first_name'] ?>" required>
            </div>
            <div class="form-group">
                <label for="nama">Last Name</label>
                <input type="text" class="form-control" id="last_name" 
                name="last_name" placeholder="<?= $profilerow['last_name'] ?>" value="<?= $profilerow['last_name'] ?>" required>
            </div>
            <div class="form-group">
                <label for="nama">Username</label>
                <input type="text" class="form-control" id="last_name" 
                name="username" placeholder="<?= $userrow['username'] ?>" value="<?= $userrow['username'] ?>" required>
            </div>
            <div class="form-group">
                <label for="nama">Email</label>
                <input type="text" class="form-control" id="last_name" 
                name="email" placeholder="<?= $userrow['email'] ?>" value="<?= $userrow['email'] ?>" required>
            </div>
            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" class="form-control" id="photo" 
                name="photo" placeholder="Profile Picture"">
            </div>
            <input type="hidden" name="id" value="<?= $profilerow['id'] ?>">
            <button type="submit" class="btn btn-primary" style="margin-top: 20px !important">Submit</button>
      <a href="index.php" type="submit" class="btn btn-primary" style="margin-top: 20px !important">Back</a>
        </form>
      </div>
  </div>
</body>

</html>