<?php

$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$new_password_confirm = $_POST['new_password_confirm'];

if ($new_password != "" || $new_password_confirm != "") {
    if ($new_password == $new_password_confirm) {

        require "../../app/database/update.php";
        require "../../app/database/read.php";
        require "../../app/tasks.php";
        require "../../memory.php";

        // Brings information stored at session table.
        $user_data_token = bring_user_data_by_cookie_sessionToken();

        // Brings information stored at user table.
        $user_data = bring_user_data_by_username($user_data_token["user_username"]);

        if (sha512_compare($user_data['salt'], $current_password, $user_data['password'])) {
            $salt = generateRandomString(100);
            $password_ingredients = $salt . $new_password;
            $password_hashed = sha512_hashing($password_ingredients);

            if (update_user_password($password_hashed, $salt)) {
                header("Location: ./index.php?success=passwordChangedSuccess");
            } else {
                //Internal database error.
                header("Location: ./index.php?error=InternalDataBaseError");
            }
        } else {
            //Error current password incorrect.
            header("Location: ./index.php?error=currentPasswordIncorrect");
        }
    } else {
        //Error passwords do not match.
        header("Location: ./index.php?error=passwordsDoNotMatch");
    }
} else {
    //Error empty spaces.
    header("Location: ./index.php?error=emptySpaces");
}
