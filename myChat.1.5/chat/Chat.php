<?php 
	if (!isset($_COOKIE["user_name"]) ) {
		header("Location: http://localhost/myChat.1.5/come/Come.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="Chat.css">


	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body>
	<!-- <i class="fas fa-smile"></i> -->
	<div class="chat">
		<div id="chat_content"></div>
		<button id="bottom" onclick="text_bottom_button(true)"> <i class="fas fa-arrow-down"></i> </button>

		<div class="chat_form">
			
				<input class="chat_form-text" type="text" name="" id="text">
				<input class="chat_form-submit" type="button" name="" value="Submit" onclick="user_post()">
			
		</div>

		<div class="chat_fon"></div>
	</div>


	<script type="text/javascript" src="Chat.js"></script>
</html>