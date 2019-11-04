<?php

session_start();
require './conexao.php';
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)):
    $conn = new Conn();
    $result_user = "DELETE FROM usuarios WHERE id=:id";

    $resultado_del_user = $conn->getConn()->prepare($result_user);
    $resultado_del_user->bindParam(':id', $id);

    if ($resultado_del_user->execute()):
        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'> Registro Apagado com Sucesso
               <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
               <span aria-hidden='true'>&times;</span></button> </div>";
        header("Location: index.php");
    else:
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'> Registro não apagado
               <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
               <span aria-hidden='true'>&times;</span></button> </div>";;
        header("Location: index.php");
    endif;
else:
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'> Registro não encontrado
               <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
               <span aria-hidden='true'>&times;</span></button> </div>";
    header("Location: index.php");    
endif;

?>