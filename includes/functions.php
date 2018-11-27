<?php

if (!isset($_SESSION))
    session_start();
require_once ("DIRS.php");
require_once("Element.php");

function login_error($errno, $errmsg) {
    $_SESSION["errors"] = array('errno' => $errno, 'errmsg' => $errmsg);
    $dir = ROOT_DIR . "/login";
    header("location: " . $dir);
    exit();
}

function index_error($errno, $errmsg) {
    $_SESSION["errors"] = array('errno' => $errno, 'errmsg' => $errmsg);
    $dir = ROOT_DIR . "/index";
    header("location: " . $dir);
    exit();
}

function profile_error($errno, $errmsg) {
    $_SESSION["errors"] = array('errno' => $errno, 'errmsg' => $errmsg);
    $dir = ROOT_DIR . "/profile";
    header("location: " . $dir);
    exit();
}

function capture_error($errno, $errmsg, $type) {
    $_SESSION["errors"] = array('errno' => $errno, 'errmsg' => $errmsg);
    $dir = ROOT_DIR . "/capture?type=" . $type;
    header("location: " . $dir);
    exit();
}

function valid_success($code, $msg, $location) {
    $_SESSION["success"] = array('code' => $code, 'message' => $msg);
    $dir = ROOT_DIR . $location;
    header("location: " . $dir);
    exit();
}

function general_error($code, $msg, $location) {
    $_SESSION["errors"] = array('errno' => $code, 'errmsg' => $msg);
    $dir = ROOT_DIR . $location;
    header("location: " . $dir);
    exit();
}

function output_returns() {

    $div = new Element("div", false);
    $msg;
    $class;
    if (isset($_SESSION["errors"])) {
        $msg = $_SESSION["errors"]["errmsg"];
        $class = "alert alert-danger";
    }
    if (isset($_SESSION["success"])) {
        $msg = $_SESSION["success"]["message"];
        $class = "alert alert-success";
    }
    if (isset($_SESSION["errors"]) || isset($_SESSION["success"])) {
        $div->add_class($class);
        $div->add_text($msg);
        echo $div;
        unset($_SESSION["errors"]);
        unset($_SESSION["success"]);
    }
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

function getMax() {
    $pdo = DB::getConnection();
    $stmt = $pdo->query("SELECT count(*) as total FROM `images`");
    try {
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($res["total"]);
    } catch (\PDOException $e) {
        general_error(-1, $e->getMessage(), "/index");
    }
}

function getData($profile  = false) {
    $pdo = DB::getConnection();
    if ($_SESSION["getData"] * 6 > getMax()) {
        $_SESSION["returnNull"] = true;
        $pageno = intval(getMax() / 6);
    } else {
        $_SESSION["getData"] = $_SESSION["getData"] + 1;
        $pageno = $_SESSION["getData"];
        $_SESSION["returnNull"] = false;
    }
    //debug_to_console($_SESSION["returnNull"]);
    if ($_SESSION["returnNull"] == false) {
        $pageno = 6 * $pageno;
		if ($profile == true)
		{
			$stmt = $pdo->prepare("Select * FROM images WHERE user_id=:uname ORDER BY `creation_date` DESC LIMIT 6 OFFSET :off");
            $stmt->bindParam(":uname", $_SESSION["user_id"], PDO::PARAM_STR);
			$stmt->bindParam(':off', $pageno, PDO::PARAM_INT);
		}
		else
		{
        	$stmt = $pdo->prepare("Select * FROM images ORDER BY `creation_date` DESC LIMIT 6 OFFSET :off");
        	$stmt->bindParam(':off', $pageno, PDO::PARAM_INT);
		}
        $stmt->execute();
        $row_div = new Element("div", false);
        $body = array();
        $counter = 0;
        $articles = array();
        //debug_to_console($stmt->rowCount());
        while (($row = $stmt->fetch(PDO::FETCH_ASSOC))) {
            $inter = $pdo->prepare("Select user_name, avatar, type FROM users WHERE id = :user_id");
            $inter->bindParam(':user_id', $row["user_id"], PDO::PARAM_INT);
            $inter->execute();
            $uname = $inter->fetch(PDO::FETCH_ASSOC);
            $pro_pic;
            if ($uname["avatar"] == NULL)
                $pro_pic = "./imgs/avatar.png";
            else
                $pro_pic = "data:image/" . $uname["type"] . ";base64," . $uname["avatar"];
            $data = array(
                "img_src" => "data:image/" . $row["type"] . ";base64," . $row["src"],
                "img_classes" => "img-thumbnail img-responsive",
                "img_id" => $row["id"],
                "user_id" => $uname["user_name"],
                "avatar_src" => $pro_pic,
            );
            $art = new Article($data);
            $art->add_attribute("id", $row["id"] . "art");
            array_push($articles, $art);
        }
        foreach ($articles as $key => $value) {
            if ($counter == 0) {
                $row_div = new Element("div", false);
                $row_div->add_class("gal-grid-thirds");
            }

            $col_div = new Element("div", false);
            $col_div->add_class("gal-col");
            $col_div->add_child($value);
            $row_div->add_child($col_div);
            if ($counter == 2) {
                array_push($body, $row_div);
                $counter = -1;
            }
            $counter++;
        }
        if($counter != 0)
            array_push($body, $row_div);
        return $body;
    } else
        return (array());
}

?>