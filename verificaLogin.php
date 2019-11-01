<?php
include_once('./defines.php');
include_once('./Banco.php');

$user = isset($_REQUEST['user']) ? $_REQUEST['user'] : "";
$pass = isset($_REQUEST['pass']) ? $_REQUEST['pass'] : "";

$conn = new Banco(BANCO);
$sql = "SELECT * FROM public.login l WHERE l.usuario ilike '$user' AND l.pass ilike '$pass'";
$rs = $conn->query($sql);
// var_dump($rs);die;
if($rs){
    session_start();

    $_SESSION['user'] = $user;
    $_SESSION['nome_user'] = $rs[0]['name_usu'];

    $logar = 1;
    echo $logar;
}else{
    $logar = 0;
    echo $logar;
}
?>