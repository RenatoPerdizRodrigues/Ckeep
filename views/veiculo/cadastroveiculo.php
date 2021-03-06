<?php
    session_start();
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../classes/Veiculo.php");
    //É realizada uma busca para os dados já cadastrados serem mostrados no formulário.
    if (isset($_GET['id'])){
        $id = $_GET['id'];
    } else header("Location: localizacaocadastroveiculo.php");
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
            <form method="POST" action="<?= "cadastroveiculo.php?id=".$id ?>">
            <fieldset>
            <legend>Cadastro de Veículo</legend>        
                <input type="hidden" name="condominoid" value="<?= $id; ?>">
            <div>
                <label>Tipo</label>
                <select required name="tipo">
                    <option value="Carro">Carro</option>
                    <option value="Moto">Moto</option>
                </select><br>
            </div>
            <div>
                <label>Marca</label>
                <input required type="text" name="marca"><br>
            </div>
            <div>
                <label>Modelo</label>
                <input required type="text" name="modelo"><br>
            </div>
            <div>
                <label>Placa</label>
                <input required type="text" name="placa"><br>
            </div>
            <div>
                <label>Cor</label>
                <input required type="text" name="cor"><br>
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
    $condominoid = isset($_POST['condominoid']) ? (int)$_POST['condominoid'] : null;
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
    $marca = isset($_POST['marca']) ? $_POST['marca'] : null;
    $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : null;
    $placa = isset($_POST['placa']) ? $_POST['placa'] : null;
    $cor = isset($_POST['cor']) ? $_POST['cor'] : null;

    if ($condominoid && $tipo && $marca && $modelo && $modelo && $placa && $cor){
        $veiculo = new Veiculo($tipo, $marca, $modelo, $placa, $cor, $condominoid);
        $veiculo->insert();
    }
?>