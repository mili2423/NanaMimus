<?php
include 'conexion.php';
session_start();

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];


$stmt = $conexion->prepare("SELECT pass FROM registro WHERE user = ?");

$stmt->bind_param("s", $usuario);

$stmt->execute();

$stmt->bind_result($password_hash_db);



if ($stmt->fetch()) {
    if (password_verify($clave, $password_hash_db)) {
        header("Location: logon.php");
        $_SESSION["usuario"] = $usuario;
        exit; 
    } else {
        echo "Contraseña incorrecta";
    }
} else {
    echo "<script type='text/javascript'>alert('Usuario No Encontrado');
        window.location.href = 'index.php';</script>";
}


$stmt->close();

$conexion->close();