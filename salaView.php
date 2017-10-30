<?php
  session_start();
  if (!isset($_SESSION['id'])) {
    header("Location: login.php");
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
    
  } catch (PDOException $e) {
   
      echo "There is some problem in connection: " . $e->getMessage();
   
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Reservar Sala</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="js/boothstrap-timepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <script type="text/javascript" src="js/boothstrap-timepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment-with-locales.js"></script>
  <script type="text/javascript" src="js/boothstrap-timepicker/js/locales/bootstrap-datetimepicker.pt-BR.js" charset="UTF-8"></script>
  

  <link href="css/home.css" rel="stylesheet">
  
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
        <li><a href="home.php">Home</a></li>
        <li class="active"><a href="salaView.php">Reservar</a></li>
        <li><a href="salaViewSingle.php">Verificar Salas</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="controller.php?logout=true"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
      
    </div>
    <div class="col-sm-8 text-left"> 
      <h1>Bem vindo <?=$_SESSION['nome'];?> !</h1>
      <p>
        <div class="container">
          <form class="reservarForm" method="post" id="reservarForm" name="reservarForm" action="">
            
                <fieldset>
                    <legend>Reserve sua sala e seu horário</legend>
                    <div class="form-group">
                      <label for="salaID" class="col-md-2 control-label">Escolha a sala</label>
                      <div class="input-group salaID col-md-3">
                        <select class="form-control" id="salaID" name="salaID">
                          <?php foreach ($salas as $sala) {?>
                              <option value='<?=$sala['id']?>'><?=$sala['nome']?> (<?=$sala['capacidade']?> pessoas)</option>";
                          <?php }?>
                        </select>
                      </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Reserve seu horário e sua sala</legend>
                    <div class="form-group">
                      <label for="inicioReserva" class="col-md-2 control-label">Escolha a data/hora</label>
                      <div class="input-group date form_datetime col-md-3" data-date="" data-date-format="dd-mm-yyyy HH:ii p" 
                            data-link-field="inicioReserva">
                        <input class="form-control" size="16" type="text" value="" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                      </div>
                      <input type="hidden" id="idUser" name="idUser" value="<?=$_SESSION['id'];?>" /><br/>
                      <input type="hidden" id="inicioReserva" name="inicioReserva" value="" /><br/>
                      
                      <input type="hidden" id="op" name="op" value="reservaSala" /><br/>
                    </div>
                </fieldset>
                <div id="fim">
                  <fieldset>
                      <legend></legend>
                      <div class="form-group">
                        <label for="fimReserva" class="col-md-2 control-label"></label>
                        <div class="input-group date form_datetime2 col-md-3" data-date="" data-date-format="dd-mm-yyyy HH:ii p" 
                              data-link-field="fimReserva">
                          <input class="form-control" size="16" type="text" value="" readonly>
                          <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                          <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                        </div>
                        <input type="hidden" id="fimReserva" name="fimReserva" value="" /><br/>
                      
                      </div>
                  </fieldset>
                </div>
                <fieldset>
                    <legend>Observações/informações pertinentes</legend>
                    <div class="form-group">
                      <label for="info" class="col-md-2 control-label">Observações</label>
                      <div class="input-group salaID col-md-3">
                      <textarea class="form-control" id="info" name="info" rows="3"></textarea>
                      </div>
                    </div>
                </fieldset>
                <button class="btn btn-sm btn-primary" type="submit" >Reservar</button>
      </form>
            
        </div>
      </p>
      
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
<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

</body>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        language:  'pt-BR',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
   $('.form_datetime2').datetimepicker({
    language:  'pt-BR',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
   });
    $( "#fim" ).hide();
    $('.form_datetime').datetimepicker().on('changeDate', function(ev){
      var date2 = $('.form_datetime').datetimepicker('getDate'); 
      date2.setHours(date2.getHours()+1);    
      $('.form_datetime2').datetimepicker('setDate',date2);    
  });

  $('#reservarForm').submit(function(event) {
          event.preventDefault();
          
          var formData = $('#reservarForm').serialize();
          console.log(formData);
 
          $.ajax({
            type: 'POST',
            url: 'controller.php',
            data: formData,
            dataType: "JSON",
          }).done(function(response) {
              console.log(response);
              $('#messageModal').find('.modal-body p').html(response.message.bold());
                    $('#messageModal').modal('show');
                    $('#messageModal').find('.modal-footer button').on('click', function() {
                        location.reload();
              });
            
          }).fail(function(data) {
            console.log(data);
             
              // Set the message text.
              if (data.responseText !== '') {
                  console.log(data.responseText);
              } else {
                  console.log('Oops! An error occured and your message could not be sent.');
              }
          });
          
      });
</script>
</html>
