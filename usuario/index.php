<?php
    session_start();
    include_once("../classes/Login.php");
    include_once("../classes/Aviso.php");
    include_once("../classes/Reclamacao.php");
    $logado = Login::authUser($_SESSION['sessao']);
    include_once("header.php");
    $avisos = Aviso::countAvisosAtivos();

    //Checa se é usuário ou funcionário para buscar as reclamações
    $permissao = Login::checkPermission($_SESSION['sessao']);
        $table = '';
        if ($permissao == 2){
            $table = 'condominoID';
        } elseif ($permissao == 3){
            $table = 'funcionarioID';
        }

    $reclamacoes = Reclamacao::countReclamacaoUsuario($_SESSION['ID'], $table);
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
    <div class="container m-y-32 bg-white">
        <div class="wrapper">
            <br>
            <h2>Seja bem-vindo!</h2>
            <br>
            <ul>
                <li><h3>Você tem <?= $reclamacoes ?> reclamações abertas respondidas;</h3></li><br>
                <li><h3>Existem <?= $avisos ?> avisos ativos;</h3></li><br>
            </ul>
        </div>
    </div>
<?php
    include_once("../footer.php");
?>
</body>
</html>