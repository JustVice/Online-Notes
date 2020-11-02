<?php

require "../../memory.php";
require "../tasks.php";
require "../database/read.php";
require "../database/create.php";
require "../database/delete.php";
require "../database/update.php";

$note_title = $_POST['note_title'];
$note_description = $_POST['note_description'];

if ($note_title == '')
    $note_title = "Untitled note";

if ($note_description != ' ')
    insert_private_note($note_title, $note_description);

$url = "../../private-notes";
header('Location: ' . $url);
