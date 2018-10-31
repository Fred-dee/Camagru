<?php
	if(!isset($_SESSION))
		session_start();
    include_once('./DIRS.php');
	function login_error($errno, $errmsg)
	{
		$_SESSION["errors"] = array('errno' => $errno, 'errmsg' => $errmsg);
		header("location: ".ROOT_DIR."./login");
	}
	function index_error($errno, $errmsg)
	{
		$_SESSION["errors"] = array('errno' => $errno, 'errmsg' => $errmsg);
		header("location: ".ROOT_DIR."./index");
	}

	function profile_error($errno, $errmsg)
	{
		$_SESSION["errors"] = array('errno' => $errno, 'errmsg' => $errmsg);
		header("location: ".ROOT_DIR."./profile");
	}
    
	function debug_to_console( $data ) {
		$output = $data;
		if ( is_array( $output ) )
			$output = implode( ',', $output);

		echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
	}
?>