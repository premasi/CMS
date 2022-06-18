<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<link rel="stylesheet" href="./admin/css/summernote.css">



<!-- Navigation -->

<?php include "includes/navigation.php"; ?>

<?php



if (isset($_POST['submit_email'])) {
    $to = $_POST['email'];
    $subject = wordwrap($_POST['subject']);
    $text = $_POST['content'];

    // the message
    $msg = "First line of text\nSecond line of text";

    // use wordwrap() if lines are longer than 70 characters
    $msg = wordwrap($msg,70);

    // send email
    mail($to,"My subject",$msg);
    //checkQuery($select_randsalt);
}

?>


<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Contact Me</h1>
                        <form role="form" action="" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder=".com" readonly>
                            </div>
                            <div class="form-group">
                                <label for="subject" class="sr-only">Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                            </div>
                            <div class="form-group">
                                <label for="content">Your message</label>
                                <textarea class="form-control" name="content" id="summernote" cols="30" rows="10"></textarea>
                            </div>

                            <input type="submit" name="submit_email" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <!-- <script src="js/summernote.min.js"></script> -->
    <script src="./admin/js/script.js"></script>