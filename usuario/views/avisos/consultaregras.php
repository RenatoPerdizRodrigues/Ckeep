<?php
    session_start();
    include_once("../../../classes/Login.php");
    $logado = Login::authUser($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../../classes/Aviso.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../style.css">
    <title>Document</title>
</head>
<body>
    <div class="container m-y-32 bg-white">
        <div class="wrapper">
            <br><h2>Regras</h2><br>
            <ol>
                <li><h3>Só é permitido fazer barulho até as 20h;</h3></li><br>
                <li><h3>Não são permitidos animais nas dependências do condomínio;</h3></li><br>
                <li><h3>A assembléia mensal acontece todo dia primeiro de cada mês</h3></li><br>
            </ol>
            
        </div>
    </div>
<?php
        include_once("../../../footer.php");
?>
</body>