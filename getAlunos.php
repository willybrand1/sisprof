<?php
include_once('./defines.php');
include_once('./Banco.php');

$bd = new Banco(BANCO);
$sql = "SELECT
            id_a,
            aluno,
            matricula,
            observacao
        FROM
            public.alunos
        WHERE
            status = 1
        ORDER BY
            aluno ASC";
$rs = $bd->query($sql);
$bd->close();


    $arr = array();
    
    foreach($rs as $row){
        $btn = '<input type="button" class="btn btn-dark" style="cursos: pointer;margin: 2px 2px 2px 2px;" value="Editar" onclick="showModalAlunos('.$row["id_a"].',\'Editar aluno\',1);">';
        $btn .= '<input type="button" class="btn btn-dark" style="cursos: pointer;margin: 2px 2px 2px 2px;" value="Deletar" onclick="deletaAluno('.$row["id_a"].');">';
            
        $row += ["opcoes"=>$btn];

        foreach($row as $k => $v){
            if(is_numeric($k)){
                continue;
            }
            $arr[$k] = $v;
        }
        $arrr[] = $arr;
    }
    $ar["data"] = $arrr;
    echo json_encode($ar,JSON_UNESCAPED_UNICODE);

?>