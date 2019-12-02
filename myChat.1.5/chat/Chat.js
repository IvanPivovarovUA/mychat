function connect() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			content = JSON.parse(this.responseText);
			// console.log(content);

			
			for (i = 0; i < content.length; i++) {

				if (chat_check != chat.innerHTML && add == false) {
					content[i]["text"] = content[i]["text"].replace(":)",'<i class="fas fa-smile"></i>');
					content[i]["text"] = content[i]["text"].replace(":(",'<i class="fas fa-frown"></i>');
					
					chat_check += "[" + content[i]["name"] + "] _ " + content[i]["text"] + "<br><br>";
					
				}else {
					add = true;
					chat.innerHTML += "[" + content[i]["name"] + "] _ " + content[i]["text"] + "<br><br>";

					if (text_botton == true) {
						chat_content.scrollTop = 9999;
						
					}
					

					
				}
				
				
			}
			if (add == false && chat_check != chat.innerHTML) {
				chat.innerHTML = chat_check;
			}

			add = false;
			chat_check = "";
			
			
		}
	}
	xmlhttp.open("POST","GetContent.php",false);
	xmlhttp.send();

	text_bottom_button(false);

}
var chat = document.getElementById("chat_content"),
	chat_check = "",
	add = false,
	text_botton = true,
	
	content = "";

var reguest = setInterval(connect, 50);

function user_post() {
	var value = document.getElementById("text").value;
	document.getElementById("text").value = "";


	var user_name = getCookie("user_name"),
		user_password = getCookie("user_password");


	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
	    console.log(this.responseText);
 		
	}
	};
	xhttp.open("POST", "PushUserText.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("name="+user_name+"&password="+user_password+"&text="+value);


}




function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}


function text_bottom_button(x) {

	var scrollMaxSize = chat.scrollHeight - chat.clientHeight;

	if (chat.scrollTop == scrollMaxSize || x == true) {
		text_botton = true;
		document.getElementById("bottom").style.display = "none";
		chat_content.scrollTop = 9999;
	}else {
		text_botton = false;
		document.getElementById("bottom").style.display = "block";
	}
	



}


window.addEventListener("keydown", function(event) {
	if (event.code == "Enter") {
		user_post();
	}
});
