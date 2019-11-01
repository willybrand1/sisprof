<?php
include_once('./defines.php');
include_once('./Banco.php');

session_start();

if($_SESSION['user'] == ""){
    header("Location: index.php");
}else{
    $user = $_SESSION['user'];
    $userName = $_SESSION['nome_user'];
    
}

$aluno = isset($_REQUEST["aluno"]) ? $_REQUEST["aluno"] : 0;

$bd = new Banco(BANCO);

$sql = "SELECT * FROM public.alunos WHERE status = 1  AND id_a = $aluno;";
$rs = $bd->query($sql);

$bd->close();
?>
<script src="vendor/bootstrap/jquery-3.4.1.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.js"></script>
<script src="vendor/bootstrap/popper.min.js"></script>
<script src="vendor/bootstrap/tooltip.min.js"></script>
<link rel="stylesheet" type="text/css" href="vendor/bootstrap/dist/css/bootstrap.css">
<script src="vendor/datatables/datatables.js"></script>
<link href="vendor/datatables/datatables.css" rel="stylesheet" type="text/css">
<script src="vendor/select2/js/select2.full.js"></script>
<link href="vendor/select2/css/select2.css" rel="stylesheet" type="text/css">
<link href="vendor/fontawesome/css/all.css" rel="stylesheet" type="text/css">
<script src="vendor/fontawesome/js/all.js"></script>
<script>
function cadastraAluno(){
    var erro = 0;
    var msg = "[ERROS]: ";
    var aluno = $("#txtAluno").val();
    var matricula = $("#txtMatricula").val();
    var observacao = $("#txtObservacao").val();
    var id_aluno_e = $("#txtIdAlunoE").val();
    
    if(aluno == ""){
        erro += 1;
        msg += "- O campo aluno deve ser preenchido\n";
    }

    if(matricula == ""){
        erro += 1;
        msg += "- O campo matrícula deve ser preenchido\n";
    }

    if(erro > 0){
        alert(msg);
        return false;
    }else{
        $.ajax({
            url: './processaAluno.php',
            dataType: 'json',
            method: 'POST',
            data: {
                aluno:turma,
                matricula:periodo,
                observacao:observacao,
                id_aluno_e:id_aluno_e
            },
            success: function(obj){
                var o = obj.data;
                var op = o.op;
                var msg = o.msg;
                
                if(op > 0){
                    alert(msg);
                    parent.location.reload();
                }else{
                    alert(msg);
                    return false;
                }
            }
        });
    }
}
</script>
<input type="hidden" value="<?=$aluno?>" id="id_aluno_e">
<div class="row">
    <div class="col-md-12">
        <span class="badge badge-secondary">Aluno:</span>
        <input value="<?=$rs[0]["aluno"]?>" class="form-control" type="text" id="txtAluno" style="width: 80%;">
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <span class="badge badge-secondary">Matrícula:</span>
        <input value="<?=$rs[0]["matricula"]?>" class="form-control" type="text" id="txtMatricula" style="width: 30%;">
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <span class="badge badge-secondary">Observacao:</span>
        <textarea class="form-control" id="txtObservacao" cols="4" rows="5"  style="width: 90%;"><?=$rs[0]["observacao"]?></textarea>
    </div>
</div>
<br><br>
<div class="row">
    <div class="col-md-12">
        <center><input value="<?=(($aluno > 0) ? "Editar" : "Cadastrar")?>" style="margin-bottom: 50px;" class="btn btn-primary" type="button" id="btnSubmit" onclick="cadastraAluno();"></center>
    </div>
</div>