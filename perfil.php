<?php include_once('includes/config.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CatSocial</title>
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
    <?php include_once('includes/header.php'); ?>

    <!-- Perfil -->
    <section class="h-100 gradient-custom-2" style="margin-top: 100px;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7">
                    <div class="card">
                        <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
                            <div class="ms-4 mt-5" style="width: 150px;">

                                <?php
                                $id = intval($_GET['uid']);
                                $query = 'SELECT id_usuario, imagem FROM usuario WHERE status = 1 and id_usuario = ' . $id . ' ';
                                $result = mysqli_query($conexao, $query);

                                if ($perfil = mysqli_fetch_array($result)) {
                                ?>    
                                    <a href="" type="button" data-toggle="modal" data-target="#exampleModal">
                                        <img src="fotosperfil/<?php echo $perfil['imagem'] ?>" alt="Generic placeholder image" class="img-fluid img-thumbnail mt-1" style="width: 150px; height: 150px; z-index: 2">
                                    </a>                                    
                                    <div class="container">

                                        <div class="row">
                                            <?php if ($id == $_SESSION['id']) { ?>
                                                <a href="editprofile.php?uid=<?php echo $perfil['id_usuario'] ?>" style="z-index: 0;" class="btn  btn-dark mt-4">Editar perfil</a>
                                            <?php }  ?>
                                        <?php } ?>
                                        <?php if ($id != $_SESSION['id']) { ?>
                                            <form action="perfil.php" method="post" class="m-0" style="z-index: 1" ;>
                                                <input type="submit" class="btn btn-dark mt-4" value="Seguir" style="z-index: 1;" name="seguir"></input>
                                            </form>
                                        <?php }  ?>
                                        </div>
                                    </div>
                            </div>
                            <?php
                            $id = intval($_GET['uid']);
                            $query = 'SELECT nome, apelido FROM usuario WHERE status = 1 ' . (isset($_GET['uid']) ? 'AND id_usuario = ' . $id : 'xxxx');
                            $result = mysqli_query($conexao, $query);

                            if ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <div class="ms-3" style="margin-top: 130px;">
                                    <h5><?php echo $row['apelido']; ?></h5>
                                    <h5><small><?php echo $row['nome'];} ?></small></h5>
                                </div>
                        </div>
                        <div class="p-4 text-black" style="background-color: #f8f9fa;">
                            <div class="d-flex justify-content-end text-center py-1">
                                <?php
                                $query = 'SELECT COUNT(id_usuario) as contador FROM publicacao WHERE id_usuario = ' . $id . '';
                                $result = mysqli_query($conexao, $query);

                                if ($contagem = mysqli_fetch_assoc($result)) {
                                ?>
                                    <div>
                                        <p class="mb-1 h5"><?php echo $contagem['contador'] ?></p>
                                        <p class="small text-muted mb-0">Publicações</p>
                                        <p><?php echo $bio['data_cad'] ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card-body p-4 text-black">
                            <div class="mb-5">
 
                                <?php
                                $query = 'SELECT bio, data_cad FROM usuario WHERE status = 1 and id_usuario = ' . $id . '';
                                $result = mysqli_query($conexao, $query);

                                if ($bio = mysqli_fetch_assoc($result)) {
                                ?>
                                <div>
                                    <p class="text-muted">Membro desde <?php echo date_format(date_create($bio['data_cad']), 'd/m/y') ?></p>
                                </div>
                                <p class="lead fw-normal mb-1">Bio</p>                                   
                                    <div class="form-outline">
                                        <textarea class="form-control text-muted" id="textbios" name="texto" rows="4" placeholder="Vazio." disabled style="resize: none; background-color: transparent; border: 0;"><?php echo $bio['bio'] ?></textarea>
                                        <a href="" class="d-flex justify-content-end" style="text-decoration: none;"></a>
                                    </div>
                            </div>
                            <?php }?>
                            <div class="d-flex  align-items-center">
                                <p class="lead fw-normal mb-0">Publicações
                                <h6 class="text-muted">
                                    </h2>
                                    </p>
                            </div>
                        </div>
                        <?php
                        $query = 'SELECT publicacao.id_publicacao as pid, publicacao.data_post, publicacao.descricao, publicacao.imagem, usuario.apelido, usuario.imagem as perfil FROM publicacao JOIN usuario ON usuario.id_usuario = publicacao.id_usuario  WHERE usuario.id_usuario = ' . $id . ' ORDER BY publicacao.data_post desc';
                        $result = mysqli_query($conexao, $query);

                        while ($pub = mysqli_fetch_assoc($result)) {
                        ?>
                            <section style="background-color: rgb(255, 255, 255);">
                                <div class="container py-5">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-12 col-lg-10 col-xl-12 d-flex justify-content-center">
                                            <div class="card" style="width: 685px;">
                                                <div class="card-body ">
                                                    <div class="d-flex flex-start align-items-center p-2">
                                                        <img class="rounded-circle shadow-1-strong me-3" src="fotosperfil/<?php echo $pub['perfil'] ?>" alt="avatar" width="60" height="60" />
                                                        <div>
                                                            <h6 class="fw-bold text-dark mb-1"><?php echo $pub['apelido'] ?></h6>
                                                            <p class="text-muted small mb-0"><?php echo date_format(date_create($pub['data_post']), 'd/m/y H:i') ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="container">
                                                        <p class="mt-2 mb-4 pb-2" style="text-align: justify; width: 470px;">
                                                            <?php echo $pub['descricao'] ?>
                                                        </p>
                                                        <img src="postimage/<?php echo $pub['imagem'] ?>" class="img-fluid" alt="">
                                                        <div class="small d-flex justify-content-start mt-4">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer py-3 border-0" style="background-color: #ffffff;">
                                                    <div class="d-flex flex-start w-100">
                                                        <div class="form-outline w-100">                                                 
                                                        </div>
                                                    </div>
                                                    <div class="float-end mt-2 pt-1">
                                                        <a href="comentar.php?pid=<?php echo $pub['pid'] ?>" class="btn  btn-dark btn-sm">Postar comentário</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        <?php } ?>
                    </div>
                </div>
            </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="fotosperfil/<?php echo $perfil['imagem'] ?>" alt="Generic placeholder image" class="img-fluid img-thumbnail mt-1" style="min-width: 300px; min-height: 300px; z-index: 2">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>