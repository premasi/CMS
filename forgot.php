<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

?>

<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php require './classes/config.php'; ?>


<!-- Navigation -->

<?php include "includes/navigation.php"; ?>

<?php
$emailsend = false;

if (!checkMethod('get') && !isset($_GET['forgot'])) {
    redirect("index");
}

if (checkMethod('post')) {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        $length = 50;

        $token = bin2hex(openssl_random_pseudo_bytes($length));

        $search_email = checkEmail($email);

        if ($search_email > 0) {
            if ($stmt = mysqli_prepare($connection, "UPDATE users SET token = '{$token}' WHERE user_email = ?")) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                //configure phpmailer
                $mail = new PHPMailer();

                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = config::SMTP_HOST;                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = config::SMTP_USER;                     //SMTP username
                $mail->Password   = config::SMTP_PASSWORD;                               //SMTP password
                $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
                $mail->Port       = config::SMTP_PORT;
                $mail->isHTML(true);                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                $mail->charSet = 'UTF-8';
                $mail->setFrom('from@example.com', 'Mailer');
                $mail->addAddress($email);     //Add a recipient
                $mail->Subject = 'Recovery Password';
                $mail->Body    = "<p>Click here to reset your password
                <a href='http://localhost/course/CMS/reset?email=$email&token=$token'>Reset Password</a>
                </p>";
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


                if ($mail->send()) {
                    $emailsend = true;
                }
            } else {
                echo "Something wrong";
            }
        }
    }
}

?>

<?php if ($emailsend == false) : ?>
    <!-- Page Content -->
    <div class="container">

        <div class="form-gap"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="text-center">


                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control" type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->
                            <?php else : ?>
                                <?php if ($emailsend == true) : ?>
                                    <div class="media">
                                        <div class="container">
                                            <div class="well">
                                                <h4 class="bg-success text-center">Please check your email</h4>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <hr>

        <?php include "includes/footer.php"; ?>

    </div> <!-- /.container -->