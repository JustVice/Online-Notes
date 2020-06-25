<?php

if (empty($_POST['username_input']) || empty($_POST['password_input'])) {
    header("Location: ../../register/index.php?error=emptyFields");
} else {

    require "../tasks.php";
    require "../database/mysql.php";

    $username = $_POST["username_input"];
    $password = $_POST["password_input"];

    $salt = generateRandomString(100);
    $password_ingredients = $salt . $password;
    $password_hashed = sha512_hashing($password_ingredients);

    $is_username_not_taken = check_username_disponibility($username);

    if (!$is_username_not_taken) {
        register_a_new_user($username, $password_hashed, $salt);
    }else{
        header("Location: ../../register/index.php?error=usernameTaken");
    }
}
