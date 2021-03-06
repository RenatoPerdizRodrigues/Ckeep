<?php
    session_start();
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../classes/Aviso.php");
    if (isset($_GET['id'])){
        $id1 = $_GET['id'];
        $result = Aviso::searchAll($id1, 'ID');
        $aviso = $result->fetch_all(MYSQLI_ASSOC);       
    }
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
            <form method="POST" action="editaraviso.php?id=<?= $_GET['id'] ?>">
            <fieldset>
            <legend>Edição de Aviso</legend>
            <div>
                <label>Data*</label>
                <input  type="hidden" name="data" value="<?= date('Y-m-d') ?>"><br>
                <input  type="hidden" name="id" value="<?= $aviso[0]['ID'] ?>">
                <input disabled type="date" name="data" value="<?= date('Y-m-d') ?>"><br>
            </div>
            <div>
                <label>Descrição*</label>
                <input required type="textarea" name="descricao" value="<?= $aviso[0]['descricao'] ?>"><br>
            </div>
                <input type="submit" class="button" value="Enviar">
            </fieldset>
            </form>
        </div>
    </div>
<?php
    include_once("../../footer.php");
?>
</body>
</html>
<?php
    /*Em caso de primeiro nome composto, ele é dividido, e tem sua primeira palavra inserida
    em "Nome" e as outras acrescentadas em "Sobrenome", para facilitar a busca.*/
    $data = isset($_POST['data']) ? $_POST['data'] : null;
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : null;
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    if ($data && $descricao && $id){
        if ($aviso = new Aviso($data, $descricao)){
        $aviso->update($id);
        header("Location: consultaaviso.php?id=".$id1);
        }
    }
?>