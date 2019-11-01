<?php
include_once('./defines.php');
include_once('./Banco.php');

$erro = 0;
$msg = "[ERROS]: ";
$aluno = isset($_REQUEST["aluno"]) ? $_REQUEST["aluno"] : "";
$matricula = isset($_REQUEST["matricula"]) ? $_REQUEST["matricula"] : "";
$observacao = isset($_REQUEST["observacao"]) ? $_REQUEST["observacao"] : "";
$id_aluno_e = isset($_REQUEST["id_aluno_e"]) ? $_REQUEST["id_aluno_e"] : "";

$bd = new Banco(BANCO);
// var_dump($bd);
if($aluno == ""){
    $erro += 1;
    $msg .= "- O campo aluno deve ser preenchido\n";
}

if($matricula == ""){
    $erro += 1;
    $msg .= "- O campo matrícula deve ser preenchido\n";
}

if($erro > 0){
    $arr["data"] = ["op"=>0,"msg"=>$msg];
    echo json_encode($arr,JSON_UNESCAPED_UNICODE);
}else{
    if($id_aluno_e > 0){
        $sql = "UPDATE public.alunos SET aluno = '$aluno', matricula = '$matricula', observacao = '$observacao' WHERE id_a = $id_aluno_e;";
        $rs = $bd->query($sql);

        $msg = "- Operação realizada com sucesso!";
        $arr["data"] = ["op"=>1,"msg"=>$msg];
        echo json_encode($arr,JSON_UNESCAPED_UNICODE);  
    }else{
        $sql_in = "INSERT INTO public.alunos (aluno, matricula, observacao) VALUES ('$aluno','$matricula','$observacao');";
        $rs_in = $bd->query($sql_in);
        
        $msg = "- Operação realizada com sucesso!";
        $arr["data"] = ["op"=>1,"msg"=>$msg];
        echo json_encode($arr,JSON_UNESCAPED_UNICODE);  
    }
}