<?php
	if(!isset($_SESSION))
		session_start();
	function login_error($errno, $errmsg)
	{
		$_SESSION["errors"] = array('errno' => $errno, 'errmsg' => $errmsg);
		header("location: ../login");
	}
	function index_error($errno, $errmsg)
	{
		$_SESSION["errors"] = array('errno' => $errno, 'errmsg' => $errmsg);
		header("location: ../index");
	}
?>