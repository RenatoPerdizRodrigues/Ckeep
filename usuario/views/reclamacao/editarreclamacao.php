<?php
    session_start();
    include_once("../../../classes/Login.php");
    $logado = Login::authUser($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../classes/Reclamacao.php");
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        $result = Reclamacao::search($id, 'ID');
        $reclamacao = $result->fetch_all(MYSQLI_ASSOC);       
    } else header("Location: consultareclamacao.php");
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
            <form method="POST" action="editarreclamacao.php">
            <fieldset>
            <legend>Edição de Reclamação</legend>
                <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
            <div>
                <label>Data*</label>
                <input required type="hidden" name="datag" value="<?= date('Y-m-d') ?>"><br>
                <input required type="data" value="<?= date('Y-m-d') ?>" disabled><br>
            </div>
            <div>
                <label>Descrição*</label>
                <input required type="textarea" name="descricao" value="<?= $reclamacao[0]['descricao']; ?>"><br>
            </div>
                <input type="submit" class="button" value="Enviar">
            </fieldset>
            </form>
        </div>
    </div>
</html>
<?php
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : null;
    $datag = isset($_POST['datag']) ? $_POST['datag'] : null;
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    if ($datag && $descricao && $id){
        if ($reclamacao = new Reclamacao($datag, $descricao, 1)){
            $reclamacao->update($id);
            header("Location: consultareclamacao.php");
            exit();
        }
    }

    include_once("../../../footer.php");
?>
</body>