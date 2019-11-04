<?php
session_start();
?>
        <?php
        require './conexao.php';
        $conn = new Conn();
        
        //Editar usuario
       $Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        //var_dump($Dados);
       if (!empty($Dados['SendEditUser'])):
            unset($Dados['SendEditUser']);
            
            
            $result_up_user = "UPDATE usuarios SET nome=:nome, email=:email, usuario=:usuario, senha=:senha, modified=NOW() WHERE id=:id";
            $update_user = $conn->getConn()->prepare($result_up_user);
            $update_user->bindParam(':id', $Dados['id']);
            $update_user->bindParam(':nome', $Dados['nome'], PDO::PARAM_STR);
            $update_user->bindParam(':email', $Dados['email'],PDO::PARAM_STR);
            $update_user->bindParam(':usuario', $Dados['usuario'], PDO::PARAM_STR);
            $update_user->bindParam(':senha', $Dados['senha'], PDO::PARAM_STR);
            

            if ($update_user->execute()):
               $_SESSION['msg'] = "<div class='alert alert-success' role='alert'> Registro editado com sucesso
               <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
               <span aria-hidden='true'>&times;</span></button> </div>";
               header("Location: index.php");
            else:
                echo "<div class='alert alert-danger' role='alert'> Registro  não foi editado
               <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
               <span aria-hidden='true'>&times;</span></button> </div>";
                header("Location: index.php");
             endif;
         endif;
         
      
        ?>
