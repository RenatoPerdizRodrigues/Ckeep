<?php
    /*
    session_start();
    $id = $_SESSION['ID'];
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($id);
    */
    include_once("../../header.php");
    include_once("../../classes/Veiculo.php");
    //É realizada uma busca para os dados já cadastrados serem mostrados no formulário.
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        $result = Veiculo::search($id, 'ID');
        $veiculo = $result->fetch_all(MYSQLI_ASSOC);       
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
        <form method="POST" action="<?= 'editarveiculo.php?id='.$veiculo[0]['ID']; ?>">
        <fieldset>
        <legend>Edição de Veículo</legend>        
            <input type="hidden" name="id" value="<?= $veiculo[0]['ID']; ?>">
            <input type="hidden" name="proprietario" value="<?= $veiculo[0]['condominoID']; ?>">
            <label>Tipo</label>
            <input type="text" name="tipo" value="<?= $veiculo[0]['tipo']; ?>"><br>
            <label>Marca</label>
            <input type="text" name="marca" value="<?= $veiculo[0]['marca']; ?>"><br>
            <label>Modelo</label>
            <input type="text" name="modelo" value="<?= $veiculo[0]['modelo']; ?>"><br>
            <label>Placa</label>
            <input type="text" name="placa" value="<?= $veiculo[0]['placa']; ?>"><br>
            <label>Cor</label>
            <input type="text" name="cor" value="<?= $veiculo[0]['cor']; ?>"><br>
            <input type="submit">
        </fieldset>
        </form>
    </div>
</body>
</html>
<?php
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
    $proprietario = isset($_POST['proprietario']) ? (int)$_POST['proprietario'] : null;
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
    $marca = isset($_POST['marca']) ? $_POST['marca'] : null;
    $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : null;
    $placa = isset($_POST['placa']) ? $_POST['placa'] : null;
    $cor = isset($_POST['cor']) ? $_POST['cor'] : null;

    if ($id && $proprietario && $tipo && $marca && $modelo && $placa && $cor){
        //Veiculo($tipo, $marca, $modelo, $placa, $cor, $proprietario){
        $veiculo = new Veiculo($tipo, $marca, $modelo, $placa, $cor, $proprietario);
        $veiculo->update($id);
        header("Location: consultaveiculo.php");
    }
?>