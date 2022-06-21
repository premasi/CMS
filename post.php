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
            if (isset($_GET['p_id'])) {
                $post_id = escape($_GET['p_id']);

                $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $post_id";
                $send_view_query = mysqli_query($connection, $view_query);

                $query = "SELECT * FROM posts WHERE post_id = $post_id ";
                $select_all_post = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_all_post)) {
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
                        <a href="#"><?php echo $show_post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="/course/CMS/author.php?a_id=<?php echo $show_post_author ?>"><?php echo $show_post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span><?php echo $show_post_date ?></p>
                    <hr>
                    <img class="img-responsive" src="/course/CMS/images/<?php echo $show_image ?>" alt="">
                    <hr>
                    <p><?php echo $show_post_content ?></p>
                <?php
                }


                ?>

                <hr>


                <!-- Blog Comments -->

                <?php
                if (isset($_POST['create_comment'])) {
                    $post_id = escape($_GET['p_id']);
                    $comment_author = escape($_POST['comment_author']);
                    $comment_email = escape($_POST['comment_email']);
                    $comment_content = escape($_POST['comment_content']);

                    if (empty($comment_author) || empty($comment_email) || empty($comment_content)) {
                        echo "<script>alert('Field cannot be empty')</script>";
                    } else {

                        $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                        $query .= "VALUES ($post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'Unapproved', now())";

                        $create_comment_q = mysqli_query($connection, $query);

                        if (!$create_comment_q) {
                            die("Failed " . mysqli_error($connection));
                        }

                        // $query_count = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $post_id ";
                        // $comment_count = mysqli_query($connection, $query_count);
                    }
                }


                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                        <div class="form-group">
                            <input type="text" class="form-control" name="comment_author" placeholder="Author">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="comment_email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="comment_content" rows="3">Your Comments!</textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <?php
                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id ";
                $query .= "AND Comment_status = 'approved' ORDER BY comment_date DESC ";
                $show_comment = mysqli_query($connection, $query);

                if (!$show_comment) {
                    die("Failed " . mysqli_error($connection));
                }
                while ($row = mysqli_fetch_array($show_comment)) {
                    $comment_author = escape($row['comment_author']);
                    $comment_date = escape($row['comment_date']);
                    $comment_content = escape($row['comment_content']);

                ?>

                    <!-- Comment -->
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="http://placehold.it/64x64" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $comment_author; ?>
                                <small><?php echo $comment_date; ?></small>
                            </h4>
                            <?php echo $comment_content; ?>
                        </div>
                    </div>


            <?php
                }
            } else {
                header('loaction: index.php');
            }
            ?>



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