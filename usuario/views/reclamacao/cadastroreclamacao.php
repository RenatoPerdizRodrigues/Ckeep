<?php
    session_start();
    include_once("../../../classes/Login.php");
    $logado = Login::authUser($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../classes/Reclamacao.php");
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
        <form method="POST" action="cadastroreclamacao.php">
        <fieldset>
        <legend>Cadastro de Reclamação</legend>
        <div>
            <label>Data*</label>
            <input required type="hidden" name="datag" value="<?= date('Y-m-d') ?>"><br>
            <input required type="data" value="<?= date('Y-m-d') ?>" disabled><br>
        </div>
        <div>
            <label>Descrição*</label>
            <input required type="textarea" name="descricao"><br>
        </div>
            <input type="submit" class="button" value="submit">
        </fieldset>
        </form>
    </div>
</div>
</body>
</html>
<?php
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : null;
    $datag = isset($_POST['datag']) ? $_POST['datag'] : null;

    if ($datag && $descricao){
        //Aqui usaremos o ID do usuário, de acordo com seu login, para atrelar a recalamação. Por enquatno, o ID atrelado é 1.
        
        //Função que checa se o usuário é condômino (2) ou funcionário(3), para inserir com o respectivo ID
        $permissao = Login::checkPermission($_SESSION['sessao']);
        $table = '';
        if ($permissao == 2){
            $table = 'condominoID';
        } elseif ($permissao == 3){
            $table = 'funcionarioID';
        }
        //O 1 na instanciação da reclamação significa que a mesma está aberta
        if ($reclamacao = new Reclamacao($datag, $descricao, 1)){
            $reclamacao->insert($_SESSION['ID'], $table);
            header("Location: consultareclamacao.php");
            exit();
        }
    }
?>
<?php
        include_once("../../../footer.php");
?>
</body>