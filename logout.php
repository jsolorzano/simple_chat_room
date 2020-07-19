<?php
if(isset($_GET['logout'])){
	//Mensaje simple de salida
	$fp = fopen("log.html", 'a');
	fwrite($fp, "<div class='msgln'><i>User ". $_SESSION['name'] ." has left the chat session.</i><br></div>");
	fclose($fp);

	session_destroy();
	header("Location: index.php"); //Redirige al usuario
}
?>
