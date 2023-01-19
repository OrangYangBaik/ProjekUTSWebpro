<?php
require_once 'connect.php';
require 'vendor/autoload.php';
$GLOBALS['result'] = $GLOBALS['error'] = "";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
$mail = new PHPMailer(true);

if (isset($_SESSION['loggedIn'])) {
    header('Location: index.php');
    die();
}

if (isset($_POST['username'])) {
    try {
        $username = $_POST['username'];

        $stmt = $db->prepare('  SELECT email 
                                FROM user 
                                WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $email = $user['email'];

            $expDate = date("Y-m-d H:i:s", mktime(
                date("H"),
                date("i"),
                date("s"),
                date("m"),
                date("d") + 1,
                date("Y")
            ));
            $hidden = password_hash($email, PASSWORD_BCRYPT);

            $stmt = $db->prepare('  INSERT INTO passreset_temp(email, hidden, expDate)
                                        VALUES (?,?,?)');
            $stmt->execute([$email, $hidden, $expDate]);

            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'disformspprt@gmail.com';
            $mail->Password   = 'fhbwtnqgjmmqucgf';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->setFrom('disformspprt@gmail.com');
            $mail->addAddress($email);
            $mail->FromName = "Disform Support";

            $mail->isHTML(true);
            $mail->Subject = 'Reset Disform Password';
            $mail->Body    = "
                <p>
                Hello {$username}, <br>
                You have requested a password reset for your Disform account. <br><br>
            
                Please follow the link below to reset your password: <br>
                <a href='https://disform.000webhostapp.com/reset_process.php?key=" . $hidden . "&email=" . $email . "&action=reset' target='_blank'>
                https://disform.000webhostapp.com/reset_process.php?key=" . $hidden . "&email=" . $email . "&action=reset
                </a><br><br>
        
                The link will expire in 24 hours. 
                If the link does not work or is not clickable, 
                please copy and paste the URL into your browser's address bar.<br>
                Please ignore this email if you did not request this password reset, 
                your password will not be changed.<br><br>
        
                Thanks,<br>
                Disform Team.</p>";

            $mail->send();

            $em = explode("@", $email);
            $name = implode('@', array_slice($em, 0, count($em) - 1));
            $length = floor(strlen($name) / 2);
            $result = substr($name, 0, $length) . str_repeat('*', $length) . "@" . end($em);

            $GLOBALS['result'] = 'An email has been sent to you (' . $result . ') with instructions on how to reset your password. 
                Please check your spam folder if you do not see the email.
                You can now close this page safely.';
        } else {
            $GLOBALS['error'] = 'User not found. Please check if you have entered the correct email.';
        }
    } catch (Exception $e) {
        $GLOBALS['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}. Please the contact Disform support.";
    }
    require_once 'close.php';
}
?>

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
                            <span class="padding-bottom--15">Password Reset</span>
                            <form id="stripe-login" method="POST">
                                <div class="field">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username">
                                </div>
                                <div style="padding-top: 12px; padding-bottom: 12px;">
                                    <h6><?= $GLOBALS['result'] ?></h6>
                                    <h6 style="color: red;"><?= $GLOBALS['error'] ?></h6>
                                </div>
                                <div class="field">
                                    <input type="submit" name="submit" value="Continue">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
</body>

</html>