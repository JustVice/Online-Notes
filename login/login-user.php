<?php

if (empty($_POST['username_input']) || empty($_POST['password_input'])) {
    header("Location: ../../login/index.php?error=emptyFields");
} else {

    require "../app/tasks.php";
    require "../app/database/read.php";
    require "../memory.php";

    $username_input = $_POST["username_input"];
    $password_input = $_POST["password_input"];

    $user_result = bring_user_data_by_username($username_input);

    if ($user_result['ID'] == "no record found") {
        header("Location: ../../login/index.php?error=badCredentials");
    } else {
        $password_matches = sha512_compare($user_result['salt'], $password_input, $user_result['password']);
        if ($password_matches) {
            echo "Password matches";
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user_result['ID'];
            $_SESSION['user_username'] = $user_result['username'];
            header("Location: /private-notes/");
        } else {
            header("Location: ../../login/index.php?error=badCredentials");
        }
    }
}
