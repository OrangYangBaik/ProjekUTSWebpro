<?php 
  include('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="icon" href="src/assets/disform.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <form method="POST" enctype="multipart/form-data" action="createpost.php">
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control" placeholder="Enter Your Title" name="title">
            </div>
            <div class="form-group">
          <label for="lang">Language</label>
          <select name="category" id="lang">
            <option value="C">C</option>
            <option value="CPP">C++</option>
            <option value="CSharp">C#</option>
            <option value="Java">Java</option>
            <option value="Javascript">JavaScript</option>
            <option value="PHP">PHP</option>
            <option value="Python">Python</option>
            <option value="Misc">Misc</option>
      </select>
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea class="form-control" rows="3" placeholder="Your Content" name="content"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 20px !important;">Submit</button>
        </form>

      
    </div>
</body>
</html>