<?php
$GLOBALS['error'] = "";

if (isset($_POST['email']) || isset($_POST['firstname']) || isset($_POST['lastname']) || isset($_POST['username'])  || isset($_POST['password'])) {
    require_once 'connect.php';
    try {
        if ((!empty($_POST['email'])) && !empty($_POST['username']) && !empty($_POST['password'])) {
            if (($_POST['password'] != $_POST['confirm_password'])) {
                throw new Exception("Passwords do not match, please try again.");
            } else {
                $email = $_POST['email'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $profileid = substr(strtoupper(uniqid()), 7);
                $access = 'member';
                $state = 'safe';
                $defaultphoto = 'src/default.jpg';

                $hashPassword = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $db->prepare("INSERT INTO user(email, username, password, access, state) VALUES(?,?,?,?,?)");
                $stmt->execute([$email, $username, $hashPassword, $access, $state]);

                $query = "SELECT id FROM user WHERE email = '{$email}'";
                $result = $db->query($query);
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $stmt = $db->prepare("INSERT INTO profile(id, user_id, first_name, last_name, photo) VALUES(?,?,?,?,?)");
                $stmt->execute([$profileid, $row['id'], $firstname, $lastname, $defaultphoto]);
                
                require_once 'close.php';
                header('Location: signin.php?success=1');
                die();
            }
        } else {
            throw new Exception("One or more fields required is empty!");
        }
    } catch (Exception $e) {
        $GLOBALS['error'] = $e->getMessage();
    }
}
?>

<html>

<head>
    <meta charset="utf-8">
    <title>Sign Up</title>
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
                    <h1><a href="index.php" rel="dofollow"><b>SIGN UP</b></a></h1>
                </div>
                <div class="formbg-outer">
                    <div class="formbg">
                        <div class="formbg-inner padding-horizontal--48">
                            <span class="padding-bottom--15">Create new account</span>
                            <form id="stripe-login" method="POST">
                                <div class="field padding-bottom--24">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email">
                                </div>
                                <div class="field padding-bottom--24">
                                    <label for="fname">First Name</label>
                                    <input type="text" name="firstname" id="fname">
                                </div>
                                <div class="field padding-bottom--24">
                                    <label for="lname">Last Name</label>
                                    <input type="text" name="lastname" id="lname">
                                </div>
                                <div class="field padding-bottom--24">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username">
                                </div>
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
                                    <input type="checkbox" onclick="showPassword('confirm_password')" style="margin-right: 6px;">Show Password
                                </div>
                                <h6 style="color: red; padding: 10px 0 6px 0;"><?= $GLOBALS['error'] ?></h6>
                                <div class="field padding-bottom--24">
                                    <input type="submit" name="submit" value="Continue">
                                </div>
                            </form>
                            <div>
                                <h6>Already have an account? <a href="signin.php">Sign in</a> now!
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