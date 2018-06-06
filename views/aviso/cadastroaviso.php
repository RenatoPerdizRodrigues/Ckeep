<?php
    session_start();
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../classes/Aviso.php");
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
        <form method="POST" action="cadastroaviso.php">
        <fieldset>
        <legend>Cadastro de Aviso</legend>
            <label>Data*</label>
            <input hidden required type="date" name="data" value="<?= date('Y-m-d') ?>"><br>
            <input disabled type="date" name="data" value="<?= date('Y-m-d') ?>"><br>
            <label>Descrição*</label>
            <input required type="textarea" name="descricao"><br>
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
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : null;;
 
    if ($data && $descricao){
        echo "entrei";
        if ($aviso = new Aviso($data, $descricao)){
        $aviso->insert();
        header("Location: consultaaviso.php?datag=".$data);
        }
    }
?>