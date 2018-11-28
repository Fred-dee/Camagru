<?php

if (!isset($_SESSION))
    session_start();
require_once('./includes/Article.php');
require_once('./includes/Element.php');
require_once('./config/database.php');
require_once('./includes/functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = array();
    //if($_SESSION["returnNull"] == false)
	if ($_GET["profile"] == "true")
        $data = getData(true);
	else
		$data = getData();
    if (!empty($data)) {
        $arr_conv = array();
        foreach ($data as $key => $value) {
            array_push($arr_conv, print($value));
        }
        echo ($arr_conv);
    }
    else
    {
        echo "";
    }
}
?>
