<?php

include("./includes/delete_modal.php");

if (isset($_POST['checkBoxesArray'])) {
    foreach ($_POST['checkBoxesArray'] as $checkBoxesValues) {
        $bulk_option = escape($_POST['bulk_option']);

        switch ($bulk_option) {
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_option}' WHERE post_id = $checkBoxesValues";
                $updatestatus = mysqli_query($connection, $query);
                break;
            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_option}' WHERE post_id = $checkBoxesValues";
                $updatestatus = mysqli_query($connection, $query);
                break;
            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id = $checkBoxesValues";
                $get_posts = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($get_posts)) {
                    $cat_id = $row['post_category_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_images = $row['post_images'];
                    $post_content = $row['post_content'];
                    $post_tag = $row['post_tag'];
                    $post_comment_count = $row['post_comment_count'];
                    $post_status = $row['post_status'];
                }

                $query = "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_images, post_content, post_tag, post_status) ";
                $query .= "VALUES({$cat_id}, '{$post_title}', '{$post_author}', now(), '{$post_images}', '{$post_content}', '{$post_tag}', '{$post_status}')";

                $copy_post = mysqli_query($connection, $query);

                break;
            case 'reset':
                $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = $checkBoxesValues";
                $updatestatus = mysqli_query($connection, $query);
                break;
            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = $checkBoxesValues";
                $updatestatus = mysqli_query($connection, $query);
                break;
        }
    }
}

?>


<form action="" method="post">
    <table class="table table-bordered table-hover">
        <div id="bulkOptionContainer" class="col-xs-3" style="padding: 0; margin-bottom: 20px;">
            <select class="form-control" name="bulk_option" id="">
                <option value="">Select Option</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="clone">Clone</option>
                <option value="reset">Reset View Count</option>
                <option value="delete">Delete</option>
            </select>

        </div>

        <div class="col-xs-3">
            <input type="submit" class="btn btn-success" name="submit" value="Apply">
            <a href="posts.php?source=add_posts" class="btn btn-primary">Add Post</a>
        </div>

        <tr>
            <th><input type="checkbox" name="" id="selectAllBoxes"></th>
            <th>Id</th>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>Views Count</th>
            <th>Link</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM posts ORDER BY post_date DESC ";
            $select_posts = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_posts)) {
                $post_id =  escape($row['post_id']);
                $post_title =  escape($row['post_title']);
                $post_author =  escape($row['post_author']);
                $post_cat =  escape($row['post_category_id']);
                $post_status =  escape($row['post_status']);
                $post_images =  escape($row['post_images']);
                $post_tags =  escape($row['post_tag']);
                //$post_comment = $row['post_comment_count'];
                $post_date =  escape($row['post_date']);
                $post_view = escape($row['post_views_count']);

            ?>
                <tr>
                    <td><input type="checkbox" name='checkBoxesArray[]' class="checkBoxes" value="<?php echo $post_id    ?>"></td>
                    <td><?php echo $post_id    ?></td>
                    <td><?php echo $post_title    ?></td>
                    <td><?php echo $post_author    ?></td>

                    <?php
                    $query = "SELECT * FROM categories WHERE cat_id = $post_cat ";
                    $select_categories_id = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_categories_id)) {
                        $cat_id =  escape($row['cat_id']);
                        $cat_title =  escape($row['cat_title']);
                    ?>
                        <td><?php echo $cat_title    ?></td>
                    <?php
                    } ?>


                    <td><?php echo $post_status    ?></td>
                    <td> <?php echo "<img src = '../images/$post_images' alt='$post_title' height = '100px' width = '200px'/>"    ?></td>
                    <td><?php echo $post_tags    ?></td>

                    <?php
                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                    $get_count = mysqli_query($connection, $query);
                    $count_comment = mysqli_num_rows($get_count);


                    ?>

                    <td><a href="comments.php?source=c_perpost&p_id=<?php echo $post_id;    ?>"><?php echo $count_comment    ?></a></td>


                    <td><?php echo $post_date    ?></td>
                    <td><?php echo $post_view    ?></td>
                    <td><a href="../post.php?p_id=<?php echo $post_id; ?>" class="btn btn-secondary">Link Post</a></td>
                    <td><a href="posts.php?source=edit_posts&p_id=<?php echo $post_id; ?>" class="btn btn-secondary">Edit</a></td>
                    <!-- <td><a onclick="javascript: return confirm('Are you sure?');" href="posts.php?delete=<?php echo $post_id; ?>" class="btn btn-danger">Delete</a></td> -->
                    <td><a rel="<?php echo $post_id; ?>" href="javascript:void(0)" class="delete_link">Delete</a></td>
                </tr>

            <?php } ?>

            <?php //delete post
            if (isset($_GET['delete'])) {
                $post_id_delete = escape($_GET['delete']);
                $post_id_delete = mysqli_real_escape_string($connection, $_GET['delete']);


                $user_id = escape($_SESSION['user_id']);
                $user_id = mysqli_real_escape_string($connection, $_SESSION['user_id']);

                if (isset($user_id)) {
                    $query = "SELECT role FROM users WHERE user_id = $user_id";
                    $get_role = mysqli_query($connection, $query);
                    $role = "";
                    while ($row = mysqli_fetch_assoc($get_role)) {
                        $role =  escape($row['role']);
                    }

                    if ($role === "admin") {

                        $query = "DELETE FROM posts WHERE post_id = $post_id_delete ";
                        $delete_query = mysqli_query($connection, $query);
                        header("location: ./posts.php");
                    }
                }
            }

            ?>
        </tbody>
    </table>
</form>

<script>
    $(document).ready(function() {
        $(".delete_link").on('click', function() {
            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete=" + id + " ";
            $(".modal_delete_link").attr("href", delete_url);
            $("#myModal").modal('show');
        })
    })
</script>