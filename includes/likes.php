<?php
    if(!isset($_SESSION))
        session_start();
    include_once('../config/database.php');
    //if (!isset($_GET) && !isset($_POST))
    if(isset($_GET["uid"]))
    {
        if ($_SESSION["login"] != "guest")
            echo $_SESSION["user_id"];
        else
            echo "guest";
    }
    else
    {
        if(isset($_GET["method"]) && isset($_GET["img"]) && isset($_SESSION["user_id"]))
        {
            $img_id =  preg_replace("/art/", "", htmlspecialchars($_GET["img"]));
            $pdo = DB::getConnection();
            
            $stmt = $pdo->prepare("SELECT * FROM events WHERE type='like' AND user_id=:uid AND img_id =:iid");
            $stmt->bindParam(":uid", $_SESSION["user_id"], PDO::PARAM_INT, 11);
            $stmt->bindParam(":iid", $img_id, PDO::PARAM_INT, 11);
            $stmt->execute();
            
            $sql;
            if($stmt->rowCount() == 0)
            {
                $sql = "INSERT INTO events (`type`, `img_id`, `user_id`) VALUES (:type, :iid, :uid)";
            }
            else
            {
                $sql = "DELETE FROM events WHERE type=:type AND user_id=:uid AND img_id=:iid";
            }
            try
            {
                $type = "like";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":uid", $_SESSION["user_id"], PDO::PARAM_INT, 11);
                $stmt->bindParam(":iid", $img_id, PDO::PARAM_INT, 11);
                $stmt->bindParam(":type", $type, PDO::PARAM_STR);
                $stmt->execute();
                echo "success";
            }
            catch (\PDOException $e) {
				 echo new \PDOException($e->getMessage(), (int)$e->getCode());
			}
        }
    }
        
?>
