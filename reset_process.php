<?php
// whew berantakan banget :p
require_once 'connect.php';
$GLOBALS['result'] = $GLOBALS['error'] = "";
session_start();

if (isset($_SESSION['loggedIn'])) {
    header('location: index.php');
    die();
} ?>

<html>

<head>
    <meta charset="utf-8">
    <title>Password Reset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="login-root">
        <div class="box-root flex-flex flex-direction--column" style="min-height: 100vh;flex-grow: 1;">
            <div class="loginbackground padding-top--64">
                <div class="loginbackground-gridContainer">
                    <div class="box-root flex-flex" style="grid-area: top / start / 8 / end;">
                        <div class="box-root" style="background-image: linear-gradient(white 0%, rgb(247, 250, 252) 33%); flex-grow: 1;">
                        </div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 4 / 2 / auto / 5;">
                        <div class="box-root box-divider--light-all-2 animationLeftRight tans3s" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 6 / start / auto / 2;">
                        <div class="box-root box-background--blue800" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 7 / start / auto / 4;">
                        <div class="box-root box-background--blue animationLeftRight" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 8 / 4 / auto / 6;">
                        <div class="box-root box-background--gray100 animationLeftRight tans3s" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 2 / 15 / auto / end;">
                        <div class="box-root box-background--cyan200 animationRightLeft tans4s" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 3 / 14 / auto / end;">
                        <div class="box-root box-background--blue animationRightLeft" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 4 / 17 / auto / 20;">
                        <div class="box-root box-background--gray100 animationRightLeft tans4s" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 5 / 14 / auto / 17;">
                        <div class="box-root box-divider--light-all-2 animationRightLeft tans3s" style="flex-grow: 1;"></div>
                    </div>
                </div>
            </div>
            <div class="box-root padding-top--24 flex-flex flex-direction--column" style="flex-grow: 1; z-index: 9;">
                <div class="box-root padding-top--48 padding-bottom--24 flex-flex flex-justifyContent--center">
                    <h1><a href="index.php" rel="dofollow"><b>PASSWORD RESET</b></a></h1>
                </div>
                <div class="formbg-outer">
                    <div class="formbg">
                        <div class="formbg-inner padding-horizontal--48">

                            <!-- start -->
                            <?php
                            if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"] == "reset") && !isset($_POST["action"])) {
                                $hidden = $_GET["key"];
                                $email = $_GET["email"];
                                $curDate = date("Y-m-d H:i:s");

                                $stmt = $db->prepare('  SELECT * 
                                                        FROM passreset_temp 
                                                        WHERE hidden = ? AND email = ?');
                                $stmt->execute([$hidden, $email]);
                                $authtemp = $stmt->fetch(PDO::FETCH_ASSOC);

                                if (!$authtemp) {
                                    $GLOBALS['error'] = "The link is invalid or expired. 
                                    Either you did not copy the correct link from the email, or the link has already been used.
                                    Please <a href='https://disform.000webhostapp.com/password_reset.php'> click here</a> to reset your password";
                                } else {
                                    $expDate = $authtemp['expDate'];
                                    if ($expDate >= $curDate) {
                            ?>
                                        <span class="padding-bottom--15">Password Reset</span>
                                        <form id="stripe-login" method="POST">
                                            <input type="hidden" name="action" value="update" />
                                            <input type="hidden" name="email" value="<?= $email; ?>" />
                                            <div class="field">
                                                <label for="password">Password</label>
                                                <input type="password" name="password" id="password">
                                            </div>
                                            <div class="padding-bottom--24">
                                                <input type="checkbox" onclick="showPassword('password')" style="margin-right: 6px;">Show Password
                                            </div>
                                            <div class="field">
                                                <label for="confirm_password">Confirm Password</label>
                                                <input type="password" name="confirm_password" id="confirm_password">
                                            </div>
                                            <div>
                                                <input type="checkbox" onclick="showPassword('confirm_password')" style="margin-right: 6px; margin-bottom: 24px;">Show Password
                                            </div>
                                            <div class="field">
                                                <input type="submit" name="submit" value="Continue">
                                            </div>
                                        </form>
                                    <?php
                                    } else {
                                        $GLOBALS['error'] = "You are trying to use an expired link.
                                Please <a href='https://disform.000webhostapp.com/password_reset.php'> click here</a> to reset your password";
                                    }
                                }
                            } else if (isset($_POST["email"]) && isset($_POST["action"]) && ($_POST["action"] == "update")) {
                                //! surely there is a better way to do this
                                $check = false;
                                if (empty($_POST['password']) || empty($_POST['confirm_password'])) {
                                    $GLOBALS['error'] = "One or more fields is empty.";
                                    $check = true;
                                } else if ($_POST['password'] != $_POST['confirm_password']) {
                                    $GLOBALS['error'] = "Passwords does not match, please try again.";
                                    $check = true;
                                }

                                if ($check) {
                                    ?>
                                    <span class="padding-bottom--15">Password Reset</span>
                                    <form id="stripe-login" method="POST">
                                        <input type="hidden" name="action" value="update" />
                                        <input type="hidden" name="email" value="<?= $email; ?>" />
                                        <div class="field">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" id="password">
                                        </div>
                                        <div class="padding-bottom--24">
                                            <input type="checkbox" onclick="showPassword('password')" style="margin-right: 6px;">Show Password
                                        </div>
                                        <div class="field">
                                            <label for="confirm_password">Confirm Password</label>
                                            <input type="password" name="confirm_password" id="confirm_password">
                                        </div>
                                        <div>
                                            <input type="checkbox" onclick="showPassword('confirm_password')" style="margin-right: 6px; margin-bottom: 24px;">Show Password
                                        </div>
                                        <div class="field">
                                            <input type="submit" name="submit" value="Continue">
                                        </div>
                                    </form>
                            <?php
                                } else {
                                    $password = $_POST['password'];
                                    $email = $_POST["email"];
                                    $curDate = date("Y-m-d H:i:s");

                                    $hashPassword = password_hash($password, PASSWORD_BCRYPT);
                                    $stmt = $db->prepare('UPDATE user SET password = ? WHERE email = ?');
                                    $stmt->execute([$hashPassword, $email]);

                                    $stmt = $db->prepare('DELETE FROM passreset_temp WHERE email = ?');
                                    $stmt->execute([$email]);

                                    $GLOBALS['result'] = "Your password has been reset. <a href='https://disform.000webhostapp.com/signin.php'>Click here</a> to login";
                                }
                            } else {
                                $GLOBALS['error'] = "Unauthorized. Please <a href='https://disform.000webhostapp.com/password_reset.php'> click here</a> to reset your password";
                            } ?>
                            <div style="margin-top: 12px;">
                                <h6><?= $GLOBALS['result'] ?></h6>
                                <h6 style="color: red;"><?= $GLOBALS['error'] ?></h6>
                            </div>
                            <!-- end -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showPassword(id) {
            var form = document.getElementById(id);
            if (form.type === "password") {
                form.type = "text";
            } else {
                form.type = "password";
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
</body>

</html>