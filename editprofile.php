<?php
include_once('includes/config.php');

if (isset($_POST['submit'])) {
    $napelido = mysqli_real_escape_string($conexao,  $_POST['apelido']);
    $nnome = mysqli_real_escape_string($conexao,  $_POST['nome']);
    $bio = mysqli_real_escape_string($conexao,  $_POST['bio']);
    $imgfile = $_FILES["foto"]["name"];
    if ($imgfile == "") {

    } else {
        $extension = substr($imgfile, strlen($imgfile) - 4, strlen($imgfile));
        $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");

        if (!in_array($extension, $allowed_extensions)) {
            //echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
            $error= "Formato Invalido. Somente os formatos jpg / jpeg/ png /gif são permitidos";
        } else {
            $imgnewfile = md5($imgfile) . $extensions;
            move_uploaded_file($_FILES["foto"]["tmp_name"], "fotosperfil/" . $imgnewfile);
            $query = 'UPDATE usuario SET imagem = "' . $imgnewfile . '" WHERE id_usuario = ' . $_SESSION['id'] . '';
            $result = mysqli_query($conexao, $query);
        }

    }
    if (!empty($napelido)) {
        $query = mysqli_query($conexao, 'UPDATE usuario SET apelido = "' . $napelido . '" WHERE id_usuario = ' . $_SESSION['id'] . '');
    }
    if (!empty($nnome)) {
        $query = mysqli_query($conexao, 'UPDATE usuario SET nome = "' . $nnome . '" WHERE id_usuario = ' . $_SESSION['id'] . '');
    }
    if (!empty($bio)) {
        $query = mysqli_query($conexao, 'UPDATE usuario SET bio = "' . $bio . '" WHERE id_usuario = ' . $_SESSION['id'] . '');
    }
    //header('location: perfil.php?uid=' . $_SESSION['id'] . '');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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
                            <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                                <?php
                                $query = 'SELECT nome, apelido, imagem FROM usuario WHERE status = 1 and id_usuario = ' . $_SESSION['id'] . '';
                                $result = mysqli_query($conexao, $query);

                                if ($dados = mysqli_fetch_assoc($result)) {
                                ?>
                                    <img src="fotosperfil/<?php echo $dados['imagem'] ?>" alt="Generic placeholder image" class="img-fluid img-thumbnail mt-1 mb-2" style="min-width: 150px; min-height: 150px; z-index: 1">
                                    <div class="container">
                                    </div>
                            </div>
                            <div class="ms-3" style="margin-top: 130px;">
                                <h5><?php echo $dados['apelido']; ?></h5>
                                <h5><?php echo $dados['nome'];
                                } ?></h5>
                            </div>
                        </div>
                        <?php
                        $select = mysqli_query($conexao, 'SELECT apelido, nome, bio, email, imagem FROM usuario WHERE id_usuario = ' . $_SESSION['id'] . '');
                        while ($row = mysqli_fetch_assoc($select)) {
                        ?>
                            <div class="card-body p-4 text-black">
                                <form action="editprofile.php" method="post" enctype="multipart/form-data">
                                    <div class="mb-3 mt-3">
                                        <label for="foto"><i class='bx bxs-camera bx-tada' style="cursor: pointer; position: relative; top: -80px; left: 100px;; z-index: 2; font-size: 50px; color:#000"></i></label">
                                        <input type="file"  id="foto" value="<?php echo $row['imagem'] ?>" name="foto" style="display: none;">
                                        <input type="submit" value="Atualizar" name="submit" class="btn btn-dark" style="width: 150px; position: absolute; left: 30px;">
                                    </div>
                                    <?php if ($error) { ?>
                                        <div class="alert alert-warning" role="alert">
                                            <strong>Erro:</strong> <?php echo $error; ?>
                                        </div>
                                        <?php } ?>
                                    <div class="mb-5">
                                        <p class="lead fw-normal mb-1">Bio</p>
                                        <div class="form-outline">
                                            <textarea class="form-control" id="textAreaExample" name="bio" rows="4" placeholder="Sobre você" style="resize: none; "><?php echo $row['bio'] ?></textarea>
                                        </div>
                                    </div>
                                    <p>Atualize seu perfil:</p>
                                    <div class="form-floating mb-3">
                                        <input type="text" name="nome" class="form-control" id="nome" value="<?php echo $row['nome'] ?>">
                                        <label for="nome">Novo Nome</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" name="apelido" class="form-control" id="apelido" value="<?php echo $row['apelido'] ?>">
                                        <label for="apelido">Novo Apelido</label>
                                    </div>
                                <?php } ?>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>