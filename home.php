<?php
  session_start();

  if (!isset($_SESSION['id'])) {
    header("Location: login.php");
  }

  include "kingcon.php";
  
  try {
   
      $database = new Connection();
   
      $db = $database->openConnection();
    
      $sql = "SELECT rs.id, rs.sala_id, slt.nome, rs.inicio_reserva, rs.fim_reserva, rs.info
                FROM reserva_salas rs 
                  INNER JOIN sala slt 
                  ON rs.sala_id = slt.id
                  WHERE rs.usuario_id = ?
                  ORDER BY rs.inicio_reserva ASC" ;
      $stmt = $db->prepare($sql);
      $stmt->execute(array($_SESSION['id']));
      $reunioes = $stmt->fetchAll();

      $sql2 = "SELECT id,nome,capacidade, info FROM sala " ;
      $stmt2 = $db->prepare($sql2);
      $stmt2->execute();
      $salas = $stmt2->fetchAll();
      $database->closeConnection();
    
  } catch (PDOException $e) {
   
      echo "There is some problem in connection: " . $e->getMessage();
   
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
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
  <link href="css/teste2.css" rel="stylesheet">
  
  
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
        <li class="active"><a href="home.php">Home</a></li>
        <li><a href="salaView.php">Reservar</a></li>
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
      <h1>Bem-Vindo <?=$_SESSION['nome'];?></h1>
      <p>
        <div class="container" id="tourpackages-carousel">
      <div class="row">
        <div class="col-lg-12"><h1>Minha lista de reservas <a class="addBtn btn icon-btn btn-primary pull-right" href="#"><span class="glyphicon btn-glyphicon glyphicon-plus img-circle"></span> Fazer Reserva</a></h1></div>
        <?php foreach ($reunioes as $reuniao) {?>
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
          <div class="thumbnail">
              <div class="caption">
                <div class='col-lg-12'>
                    <span class="glyphicon action glyphicon-pushpin"></span>
                    <a href="" data-toggle="modal" data-target="#deleteModal" data-id="<?=$reuniao['id']?>" class="deleteReserva">
                      <span class="glyphicon glyphicon-trash pull-right text-primary"></span>
                    </a>
                </div>
                <div class='col-lg-12 well well-add-card'>
                    <h4><?=$reuniao['nome']?></h4>
                </div>
                <div class='col-sm-12'>
                  <span class="glyphicon glyphicon-calendar pull-left text-primary"></span>
                  <span><?=date(' Y/m/d', strtotime($reuniao['inicio_reserva']));?></span>
                  <span class="pull-right"> -<?=date('H:i', strtotime($reuniao['fim_reserva']));?> </span>   
                  <span class="pull-right"><?=date('H:i', strtotime($reuniao['inicio_reserva']));?> - </span>
                  <span class="glyphicon glyphicon-time pull-right text-primary"></span>
                </div>

                <div class='col-lg-12'>
                   <p class="text-muted"><?=$reuniao['info']?></p>
                </div>
                <!--<button type="button" class="btn btn-primary btn-xs btn-update btn-add-card">Update</button>-->
                
                <button type="button" class="btn btn-danger btn-circle"><i class="glyphicon glyphicon-remove"></i></button>
                <span class='glyphicon glyphicon-exclamation-sign text-danger pull-right icon-style'></span>
            </div>
          </div>
        </div>
        <?php }?>
      </div><!-- End row -->
    </div><!-- End container -->
      </p>
      
    </div>

  </div>
</div>

<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

    <div class="container">
  
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <form class="reservarForm" method="post" id="reservarForm" name="reservarForm" action="" role="form">
            <div class="form-group">
              <label for="salaID"><span class="glyphicon glyphicon-tower"></span> Escolha a sala</label>
              
                        <select class="form-control" id="salaID" name="salaID">
                          <?php foreach ($salas as $sala) {?>
                              <option value='<?=$sala['id']?>'><?=$sala['nome']?> (<?=$sala['capacidade']?> pessoas)</option>";
                          <?php }?>
                        </select>
            </div>
            <div class="form-group">
                               
                      <label for="inicioReserva"><span class="glyphicon glyphicon-time"></span> Escolha a data/hora</label>
                      <div class="input-group date form_datetime" data-date="" data-date-format="dd-mm-yyyy HH:ii p" 
                            data-link-field="inicioReserva">
                        <input class="form-control" size="16" type="text" value="" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                      </div>
                      <input type="hidden" id="idUser" name="idUser" value="<?=$_SESSION['id'];?>" />
                      <input type="hidden" id="inicioReserva" name="inicioReserva" value="" />
                      <input type="hidden" id="op" name="op" value="reservaSala" />
                      <div id="fim">
                        <div class="input-group date form_datetime2 col-md-3" data-date="" data-date-format="dd-mm-yyyy HH:ii p" 
                              data-link-field="fimReserva">
                          <input class="form-control" size="16" type="text" value="" readonly>
                          <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                          <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                        </div>
                        <input type="hidden" id="fimReserva" name="fimReserva" value="" />
                      </div>

            </div>
            <div class="form-group">
              <legend>Observações/informações pertinentes</legend>
                    <div class="form-group">
                      <div class="input-group salaID">
                      <textarea class="form-control" id="info" name="info" rows="3"></textarea>
                      </div>
                    </div>
                </fieldset>
            </div>
            <button class="btn btn-sm btn-primary pull-left" type="submit" >Reservar</button>
             <button type="button" class="btn btn-danger btn-default pull-right" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
          </form>
        </div>
        <div class="modal-footer">
         
          
        </div>
      </div>
      
    </div>
  </div> 
</div>
<!-- Modal deletar reserva -->
    <div class="container">
      <div class="modal fade" id="deleteModal" role="dialog">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Desmarcar reserva ?</h4>
            </div>
            <div class="modal-body">
              <p id="deleteConfirm">Deseja mesmo desfazer esta reserva ? </p>
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
<script type="text/javascript">
  var reservaID;
  $(document).on("click", ".deleteReserva", function () {
     reservaID = $(this).data('id');
  });

  $(".addBtn").click(function() {
        opform = "addUser";
        $("#myModal").find('.modal-title').text('Adicionar Usuário');
       
        $("#myModal").modal();
        
    });
    $('#deleteModal').find('.modal-footer #delBtn').on('click', function() {
       
        $.ajax({
          type: "POST",
          url: "controller.php",
          data: {id: reservaID, op: 'delReserva'},
          dataType: "JSON",
            success : function(result)  {
            console.log(result);        
                    $('#deleteModal').modal('hide');
                    var resultBold = result.message.bold();
                    $('#messageModal').find('.modal-body p').html(resultBold);
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
