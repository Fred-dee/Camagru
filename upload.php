<?php

if (!isset($_SESSION))
    session_start();
if ($_SESSION["login"] == "guest")
    index_error(-1, "You must be logged in to view this page");
require_once ('./includes/DIRS.php');
require_once ("./includes/functions.php");
require_once ("./config/database.php");
date_default_timezone_set('Africa/Harare');


$uploadOk = 1;
$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION));
if (!isset($_GET))
    capture_error(-1, "This is not a valid request", $_GET["type"]);
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        capture_error(-1, "File is not an image.", $_GET["type"]);
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    capture_error(-1, "Sorry, your file is too large.", $_GET["type"]);
    $uploadOk = 0;
}
// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    capture_error(-1, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.", $_GET["type"]);
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    capture_error(-1, "Sorry, your file was not uploaded.", $_GET["type"]);
// if everything is ok, try to upload file
} else {
    try {
        $pdo = DB::getConnection();
        $img_src = base64_encode(file_get_contents($_FILES["fileToUpload"]["tmp_name"]));
        if ($_GET["type"] == "gallery") {
            
            $stmt = $pdo->prepare("INSERT INTO images (`user_id`, `src`, `creation_date`, `type`) VALUES (:uid, :src, NOW(), :type)");
            $stmt->bindParam(":uid", $_SESSION["user_id"], PDO::PARAM_STR);
            $stmt->bindParam(":src", $img_src, PDO::PARAM_LOB);
            $stmt->bindParam(":type", $imageFileType, PDO::PARAM_STR);
            $stmt->execute();
            valid_success(-1, "The file: " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.", "/capture?type=gallery");
        }
        else if($_GET["type"] == "propic")
        {
            $stmt = $pdo->prepare("UPDATE users SET `avatar` = :img , `type` = :type WHERE user_name = :uname");
            $stmt->bindParam(":uname", $_SESSION["login"], PDO::PARAM_STR);
            $stmt->bindParam(":img", $img_src, PDO::PARAM_LOB);
            $stmt->bindParam(":type", $imageFileType, PDO::PARAM_STR);
            $stmt->execute();
            valid_success(-1, "Your Profile Picture has been updated", "/profile");
        }
            
    } catch (\PDOException $e) {
        capture_error(-1, $e->getMessage(), $_GET["type"]);
    }
}
