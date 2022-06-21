<?php
function redirect($location){
    header("Location:".$location);
    exit;
}

function checkMethod($method=NULL){
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
        return true;
    }
    return false;


}

function checkLogin(){
    if(isset($_SESSION['user_id'])){
        return true;
    } 
    return false;
}

function redirectLogin($redirectLocation = NULL){
    if(checkLogin()){
        redirect($redirectLocation);
    }
}

function escape($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function users_online()
{
    if (isset($_GET['onlineusers'])) {

        global $connection;

        if (!$connection) {
            session_start();

            include("../includes/db.php");
            $session = session_id();
            $time = time();
            $time_in_seconds = 05;
            $time_out = $time - $time_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count_session = mysqli_num_rows($send_query);

            if ($count_session == NULL) {
                $query = "INSERT INTO users_online(session, time) VALUES ('$session', '$time')";
                $send_session = mysqli_query($connection, $query);
            } else {
                $query = "UPDATE users_online SET time = 'time' WHERE session = '$session'";
                $send_session_update = mysqli_query($connection, $query);
            }

            $users_online = "SELECT * FROM users_online WHERE time > '$time_out'";
            $send_online = mysqli_query($connection, $users_online);
            $count_user = mysqli_num_rows($send_online);
            echo $count_user;
        }
    } //get request
}

users_online();

function checkQuery($result)
{

    global $connection;
    if (!$result) {
        die("Failed" . mysqli_error($connection));
    }
}

function insert_categories()
{
    $submit = isset($_POST['submit']);
    global $connection;

    if ($submit) {
        $cat_title =  escape($_POST["cat_title"]);
        $cat_title = mysqli_real_escape_string($connection, $cat_title);

        $query = "SELECT * FROM categories WHERE cat_title = '$cat_title'";
        $get_another_cat = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($get_another_cat)) {
            $another_title = $row['cat_title'];
        }



        if ($cat_title == $another_title) {
            echo "Category already created!";
        } else if ($cat_title == "" || empty($cat_title) || strlen($cat_title) < 4) {
            echo "Must be longer than 4";
        } else {
            $query = "INSERT INTO categories(cat_title) ";
            $query .= "VALUES ('$cat_title') ";
            $create_cat_title = mysqli_query($connection, $query);

            if (!$create_cat_title) {
                die('Query Failed' . mysqli_error($connection));
            }
        }
    }
}

function showAllCategories()
{
    global $connection;
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);

    $i = 1;
    while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<tr>";
        echo "<td>{$i}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='./categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='./categories.php?update={$cat_id}'>Update</a></td>";
        echo "</tr>";

        $i++;
    }
}

function delete_categories()
{
    global $connection;

    if (isset($_GET['delete'])) {
        $cat_delete = escape($_GET['delete']);

        $query = "DELETE FROM categories WHERE cat_id = {$cat_delete}";
        $delete_query = mysqli_query($connection, $query);
        header("location: ./categories.php");
    }
}

function countData($table)
{
    global $connection;
    $query = "SELECT * FROM " . $table;
    $select_post = mysqli_query($connection, $query);
    return $result = mysqli_num_rows($select_post);
}

function usersRole($user_id)
{
    global $connection;
    $query = "SELECT role FROM users WHERE user_id = " . $user_id;
    $select_users = mysqli_query($connection, $query);
    
    $row = mysqli_fetch_assoc($select_users);

    if($row['role'] == "admin"){
        return true;
    } else {
        return false;
    }


}


function registration($username, $email, $password)
{
    global $connection;

    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT randsalt FROM users";
    $select_randsalt = mysqli_query($connection, $query);

    //crypt
    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

    //menambil salt dari kolom database
    // $row = mysqli_fetch_assoc($select_randsalt);
    // $salt = $row['randsalt'];
    // $password = crypt($password, $salt);

    //cara lain
    // $hashformat = "2y$10$";
    // $salt = "willyoumarrymeyeahjust";
    // $hash_and_salt = $hashformat . $salt;
    // $password = crypt($password, $hash_and_salt);


    $query = "INSERT INTO users (username, user_email, user_password, role) ";
    $query .= "VALUES('$username', '$email', '$password', 'subscriber')";
    $create_account = mysqli_query($connection, $query);

    if (!$create_account) {
        die("Failed" . mysqli_error($connection));
    }

    echo "<script>alert('Success')</script>";
    header("index.php");
}


function checkUsername($username)
{
    global $connection;
    $query = "SELECT * FROM users WHERE username = '$username'";
    $get_username = mysqli_query($connection, $query);
    return $count_username = mysqli_num_rows($get_username);
}

function checkEmail($email)
{
    global $connection;
    $query = "SELECT * FROM users WHERE user_email = '$email'";
    $get_email = mysqli_query($connection, $query);
    return $count_email = mysqli_num_rows($get_email);
}
