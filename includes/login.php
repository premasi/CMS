<?php 
include "db.php";

session_start();

if(isset($_POST['login'])){
    global $connection;

    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user = mysqli_query($connection, $query);
    if(!$select_user){
        die("Query failed ".mysqli_error($connection));
    }

    while($row = mysqli_fetch_array($select_user)){
        $user_id = $row['user_id'];
        $user_username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $role = $row['role'];
    }

    $password = crypt($password, $user_password);

    if($username !== $user_username && $password !== $user_password){
        header("location: ../index.php");
    } else {
        $_SESSION['user_id'] = $user_id;
        header("location: ../admin/index.php");
    }
}

?>