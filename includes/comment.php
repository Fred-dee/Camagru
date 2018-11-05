<?php
    if(!isset($_SESSION))
        session_start();
    include_once('./functions.php');
    include_once('../config/database.php');
    include_once('./DIRS.php');
    if(isset($_SESSION["login"]) && $_SESSION["login"] != "guest" && isset($_POST))
    {
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
        try
        {
            
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
            if ($row["em_subs"] == 1)
            {
                $to_mail = $row["email"];
                $subject = "You have unread Comments";
                $message = "User ".$_SESSION["login"].", has commented on your image saying:".PHP_EOL.$msg.PHP_EOL."Best\n Camagru Team";
                $headers = 'From: noreply@camagru.com';
                if(!mail($to_email, $subject, $message, $headers))
                    index_error(-1, "Was unable to send a notifcation");
            }
            header("location: ".ROOT_DIR."/index");
        }
        catch (\PDOException $e)
        {
             index_error(-1, $e->getMessage());
        }
    }
    else
    {
        index_error(-1, "struggled to proccess the comment");
    }
?>