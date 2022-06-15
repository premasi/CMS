<?php 
include "./includes/db.php";
global $connection;
include "./includes/header.php";


?>

    <!-- Navigation -->
<?php
include "./includes/navigation.php";

?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php 

                $query = "SELECT * FROM posts WHERE post_status = 'published' ";
                $select_all_post = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_all_post)){
                    $show_post_id = $row['post_id'];
                    $show_post_title = $row['post_title'];
                    $show_post_author = $row['post_author'];
                    $show_post_date = $row['post_date'];
                    $show_image = $row['post_images'];
                    $show_post_content = substr($row['post_content'],0,100);
                    $post_status = $row['post_status'];

                ?>

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $show_post_id ?>"><?php echo $show_post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="author.php?a_id=<?php echo $show_post_author ?>"><?php echo $show_post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $show_post_date ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $show_post_id ?>">
                <img class="img-responsive" src="./images/<?php echo $show_image ?>" alt="">
                </a>
                <hr>
                <p><?php echo $show_post_content ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $show_post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <?php

                }

                ?>


                <hr>

                </div>


            <!-- Blog Sidebar Widgets Column -->
<?php 
include "./includes/sidebar.php"

?>

        </div>
        <!-- /.row -->

        <hr>

<?php
include "./includes/footer.php";

?>
