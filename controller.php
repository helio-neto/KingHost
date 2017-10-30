<?php
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	date_default_timezone_set('America/Sao_Paulo');

	include_once 'kingcon.php';

	$op = ($_POST) ? $_POST['op'] : null ;
	$response = array();
	
	switch ($op) {

		case 'login':

			$email = $_POST['inputEmail'];
			$senha = $_POST['inputPassword'];
			
			try {
 				
			    $database = new Connection();
			    $db = $database->openConnection();
  				
			 	$sql = 'SELECT id, nome, email, senha FROM usuario WHERE email=:email';
				$stmt = $db->prepare($sql);
				$stmt->bindValue(':email', $email);
		
				$stmt->execute();
				if ($stmt->rowCount() > 0) {
					$data = $stmt->fetch();
					if (password_verify($senha, $data['senha'])) {
						$response['usuario'] = $data;
						$response['login_status'] = true;
						$response['message'] = "Login efetuado com sucesso!";
						session_start();
						$_SESSION["id"] = $data['id'];
						$_SESSION["nome"] = $data['nome'];
						
						// Set the redirect url after successful login
						$response['redirect_url'] = 'home.php';
						echo json_encode(($response));
						$login_status = 'success';
					}else{
						$response['login_status'] = false;
						$response['message'] = "Senha invalida!";
						echo json_encode(($response));
					}
					
				}else{
					$response['login_status'] = false;
					$response['message'] = "Email invalido!";
					echo json_encode(($response));
				}
				
			}	catch (PDOException $e) {
 				$response['message'] = "There is some problem in connection: " . $e->getMessage();
    			echo json_encode($response);
			}
			break;

		case 'addUser':

			$nome = $_POST['inputNome'];
			$email = $_POST['inputEmail'];
			$senha = $_POST['inputPassword'];
			$hashpass = password_hash($senha, PASSWORD_DEFAULT);
			try {
 				
			    $database = new Connection();
			    $db = $database->openConnection();
  				
			 	$sql = "INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)";
				$stmt = $db->prepare($sql);
				
				if ($stmt->execute(array($nome, $email, $hashpass)))	{
					$response['usuario'] = $nome;
					$response['message'] = "criado com successo!";
					echo json_encode(($response));
				}else{
					$response['message'] = $stmt->error;
					echo json_encode(($response));
				}
				
			}	catch (PDOException $e) {
 				$response['message'] = "There is some problem in connection: " . $e->getMessage();
    			echo json_encode($response);
			}
			
			
			break;

		case 'editUSer':

			$id = $_POST['id'];
			$nome = $_POST['inputNome'];
			$email = $_POST['inputEmail'];
			$senha = $_POST['inputPassword'];
			$hashpass = password_hash($senha, PASSWORD_DEFAULT);
			try {
 				
			    $database = new Connection();
			    $db = $database->openConnection();
  				
			 	$sql = "UPDATE usuario SET nome = ?, email = ?, senha = ? WHERE id = ?";
				$stmt = $db->prepare($sql);			
				
				if ($stmt->execute(array($nome, $email, $hashpass, $id)))	{
					$response['usuario'] = $nome;
					$response['message'] = "editado com successo!";
					echo json_encode(($response));
				}else{
					$response['message'] = $stmt->error;
					echo json_encode(($response));
				}
				
			}	catch (PDOException $e) {
    			$response['message'] = "There is some problem in connection: " . $e->getMessage();
    			echo json_encode($response);
			}
			break;

		case 'delUSer':

			$id = $_POST['id'];
			$nome = $_POST['nome'];
			try {
 				
			    $database = new Connection();
			    $db = $database->openConnection();
  				
			 	$sql = "DELETE FROM usuario WHERE id = ?";
				$stmt = $db->prepare($sql);			
				
				if ($stmt->execute(array($id)))	{
					$response['usuario'] = $nome;
					$response['message'] = "deletado com successo!";
					echo json_encode(($response));
				}else{
					$response['message'] = $stmt->error;
					echo json_encode(($response));
				}
				
			}	catch (PDOException $e) {
 				$response['message'] = "There is some problem in connection: " . $e->getMessage();
    			echo json_encode($response);
			}
			break;

		case 'getSala':

			$id = $_POST['id'];
			
			try {
 				
			    $database = new Connection();
			    $db = $database->openConnection();
  				
			 	$sql = "SELECT rs.id, slt.nome,slt.capacidade, rs.inicio_reserva, rs.fim_reserva, rs.info 
			 				FROM reserva_salas rs 
			 				INNER JOIN sala slt ON rs.sala_id = slt.id
			 				WHERE rs.sala_id = ? 
			 				ORDER BY rs.inicio_reserva ASC";
				$stmt = $db->prepare($sql);
							
				if ($stmt->execute(array($id)))	{
					$reunioes = $stmt->fetchAll();
					$response['reunioes_sala'] = ($reunioes);
					$response['message'] = "Reuniões carregadas!";
					echo json_encode(($response));
				}else{
					$response['message'] = $stmt->error;
					echo json_encode(($response));
				}
				
			}	catch (PDOException $e) {
 				$response['message'] = "There is some problem in connection: " . $e->getMessage();
    			echo json_encode($response);
			}
			
			
			break;

		case 'addSala':

			$nome = $_POST['inputNome'];
			$capacidade = $_POST['inputCap'];
			$info = $_POST['inputInfo'];
			try {
 				
			    $database = new Connection();
			    $db = $database->openConnection();
  				
			 	$sql = "INSERT INTO sala (nome, capacidade, info) VALUES (?, ?, ?)";
				$stmt = $db->prepare($sql);
							
				if ($stmt->execute(array($nome, $capacidade, $info)))	{
					$response['sala'] = $nome;
					$response['message'] = "criada com successo!";
					echo json_encode(($response));
				}else{
					$response['message'] = $stmt->error;
					echo json_encode(($response));
				}
				
			}	catch (PDOException $e) {
 				$response['message'] = "There is some problem in connection: " . $e->getMessage();
    			echo json_encode($response);
			}
					
			break;

		case 'editSala':

			$id = $_POST['id'];
			$nome = $_POST['inputNome'];
			$capacidade = $_POST['inputCap'];
			$info = $_POST['inputInfo'];
			try {
 				
			    $database = new Connection();
			    $db = $database->openConnection();
  				
			 	$sql = "UPDATE sala SET nome = ?, capacidade = ?, info = ? WHERE id = ?";
				$stmt = $db->prepare($sql);			
				
				if ($stmt->execute(array($nome, $id, $capacidade, $info)))	{
					$response['sala'] = $nome;
					$response['message'] = "editada com successo!";
					echo json_encode(($response));
				}else{
					$response['message'] = $stmt->error;
					echo json_encode(($response));
				}
				
			}	catch (PDOException $e) {
 				$response['message'] = "There is some problem in connection: " . $e->getMessage();
    			echo json_encode($response);
			}
			break;

		case 'delSala':

			$id = $_POST['id'];
			$nome = $_POST['nome'];
			try {
 				
			    $database = new Connection();
			    $db = $database->openConnection();
  				
			 	$sql = "DELETE FROM sala WHERE id = ?";
				$stmt = $db->prepare($sql);			
				
				if ($stmt->execute(array($id)))	{
					$response['sala'] = $nome;
					$response['message'] = "deletada com successo!";
					echo json_encode(($response));
				}else{
					$response['message'] = $stmt->error;
					echo json_encode(($response));
				}
				
			}	catch (PDOException $e) {
 				$response['message'] = "There is some problem in connection: " . $e->getMessage();
    			echo json_encode($response);
			}
			break;

		case 'reservaSala':

			$salaID = $_POST['salaID'];
			$inicioReserva = $_POST['inicioReserva'];
			$idUser = $_POST['idUser'];
			$fimReserva = $_POST['fimReserva'];
			$info = $_POST['info'];
			try {
 				
			    $database = new Connection();
			    $db = $database->openConnection();
			    $sql = "SELECT 1 FROM `reserva_salas` WHERE date(?) BETWEEN date(`inicio_reserva`) AND date(`fim_reserva`) AND time(?) 
			    		BETWEEN time(`inicio_reserva`) AND time(`fim_reserva`)";
				$stmt = $db->prepare($sql);
  				if ($stmt->execute(array($inicioReserva, $inicioReserva)))	{
  					if ($stmt->fetch() > 0) {
  						$response["disponivel"] = false;
  						$response['message'] = "Horário já utilizado!";
						echo json_encode(($response));
  					}else{
  						$response["disponivel"] = true;
  						$sql2 = "INSERT INTO reserva_salas (sala_id, usuario_id, inicio_reserva, fim_reserva, info) VALUES (?, ?, ?, ?, ?)";
						$stmt2 = $db->prepare($sql2);
										
						if ($stmt2->execute(array($salaID, $idUser, $inicioReserva, $fimReserva, $info)))	{
								
							$response['message'] = "Sala reservada com successo!";
							echo json_encode(($response));
						}else{
							$response['message'] = $stmt2->error;
							echo json_encode(($response));
						}
  					}
  				}else{
  					$response['message'] = $stmt->error;
					echo json_encode(($response));
  				}
			 	
				
			}	catch (PDOException $e) {
 				$response['message'] = "There is some problem in connection: " . $e->getMessage();
    			echo json_encode($response);
			}
			break;

		case 'delReserva':

			$idReserva = $_POST['id'];
			
			try {
 				
			    $database = new Connection();
			    $db = $database->openConnection();
  				
			 	$sql = "DELETE FROM reserva_salas WHERE id = ?";
				$stmt = $db->prepare($sql);			
				
				if ($stmt->execute(array($idReserva)))	{
					
					$response['message'] = "Reserva deletada com successo!";
					echo json_encode(($response));
				}else{
					$response['message'] = $stmt->error;
					echo json_encode(($response));
				}
				
			}	catch (PDOException $e) {
 				$response['message'] = "There is some problem in connection: " . $e->getMessage();
    			echo json_encode($response);
			}
			break;

		default:
			if ($_GET['logout'] == true) {
				session_start();
				session_destroy();
				header("Location: index.php");
			}
			break;
	}
?>