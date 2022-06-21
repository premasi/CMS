<?php
include "db.php";


function escapeLogin($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}


if (isset($_POST['login'])) {
    global $connection;

    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    if (empty($username) || empty($password)) {
        echo "<script>alert('Field cannot be empty!')</script>";
    } else {

        $query = "SELECT * FROM users WHERE username = '{$username}'";
        $select_user = mysqli_query($connection, $query);
        $count_account = mysqli_num_rows($select_user);

        if (!$select_user) {
            die("Query failed " . mysqli_error($connection));
        }

        if($count_account < 1){
            echo "<script>alert('Account not found!')</script>";
        } else {

        while ($row = mysqli_fetch_array($select_user)) {
            $user_id = escapeLogin($row['user_id']);
            $user_username = escapeLogin($row['username']);
            $user_password = escapeLogin($row['user_password']);
            $user_firstname = escapeLogin($row['user_firstname']);
            $user_lastname = escapeLogin($row['user_lastname']);
            $role = escapeLogin($row['role']);
        }

        // verifikasi cara 1
        // $password = crypt($password, $user_password);

        // if($username !== $user_username && $password !== $user_password){
        //     header("location: ../index.php");
        // } else {
        //     $_SESSION['user_id'] = $user_id;
        //     header("location: ../admin/index.php");
        // }

        // verifikasi cara 2
        if (password_verify($password, $user_password)) {
            $_SESSION['user_id'] = $user_id;
            header("location: ./admin/index.php");
        } else {
            echo "<script>alert('Login failed')</script>";
        }
    }
    }
}
