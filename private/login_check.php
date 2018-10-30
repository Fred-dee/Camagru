<?php
	if(!isset($_SESSION))
		session_start();
	require_once("../config/database.php");
	require_once("../includes/functions.php");
	
	$pdo = DB::getConnection();
	if ($pdo == null)
		login_error(-1, "Could not obtain a pdo object");
	if (isset($_POST["submit"]))
	{
		if ($_POST["submit"] == "Register")
		{
			$fname = htmlspecialchars($_POST["s_fname"]);
			$lname = htmlspecialchars($_POST["s_lname"]);
			$email = htmlspecialchars($_POST["s_email"]);
			$password = htmlspecialchars($_POST["s_password"]);
			$cpass = htmlspecialchars($_POST["s_cpassword"]);
			$username= htmlspecialchars($_POST["s_username"]);
			$stmt = $pdo->prepare("SELECT * FROM users WHERE user_name= ?");
			$stmt->execute([$username]);
			$numrows= $stmt->rowCount();
			if ($numrows != 0)
			{
				login_error(1, "Username already exists");
			}
			if (cpass != password)
			{
				login_error(1, "Passwords do not match");
			}
			$hashed = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $pdo->prepare("INSERT INTO users (`user_name`, `first_name`, `last_name`, `email`, `hash`) VALUES
			(:uname, :fname, :lname, :email, :hash)
			");
			$stmt->bindParam(':uname', $username, PDO::PARAM_STR, 15);
			$stmt->bindParam(':fname', $fname, PDO::PARAM_STR, 25);
			$stmt->bindParam(':lname', $lname, PDO::PARAM_STR, 25);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->bindParam(':hash', $hashed, PDO::PARAM_STR);
			try
			{
				$stmt->execute();
			}
			catch (PDOException $e)
			{
				login_error(1, $e->getMessage());
			}
			$_SESSION["login"] = $username;
            $stmt = $pdo->prepare("SELECT id FROM users WHERE user_name=:uname");
            $stmt->bindParam(':uname', $username, PDO::PARAM_STR, 15);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION["user_id"] = (int) $row["id"];
			header("location: ../index");
		}
		if ($_POST["submit"] == "Login")
		{
			
			$username = htmlspecialchars($_POST["lusername"]);
			$rawpassword = htmlspecialchars($_POST["lpassword"]);
			$stmt = $pdo->prepare("SELECT * FROM users WHERE user_name = :uname");
			$stmt->bindParam(':uname', $username, PDO::PARAM_STR, 15);
			try
			{
				$stmt->execute();
				$numRows = $stmt->rowCount();
				if ($numRows == 1)
				{
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					if (password_verify($rawpassword, $row["hash"]))
					{
						$_SESSION["login"] = $username;
                        $_SESSION["user_id"] = (int) $row["id"];
						header("location: ../index");
					}
					else
						login_error(0, "Username/Password entered does not match any known users");
				}
				else
				{
					login_error(0, "Username/Password entered does not match any known users");
				}
			}
			catch (PDOException $e)
			{
				login_error(0, $e->getMessage());
			}
		}
			
	}
?>