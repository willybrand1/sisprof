<?php
include_once('./defines.php');
include_once('./Banco.php');

$bd = new Banco(BANCO);
$sql = "select
            t.id_t,
            t.periodo,
            t.serie,
            t.turma,
            txa.qtd_aluno
        from
            public.turma t
        left join 
            (
                select
                    id_t,
                    count(id_t) as qtd_aluno
                from
                    public.turma_x_aluno
                group by
                    id_t 
            ) txa on txa.id_t = t.id_t
        where
            t.status = 1;";
$rs = $bd->query($sql);
$bd->close();

if($rs){
    $arr = array();
    
    foreach($rs as $row){
        $btn = '<input type="button" class="btn btn-dark" style="cursos: pointer;margin: 2px 2px 2px 2px;" value="Editar" onclick="showModalTurmas('.$row["id_t"].',\'Editar turma\',1);">';
        $btn .= '<input type="button" class="btn btn-dark" style="cursos: pointer;margin: 2px 2px 2px 2px;" value="Deletar" onclick="deletaTurma('.$row["id_t"].');">';
            
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
}
?>