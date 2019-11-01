<?php
session_start();

$user = isset($_REQUEST['user']) ? $_REQUEST['user'] : "";
$deslogar = isset($_REQUEST['deslogar']) ? $_REQUEST['deslogar'] : 0;
$error = 0;

if(($deslogar < 1) || ($user == "")){
    $error = 1;
    echo $error;
}else{
    unset($_SESSION['user']);
    unset($_SESSION['nome_user']);

    session_destroy();

    echo $error;
}
?>