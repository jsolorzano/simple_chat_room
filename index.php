<?php include "login.php"; ?>
<?php include "logout.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Chat – Customer Module</title>
		<link type="text/css" rel="stylesheet" href="style.css" />
	</head>
	
	</body>
		
		<?php
		if(!isset($_SESSION['name'])){
			loginForm();
		}else{
		?>
		<div id="wrapper">
			<div id="menu">
				<p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
				<p class="logout"><a id="exit" href="#">Exit Chat</a></p>
				<div style="clear:both"></div>
			</div>

			<div id="chatbox">
			<?php
			if(file_exists("log.html") && filesize("log.html") > 0){
				$handle = fopen("log.html", "r");
				$contents = fread($handle, filesize("log.html"));
				fclose($handle);

				echo $contents;
			}
			?>
			</div>

			<form name="message" action="" method="POST">
				<input name="usermsg" type="text" id="usermsg" size="63" />
				<input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
			</form>
		</div>
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
		
		<script type="text/javascript">
		$(document).ready(function(){
			//Si el usuario quiere dejar la sesión
			$("#exit").click(function(){
				var exit = confirm("Are you sure you want to end the session?");
				if(exit==true){window.location = 'index.php?logout=true';}
			});
			
			// Envío de mensaje
			$("#submitmsg").click(function(e){
				e.preventDefault();
				var clientmsg = $("#usermsg").val();
				if(clientmsg != ""){
					$.post("post.php", {text: clientmsg});
					$("#usermsg").attr("value", "");
					// Actualizar mensajes
					loadLog();
				}
				return false;
			});
			
			//Carga el archivo que contiene el log de chat
			function loadLog(){
				var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //La altura del scroll antes de la petición
				$.ajax({
					url: "log.html",
					cache: false,
					success: function(html){
						
						$("#chatbox").html(html); //Inserta el log de chat en el div #chatbox
						
						//Auto-scroll
						var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //La altura del scroll después del pedido
						if(newscrollHeight > oldscrollHeight){
							$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll hacia el fondo del div
						}
						
					},
				});
			}
			
			//Recarga el archivo cada 2500 ms o x ms si deseas cambiar el segundo parámetro
			setInterval (loadLog, 2500);
		});
		</script>
		<?php
		}
		?>
		
	</body>
</html>
