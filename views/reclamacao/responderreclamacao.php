<?php
    session_start();
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../usuario/classes/Reclamacao.php");

    $result = Reclamacao::search($_GET['id'], 'ID');
    $reclamacoes = $result->fetch_all(MYSQLI_ASSOC);
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
        <form method="POST" action="responderreclamacao.php?id=<?= $_GET['id'] ?>">
        <fieldset>
        <legend>Responder Reclamação</legend>
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
            <label>Reclamação</label>
            <input disabled type="textarea" value="<?= $reclamacoes[0]['descricao'] ?>">
            <label>Resposta*</label>
            <input required type="textarea" name="resposta"><br>
            <input type="submit">
        </fieldset>
        </form>
    </div>
</body>
</html>
<?php
    $resposta = isset($_POST['resposta']) ? $_POST['resposta'] : null;
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    if ($resposta && $id){
        $resposta = Reclamacao::responder($id, $resposta);
    }
?>