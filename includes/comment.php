<?php

if (!isset($_SESSION))
    session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('./functions.php');
include_once('../config/database.php');
include_once('./DIRS.php');
require_once './mailer.php';
if (isset($_SESSION["login"]) && $_SESSION["login"] != "guest" && isset($_POST)) {
    $img_id = (int) htmlspecialchars($_POST["img_id"]);
    $type = "comment";
    $msg = htmlspecialchars($_POST["message"]);
    $pdo = DB::getConnection();
    $stmt = $pdo->prepare("INSERT INTO events (`type`, `img_id`, `user_id`, `message`)
        VALUES (:type, :iid, :uid, :msg)");
    $stmt->bindParam(":type", $type, PDO::PARAM_STR);
    $stmt->bindParam(":iid", $img_id, PDO::PARAM_INT, 11);
    $stmt->bindParam(":uid", $_SESSION["user_id"], PDO::PARAM_INT, 11);
    $stmt->bindParam(":msg", $msg, PDO::PARAM_STR);
    try {

        $stmt->execute();
        $stmt = $pdo->prepare("Select * FROM images WHERE id = :iid");
        $stmt->bindParam(":iid", $img_id, PDO::PARAM_INT, 11);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //var_dump($row);
        $stmt = $pdo->prepare("SELECT * FROM users where id = :uid");
        $stmt->bindParam(':uid', $row["user_id"], PDO::PARAM_INT, 11);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row["em_subs"] == 1) {
            $msg = 'New Password is: ' . "j5444302@nwytg.net";

            $msg = wordwrap($msg, 70);

            $header = "From: no-reply@pictostellar.co.za";

            $bool = mail("j5444302@nwytg.net", "New Email Address", $msg, $header);
            /*$to_mail = $row["email"];
            $subject = "You have unread Comments";
            $message = "User " . $_SESSION["login"] . ", has commented on your image saying:" . PHP_EOL . $msg . PHP_EOL . "Best\n Camagru Team";
            $message = str_replace("\n.", "\n..", $message);
            $headers = 'FROM: fred.dilapisho@gmail.com';

            $myMail = new Mailer();

            $arr_var = array(
                "to" => $row["email"],
                "subject" => "You have unread Comments",
                "message" => $message,
                "from" => "noreply@camagru.com",
                "isSMTP" => true,
                "username" => "fred.dilapisho@gmail.com",
                "password" => "Dilapisho#15",
                "smtp_port" => 587,
                "server" => "smtp.gmail.com"
            );
            //$myMail->set_variables($arr_var);
            $bool = mail($to_mail, $subject, $message, $headers);
            //$bool = $myMail->send();
            //$mail->get_setting("smtp_server");
             * 
             */
            if ($bool == false)
                index_error(-1, "Was unable to send a notifcation " . $row["email"]);
            else
                valid_success(-1, "Comment was sent", "/index");
        }
        header("location: " . ROOT_DIR . "/index");
    } catch (\PDOException $e) {
        index_error(-1, $e->getMessage());
    }
} else {
    index_error(-1, "struggled to proccess the comment");
}
?>