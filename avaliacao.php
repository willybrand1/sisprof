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

$avaliacao = isset($_REQUEST["avaliacao"]) ? $_REQUEST["avaliacao"] : 0;

$bd = new Banco(BANCO);

$sql = "SELECT * FROM public.avaliacao WHERE id_avalia = $avaliacao;";
$rs = $bd->query($sql);

$bd->close();
?>
<script src="vendor/bootstrap/jquery-3.4.1.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.bundle.js"></script>
<link rel="stylesheet" type="text/css" href="vendor/bootstrap/dist/css/bootstrap.css">
<script src="vendor/datatables/datatables.js"></script>
<link href="vendor/datatables/datatables.css" rel="stylesheet" type="text/css">
<script src="vendor/select2/js/select2.full.js"></script>
<link href="vendor/select2/css/select2.css" rel="stylesheet" type="text/css">
<link href="vendor/fontawesome/css/all.css" rel="stylesheet" type="text/css">
<script src="vendor/fontawesome/js/all.js"></script>
<script>
function cadastraAvaliacao(){
    var erro = 0;
    var msg = "[ERROS]: ";
    var avaliacao = $("#txtAvaliacao").val();
    var notamax = $("#txtNotamax").val();
    var dta_avaliacao = $("#txtDta_avaliacao").val();
    var id_avalia_e = $("#id_avalia_e").val();
    
    if(avaliacao == ""){
        erro += 1;
        msg += "- O campo avaliação deve ser preenchido\n";
    }

    if(notamax == ""){
        erro += 1;
        msg += "- O campo nota máxima deve ser preenchido\n";
    }

    if(notamax > 10){
        erro += 1;
        msg += "- O campo nota máxima deve ser preenchido\n";
    }

    if(dta_avaliacao == ""){
        erro += 1;
        msg += "- O campo data da avaliação deve ser preenchido\n";
    }

    if(erro > 0){
        alert(msg);
        return false;
    }else{
        $.ajax({
            url: './processaAvaliacao.php',
            dataType: 'json',
            method: 'POST',
            data: {
                avaliacao:avaliacao,
                notamax:notamax,
                dta_avaliacao:dta_avaliacao,
                id_avalia_e:id_avalia_e
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
<input type="hidden" value="<?=$avaliacao?>" id="id_avalia_e">
<div class="row">
    <div class="col-md-12">
        <span class="badge badge-secondary">Avaliação:</span>
        <input value="<?=$rs[0]["avaliacao"]?>" class="form-control" type="text" id="txtAvaliacao" style="width: 80%;">
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <span class="badge badge-secondary">Nota máxima:</span>
        <input value="<?=$rs[0]["notamax"]?>" class="form-control" type="number" max="10" min="0" id="txtNotamax" style="width: 20%;">
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <span class="badge badge-secondary">Data da avaliação:</span>
        <input class="form-control" id="txtDta_avaliacao" type="date"  style="width: 30%;" value="<?=$rs[0]["dta_avaliacao"]?>">
    </div>
</div>
<br><br>
<div class="row">
    <div class="col-md-12">
        <center><input value="<?=(($aluno > 0) ? "Editar" : "Cadastrar")?>" style="margin-bottom: 50px;" class="btn btn-primary" type="button" id="btnSubmit" onclick="cadastraAvaliacao();"></center>
    </div>
</div>