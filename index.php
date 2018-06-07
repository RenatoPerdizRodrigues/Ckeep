<?php
    session_start();
    include_once("classes/Login.php");
    include_once("classes/Moradores.php");
    include_once("classes/Reclamacao.php");
    include_once("classes/Gasto.php");
    $logado = Login::authAdm($_SESSION['sessao']);
    $devedores = Moradores::countDevedor();
    $reclamacoes = Reclamacao::countReclamacao();
    $gasto = Gasto::countGastoTotal();
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
    <?php include_once("header.php");?>

    <div class="container m-y-32 bg-white">
        <div class="wrapper">
            <br>
            <h2>Seja bem-vindo!</h2><br>
            <br>
            <ul>
                <li><h3> <?= $devedores ?> apartamentos não estão em dia com o condomínio;</h3><br></li>
                <li><h3>Existem <?= $reclamacoes ?> reclamações abertas;</h3><br></li>
                <li><h3>Neste mês, os gastos estão previstos para no mínimo R$:<?= $gasto ?>,00;</h3><br></li>
            </ul>
        </div>
    </div>
    <?php
        include_once("footer.php");
    ?>
</body>
</html>