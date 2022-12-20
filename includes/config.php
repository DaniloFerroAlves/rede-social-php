<?php 
session_start();
include('conexao.php');
if(strlen($_SESSION['login']) == 0) {
   header('location: login.php');
   exit;
}
?>