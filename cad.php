<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>CRUD</title>
    </head>
    <body>
        
        <?php
        require './conexao.php';
        
        $Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        //var_dump($Dados);
        if (!empty($Dados['SendCadUser'])):
            unset($Dados['SendCadUser']);
            $conn = new Conn();
            
            $result_cadastrar = "INSERT INTO usuarios (nome, email, usuario, senha, created) VALUES (:nome, :email, :usuario, :senha, NOW())";
            $cadastrar = $conn->getConn()->prepare($result_cadastrar);

            $cadastrar->bindParam(':nome', $Dados['nome'], PDO::PARAM_STR);
            $cadastrar->bindParam(':email', $Dados['email'], PDO::PARAM_STR);
            $cadastrar->bindParam(':usuario', $Dados['usuario'], PDO::PARAM_STR);
            $cadastrar->bindParam(':senha', $Dados['senha'], PDO::PARAM_STR);

            $cadastrar->execute();

            if ($cadastrar->rowCount()):
                $_SESSION['msg'] = "<p style='color:green;'>Registro cadastro com sucesso</p>";
                header("Location: index.php");
            endif;
        endif;

        ?>
    </body>
</html>
