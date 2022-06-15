<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM users";
        $select_users = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_users)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $userpass = $row['user_password'];
            $userfirst = $row['user_firstname'];
            $userlast = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $role = $row['role'];
        ?>
            <tr>
                <td><?php echo $user_id;    ?></td>
                <td><?php echo $username;    ?></td>
                <td><?php echo $userfirst;    ?></td>
                <td><?php echo $userlast;    ?></td>
                <td><?php echo $user_email;    ?></td>
                <?php
                // $query = "SELECT * FROM posts WHERE post_id = $post_comment ";
                // $select_posts_id = mysqli_query($connection, $query);

                // while($row = mysqli_fetch_assoc($select_posts_id)){
                //     $post_id = $row['post_id'];
                //     $post_title = $row['post_title'];
                // ?>
                <!-- <td><a href="../post.php?p_id=<?php //echo $post_id;    ?>"><?php //echo $post_title;    ?></a></td> -->
                <?php
                // } ?>
                <td><?php echo $role;    ?></td>
                <td><a href="users.php?change_admin=<?php echo $user_id;?>" class="">Admin</a></td>
                <td><a href="users.php?change_subs=<?php echo $user_id;?>" class="">Subscriber</a></td>
                <td><a href="users.php?source=edit_users&u_id=<?php echo $user_id;?>" class="">Edit</a></td>
                <td><a href="users.php?delete=<?php echo $user_id;?>" class="btn btn-danger">Delete</a></td>
            </tr>

        <?php } ?>

        <?php 
        //approve comments
        if(isset($_GET['change_admin'])){
            $change_admin = $_GET['change_admin'];

            $query = "UPDATE users SET role = 'admin' WHERE user_id = $change_admin ";
            $change_admin_query = mysqli_query($connection, $query);
            header("location: ./users.php");
        }

        //unapprove comments
        if(isset($_GET['change_subs'])){
            $change_subs = $_GET['change_subs'];

            $query = "UPDATE users SET role = 'subscriber' WHERE user_id = $change_subs ";
            $change_subs_query = mysqli_query($connection, $query);
            header("location: ./users.php");
        }
        
        
        //delete comment
        if(isset($_GET['delete'])){
            $user_id_delete = $_GET['delete'];

            $query = "DELETE FROM users WHERE user_id = $user_id_delete ";
            $delete_query = mysqli_query($connection, $query);
            header("location: ./users.php");
        }
        
        ?>
    </tbody>
</table>