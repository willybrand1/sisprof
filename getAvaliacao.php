<?php
include_once('./defines.php');
include_once('./Banco.php');

$bd = new Banco(BANCO);
$sql = "SELECT
            id_avalia,
            avaliacao,
            notamax,
            to_char(dta_avaliacao,'dd/mm/yyyy') as dta_avaliacao
        FROM
            public.avaliacao
        ORDER BY
            dta_avaliacao ASC";
$rs = $bd->query($sql);
$bd->close();

if($rs){
    $arr = array();
    
    foreach($rs as $row){
        $btn = '<input type="button" class="btn btn-dark" style="cursos: pointer;margin: 2px 2px 2px 2px;" value="Editar" onclick="showModalAvaliacao('.$row["id_avalia"].',\'Editar avaliação\',1);">';
            
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
}else{
    $ar["data"] = "";
    echo json_encode($ar,JSON_UNESCAPED_UNICODE);
}
?>