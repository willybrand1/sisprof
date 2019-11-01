<?php
session_start();

if($_SESSION['user'] == ""){
    header("Location: index.php");
}else{
    $user = $_SESSION['user'];
    $userName = $_SESSION['nome_user'];

}
?>



  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SISPROF</title>

  <!-- Custom fonts for this template-->
  <script src="vendor/jquery/jquery.js"></script>
  <link href="vendor/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">
  <script src="vendor/bootstrap/dist/js/bootstrap.bundle.js"></script>
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/dist/css/bootstrap.css">
  <script src="vendor/datatables/datatables.js"></script>
  <link href="vendor/datatables/datatables.css" rel="stylesheet" type="text/css">
  <script src="vendor/select2/js/select2.full.js"></script>
  <link href="vendor/select2/css/select2.css" rel="stylesheet" type="text/css">
  
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <script>
  function deletaTurma(id_t){
      if(confirm('Deseja realmente deletar a turma?')){
          $.ajax({
              url: './deletaTurma.php',
              dataType: 'text',
              method: 'POST',
              data: {
                  id_turma:id_t
              },
              success: function(txt){
                  alert(txt);
                  window.location.reload();
              }
          });
      }
  }

  function deletaAluno(id_a){
      if(confirm('Deseja realmente deletar o aluno?')){
          $.ajax({
              url: './deletaAluno.php',
              dataType: 'text',
              method: 'POST',
              data: {
                  id_aluno:id_a
              },
              success: function(txt){
                  alert(txt);
                  window.location.reload();
              }
          });
      }
  }

  function deslogar(){
      var user = '<?=$user?>';
      $.ajax({
          url: './logout.php',
          dataType: 'text',
          type: "POST",
          data: {
              user:user,
              deslogar:1
          },
          success: function(obj){
              console.log(obj);
              if(obj < 1){
                  setTimeout(function(){
                      alert("Obrigado pelo seu trabalho, até breve professor.");
                      window.location.href = "index.php";
                  }, 500);
              }else{
                  alert("Erro ao tentar deslogar.");
              }
          }
      });
  }

  function mudaDiv(div = "inicio"){
      if(div == 'inicio'){
          $("#divInicio").css("display","block");
          $("#divTurma").css("display","none");
          $("#divAluno").css("display","none");
          $("#divFalta").css("display","none");
          $("#avaliacao").css("display","none");
          $("#darnota").css("display","none");
          $("#notaturma").css("display","none");
          $("#divDash").css("display","none");
      }else if(div == 'turma'){
          $("#divInicio").css("display","none");
          $("#divTurma").css("display","block");
          $("#divAluno").css("display","none");
          $("#divFalta").css("display","none");
          $("#avaliacao").css("display","none");
          $("#darnota").css("display","none");
          $("#notaturma").css("display","none");
          $("#divDash").css("display","none");
      }else if(div == 'aluno'){
          $("#divInicio").css("display","none");
          $("#divTurma").css("display","none");
          $("#divAluno").css("display","block");
          $("#divFalta").css("display","none");
          $("#avaliacao").css("display","none");
          $("#darnota").css("display","none");
          $("#notaturma").css("display","none");
          $("#divDash").css("display","none");
      }else if(div == 'falta'){
          $("#divInicio").css("display","none");
          $("#divTurma").css("display","none");
          $("#divAluno").css("display","none");
          $("#divFalta").css("display","block");
          $("#avaliacao").css("display","none");
          $("#darnota").css("display","none");
          $("#notaturma").css("display","none");
          $("#divDash").css("display","none");
      }else if(div == 'avaliacao'){
          $("#divInicio").css("display","none");
          $("#divTurma").css("display","none");
          $("#divAluno").css("display","none");
          $("#divFalta").css("display","none");
          $("#avaliacao").css("display","block");
          $("#darnota").css("display","none");
          $("#notaturma").css("display","none");
          $("#divDash").css("display","none");
      }else if(div == 'darnota'){
          $("#divInicio").css("display","none");
          $("#divTurma").css("display","none");
          $("#divAluno").css("display","none");
          $("#divFalta").css("display","none");
          $("#avaliacao").css("display","none");
          $("#darnota").css("display","block");
          $("#notaturma").css("display","none");
          $("#divDash").css("display","none");
      }else if(div == 'notaturma'){
          $("#divInicio").css("display","none");
          $("#divTurma").css("display","none");
          $("#divAluno").css("display","none");
          $("#divFalta").css("display","none");
          $("#avaliacao").css("display","none");
          $("#darnota").css("display","none");
          $("#notaturma").css("display","block");
          $("#divDash").css("display","none");
      }else if(div == 'dash'){
          $("#divInicio").css("display","none");
          $("#divTurma").css("display","none");
          $("#divAluno").css("display","none");
          $("#divFalta").css("display","none");
          $("#avaliacao").css("display","none");
          $("#darnota").css("display","none");
          $("#notaturma").css("display","none");
          $("#divDash").css("display","block");
      }
  }

  function showModalTurmas(id_turma = 0,modTitulo,modSize = 0){
      if((modTitulo.length < 1) || (modTitulo == "")){
          modTitulo = "Modal";
      }

      if(modSize > 0){
          modSize = "modal-lg";
      }else{
          modSize = "modal-sm";
      }
      var txt = '';
      txt += '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
          txt += '<div class="modal-dialog '+modSize+'" role="document">';
              txt += '<div class="modal-content" style="text-align: justify;">';
                  txt += '<div class="modal-header">';
                      txt += '<h5 class="modal-title" id="exampleModalLabel">'+modTitulo+'</h5>';
                      txt += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                          txt += '<span aria-hidden="true">&times;</span>';
                      txt += '</button>';
                  txt += '</div>';
              txt += '<div class="iframe-container">';
                  txt += '<iframe id="myIframe" style="width: 100%; border: none;" src="./turma.php?turma='+id_turma+'"></iframe>';
              txt += '</div>';
              // txt += '<div class="modal-footer">';
              //     txt += '<button type="button" style="margin: 3px 3px 3px 3px;" class="btn btn-secondary" data-dismiss="modal">Fechar</button>';
              //     txt += '<button type="button" style="margin: 3px 3px 3px 3px;" class="btn btn-primary">Salvar</button>';
              // txt += '</div>';
          txt += '</div>';
      txt += '</div>';

      $("#divModal").html(txt);
      setTimeout(function(){
          $("#myModal").modal("show");
      }, 50);
  }

  function showModalAlunos(id_aluno = 0,modTitulo,modSize = 0){
      if((modTitulo.length < 1) || (modTitulo == "")){
          modTitulo = "Modal";
      }

      if(modSize > 0){
          modSize = "modal-lg";
      }else{
          modSize = "modal-sm";
      }
      var txt = '';
      txt += '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
          txt += '<div class="modal-dialog '+modSize+'" role="document">';
              txt += '<div class="modal-content" style="text-align: justify;">';
                  txt += '<div class="modal-header">';
                      txt += '<h5 class="modal-title" id="exampleModalLabel">'+modTitulo+'</h5>';
                      txt += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                          txt += '<span aria-hidden="true">&times;</span>';
                      txt += '</button>';
                  txt += '</div>';
              txt += '<div class="iframe-container">';
                  txt += '<iframe id="myIframe" style="width: 100%; border: none;" src="./aluno.php?aluno='+id_aluno+'"></iframe>';
              txt += '</div>';
              // txt += '<div class="modal-footer">';
              //     txt += '<button type="button" style="margin: 3px 3px 3px 3px;" class="btn btn-secondary" data-dismiss="modal">Fechar</button>';
              //     txt += '<button type="button" style="margin: 3px 3px 3px 3px;" class="btn btn-primary">Salvar</button>';
              // txt += '</div>';
          txt += '</div>';
      txt += '</div>';

      $("#divModal").html(txt);
      setTimeout(function(){
          $("#myModal").modal("show");
      }, 50);
  }

  function preencheTab(){
      $.ajax({
          url: './getTurmas.php',
          dataType: 'json',
          method: 'post',
          success: function(obj){
              var o = obj.data;
              var tr = '';
              for(var i=0; i<o.length; i++){
                  tr += '<tr>';
                  tr += '<td></td>';
                  tr += '<td>'+o[i].qtd_aluno+'</td>';
                  tr += '<td>'+o[i].serie+'</td>';
                  tr += '<td>'+o[i].periodo+'</td>';
                  tr += '<td>'+o[i].turma+'</td>';
                  tr += '</tr>';
              }

              $("#tbturma").append(tr);
          }
      });
  }

  $(document).ready(function(){
      mudaDiv();

      $('#txtAlunos').select2({
          dropdownParent: $('#myModal')
      });

      var dataTable = $('#tbturma').DataTable( {
          "ajax": "./getTurmas.php",
          "deferRender": true,
          "columns": [
              { "data": "id_t" },
              { "data": "turma" },
              { "data": "periodo" },
              { "data": "serie" },
              { "data": "qtd_aluno" },
              { "data": "opcoes" }
          ],
          // "dom": 'lfrtipB',
          "buttons": [

          ],
          "oLanguage": {
              "sProcessing":   "Processando...",
              "sLengthMenu":   "Mostrar _MENU_ registros",
              "sZeroRecords":  "N&atilde;o foram encontrados resultados",
              "sInfo":         "Mostrando de _START_ at&eacute; _END_ de _TOTAL_ registros",
              "sInfoEmpty":    "Mostrando de 0 at&eacute; 0 de 0 registros",
              "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
              "sInfoPostFix":  "",
              "sSearch":       "Buscar:",
              "sUrl":          "",
              "oPaginate": {
                  "sFirst":    "Primeiro",
                  "sPrevious": "Anterior",
                  "sNext":     "Seguinte",
                  "sLast":     "&Uacute;ltimo"
              }
          }
      });

      var dataTable = $('#tbaluno').DataTable( {
          "ajax": "./getAlunos.php",
          "deferRender": true,
          "columns": [
              { "data": "id_a" },
              { "data": "aluno" },
              { "data": "matricula" },
              { "data": "observacao" },
              { "data": "opcoes" }
          ],
          // "dom": 'lfrtipB',
          "buttons": [

          ],
          "oLanguage": {
              "sProcessing":   "Processando...",
              "sLengthMenu":   "Mostrar _MENU_ registros",
              "sZeroRecords":  "N&atilde;o foram encontrados resultados",
              "sInfo":         "Mostrando de _START_ at&eacute; _END_ de _TOTAL_ registros",
              "sInfoEmpty":    "Mostrando de 0 at&eacute; 0 de 0 registros",
              "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
              "sInfoPostFix":  "",
              "sSearch":       "Buscar:",
              "sUrl":          "",
              "oPaginate": {
                  "sFirst":    "Primeiro",
                  "sPrevious": "Anterior",
                  "sNext":     "Seguinte",
                  "sLast":     "&Uacute;ltimo"
              }
          }
      });

      var dataTable = $('#tbavalia').DataTable( {
          "ajax": "./getAvaliacao.php",
          "deferRender": true,
          "columns": [
              { "data": "id_avalia" },
              { "data": "avaliacao" },
              { "data": "notamax" },
              { "data": "dta_avaliacao" },
              { "data": "opcoes" }
          ],
          // "dom": 'lfrtipB',
          "buttons": [

          ],
          "oLanguage": {
              "sProcessing":   "Processando...",
              "sLengthMenu":   "Mostrar _MENU_ registros",
              "sZeroRecords":  "N&atilde;o foram encontrados resultados",
              "sInfo":         "Mostrando de _START_ at&eacute; _END_ de _TOTAL_ registros",
              "sInfoEmpty":    "Mostrando de 0 at&eacute; 0 de 0 registros",
              "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
              "sInfoPostFix":  "",
              "sSearch":       "Buscar:",
              "sUrl":          "",
              "oPaginate": {
                  "sFirst":    "Primeiro",
                  "sPrevious": "Anterior",
                  "sNext":     "Seguinte",
                  "sLast":     "&Uacute;ltimo"
              }
          }
      });

      // preencheTab();
  });
  </script>


  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
    <a class="navbar-brand mr-1" href="console.php"><span class="badge badge-secondary" style="font-size: 20px;">SIS</span>PROF - Sistema para professores</a>

    

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      
      
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?=$_SESSION["nome_user"]?>&nbsp;&nbsp;<i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a onclick="deslogar();" class="dropdown-item" style="cursor: pointer;">Logout</a>
      </li>
    </ul>

  </nav>

  <div id="wrapper">
    <div id="sidebar-wrapper">
        <!-- <ul class="sidebar navbar-nav">
            <li class="nav-item active"> <input class="nav-link" type="button" value="Início" style="cursor: pointer;background: none; border: none; padding: 0 auto;color: white;" id="inicio" name="inicio" onclick="mudaDiv('inicio');"> </li>
            <li class="nav-item active"> <input class="nav-link" type="button" value="Controle de turma" style="cursor: pointer;background: none; border: none; padding: 0 auto;color: white;" id="ctrTurma" name="ctrTurma" onclick="mudaDiv('turma');"> </li>
            <li class="nav-item active"> <input class="nav-link" type="button" value="Controle de alunos" style="cursor: pointer;background: none; border: none; padding: 0 auto;color: white;" id="ctrAluno" name="ctrAluno" onclick="mudaDiv('aluno');"> </li>
            <li class="nav-item active"> <input class="nav-link" type="button" value="Controle de faltas" style="cursor: pointer;background: none; border: none; padding: 0 auto;color: white;" id="ctrFalta" name="ctrFalta" onclick="mudaDiv('falta');"> </li>
            <li class="nav-item active"> <input class="nav-link" type="button" value="Controle de notas" style="cursor: pointer;background: none; border: none; padding: 0 auto;color: white;" id="ctrNotas" name="ctrNotas" onclick="mudaDiv('nota');"> </li>
            <li class="nav-item active"> <input class="nav-link" type="button" value="Dashboard" style="cursor: pointer;background: none; border: none; padding: 0 auto;color: white;" id="dash" name="dash" onclick="mudaDiv('dash');"> </li>
        </ul> -->
        <ul class="sidebar navbar-nav">
            <li class="nav-item">
                <a class="nav-link" style="cursor: pointer;" onclick="mudaDiv('inicio');">
                <i class="fas fa-fw fa-home"></i>
                <span>Início</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="cursor: pointer;" onclick="mudaDiv('turma');">
                <i class="fas fa-fw fa-graduation-cap"></i>
                <span>Controle de turmas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="cursor: pointer;" onclick="mudaDiv('aluno');">
                <i class="fas fa-fw fa-users"></i>
                <span>Controle de alunos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="cursor: pointer;" onclick="mudaDiv('falta');">
                <i class="fas fa-fw fa-user-times"></i>
                <span>Controle de faltas</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a style="cursor: pointer;" class="nav-link dropdown-toggle" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-pen"></i>
                    <span>Controle de notas</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <a class="dropdown-item"  style="cursor: pointer;" onclick="mudaDiv('avaliacao');">Cadastrar avaliação</a>
                    <a class="dropdown-item"  style="cursor: pointer;" onclick="mudaDiv('darnota');">Dar nota</a>
                    <a class="dropdown-item"  style="cursor: pointer;" onclick="mudaDiv('notaturma');">Ver nota/turma</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="cursor: pointer;" onclick="mudaDiv('dash');">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
                </a>
            </li>
        </ul>
    </div>
    


    <div id="content-wrapper">

      <div class="container-fluid">
      <div id="divModal"></div>
            <div id="divInicio">
                <div class="container-fluid">
                    <h1>SISPROF - Sistema para professores</h1>
                    <hr style="width: 100%;">
                    <p>Esse sistema tem por objetivo auxiliar os professores no controle de suas turmas e alunos.</p>
                    <p>Com ele é possível cadastrar novas turmas, inserir alunos nessas turmas, dar notas aos alunos, assim como </p>
                    <p>indicar se esse aluno teve falta. É possível também ter um controle sobre todos esses dados e informações.</p>
                </div>
            </div>
            <div id="divTurma">
                <div class="container-fluid">
                    <h1>Controle de turmas</h1>
                    <hr style="width: 100%;">
                    <div class="row">
                        <div class="col-md-12">
                            <input style="float: right;" class="btn btn-primary" type="button" value="Cadastrar Turma" onclick="showModalTurmas(0,'Cadastrar turma',1);">
                            <br><br><br>
                        </div>
                        <div class="col-md-12">
                            <table id="tbturma" style="width: 100%;" name="tbturma" class="table table-bordered table-striped cell-border compact stripe">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;text-align: center;">ID</th>
                                        <th style="width: 10%;text-align: center;">Turma</th>
                                        <th style="width: 20%;text-align: center;">Período</th>
                                        <th style="width: 30%;text-align: center;">Série</th>
                                        <th style="width: 20%;text-align: center;">QTD. Alunos</th>
                                        <th style="width: 15%;text-align: center;">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="divAluno">
                <div class="container-fluid">
                    <h1>Controle de alunos</h1>
                    <hr style="width: 100%;">
                    <div class="row">
                        <div class="col-md-12">
                            <input style="float: right;" class="btn btn-primary" type="button" value="Cadastrar aluno" onclick="showModalAlunos(0,'Cadastrar aluno',1);">
                            <br><br><br>
                        </div>
                        <div class="col-md-12">
                            <table id="tbaluno" style="width: 100%;" name="tbaluno" class="table table-bordered table-striped cell-border compact stripe">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;text-align: center;">ID</th>
                                        <th style="width: 10%;text-align: center;">Aluno</th>
                                        <th style="width: 20%;text-align: center;">Matrícula</th>
                                        <th style="width: 30%;text-align: center;">Observação</th>
                                        <th style="width: 15%;text-align: center;">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="divFalta">
                <div class="container-fluid">
                    <h1>Controle de faltas</h1>
                    <hr style="width: 100%;">
                </div>
            </div>
            <div id="avaliacao">
                <div class="container-fluid">
                    <h1>Cadastrar avaliação</h1>
                    <hr style="width: 100%;">
                    <div class="row">
                        <div class="col-md-12">
                            <input style="float: right;" class="btn btn-primary" type="button" value="Cadastrar avaliação" onclick="showModalAvaliação(0,'Cadastrar avaliação',1);">
                            <br><br><br>
                        </div>
                        <div class="col-md-12">
                            <table id="tbavalia" style="width: 100%;" name="tbavalia" class="table table-bordered table-striped cell-border compact stripe">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;text-align: center;">ID</th>
                                        <th style="width: 10%;text-align: center;">Avaliação</th>
                                        <th style="width: 20%;text-align: center;">Nota max.</th>
                                        <th style="width: 30%;text-align: center;">Dta. aplicação</th>
                                        <th style="width: 15%;text-align: center;">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="darnota">
                <div class="container-fluid">
                    <h1>Dar notas</h1>
                    <hr style="width: 100%;">
                </div>
            </div>
            <div id="notaturma">
                <div class="container-fluid">
                    <h1>Visualizar nota/turma</h1>
                    <hr style="width: 100%;">
                </div>
            </div>
            <div id="divDash">
                <div class="container-fluid">
                    <h1>Dashboard</h1>
                    <hr style="width: 100%;">
                </div>
            </div>
        </div>
      </div>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->

</body>

</html>
