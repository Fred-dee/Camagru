<?php
if (!isset($_SESSION))
    session_start();
require_once ("DIRS.php");

function login_error($errno, $errmsg) {
    $_SESSION["errors"] = array('errno' => $errno, 'errmsg' => $errmsg);
    $dir = ROOT_DIR . "/login";
    header("location: " . $dir);
    exit();
}

function index_error($errno, $errmsg) {
    $_SESSION["errors"] = array('errno' => $errno, 'errmsg' => $errmsg);
    $dir = ROOT_DIR . "/index";
    header("location: ".$dir);
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
    $dir = ROOT_DIR . "/capture?type=".$type;
    header("location: " . $dir);
    exit();
}

function valid_success($code, $msg, $location)
{
    $_SESSION["success"] = array('code' => $code, 'message' => $msg);
    $dir = ROOT_DIR.$location;
    header("location: ".$dir);
    exit();
}

function general_error($code, $msg, $location)
{
    $_SESSION["errors"] = array('errno' => $code, 'errmsg' => $msg);
    $dir = ROOT_DIR.$location;
    header("location: ".$dir);
    exit();
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

?>