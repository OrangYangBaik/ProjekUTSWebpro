<?php
require_once('connect.php');
session_start();

$id = $_GET['id_post'];
$sql = "SELECT * FROM post WHERE id = ?";
$stmt = $db->prepare($sql);
$data = [$id];
$stmt->execute($data);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" 
        crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="container-fluid justify-content-center">
      <?php 
        include('navbar.php');
        ?>
        <form action="index.php" class="mx-5" method="post">
            <a class="text-decoration-none text-reset" href="index.php">
                <button type="submit" class="mt-5 btn btn-primary rounded-5" style="width: 100px; color:white !important;">
                    <b>Back</b> 
                </button>
            </a>
        </form>
        <form action="update.php" method="post">		
            <table>
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="hidden" name="id_post" value="<?= $id?>">
                        <input type="text" name="title">
                    </td>					
                </tr>	
                <tr>
                    <td>Category</td>
                    <td>
                            <select name="Category" id="lang">
                            <option value="C">C</option>
                            <option value="CPP">C++</option>
                            <option value="CSharp">C#</option>
                            <option value="Java">Java</option>
                            <option value="Javascript">JavaScript</option>
                            <option value="PHP">PHP</option>
                            <option value="Python">Python</option>
                            <option value="Misc">Misc</option>
      </select>
                    </td>					
                </tr>	
                <tr>
                    <td>Content</td>
                    <td>
                        <input type="text" name="content">
                    </td>					
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit">
                    </td>					
                </tr>				
            </table>
	    </form>
    </div>
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" 
        crossorigin="anonymous">
    </script>
  </body>
</html>