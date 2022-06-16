<?php
include "./includes/admin_header.php";
?>


<div id="wrapper">

    <!-- Navigation -->
    <?php
    include "./includes/admin_navigation.php";
    ?>

    <div id="page-wrapper">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <div class="container-fluid">
            <!-- Navigation -->

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome back!

                        <!-- get firstname and lastname -->
                        <?php
                        if (isset($_SESSION['user_id'])) {
                            $user_id = $_SESSION['user_id'];
                            $query = "SELECT * FROM users WHERE user_id = $user_id";
                            $select_user = mysqli_query($connection, $query);

                            while ($row = mysqli_fetch_array($select_user)) {
                                $firstname = $row['user_firstname'];
                                $lastname = $row['user_lastname'];
                                $role = $row['role'];
                            }

                            if ($role !== 'admin') {
                                header("location: ../index.php");
                            }
                        } else {
                            header("location: ../index.php");
                        }

                        ?>
                        <small><?php echo $firstname . " " . $lastname; ?></small>


                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="index.html">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-file"></i> Blank Page
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->


            <!-- /.row -->

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                    $query = "SELECT * FROM posts";
                                    $select_post = mysqli_query($connection, $query);
                                    $post_count = mysqli_num_rows($select_post);

                                    echo "<div class='huge'>$post_count</div>";

                                    ?>

                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                    $query = "SELECT * FROM comments";
                                    $select_comment = mysqli_query($connection, $query);
                                    $comment_count = mysqli_num_rows($select_comment);
                                    echo "<div class='huge'>$comment_count</div>";

                                    ?>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                    $query = "SELECT * FROM users";
                                    $select_user = mysqli_query($connection, $query);
                                    $user_count = mysqli_num_rows($select_user);
                                    echo "<div class='huge'>$user_count</div>";

                                    ?>
                                    <div> Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
                                    $query = "SELECT * FROM categories";
                                    $select_cat = mysqli_query($connection, $query);
                                    $cat_count = mysqli_num_rows($select_cat);
                                    echo "<div class='huge'>$cat_count</div>";

                                    ?>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- count post by status -->
            <?php
            $query = "SELECT * FROM posts WHERE post_status = 'published'";
            $select_post_published = mysqli_query($connection, $query);
            $post_published = mysqli_num_rows($select_post_published);

            $query = "SELECT * FROM posts WHERE post_status = 'draft'";
            $select_post_draft = mysqli_query($connection, $query);
            $post_draft = mysqli_num_rows($select_post_draft);



            ?>

            <div class="row m-auto">
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['bar']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Data', 'Count'],

                            <?php
                            $element_text = ['Draft Post', 'Published Post', 'Comments', 'Users', 'Categories'];
                            $element_count = [$post_draft, $post_published, $comment_count, $user_count, $cat_count];

                            for ($i = 0; $i < 5; $i++) {
                                echo "['{$element_text[$i]}'" . ", " . "{$element_count[$i]}], ";
                            }


                            ?>

                            //['Post', 1030]
                        ]);

                        var options = {
                            chart: {
                                title: '',
                                subtitle: '',
                            }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                </script>
                <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php
    include "./includes/admin_footer.php";
    ?>