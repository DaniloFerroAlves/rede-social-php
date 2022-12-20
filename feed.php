<?php
include_once('includes/config.php');
session_start();

if (isset($_POST['submit'])) {
  $texto = mysqli_real_escape_string($conexao, $_POST['texto']);
  $imgfile = $_FILES["postimage"]["name"];
  if ($imgfile == "") {
    $query = 'INSERT INTO publicacao (descricao, data_post, status, id_usuario) VALUES ("' . $texto . '", now() , 1, ' . $_SESSION['id'] . ')';
    $result = mysqli_query($conexao, $query);
  } else {

    $extension = substr($imgfile, strlen($imgfile) - 4, strlen($imgfile));
    $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");

    if (!in_array($extension, $allowed_extensions)) {
      echo "<script>alert('Formato Invalido. Somente os formatos jpg / jpeg/ png /gif são permitidos');</script>";
    } else {
      $imgnewfile = md5($imgfile) . $extension;
      move_uploaded_file($_FILES["postimage"]["tmp_name"], "postimage/" . $imgnewfile);
    }
    $query = 'INSERT INTO publicacao (imagem, descricao, data_post, status, id_usuario) VALUES ("' . $imgnewfile . '","' . $texto . '", now() , 1, ' . $_SESSION['id'] . ')';
    $result = mysqli_query($conexao, $query);
    $_SESSION['idpub'] = mysqli_insert_id($conexao);
  }
}

// comentários

if (isset($_POST['comentar'])) {
  header('location: comentar.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página principal / CatSocial</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

  <!-- boxicons -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <!-- css -->
  <link rel="stylesheet" href="style.css">
  <!-- fonte -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap" rel="stylesheet">

</head>

<body>
  <!-- navbar -->
  <?php include_once('includes/header.php');
  ?>
  <!-- publicar -->
  <div class="container">
  <section style="background-color: #ffffff;">
      <div class="my-5 py-5 text-dark">
        <div class="row d-flex justify-content-center">
          <div class="col-md-12 col-lg-8 col-xl-6 d-flex justify-content-center">
            <div class="card" style="width: 525px;">
              <div class="card-body p-4">
                <div class="d-flex flex-start w-100">
                  <?php
                  $query = 'SELECT id_usuario, imagem FROM usuario WHERE status = 1 and id_usuario = ' . $_SESSION['id'] . '';
                  $result = mysqli_query($conexao, $query);

                  if ($feed = mysqli_fetch_array($result)) {

                  ?>
                    <img class="rounded-circle shadow-1-strong me-3" src="fotosperfil/<?php echo $feed['imagem'] ?>" alt="avatar" width="70px" height="70px" />
                  <?php } ?>
                  <div class="w-100">
                    <h5>Página Inicial</h5>
                    <form action="" method="post" enctype="multipart/form-data">
                      <div class="form-outline">
                        <textarea class="form-control" id="feed-teste" name="texto" rows="4" placeholder="O que está acontecendo?" style="resize: none"></textarea>
                      </div>
                      <div class="d-flex justify-content-between mt-3">
                        <label for="postimage"><i class='bx bx-link-alt' style="cursor: pointer; color: darkgray"></i></label>
                        <input class="form-control" id="postimage" name="postimage" type="file" style="display: none;">
                        </inp>
                        <div>
                          <input type="submit" class="btn btn-dark" name="submit" value="Catweetar">
                        </div>
                      </div>
                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php

    $query = mysqli_query($conexao, 'SELECT publicacao.id_publicacao as pid, publicacao.data_post, publicacao.descricao, publicacao.imagem, usuario.apelido, usuario.id_usuario, usuario.imagem as perfil FROM publicacao JOIN usuario ON usuario.id_usuario = publicacao.id_usuario ORDER BY id_publicacao desc');
    while ($pub = mysqli_fetch_assoc($query)) {
    ?>
      <section style="background-color: rgb(255, 255, 255);">
      <div class="my-4 py-4">
          <div class="row d-flex justify-content-center">
            <div class="col-md-12 col-lg-10 col-xl-8 col-xl-6 d-flex justify-content-center">
              <div class="card" style="width: 525px; ">
                <div class="card-body ">
                  <div class="d-flex flex-start align-items-center">
                    <img class="rounded-circle shadow-1-strong me-3" src="fotosperfil/<?php echo $pub['perfil'] ?>" alt="avatar" width="60" height="60" />
                    <div>
                      <h6 class="fw-bold text-black mb-1"><a class="fw-bold text-black mb-1" style="text-decoration: none;" href="perfil.php?uid=<?php echo $pub['id_usuario'] ?>">
                          <?php echo $pub['apelido'] ?>
                        </a></h6>
                      <p class="text-muted small mb-0">
                        <?php echo date_format(date_create($pub['data_post']), 'd/m/y H:i') ?>
                      </p>
                    </div>
                  </div>
                  <?php echo $_GET['pid'] ?>
                  <div class="container">
                    <p class="mt-3 mb-4 pb-2" style="text-align: justify; width: 470px;">
                      <?php echo $pub['descricao'] ?>
                    </p>
                    <img src="postimage/<?php echo $pub['imagem'] ?>" class="img-fluid" alt="">
                    <div class="small d-flex justify-content-start mt-4">
                    </div>
                  </div>
                </div>
                <div class="card-footer py-3 border-0" style="background-color: #ffffff;">
                  <div class="d-flex flex-start w-100">
                    <form action="feed.php" method="post">
                  </div>
                  <a class="float-end mt-2 pt-1 btn btn-outline-dark btn-sm" href="comentar.php?pid=<?php echo $pub['pid'] ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Postar um Comentário
                  </a>
                </div>
                </p>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <!-- CARD FEED PUB -->
</body>

</html>