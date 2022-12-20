<?php
include('includes/conexao.php');

session_start();

if (isset($_POST['login'])) {

  if (!empty($_POST['email']) && !empty($_POST['senha'])) {

    include('includes/conexao.php');
    $email = mysqli_real_escape_string($conexao,  $_POST['email']);
    $senha = mysqli_real_escape_string($conexao,  $_POST['senha']);

    $query = mysqli_query($conexao, "SELECT email, senha, id_usuario FROM usuario WHERE email = '$email' AND senha = password('$senha')");

    if (mysqli_num_rows($query) === 1) {

      $verificar = mysqli_query($conexao, "SELECT id_usuario from usuario WHERE email = '$email' ");
      $identificacao = mysqli_fetch_array($verificar);
      $_SESSION['id'] = $identificacao['id_usuario'];
      $_SESSION['login'] = $email;
      header('Location: feed.php');
    } else {
      $error = "Credenciais invalidas";
    }
  } else {
    header('Location: index.php');
  }
}


//REGISTER
if (isset($_POST['submit'])) {

  $email = mysqli_real_escape_string($conexao,  $_POST['email']);
  $nome = mysqli_real_escape_string($conexao,  $_POST['nome']);
  $apelido = mysqli_real_escape_string($conexao,  $_POST['apelido']);
  $senha = mysqli_real_escape_string($conexao,  $_POST['senha']);

  if (empty($email) && empty($nome) && empty($apelido) && empty($senha)) {
    $erro = "Preencha todos os campos para fazer o cadastro!";
  } else {
    $query = "INSERT INTO usuario (email, nome, apelido, senha, status, data_cad, imagem) VALUES ('$email', '$nome', '$apelido', password('$senha'),1 , NOW(), 'pessoas.jpg')";
    $result = mysqli_query($conexao, $query);
    $_SESSION['apelido'] = $apelido;
    echo "<script>alert('Cadastrado com Sucesso!')
    </script>";
  }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bem-vindo a Catsocial</title>
  <link rel="stylesheet" href="style.css">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-0 shadow rounded-3 my-5">
          <div class="card-body p-4 p-sm-3">
            <div class="d-flex justify-content-center">
              <img src="imagnes/logo.png" class="img-fluid" style="width: 170px;" alt="">
            </div>
            <h5 class="card-title text-center mb-5 fw-light fs-5">Bem-vindo a Cat!</h5>
            <form action="index.php" method="post">
              <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="email">
                <label for="email">E-mail</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" name="senha" class="form-control" id="senha">
                <label for="senha">Senha</label>
                <label for="uid"></label>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="" id="rememberPasswordCheck">
                <label class="form-check-label" for="rememberPasswordCheck">
                  Lembre-se de mim
                </label>
              </div>
              <div class="d-grid">
                <?php
                ?>
                <input class="btn btn-outline-secondary btn-dark text-white text-uppercase fw-bold" type="submit" name="login"></input></a>
              </div>
            </form>
            <?php ?>
            <hr class="my-4">
            <div class="text-center">
              <!-- Button trigger modal -->
              <p>Ainda não é um membro? <a href="cadastro.php" data-toggle="modal" data-target="#exampleModal">Registre-se</a></p>
            </div>
            <?php if ($error) { ?>
              <div class="alert alert-warning" role="alert">
                <strong>Erro:</strong> <?php echo $error; ?>
              </div>
            <?php } ?>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Faça parte da nossa rede social!</h5>
                    <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
                    </button>
                  </div>
                  <div class="modal-body">
                    <!-- REGISTER BODY-->
                    <div class="container">
                      <div class="row">
                        <div class="col-lg-12 mx-auto">
                          <div class="card border-0 shadow rounded-3 ">
                            <div class="card-body">
                              <form method="post">
                                <div class="d-flex justify-content-center mb-0">
                                  <img src="imagnes/logo.png" class="img-fluid" style="width: 170px;" alt="">
                                </div>
                                <div class="form-floating mb-3">
                                  <input type="email" required name="email" class="form-control" id="email">
                                  <label for="email">E-mail</label>
                                </div>
                                <div class="form-floating mb-3">
                                  <input type="text" required name="nome" class="form-control" id="nome">
                                  <label for="nome">Nome</label>
                                </div>
                                <div class="form-floating mb-3">
                                  <input type="text" required name="apelido" class="form-control" id="apelido">
                                  <label for="apelido">Apelido</label>
                                </div>
                                <div class="form-floating mb-3">
                                  <input type="password" required name="senha" class="form-control" id="senha">
                                  <label for="senha">Senha</label>
                                </div>
                                <div class="d-grid">
                                  <input type="submit" class="btn btn-outline-secondary btn-dark text-white text-uppercase fw-bold" name="submit" type="submit" value="Cadastrar"></input>
                                </div>
                                <hr class="my-4">
                                <?php if ($error) { ?>
                                  <div class="alert alert-warning" role="alert">
                                    <strong>Erro:</strong> <?php echo $error; ?>
                                  </div>
                                <?php } ?>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      </form>
                      <div class="modal" tabindex="-1" role="dialog">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
</body>

</html>