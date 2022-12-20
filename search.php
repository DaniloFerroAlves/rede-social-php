<?php
include_once('includes/config.php');
if (isset($_POST['search'])) {
    $txtprocura = mysqli_real_escape_string($conexao,  $_POST['txtprocura']);
    $query = mysqli_query($conexao, 'SELECT id_usuario, nome, apelido, imagem FROM usuario WHERE status = 1 AND nome LIKE "%' . $txtprocura . '%"');
    unset($_POST);
}
while ($row = mysqli_fetch_assoc($query)) {
?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style2.css">
    <?php include('includes/header2.php'); ?>
    <div class="container mt-5 d-flex justify-content-center">
        <div class="card p-3 mt-5">
            <div class="d-flex align-items-center">
                <div class="image">
                    <img src="fotosperfil/<?php echo $row['imagem'] ?>" class="rounded me-2" width="155" style="min-height: 150px; min-width: 150px;">
                </div>
                <div class="ml-3 w-100">
                    <h4 class="mb-0 mt-0" style="font-size: 19px;;"><?php echo $row['nome'] ?></h4>
                    <span style="font-size: 17px;;" class="text-muted"><?php echo $row['apelido'] ?></span>
                    <div class="button mt-5 d-flex flex-row align-items-center">
                        <a href="perfil.php?uid=<?php echo $row['id_usuario'] ?>" class="btn btn-sm btn-outline-dark w-100 me-2">Visitar Perfil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>