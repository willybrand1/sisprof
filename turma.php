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

$turma = isset($_REQUEST["turma"]) ? $_REQUEST["turma"] : 0;

$bd = new Banco(BANCO);

//resgata os alunos pro select
$sql = "SELECT * FROM public.alunos WHERE status = 1 ORDER BY aluno ASC;";

$rs = $bd->query($sql);
// var_dump($sql);die;
if($turma > 0){
    //resgata os alunos pro select em caso de edição
    $sql_e = "SELECT a.id_a FROM public.alunos a LEFT JOIN public.turma_x_aluno txa ON txa.id_a = a.id_a WHERE txa.id_t = $turma AND a.status = 1;";
    // echo $sql_e;die;
    $rs_e = $bd->query($sql_e);
    $alunos = "";
    $x = 0;
    // var_dump($rs_e);die;
    if($rs_e){
        foreach($rs_e as $row_e){
            if($x < 1){
                $alunos = $row_e["id_a"];
            }else{
                $alunos .= ",".$row_e["id_a"];
            }
            $x++;
        }
    
        $alunos_array = explode(",",$alunos);
    }else{
        $alunos_array = array();
    }
}else{
    $alunos = "";
    $alunos_array = array();
}
// var_dump($alunos_array);die;
//se $turma for maior que 0, então preenche os dados para edição
$sql_t = "SELECT * FROM public.turma WHERE id_t = $turma AND status = 1;";
$rs_t = $bd->query($sql_t);

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
$(document).ready(function(){
    var alunos = "<?=$alunos?>";

    $('#txtAlunos').select2({
        multiple: true
    });

    if(alunos == ""){
        $(".select2-selection__rendered").attr('style', 'height: 34px !important');
    }else{
        $(".select2-selection__rendered").attr('style', 'height: auto !important');
    }
});

function selecionaTudo(){
    $(".select2-selection__rendered").attr('style', 'height: auto !important');
    $('#txtAlunos').select2('destroy').find('option').prop('selected', 'selected').end().select2();
}

function cadastraTurma(){
    var erro = 0;
    var msg = "[ERROS]: ";
    var turma = $("#txtTurma").val();
    var periodo = $("#txtPeriodo").val();
    var serie = $("#txtSerie").val();
    var anoLet = $("#txtAno").val();
    var id_turma_req = $("#id_turma_req").val();
    var alunos = $("#txtAlunos").select2("val");
    
    if(turma == ""){
        erro += 1;
        msg += "- O campo turma deve ser preenchido\n";
    }

    if(periodo == ""){
        erro += 1;
        msg += "- Selecione um período\n";
    }

    if(serie == ""){
        erro += 1;
        msg += "- O campo série deve ser preenchido\n";
    }

    if(anoLet == ""){
        erro += 1;
        msg += "- O campo ano letivo deve ser preenchido\n";
    }

    if(erro > 0){
        alert(msg);
        return false;
    }else{
        $.ajax({
            url: './processaTurma.php',
            dataType: 'json',
            method: 'POST',
            data: {
                turma:turma,
                periodo:periodo,
                serie:serie,
                anolet:anoLet,
                alunos:alunos,
                id_turma_req:id_turma_req
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
<input type="hidden" value="<?=$turma?>" id="id_turma_req">
<div class="row">
    <div class="col-md-12">
        <span class="badge badge-secondary">Turma:</span>
        <input value="<?=$rs_t[0]["turma"]?>" class="form-control" type="text" id="txtTurma" style="width: 20%;">
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <span class="badge badge-secondary">Período:</span>
        <select class="form-control" type="text" id="txtPeriodo" style="width: 40%;">
            <option value="matutino" <?=(($rs_t[0]["periodo"] == "matutino") ? "selected" : "")?>>Matutino</option>
            <option value="vespertino" <?=(($rs_t[0]["periodo"] == "vespertino") ? "selected" : "")?>>Verspertino</option>
            <option value="noturno" <?=(($rs_t[0]["periodo"] == "noturno") ? "selected" : "")?>>Noturno</option>
        </select>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <span class="badge badge-secondary">Série:</span>
        <input value="<?=$rs_t[0]["serie"]?>" class="form-control" type="text" id="txtSerie" style="width: 20%;">
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <span class="badge badge-secondary">Ano letivo:</span>
        <input value="<?=$rs_t[0]["ano"]?>" class="form-control" type="text" id="txtAno" style="width: 20%;">
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-11">
        <span class="badge badge-secondary">Incluir alunos:</span>
        <select class="form-control js-example-basic-multiple" type="text" id="txtAlunos" name="txtAlunos[]" multiple="multiple" style="width: 100%;">
        <?php
        foreach($rs as $row){
            if(in_array($row["id_a"],$alunos_array)){
                echo '<option value="'.$row["id_a"].'" selected>'.$row["aluno"].'</option>';
            }else{
                echo '<option value="'.$row["id_a"].'">'.$row["aluno"].'</option>';
            }
        }
        ?>
        </select>
        <input onclick="selecionaTudo();" type="button" class="btn btn-primary" id="slcAll" value="Selecionar tudo" style="margin-top: 5px;">
    </div>
</div>
<br><br>
<div class="row">
    <div class="col-md-12">
        <center><input value="<?=(($turma > 0) ? "Editar" : "Cadastrar")?>" style="margin-bottom: 50px;" class="btn btn-primary" type="button" id="btnSubmit" onclick="cadastraTurma();"></center>
    </div>
</div>