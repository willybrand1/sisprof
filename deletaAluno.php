<?php
include_once('./defines.php');
include_once('./Banco.php');

$bd = new Banco(BANCO);

$id_aluno = isset($_REQUEST["id_aluno"]) ? $_REQUEST["id_aluno"] : "";

$sql = "UPDATE public.alunos SET status = 0 WHERE id_a = ".$id_aluno;
$rs = $bd->query($sql);

$sql2 = "DELETE FROM public.turma_x_aluno WHERE id_a = ".$id_aluno;
$rs2 = $bd->query($sql2);

$bd->close();
echo "Aluno deletado com sucesso.";