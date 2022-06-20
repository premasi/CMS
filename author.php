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
            if (isset($_GET['a_id'])) {
                $author = escape($_GET['a_id']);
            }

            $query = "SELECT * FROM posts WHERE post_author =  '{$author}' ";
            $select_all_post = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_all_post)) {
                $show_post_id = escape($row['post_id']);
                $show_post_title = escape($row['post_title']);
                $show_post_author = escape($row['post_author']);
                $show_post_date = escape($row['post_date']);
                $show_image = escape($row['post_images']);
                $show_post_content = escape($row['post_content']);
            ?>

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <?php
                if (isset($_SESSION['user_id'])) {
                    $user_id = escape($_SESSION['user_id']);
                    $query = "SELECT role FROM users WHERE user_id = $user_id";
                    $role = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($role)) {
                        $get_role = escape($row['role']);

                        if ($get_role === "admin") {

                ?>
                            <a href="./admin/posts.php?source=edit_posts&p_id=<?php echo $post_id ?>">
                                <p class="text-right">Edit Post</p>
                            </a>
                <?php
                        }
                    }
                } ?>
                <!-- First Blog Post -->
                <h2>
                    <a href="/course/CMS/post/<?php echo $show_post_id ?>"><?php echo $show_post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href=""><?php echo $show_post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $show_post_date ?></p>
                <hr>
                <img class="img-responsive" src="./images/<?php echo $show_image ?>" alt="">
                <hr>
                <p><?php echo $show_post_content ?></p>
            <?php
            }


            ?>

            <hr>


            <!-- Blog Comments -->

            


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