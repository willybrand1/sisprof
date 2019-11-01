<?php
include_once('./defines.php');
include_once('./Banco.php');

$bd = new Banco(BANCO);

$id_turma = isset($_REQUEST["id_turma"]) ? $_REQUEST["id_turma"] : "";

$sql = "UPDATE public.turma SET status = 0 WHERE id_t = ".$id_turma;
$rs = $bd->query($sql);

$sql2 = "DELETE FROM public.turma_x_aluno WHERE id_t = ".$id_turma;
$rs2 = $bd->query($sql2);

$bd->close();
echo "Turma deletada com sucesso.";