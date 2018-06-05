<?php
    /*
    session_start();
    $id = $_SESSION['ID'];
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($id);
    */
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
    <div class="wrapper">
        <form method="POST" action="editaraviso.php?id=<?= $_GET['id'] ?>">
        <fieldset>
        <legend>Cadastro de Aviso</legend>
            <label>Data*</label>
            <input hidden type="date" name="data" value="<?= date('Y-m-d') ?>"><br>
            <input hidden type="number" name="id" value="<?= $aviso[0]['ID'] ?>">
            <input disabled type="date" name="data" value="<?= date('Y-m-d') ?>"><br>
            <label>Descrição*</label>
            <input required type="textarea" name="descricao" value="<?= $aviso[0]['descricao'] ?>"><br>
            <input type="submit">
        </fieldset>
        </form>
    </div>
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