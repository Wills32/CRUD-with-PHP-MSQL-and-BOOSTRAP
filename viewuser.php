<?php                          
    require './conexao.php';

//Recuperando dados da Paginacao
    $pagina = filter_input(INPUT_POST,'pagina',FILTER_SANITIZE_NUMBER_INT);
    $qtd_result_pg= filter_input(INPUT_POST,'qtd_result_pg',FILTER_SANITIZE_NUMBER_INT);
//calculo da visualizacão
$inicio = ($pagina*$qtd_result_pg)-$qtd_result_pg;

// Conexão e listagem dos usuarios
    $conn = new Conn();
    $result_user = "SELECT * FROM usuarios ORDER by id DESC LIMIT $inicio,$qtd_result_pg";
                        
    $resultado_user = $conn->getConn()->prepare($result_user);
    $resultado_user->execute();
    
?>
<table class="table table-striped">
       <thead class="thead-dark">
            <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">Email</th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            </tr>
        </thead>
<tbody>
<!-- Ver detalhes do usuario em Janela Modal -->    
<?php
    while($row_user = $resultado_user->fetch(PDO::FETCH_ASSOC)):
?>
        <tr>
            <th scope="row"><?php echo $row_user['id']; ?></th>
            <td><?php echo $row_user['nome']; ?></td>
            <td><?php echo $row_user['email']; ?></td>
            <td><button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#visualizar<?php echo $row_user['id'];?>" >Visualizar</button></td>
            <td><button type="button" class="btn btn-outline-dark btn-block" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $row_user['id'] ?>" data-whatevernome="<?php echo $row_user['nome'] ?>" data-whateveremail="<?php echo $row_user['email'] ?>" data-whateverusuario="<?php echo $row_user['usuario'] ?>" data-whateversenha="<?php echo $row_user['senha'] ?>">Editar</button></td>
            <td> <a class="btn btn-outline-danger btn-block" role="button"  href='apagar.php?id=" . <?php echo $row_user['id'];?>. "'>Apagar</a></td>
        </tr>
            <div class="modal fade" id="visualizar<?php echo $row_user['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detalhes do Usuario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Visualiza detalhes do usuario -->

                            <?php        
                                echo "ID: " . $row_user['id'] . "<br>";
                                echo "Nome: " . $row_user['nome'] . "<br>";
                                echo "E-mail: " . $row_user['email'] . "<br>";
                                echo "Criado: " . date('d/m/Y H:i:s', strtotime($row_user['created'])) . "<br>";
                                if(!empty($row_user['modified'])):
                                    echo "Alterado: " . date('d/m/Y H:i:s', strtotime($row_user['modified'])) . "<br>";
                                endif;
                            ?>

                        </div>
                    </div>
                </div>
            </div>
    <?php endwhile; ?>                           

</tbody>
</table>
<?php 
//Paginacao Somar Quantidade de usuarios
$result_pg = "SELECT COUNT(id) AS num_result from usuarios";
$resultado_pg = $conn->getConn()->prepare($result_pg);
$resultado_pg->execute();
$row_pg = $resultado_pg->fetch(PDO::FETCH_ASSOC);

//Quantidade De Paginas
$quantidade_pg = ceil($row_pg['num_result']/$qtd_result_pg);

// variavel mostrar e Limitar pagina antes e depois
$max_links =2;
echo '<nav aria-label="paginacao">';
    echo '<ul class="pagination">';
        echo '<li class="page-item">';
        echo"<span class='page-link'><a href ='#' onclick = 'listar_usuarios(1,$qtd_result_pg)'> Primeira</a></span>";
        echo'</li>';
        // Mostrar duas paginas Anteriores
        for($pag_anterior = $pagina - $max_links; $pag_anterior <= $pagina -1; $pag_anterior++){
            if($pag_anterior>=1){
            echo "<li class='page-item'><a class='page-link' href ='#' onclick = 'listar_usuarios($pag_anterior ,$qtd_result_pg)'> $pag_anterior </a></li>";
            }
        }
    
        echo"<li class='page-item active' aria-current='page'>";
            echo"<span class='page-link'>";
            echo $pagina;
            echo'</span>';
        echo'</li>';
        // Mostrar duas paginas Posteriores
            for($pag_dep = $pagina + 1; $pag_dep <= $pagina+ $max_links ; $pag_dep++){
                if($pag_dep <= $quantidade_pg){
                    echo "<li class='page-item'><a class='page-link' href ='#' onclick = 'listar_usuarios($pag_dep ,$qtd_result_pg)' > $pag_dep </a></li> ";
                } 
            }    
        echo '<li class="page-item">';
            echo"<span class='page-link'><a href ='#' onclick = 'listar_usuarios($quantidade_pg ,$qtd_result_pg)' > Ultima</a></span>";
        echo'</li>';      
  echo'</ul>';
echo'</nav>';

?>
<!--Editar Registro em BD -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Cadastro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                    <form method ="POST" action="editar_user.php"  >
                        <input type="hidden" name= "id" id="id_user" >
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Nome </label>
                                <div class="col-sm-10">
                                    <input type="text" name ="nome" class="form-control" placeholder="Nome Completo" id = "nome">
                                </div>
                            </div>   

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" >Email </label>
                                <div class="col-sm-10">
                                    <input type="email" name ="email" class="form-control" placeholder="Digite seu email" id = "email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Usuario</label>
                                <div class="col-sm-10">
                                    <input type="text" name ="usuario" class="form-control" placeholder="Digite seu usuario" id = "usuario" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Senha</label>
                                <div class="col-sm-10">
                                    <input type="password" name ="senha" class="form-control" placeholder="Digite sua senha" id = "senha">
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success" name="SendEditUser"id="SendEditUser" value="SendEditUser">Alterar</button>
                            </div>
                </form>
      </div>

    </div>
  </div>
</div>

<script>
// recebe os dados dos usuarios 
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  var recipientnome = button.data('whatevernome')
  var recipientemail = button.data('whateveremail')
  var recipientusuario = button.data('whateverusuario')
  var recipientsenha = button.data('whateversenha')
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('#id_user').val(recipientnome)
  modal.find('#nome').val(recipientnome)
  modal.find('#email').val(recipientemail)
  modal.find('#usuario').val(recipientusuario)
  modal.find('#senha').val(recipientsenha)
})
</script>