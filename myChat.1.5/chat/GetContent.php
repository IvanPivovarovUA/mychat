<?php 
	
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "chat";
	$charset = "utf8";

	$content = "";
	$time = time();
	// header('Content-Type: text/html; charset=utf8'); 
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=$charset",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "DELETE FROM content WHERE time < '$time' ";
		$conn->exec($sql);


		$stmt = $conn->prepare("SELECT * FROM content");
 		$stmt->execute();
 		$content = $stmt->fetchAll();
	}
	catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}

	echo json_encode($content, JSON_UNESCAPED_UNICODE);
?>