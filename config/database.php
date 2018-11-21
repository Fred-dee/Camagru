<?php
        //require_once '../includes/functions.php';
	class DB
	{
		private static $host = 'localhost';
		private static $db   = 'db_camagru';
		private static $user = 'root';
		private static $pass = 'password'; //password
		private static $charset = 'utf8mb4';
		public static $pdo = null;
		
		public static function getConnection()
		{
			// initialize $pdo on first call
			if (self::$pdo == null) {
			self::init();
			}

			// now we should have a $pdo, whether it was initialized on this call or a previous one
			// but it could have experienced a disconnection
			try {
				
				$old_errlevel = error_reporting(0);
				//echo "Testing connection...\n";
				self::$pdo->query("SELECT 1");
			} catch (PDOException $e) {
				echo "Connection failed, reinitializing...\n";
				self::init();
			}
			error_reporting($old_errlevel);
			return self::$pdo;
		}
		public static function init()
		{
			$dsn = "mysql:host=".self::$host.";dbname=".self::$db.";charset=".self::$charset.";";
			$options = [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false,
			];
			try {
				 self::$pdo = new PDO($dsn, self::$user, self::$pass, $options);
			} catch (\PDOException $e) {
				 //throw new \PDOException($e->getMessage(), (int)$e->getCode());
                                 general_error((int)$e->getCode(), $e->getMessage(),"/index");
			}
		}
	}
?>