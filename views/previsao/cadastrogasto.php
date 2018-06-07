<?php
    session_start();
    include_once("../../classes/Login.php");
    $logado = Login::authAdm($_SESSION['sessao']);
    include_once("../../header.php");
    include_once("../../classes/Gasto.php");
    include_once("../../classes/Previsao.php");
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
            <form method="POST" action="cadastrogasto.php?datag=<?= $_GET['datag'] ?>">
            <fieldset>
            <legend>Cadastro de Gasto</legend>
            <div>
                <label>Data*</label>
                <input required type="hidden" name="datag" value="<?= $_GET['datag']; ?>"><br>
                <input required type="data" value="<?= $_GET['datag']; ?>" disabled><br>
            </div>
            <div>
                <label>Valor*</label>
                <input required type="number" name="valor"><br>
            </div>
            <div>
                <label>Tipo*</label>
                <select name="tipo">
                    <option value="Fixo">Fixo</option>
                    <option value="Extraordinario">Extraordinário</option>
                    <option value="Atividade">Atividade</option>
                </select>
            </div>
            <div>
                <label>Descrição*</label>
                <input required type="textarea" name="descricao"><br>
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
    $valor = isset($_POST['valor']) ? $_POST['valor'] : null;
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : null;
    $datag = isset($_POST['datag']) ? $_POST['datag'] : null;
 
    if ($datag && $valor && $tipo && $descricao){
        echo "$datag";
        if ($gasto = new Gasto($datag, $valor, $tipo, $descricao)){
        $gasto->insert();
        header("Location: consultaprevisao.php?datag=".$datag);
        }
    }
?>