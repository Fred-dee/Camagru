<?php

if (!isset($_SESSION))
    session_start();
require_once('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $pdo = DB::getConnection();
    $_POST["uid"] = htmlspecialchars($_POST["uid"]);

    try {
        $stmt = $pdo->prepare("SELECT id FROM `users` WHERE user_name=:uid");
        $stmt->bindParam(":uid", $_POST["uid"], PDO::PARAM_STR, 15);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            /*
             * Send out the email with the reset link
             */
            $len = 10;
            $strong = true;
            $key = openssl_random_pseudo_bytes($len, $strong);
            $key = password_hash($key, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE `users` set `forgot_key`=:key WHERE user_name = :uid");
            $stmt->bindParam(":key", $key, PDO::PARAM_STR);
            $stmt->bindParam(":uid", $_POST["uid"], PDO::PARAM_STR, 15);
            $stmt->execute();
            $link = "localhost:8080/Camagru/forgot.php?reset=forgot&bar=" . base64_encode(htmlspecialchars($_POST["uid"]) . "##" .$key);
            echo json_encode(array("status" => "success", "data" => $link));
        } else
            echo json_encode(array("status" => "failure", "data" => "Was unable to generate a link"));
    } catch (\PDOException $ex) {
        echo json_encode(array("status" => "error", "data" => $e->getMessage()));
    }
}
?>
