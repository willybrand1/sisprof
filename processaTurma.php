<?php
include_once('./defines.php');
include_once('./Banco.php');

$erro = 0;
$msg = "[ERROS]: ";
$turma = isset($_REQUEST["turma"]) ? $_REQUEST["turma"] : "";
$periodo = isset($_REQUEST["periodo"]) ? $_REQUEST["periodo"] : "";
$serie = isset($_REQUEST["serie"]) ? $_REQUEST["serie"] : "";
$anoLet = isset($_REQUEST["anolet"]) ? $_REQUEST["anolet"] : "";
$alunos = isset($_REQUEST["alunos"]) ? $_REQUEST["alunos"] : "";
$id_turma_req = isset($_REQUEST["id_turma_req"]) ? $_REQUEST["id_turma_req"] : 0;

$bd = new Banco(BANCO);
// var_dump($bd);
if($turma == ""){
    $erro += 1;
    $msg .= "- O campo turma deve ser preenchido\n";
}

if($periodo == ""){
    $erro += 1;
    $msg .= "- Selecione um período\n";
}

if($serie == ""){
    $erro += 1;
    $msg .= "- O campo série deve ser preenchido\n";
}

if($anoLet == ""){
    $erro += 1;
    $msg .= "- O campo ano letivo deve ser preenchido\n";
}

if($erro > 0){
    $arr["data"] = ["op"=>0,"msg"=>$msg];
    echo json_encode($arr,JSON_UNESCAPED_UNICODE);
}else{
    if($id_turma_req > 0){
        $sql = "UPDATE public.turma SET turma = '$turma', periodo = '$periodo', serie = '$serie', ano = $anoLet WHERE id_t = $id_turma_req;";
        $rs = $bd->query($sql);

        $sql_a = "DELETE FROM public.turma_x_aluno WHERE id_t = $id_turma_req;";
        $rs_a = $bd->query($sql_a);
        
        if($alunos !== ""){    
            foreach($alunos as $row){
                $sql_ar = "INSERT INTO public.turma_x_aluno (id_t, id_a) VALUES ($id_turma_req,$row);";
                $rs_ar = $bd->query($sql_ar);
            }
        }
        
        $msg = "- Operação realizada com sucesso!";
        $arr["data"] = ["op"=>1,"msg"=>$msg];
        echo json_encode($arr,JSON_UNESCAPED_UNICODE);  
    }else{
        $sql_in = "INSERT INTO public.turma (periodo, turma, serie, ano) VALUES ('$periodo','$turma','$serie',$anoLet) RETURNING id_t;";
        $rs_in = $bd->query($sql_in);
        $last_oid = $rs_in[0]["id_t"];
        
        $sql_aa = "DELETE FROM public.turma_x_aluno WHERE id_t = $id_turma_req;";
        $rs_aa = $bd->query($sql_aa);

        foreach($alunos as $roww){
            $sql_arr = "INSERT INTO public.turma_x_aluno (id_t, id_a) VALUES ($last_oid,$roww);";
            $rs_arr = $bd->query($sql_arr);
        }

        $msg = "- Operação realizada com sucesso!";
        $arr["data"] = ["op"=>1,"msg"=>$msg];
        echo json_encode($arr,JSON_UNESCAPED_UNICODE);  
    }
}