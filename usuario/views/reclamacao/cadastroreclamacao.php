<?php
    session_start();
    include_once("../../../classes/Login.php");
    $logado = Login::authCondomino($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../../classes/Reclamacao.php");
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
    <div class="wrapper">
        <form method="POST" action="cadastroreclamacao.php">
        <fieldset>
        <legend>Cadastro de Reclamação</legend>
            <label>Data*</label>
            <input required type="hidden" name="datag" value="<?= date('Y-m-d') ?>"><br>
            <input required type="data" value="<?= date('Y-m-d') ?>" disabled><br>
            <label>Descrição*</label>
            <input required type="textarea" name="descricao"><br>
            <input type="submit">
        </fieldset>
        </form>
    </div>
</body>
</html>
<?php
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : null;
    $datag = isset($_POST['datag']) ? $_POST['datag'] : null;
 
    if ($datag && $descricao){
        //Aqui usaremos o ID do usuário, de acordo com seu login, para atrelar a recalamação. Por enquatno, o ID atrelado é 1.
        if ($reclamacao = new Reclamacao($datag, $descricao, 1)){
            $reclamacao->insertCondomino($_SESSION['ID']);
            //$reclamacao->insertFuncionario(1);
        header("Location: consultareclamacao.php");
        }
    }
?>