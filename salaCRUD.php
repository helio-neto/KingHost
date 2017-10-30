<?php
	session_start();
	if (isset($_SESSION['id'])) {
		header("Location: home.php");
	}
	include "kingcon.php";
	
	try {
	 
	    $database = new Connection();
	 
	    $db = $database->openConnection();
	 	
	    $sql = "SELECT id,nome,capacidade, info FROM sala " ;
	 	$stmt = $db->prepare($sql);
		$stmt->execute();
		$salas = $stmt->fetchAll();
	   
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
		

		<title>CRUD Sala</title>

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
		      <a class="navbar-brand" href="#" ><img class="logo hidden-sm" border="0" alt="" src="https://www.kinghost.com.br/dist/logo-logo-a.png" style="width: initial; position: relative; top: -4px;"></a>
		    </div>
		    <div class="collapse navbar-collapse" id="myNavbar">
		      <ul class="nav navbar-nav">
		        <li><a href="index.php">Login</a></li>
		        <li><a href="usuarioCRUD.php">Usuários</a></li>
		        <li class="active"><a href="salaCRUD.php">Salas</a></li>
		      </ul>
		    </div>
		  </div>
		</nav>

		<div class="container">
		  <h2>Salas</h2>
		  <p><button type="button" class="addBtn btn btn-primary">Adicionar</button></p>                                                                                      
		  <div class="table-responsive">          
		  <table id="userTable" class="table table-striped table-hover">
		     <thead>
			        <tr class="ui-widget-header ">
			            <th>#</th>
			            <th>Nome</th>
			            <th>Em uso</th>
			           	<th>Info</th>
			           	<th>Actions</th>
			        </tr>
			    </thead>
			    <tbody>
			    	<?php foreach ($salas as $sala) {?>
			        <tr>
			            <td class="nr" id="iduser"><span><?=$sala['id']?></span>
			            </td>
			            <td><?=$sala['nome']?></td>
			            <td><?=$sala['capacidade']?></td>
			          	<td><?=$sala['info']?></td>
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
				        	<form class="form-sala" method="post" id="form-sala" name="form-sala" action="">
								<label for="inputNome" class="sr-only">Nome</label>
								<input type="text" id="inputNome" name="inputNome" class="form-control-sm" placeholder="Nome" required autofocus>
								<label for="inputCap" class="sr-only">Capacidade</label>
								<input type="number" id="inputCap" name="inputCap" class="form-control-sm" required>
								<label for="inputInfo" class="sr-only">Informações da sala</label>
								<textarea class="form-control" id="inputInfo" name="inputInfo" rows="3"></textarea>
								
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
		var opform, id_sala;
		$(".addBtn").click(function() {
		    opform = "addSala";
    		$("#myModal").find('.modal-title').text('Adicionar Sala');
    		$("#myModal").find('.modal-body #inputNome').val();
    		$("#myModal").find('.modal-body #inputUso').val();
    		$("#myModal").modal();
    		$("#myModal").find('#cancelBtn').on('click', function() {				
					$('#form-sala')[0].reset();	
			});
		});

		$(".editBtn").click(function() {
			opform = "editSala";
		    var row = $(this).closest("tr");    // Find the row
		    var tds = row.find("td");
		    
		    $.each(tds, function() {
		        //console.log($(this).text());
		    });
		    // Finds the closest row <tr> 
    		id_sala = row.find("td:nth-child(1)").text();
    		var nome_sala = row.find("td:nth-child(2)").text();
    		var capacidade = row.find("td:nth-child(3)").text();
    		var info = row.find("td:nth-child(4)").text();
    		$("#myModal").find('.modal-title').text('Editar  ' + id_sala);
    		$("#myModal").find('.modal-body #inputNome').val(nome_sala);
    		$("#myModal").find('.modal-body #inputCap').val(capacidade);
    		$("#myModal").find('.modal-body #inputInfo').val(info);
    		$("#myModal").modal();
    		$("#myModal").find('#cancelBtn').on('click', function() {				
					$('#form-sala')[0].reset();	
			});

		});

		$(".delBtn").click(function() {
		    var row = $(this).closest("tr");    // Find the row
		    var tds = row.find("td");
		    $.each(tds, function() {
		       // console.log($(this).text());
		    });
		    id_sala = row.find("td:nth-child(1)").text();
    		var nome_sala = row.find("td:nth-child(2)").text();
		    $("#smallModal").modal();
		   	$("#smallModal").find('.modal-body #deleteConfirm').html("Deseja mesmo deletar a sala "+nome_sala+" ?");
		    $('#smallModal').find('.modal-footer #delBtn').on('click', function() {
					$.ajax({
					type: "POST",
					url: "controller.php",
					data: {id: id_sala, nome: nome_sala ,op: 'delSala'},
					dataType: "JSON",
						success : function(result)	{
										$('#smallModal').modal('hide');
										var salaBold = result.sala.bold();
										$('#messageModal').find('.modal-body p').html("Usuário "+salaBold+"  "+result.message);
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

		$("#form-sala").on("submit", function (event) {
			event.preventDefault();

			var formdata = $("#form-sala").serialize()+'&id='+id_sala+'&op=' + opform;
			//var uso2 = $("#myModal").find('.modal-body #inputUso:checked').val();
			console.log(formdata);
		
			$.ajax({
					type: "POST",
					url: "controller.php",
					data: formdata,
					dataType: "JSON",
					success : function(result)	{
								$('#form-sala')[0].reset();	
								$("#myModal").modal('hide');
								var salaBold = result.sala.bold();
								$('#messageModal').find('.modal-body p').html("Sala "+salaBold+"  "+result.message);
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