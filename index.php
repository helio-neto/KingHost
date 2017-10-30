<?php
	session_start();
	if (isset($_SESSION['id'])) {
		header("Location: home.php");
	}	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<meta name="description" content="">
		<meta name="author" content="">
		

		<title>Reserve Sala</title>

		<!-- Custom styles for this template -->
		<link href="css/login.css" rel="stylesheet">

	</head>

	<body>
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>                        
		      </button>
		      <a class="navbar-brand" href="#" ><img class="logo hidden-sm" border="0" alt="" src="https://www.kinghost.com.br/dist/logo-logo-a.png" 
		      	style="width: initial; position: relative; top: -4px;"></a>
		    </div>
		    <div class="collapse navbar-collapse" id="myNavbar">
		      <ul class="nav navbar-nav">
		        <li class="active"><a href="index.php">Login</a></li>
		        <li><a href="usuarioCRUD.php">Usuários</a></li>
		        <li><a href="salaCRUD.php">Salas</a></li>
		      </ul>
		    </div>
		  </div>
		</nav>

		<div class="container">
			
			<form class="form-signin" method="post" id="form-signin" name="form-signin" action="">
				<h2 class="form-signin-heading">Login</h2>
				
				<label for="inputEmail" class="sr-only">Email address</label>
				<input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
				<label for="inputPassword" class="sr-only">Password</label>
				<input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
				<input type="hidden" id="op" name="op" class="form-control" value="login">
				<div class="checkbox">
					<label>
						<input type="checkbox" value="remember-me"> Remember me
					</label>
				</div>
				<button class="btn btn-lg btn-primary btn-block" type="submit" >Sign in</button>
			</form>
			<div id="form-messages"></div>
		</div>
		
	</body>
	<script type="text/javascript">
		$(function() {
		   
		    var formMessages = $('#form-messages');

		    $('#form-signin').submit(function(event) {
		    	event.preventDefault();
		    	var formData = $('#form-signin').serialize();
			    
			    $.ajax({
				    type: 'POST',
				    url: 'controller.php',
				    data: formData,
				    dataType: "JSON",
				}).done(function(response) {
					if (response.login_status == true) {
				    	$(formMessages).removeClass('alert alert-danger');
				    	$(formMessages).addClass('alert alert-success');
				    	$('#form-signin')[0].reset();
				    	window.location.href = response.redirect_url;
					}else{
					    $(formMessages).removeClass('alert alert-success');
					    $(formMessages).addClass('alert alert-danger');
					}  
				    $(formMessages).text(response.message);
			   
				}).fail(function(data) {
					console.log(data);
				    // Make sure that the formMessages div has the 'error' class.
				    $(formMessages).removeClass('alert alert-success');
				    $(formMessages).addClass('alert alert-danger');

				    // Set the message text.
				    if (data.responseText !== '') {
				        $(formMessages).text(data.responseText);
				    } else {
				        $(formMessages).text('Oops! An error occured and your message could not be sent.');
				    }
				});
			    
			});
		});
	</script>
</html>