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

            if (isset($_GET['cat_id'])) {
                $temp_id = escape($_GET['cat_id']);

                $query = "SELECT * FROM posts WHERE post_category_id = $temp_id AND post_status = 'published'";
                $select_all_post = mysqli_query($connection, $query);
                $count_post = mysqli_num_rows($select_all_post);

                if ($count_post >= 1) {

                    while ($row = mysqli_fetch_assoc($select_all_post)) {
                        $show_post_id = escape($row['post_id']);
                        $show_post_title = escape($row['post_title']);
                        $show_post_author = escape($row['post_author']);
                        $show_post_date = escape($row['post_date']);
                        $show_image = escape($row['post_images']);
                        $show_post_content = escape(substr($row['post_content'], 0, 100));

            ?>


                        <h1 class="page-header">
                            Page Heading
                            <small>Secondary Text</small>
                        </h1>

                        <!-- First Blog Post -->
                        <h2>
                            <a href="/course/CMS/post/<?php echo $show_post_id ?>"><?php echo $show_post_title ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="/course/CMS/author.php?a_id=<?php echo $show_post_author ?>"><?php echo $show_post_author ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span><?php echo $show_post_date ?></p>
                        <hr>
                        <img class="img-responsive" src="/course/CMS/images/<?php echo $show_image ?>" alt="">
                        <hr>
                        <p><?php echo $show_post_content ?></p>
                        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
            <?php
                    }
                } else {
                    echo "<h1 class='text-center'>Posts is empty</h1>";
                }
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