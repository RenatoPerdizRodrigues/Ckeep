<?php
    session_start();
    include_once("classes/Login.php");
    $logado = Login::authAdm($_SESSION['ID']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <?php include_once("header.php"); ?>

    <h1>Oi. Aqui vamos incluir informações como quantos apartamentos estão devendo, quantos estão vagos, etc.</h1>
</body>
</html>