<?php
	session_start();
	if (isset($_SESSION['id'])) {
		header("Location: home.php");
	}
	include "kingcon.php";
	
	try {
	 
	    $database = new Connection();
	 
	    $db = $database->openConnection();
	 	
	    $sql = "SELECT id,nome,email FROM usuario " ;
	 	$stmt = $db->prepare($sql);
		$stmt->execute();
		$usuarios = $stmt->fetchAll();
	   
	    $database->closeConnection();
	 	
	}	catch (PDOException $e)	{
	 
	    echo "There is some problem in connection: " . $e->getMessage();
	 
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
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/bootstrap-table.min.css">

		<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/bootstrap-table.min.js"></script>
		<meta name="description" content="">
		<meta name="author" content="">
		

		<title>CRUD Usuário</title>

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
		      <a class="navbar-brand" href="#" ><img class="logo hidden-sm" border="0" alt="W3Schools" src="https://www.kinghost.com.br/dist/logo-logo-a.png" style="width: initial; position: relative; top: -4px;"></a>
		    </div>
		    <div class="collapse navbar-collapse" id="myNavbar">
		      <ul class="nav navbar-nav">
		        <li><a href="index.php">Login</a></li>
		        <li class="active"><a href="usuarioCRUD.php">Usuários</a></li>
		        <li><a href="salaCRUD.php">Salas</a></li>
		      </ul>
		    </div>
		  </div>
		</nav>

		<div class="container">
		  <h2>Usuários</h2>
		  <p><button type="button" class="addBtn btn btn-primary">Adicionar</button></p>                                                                                      
		  <div class="table-responsive">          
		  <table id="userTable" class="table table-striped table-hover">
		     <thead>
			        <tr class="ui-widget-header ">
			            <th>#</th>
			            <th>Nome</th>
			            <th>Email</th>
			           	<th>Actions</th>
			        </tr>
			    </thead>
			    <tbody>
			    	<?php foreach ($usuarios as $usuario) {?>
			        <tr>
			            <td class="nr" id="iduser"><span><?=$usuario['id']?></span>
			            </td>
			            <td><?=$usuario['nome']?></td>
			            <td><?=$usuario['email']?></td>
			           
			            <td>
			                <button type="button" class="editBtn btn btn-success">
				      		<span class="glyphicon glyphicon-pencil"></span> editar
				      		<button type="button" class="delBtn btn btn-danger">
				      		<span class="glyphicon glyphicon-remove"></span> deletar
				    	</button>
			            </td>
			        </tr>
			       <?php }?>
			    </tbody>
		    </tbody>
		  </table>
		<div class="container">
			<!-- Modal -->
			<div class="modal fade" id="myModal" role="dialog">
				<div class="modal-dialog">
			    <!-- Modal content-->
			    	<div class="modal-content">
			    		<div class="modal-header" style="padding:35px 50px;">
	          				<h4 class="modal-title" id="exampleModalLabel">
	          					<span class="glyphicon glyphicon-lock"></span>
	          				</h4>
			            </div>
			        	<div class="modal-body" style="padding:40px 50px;">
				        	<form class="form-user" method="post" id="form-user" name="form-user" action="">
								<label for="inputNome" class="sr-only">Email address</label>
								<input type="text" id="inputNome" name="inputNome" class="form-control" placeholder="Nome" required autofocus>
								<label for="inputEmail" class="sr-only">Email address</label>
								<input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required>
								<label for="inputPassword" class="sr-only">Password</label>
								<input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
				        </div>
				        	<div class="modal-footer">
				        		<button type="submit" class="btn btn-primary">Incluir</button>
								<button type="button" class="btn btn-default" data-dismiss="modal" id="cancelBtn">Cancelar</button>
				        	</div>
			        		</form> 
			      	</div>
			    </div>
			</div>
		</div>


		<div class="container">
		  <!-- Modal -->
		  <div class="modal fade" id="smallModal" role="dialog">
		    <div class="modal-dialog modal-sm">
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title">Modal Header</h4>
		        </div>
		        <div class="modal-body">
		          <p id="deleteConfirm"></p>
		        </div>
		        <div class="modal-footer">
		        	<button type="button" class="btn btn-danger" data-dismiss="modal" id="delBtn">Sim</button>
		          	<button type="button" class="btn btn-default" data-dismiss="modal" id="cancelBtn">Cancelar</button>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Message Modal -->
		<div id="messageModal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body">								
						<p></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-dark" data-dismiss="modal">OK</button>
					</div>
				</div>
			</div>
		</div>
		
      	<div class="panel-footer">Footer</div>

		
 

	</body>
	<script type="text/javascript">
		var opform, id_user;
		$(".addBtn").click(function() {
		    opform = "addUser";
    		$("#myModal").find('.modal-title').text('Adicionar Usuário');
    		$("#myModal").find('.modal-body #inputNome').val();
    		$("#myModal").find('.modal-body #inputEmail').val();
    		$("#myModal").modal();
    		$("#myModal").find('#cancelBtn').on('click', function() {				
					$('#form-user')[0].reset();	
			});
		});

		$(".editBtn").click(function() {
			opform = "editUSer";
		    var row = $(this).closest("tr");    // Find the row
		    var tds = row.find("td");
		    
		    $.each(tds, function() {
		        //console.log($(this).text());
		    });
		    // Finds the closest row <tr> 
    		id_user = row.find("td:nth-child(1)").text();
    		var nome_user = row.find("td:nth-child(2)").text();
    		var email_user = row.find("td:nth-child(3)").text();
    		console.log(id_user);
    		$("#myModal").find('.modal-title').text('Editar  ' + nome_user);
    		$("#myModal").find('.modal-body #inputNome').val(nome_user);
    		$("#myModal").find('.modal-body #inputEmail').val(email_user);
    		$("#myModal").modal();
    		$("#myModal").find('#cancelBtn').on('click', function() {				
					$('#form-user')[0].reset();	
			});

		});

		$(".delBtn").click(function() {
		    var row = $(this).closest("tr");    // Find the row
		    var tds = row.find("td");
		    $.each(tds, function() {
		       // console.log($(this).text());
		    });
		    id_user = row.find("td:nth-child(1)").text();
    		var nome_user = row.find("td:nth-child(2)").text();
    		var email_user = row.find("td:nth-child(3)").text();
		    $("#smallModal").modal();
		   	$("#smallModal").find('.modal-body #deleteConfirm').html("Deseja mesmo deletar usuário "+nome_user+" ?");
		    $('#smallModal').find('.modal-footer #delBtn').on('click', function() {
					$.ajax({
					type: "POST",
					url: "controller.php",
					data: {id: id_user, nome: nome_user ,op: 'delUSer'},
					dataType: "JSON",
						success : function(result)	{
										$('#smallModal').modal('hide');
										var userBold = result.usuario.bold();
										$('#messageModal').find('.modal-body p').html("Usuário "+userBold+"  "+result.message);
										$('#messageModal').modal('show');
										$('#messageModal').find('.modal-footer button').on('click', function() {
												location.reload();
										});				
						},
						failure : function() {
								console.log("problemas");
						}
					});
			});
		});

		$("#form-user").on("submit", function (event) {
			event.preventDefault();

			var formdata = $("#form-user").serialize()+'&id='+id_user+'&op=' + opform;

			$.ajax({
					type: "POST",
					url: "controller.php",
					data: formdata,
					dataType: "JSON",
					success : function(result)	{
								$('#form-user')[0].reset();	
								$("#myModal").modal('hide');
								var userBold = result.usuario.bold();
								$('#messageModal').find('.modal-body p').html("Usuário "+userBold+"  "+result.message);
								$('#messageModal').modal('show');
								$('#messageModal').find('.modal-footer button').on('click', function() {
										location.reload();
								});
								
					},
					failure : function() {
						console.log("problemas");
					}
			});
			
			
		});


	</script>
</html>