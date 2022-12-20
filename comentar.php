<?php
include_once('includes/config.php');
session_start();

// comentários

if (isset($_POST['comentar'])) {
    $comentario = mysqli_real_escape_string($conexao, $_POST['comentario']);
    $pid = intval($_GET['pid']);
    $query = 'INSERT INTO comentario (texto, data_coment, status, id_publicacao, id_usuario) VALUES ("' . $comentario . '", now(), 1, ' . $pid . ', ' . $_SESSION['id'] . ')';
    $result = mysqli_query($conexao, $query);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <?php
        $query = mysqli_query($conexao, 'SELECT publicacao.id_publicacao as pid, publicacao.data_post, publicacao.descricao, publicacao.imagem, usuario.apelido, usuario.id_usuario, usuario.imagem as perfil FROM publicacao JOIN usuario ON usuario.id_usuario = publicacao.id_usuario WHERE publicacao.id_publicacao = ' . $_GET['pid'] . '');
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
                                            <h6 class="fw-bold text-dark mb-1"><a style="text-decoration: none;" class="text-dark" href="perfil.php?uid=<?php echo $pub['id_usuario'] ?>">
                                                    <?php echo $pub['apelido'] ?>
                                                </a></h6>
                                            <p class="text-muted small mb-0">
                                                <?php echo date_format(date_create($pub['data_post']), 'd/m/y H:i') ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <p class="mt-3 mb-4 pb-2" style="text-align: justify; width: 470px;">
                                            <?php echo $pub['descricao'] ?>
                                        </p>
                                        <img src="postimage/<?php echo $pub['imagem'] ?>" class="img-fluid" alt="">
                                        <div class="small d-flex justify-content-start mt-4">

                                            <?php

                                            $query = mysqli_query($conexao, 'SELECT COUNT(id_comentario) as comentarios FROM comentario WHERE id_publicacao = ' . $_GET['pid'] . '');

                                            while ($count = mysqli_fetch_assoc($query)) {
                                            ?>
                                                <p href="#!" class="me-2 d-flex text-muted" style="text-decoration: none; font-size: 15px;">
                                                    <i class='bx bx-message-rounded-dots me-2' style="color: darkgray;"></i> <!-- comentarios-->
                                                    <?php echo $count['comentarios'] ?>
                                                </p>
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>

                                <div class="card-footer py-3 border-0" style="background-color: #ffffff;">
                                    <div class="d-flex flex-start w-100">
                                        <form action="" method="post">
                                            <div class="form-outline w-100">
                                                <input type="text" name="comentario" id="" class="form-control" placeholder="Escreva um Comentário" style="width: 491px;">
                                            </div>
                                            <div class="float-end mt-2 pt-1">
                                                <button type="submit" class="btn btn-dark btn-sm" name="comentar">Postar comentário</button>
                                            </div>
                                    </div>
                                    </form>
                                </div>
                                <div class="" id="collapseExample">
                                    <!-- colapso-->
                                    <div class="">
                                        <section style="background-color: #fff;">
                                            <div class="container text-dark">
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col-md-12">
                                                        <div class="d-flex justify-content-between align-items-center mb-4 p-4">
                                                            <h4 class="text-dark mb-0">Comentarios:</h4>
                                                            <?php
                                                            $query2 = 'SELECT comentario.texto, usuario.apelido, usuario.imagem, comentario.data_coment, comentario.id_comentario FROM publicacao JOIN comentario on comentario.id_publicacao = publicacao.id_publicacao JOIN usuario ON usuario.id_usuario = comentario.id_usuario WHERE publicacao.id_publicacao = ' . $_GET['pid'] . ' ORDER BY comentario.id_comentario DESC ';
                                                            //print_r($query2);
                                                            $select = mysqli_query($conexao, $query2);

                                                            while ($feed = mysqli_fetch_assoc($select)) {
                                                            ?>
                                                                <div class="card">
                                                                </div>
                                                        </div>
                                                        <div class="card-body mb-3">
                                                            <div class="card-body">

                                                                <div class="d-flex flex-start">
                                                                    <img class="rounded-circle shadow-1-strong me-3" src="fotosperfil/<?php echo $feed['imagem'] ?>" alt="avatar" width="40" height="40" />
                                                                    <div class="w-100">
                                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                                            <h6 class=" fw-bold mb-0 d-flex align-items-center"><?php echo $feed['apelido'] ?>
                                                                                <p class="small mb-0 ms-2 text-muted" style="font-weight: 300;"><?php echo date_format(date_create($feed['data_coment']), 'd/m/y H:i') ?></p>
                                                                            </h6>
                                                                            <p class="mb-0"></p>
                                                                        </div>
                                                                        <div class="d-flex justify-content-between align-items-center">
                                                                            <span class="ms-2 p-2" style="font-weight: normal;"><?php echo $feed['texto'] ?> </span>
                                                                            <div class="d-flex flex-row">
                                                                                <i class="far fa-check-circle text-primary"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
    </section>
    <!-- CARD FEED PUB -->
<?php } ?>
</div>
</body>

</html>