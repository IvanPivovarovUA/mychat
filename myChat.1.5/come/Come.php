<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "chat";
	$charset = "utf8";
	$regist_error_message = "";
	$come_error_message = "";

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
	function user_cookie($user_name,$user_password) {///Set name and password on cookie
		setcookie("user_name",$user_name,time() + (86400 * 300), "/");
		setcookie("user_password",$user_password,time() + (86400 * 300), "/");

		header("Location: http://localhost/myChat.1.5/chat/Chat.php ");/////open chat
	}



	if (isset($_POST["submit_regist"])) {
		$myName = filter($_POST["name_regist"]);
		$myPassword = filter($_POST["password_regist"]);

		// echo $myName."<br>";
		// echo $myPassword."<br>";
		// echo strlen($myName);
		// echo "<br>";
		// echo strlen($myPassword);


		if (strlen($myName) > 3 && strlen($myName) < 17 && strlen($myPassword) > 5 && strlen($myPassword) < 17) {


			try {
				$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=$charset",$username,$password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$stmt = $conn->prepare("SELECT * FROM users");
				$stmt->execute();
				$stmt = $stmt->fetchAll();

				foreach ($stmt as $k => $v) {//////////////////////false
					if ($myName == $stmt[$k]["name"]) {
						$regist_error_message = "This name exists.Choose another name";
						
					}
				}
				if ($regist_error_message == "") {//////////////////true/////////////////////
					$regist_error_message = "Operation successful";
					$conn->exec("INSERT INTO users (name,password) VALUES ('$myName', '$myPassword') ");
					user_cookie($myName,$myPassword);
				}
				

			}
			catch(PDOException $e) {
				echo "Connection failed: " . $e->getMessage();
			}
			$conn = null;
		}

		if ($regist_error_message == "") {////////////////false
			$regist_error_message = "Error";
		}		

	}



	if (isset($_POST["submit_come"])) {
		$myName = filter($_POST["name_come"]);
		$myPassword = filter($_POST["password_come"]);
		
		if (strlen($myName) > 3 && strlen($myName) < 17 && strlen($myPassword) > 5 && strlen($myPassword) < 17) {
			try {
				$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=$charset",$username,$password);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$come = false;


				$stmt = $conn->prepare("SELECT * FROM users");
				$stmt->execute();


				$stmt = $stmt->fetchAll();
				// print_r($stml);

				foreach ($stmt as $k => $v) { 
					/////////////////////////////true//////////////////
					if ($myName == $stmt[$k]["name"] && $myPassword == $stmt[$k]["password"]) {
						$come_error_message = "Welcome ".$stmt[$k]["name"];
						user_cookie($myName,$myPassword);
					}
					
				}
	
				


			}
			catch(PDOException $e) {
				// echo "Connection failed: " . $e->getMessage();
			}
			$conn = null;
		}


		if ($come_error_message == "") {////////////////////////false
			$come_error_message = "No.This name or pasword not right";
		}
	}
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta name="viewport" content="width=device-width, initial-scale=0.6">
	<link rel="stylesheet" type="text/css" href="Come.css">
</head>
<body>
	<h1 class="header">Welcome</h1>
	<div class="forms">

		<div class="forms_regist">
			<h1>Registation</h1>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<h2>Name</h2>
				<input type="text" name="name_regist" minlength = "4" maxlength="16" required>
				<h2>Password</h2>
				<input type="password" name="password_regist" minlength = "6" maxlength="16"  required><br><br><br>
				<input type="submit" name="submit_regist" value="Submit" class="submit">
				<h2><?php echo  $regist_error_message;?> </h2>
			</form>
		</div>

		<div class="forms_come">
			<h1>Come</h1>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<h2>Name</h2>
				<input type="text" name="name_come" minlength = "4" maxlength="16" required>
				<h2>Password</h2>
				<input type="password" name="password_come" minlength = "6" maxlength="16" required><br><br><br>
				<input type="submit" name="submit_come" value="Submit" class="submit">
				<h2><?php echo  $come_error_message;?></h2>
			</form>
		</div>

	</div>
</body>
</html>