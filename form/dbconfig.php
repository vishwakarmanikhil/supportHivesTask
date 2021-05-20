<?php 

	function connect(){
		$host = "localhost";
		$username = "root";
		$password = "";

		try{
			$con = new PDO("mysql:host=$host;dbname=task",$username, $password);

			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			return $con;
			
		}
		catch(PDOException $e){
			echo "Connection Failed".$e->getMessage();
		}
	}

 ?>