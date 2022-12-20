<?php
//encerra
session_start();
$_SESSION['login']= "";
// $_SESSION['senha']= "";
session_unset();
session_destroy();
header('Location: index.php');
?>