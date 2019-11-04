<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" ></script>
    
  <title>Crud</title>
</head>

    <body>
    <?php
        if (isset($_SESSION['msg'])) :
             echo $_SESSION['msg'];
                unset($_SESSION['msg']);
        endif;
     ?>
    <div class="container">
        <div class ="jumbotron"> <h1>CRUD</h1>  </div>
            <div class="row">
                <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#cadastrar" >Cadastrar Usuario</button>
            </div>
            <div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cadastrar Usuario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <span id ="msg-cad" ></span>
                            <!--Formulario -->
                            <form action="cad.php"  method ="POST">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"> Nome Completo </label>
                                    <div class="col-sm-10">
                                        <input type="text" name ="nome" class="form-control" placeholder="Nome Completo">
                                    </div>
                                </div>   

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Email </label>
                                    <div class="col-sm-10">
                                    <input type="email" name ="email" class="form-control" placeholder="Digite seu email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Usuario</label>
                                    <div class="col-sm-10">
                                        <input type="text" name ="usuario" class="form-control" placeholder="Digite seu usuario">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Senha</label>
                                    <div class="col-sm-10">
                                        <input type="password" name ="senha" class="form-control" placeholder="Digite sua senha">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                    <button type="submit" name="SendCadUser" id="SendCadUser" value="SendCadUser" class="btn btn-success"> Cadastrar Novo Usuario</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <div class = "container">
            <div>
                <h1>Usuários do Sistema</h1>

                <span id ="conteudo" ></span>
                <script> 
                // determina o numero de resultados por pagina
                var qtd_result_pg = 50;
        	    var pagina = 1;
                $(document).ready(function () {
                    listar_usuarios(pagina,qtd_result_pg);
                });

                function listar_usuarios(pagina,qtd_result_pg){
                    var dados = {
                        pagina: pagina,
                        qtd_result_pg: qtd_result_pg
                    }
                    $.post('viewuser.php', dados ,function(retorna){
                        //substitui o valor do ID conteudo
                        $("#conteudo").html(retorna);
                    });
                }
                </script> 

            </div>
        </div>

  
        
    </body>
</html>