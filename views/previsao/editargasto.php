<?php
    /*
    session_start();
    $id = $_SESSION['ID'];
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($id);
    */
    include_once("../../header.php");
    include_once("../../classes/Gasto.php");
    //É realizada uma busca para os dados já cadastrados serem mostrados no formulário.
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        $result = Gasto::search($id, 'ID');
        $usuario = $result->fetch_all(MYSQLI_ASSOC);       
    } //else header("Location: consultafuncionario.php");
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
    <form method="POST" action="editargasto.php">
        <fieldset>
        <legend>Cadastro de Gasto</legend>
            <input type="hidden" name="id" value="<?= $id = $_GET['id'] ?>">
            <label>Data*</label>
            <input required type="date" name="datag" value="<?= $usuario[0]['datag'] ?>"><br>
            <label>Valor*</label>
            <input required type="number" name="valor" value="<?= $usuario[0]['valor'] ?>"><br>
            <label>Tipo*</label>
            <select name="tipo">
                <option <?php if($usuario[0]['tipo'] == "fixo"){echo "selected";} ?> value="fixo">Fixo</option>
                <option <?php if($usuario[0]['tipo'] == "extraordinario"){echo "selected";} ?> value="extraordinario">Extraordinário</option>
                <option <?php if($usuario[0]['tipo'] == "atividade"){echo "selected";} ?> value="atividade">Atividade</option>
            </select>
            <label>Descrição*</label>
            <input required type="textarea" name="descricao" value="<?= $usuario[0]['descricao'] ?>"><br>
            <input type="submit">
        </fieldset>
        </form>
    </div>
</body>
</html>
<?php
    $datag = isset($_POST['datag']) ? $_POST['datag'] : null;
    $valor = isset($_POST['valor']) ? $_POST['valor'] : null;
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : null;
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    if ($datag && $valor && $tipo && $descricao){
        $gasto = new Gasto($datag, $valor, $tipo, $descricao);
        $gasto->update($id);
        var_dump($gasto);
        exit();
    }
?>