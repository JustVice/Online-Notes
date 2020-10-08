<?php
// API to save a new private note using website's URL.
// Required variables: username, password, note-title, note-description.
// note-title variable is optional.

require "../../app/tasks.php";
require "../../memory.php";
require "../../app/database/create.php";
require "../../app/database/read.php";

$response = array();

if (!isset($_GET['username']) || !isset($_GET['password'])) {
    $response['status'] = "failed";
    $response['description'] = "credentials not given";
    echo $json_string = json_encode($response, JSON_PRETTY_PRINT);
} else {
    $username = $_GET['username'];
    $password = $_GET['password'];

    $result = check_credentials_return_id_api($username, $password);

    if ($result['ID'] != "NA") {
        if (isset($_GET['note-description'])) {

            $note_title = "";
            $note_description = $_GET['note-description'];

            if (!isset($_GET['note-title'])) {
                $note_title = "Untitled note";
            } else {
                if ($_GET['note-title'] != "") {
                    $note_title = $_GET['note-title'];
                } else {
                    $note_title = "Untitled note";
                }
            }

            if (insert_private_note_api($note_title, $note_description, $result['ID'])) {
                $response['status'] = "success";
                $response['description'] = "private note has been saved";
                echo $json_string = json_encode($response, JSON_PRETTY_PRINT);
            } else {
                $response['status'] = "failed";
                $response['description'] = "internal database error";
                echo $json_string = json_encode($response, JSON_PRETTY_PRINT);
            }
        } else {
            $response['status'] = "failed";
            $response['description'] = "note description not given";
            echo $json_string = json_encode($response, JSON_PRETTY_PRINT);
        }
    } else {
        $response['status'] = "failed";
        $response['description'] = "password is incorrect";
        echo $json_string = json_encode($response, JSON_PRETTY_PRINT);
    }
}