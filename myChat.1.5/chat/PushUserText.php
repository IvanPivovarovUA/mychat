<?php 

	$user_name = $_POST["name"];
	$user_password = $_POST["password"];
	$user_text = $_POST["text"];
	$time = time() + 60 * 60;


	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "chat";
	$charset = "utf8";



	$user_name = filter($user_name);
	$user_password = filter($user_password);
	$user_text = filter($user_text);
	
	if ($user_text != "") {
		try {
			$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=$charset",$username,$password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$stmt = $conn->prepare("SELECT name,password FROM users ");
	    	$stmt->execute();
	    	$stmt = $stmt->fetchAll();
	    	
	    	

			foreach ($stmt as $k => $v) {//////////////////////false
				if ($stmt[$k]["name"] == $user_name && $stmt[$k]["password"] == $user_password) {
					$sql = "INSERT INTO content (name,text,time) VALUES ('$user_name','$user_text','$time')";
					$conn->exec($sql);
				}	
				
			}


		}
		catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}

	function filter($value) {
		$value = trim($value);
		$value = stripslashes($value);
		$value = str_replace("script","", $value);
		$value = str_replace("<","", $value);
		$value = str_replace(">","", $value);

		$value = htmlspecialchars($value);
		$value = filter_var($value, FILTER_SANITIZE_STRING);
		return $value;
	}

?>