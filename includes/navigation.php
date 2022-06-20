<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/course/CMS/index">Start Bootstrap</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php 
                    $contact_class="";
                    $pagename = basename($_SERVER['PHP_SELF']);
                    $contact = "contact.php";

                    if($pagename == $contact){
                        $contact_class="active";
                    }
                    
                    ?>

                    <li>
                        <a href="admin">Admin</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li class="<?php echo $contact_class;?>">
                        <a href="/course/CMS/contact">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>