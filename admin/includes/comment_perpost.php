<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comments</th>
            <th>Email</th>
            <th>Status</th>
            <th>Post</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($_GET['p_id'])) {
            $post_id = $_GET['p_id'];
            $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
            $comment_posts = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($comment_posts)) {
                $comment_id = $row['comment_id'];
                $comment_author = $row['comment_author'];
                $comment_content = $row['comment_content'];
                $comment_email = $row['comment_email'];
                $comment_status = $row['comment_status'];
                $post_comment = $row['comment_post_id'];
                $comment_date = $row['comment_date'];



        ?>
                <tr>
                    <td><?php echo $comment_id;    ?></td>
                    <td><?php echo $comment_author;    ?></td>
                    <td><?php echo $comment_content;    ?></td>
                    <td><?php echo $comment_email;    ?></td>
                    <td><?php echo $comment_status;    ?></td>
                    <?php
                    $query = "SELECT * FROM posts WHERE post_id = $post_comment ";
                    $select_posts_id = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_posts_id)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                    ?>
                        <td><a href="../post.php?p_id=<?php echo $post_id;    ?>"><?php echo $post_title;    ?></a></td>
                    <?php
                    } ?>
                    <td><?php echo $comment_date;    ?></td>
                    <td><a href="comments.php?source=c_perpost&p_id=<?php echo $post_id;?>&approve=<?php echo $comment_id; ?>" class="btn btn-primary">Approve</a></td>
                    <td><a href="comments.php?source=c_perpost&p_id=<?php echo $post_id;?>&unapprove=<?php echo $comment_id; ?>" class="btn btn-danger">Unapprove</a></td>
                    <td><a href="comments.php?source=c_perpost&p_id=<?php echo $post_id;?>&delete=<?php echo $comment_id; ?>" class="btn btn-danger">Delete</a></td>
                </tr>

            <?php }
            ?>

        <?php
            //approve comments
            if (isset($_GET['approve'])) {
                $comment_id_update = $_GET['approve'];

                $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $comment_id_update ";
                $approve_query = mysqli_query($connection, $query);
                header("location: ./comments.php?source=c_perpost&p_id=$post_id");
            }

            //unapprove comments
            if (isset($_GET['unapprove'])) {
                $comment_id_update = $_GET['unapprove'];

                $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $comment_id_update ";
                $unapprove_query = mysqli_query($connection, $query);
                header("location: ./comments.php?source=c_perpost&p_id=$post_id");
            }


            //delete comment
            if (isset($_GET['delete'])) {
                $comment_id_delete = $_GET['delete'];

                $query = "DELETE FROM comments WHERE comment_id = $comment_id_delete ";
                $delete_query = mysqli_query($connection, $query);
                header("location: ./comments.php?source=c_perpost&p_id=$post_id");
            }
        }

        ?>
    </tbody>
</table>