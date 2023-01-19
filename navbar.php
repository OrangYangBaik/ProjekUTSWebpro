
    <nav class="navbar navbar-expand-lg navbar-light bg-light d-flex px-5" id="navbar">
        <div id="logo_kita" class="navbar-brand">
            <img src="src/assets/disform.png" width="30" height="30" class="d-inline-block align-top" alt="">
            <h4 class="d-inline-block align-top">Disform</h4>
        </div>
        <div id="logo_home">
            <a class="text-decoration-none text-reset" href="index.php" style="animation-delay:0.14s" id="bouncy">
                <img class="d-inline-block align-top" src="src/assets/home.png">
                <h6 class="ms-1 d-inline-block align-top">Home</h6>
            </a>
        </div>
        <div id="logo_answer">
            <a class="text-decoration-none text-reset" href="category.php?cat=C" style="animation-delay:0.28s" id="bouncy">
                <img class="d-inline-block align-top" src="src/assets/conversation.png">
                <h6 class="ms-1 d-inline-block align-top">Category</h6>
            </a>
        </div>

        <div class="navbar-nav" style="margin-left: auto;">
            <div>
                <?php
                session_start();

                if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
                ?>
  <div class="d-inline-block align-top text-decoration-none text-reset me-3 pt-2">
  <div class="dropdown">
  <button class="dropbtn" data-aos="fade-down"><?= $_SESSION['username'] ?></button>
  <div class="dropdown-content">
    <a href="profile.php?id=<?= $_SESSION['id'] ?>&section=1">Profile Dashboard</a>
    <a href="edit_profile.php">Edit Profile</a>
    <a href="signout.php">Sign Out</a>
  </div>
  </div>
</div>
                    <a href="add_post.php" class="d-inline-block align-center p-2 mt-3 btn btn-primary rounded-5 text-decoration-none text-reset" style="width: 100px; color: white !important;">
                        <b>Add Post</b>
                    </a>
                <?php
                } else {
                ?>
                    <a class="text-decoration-none text-reset" href="signin.php" style="animation-delay:0.56s" id="bouncy">
                        <h6 class="ms-1 d-inline-block align-top">Sign In</h6>
                    </a>
                <?php
                } ?>
            </div>
        </div>
    </nav>

</html>