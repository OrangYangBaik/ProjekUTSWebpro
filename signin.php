<?php
$GLOBALS['error'] = "";

if (isset($_POST['username'])) {
    require_once 'connect.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare('SELECT id, username, password, access, state FROM user WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $db->prepare('SELECT id FROM profile WHERE user_id = ?');
    $stmt->execute([$user['id']]);
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    try {
        if ($user && password_verify($password, $user['password'])) {
            if ($user['state'] == 'banned') {
                throw new Exception("User is banned from accessing the forum. Please contact Disform support to appeal");
            } else {
                session_start();

                $_SESSION['loggedIn'] = true;
                $_SESSION['userid'] = $user['id'];
                $_SESSION['id'] = $profile['id'];
                $_SESSION['username'] = $username;
                $_SESSION['errorMsg'] = "";

                if ($user['access'] = 'admin') {
                    $_SESSION['isAdmin'] = true;
                } else {
                    $_SESSION['isAdmin'] = false;
                }

                header("location: profile.php?id={$profile['id']}&section=1");
                die();
            }
        } else {
            throw new Exception("Username or password is invalid");
        }
    } catch (Exception $e) {
        $GLOBALS['error'] = $e->getMessage();
    }
    require_once 'close.php';
}
?>

<html>

<head>
    <meta charset="utf-8">
    <title>Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="src/assets/disform.png">
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
                    <h1><a href="index.php" rel="dofollow"><b>SIGN IN</b></a></h1>
                </div>
                <div class="formbg-outer">
                    <div class="formbg">
                        <div class="formbg-inner padding-horizontal--48">
                            <span class="padding-bottom--15">Sign in to your account</span>
                            <form id="stripe-login" method="POST">
                                <div class="field padding-bottom--24">
                                    <label for="email">Username</label>
                                    <input type="text" name="username" id="username">
                                </div>
                                <div class="field">
                                    <div class="grid--50-50">
                                        <label for="password">Password</label>
                                        <div class="reset-pass">
                                            <a href="password_reset.php">Forgot your password?</a>
                                        </div>
                                    </div>
                                    <input type="password" name="password" id="password">
                                </div>
                                <div>
                                    <input type="checkbox" onclick="showPassword('password')" style="margin-right: 6px;">Show Password
                                </div>
                                <h6 style="color: red; padding: 10px 0 6px 0;"><?= $GLOBALS['error'] ?></h6>
                                <div class="field padding-bottom--24">
                                    <input type="submit" name="submit" value="Continue">
                                </div>
                            </form>
                            <div>
                                <h6>Don't have an account? <a href="signup.php">Sign up</a> now!
                            </div>
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